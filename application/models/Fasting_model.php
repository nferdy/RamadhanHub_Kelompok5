<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fasting_model extends CI_Model
{
    public function save_log(array $data)
    {
        $valid_statuses = array('done', 'excused', 'missed', 'empty');
        $filled_statuses = array('done', 'excused', 'missed');
        $data['user_id'] = (int) $data['user_id'];
        $data['ramadhan_day'] = (int) $data['ramadhan_day'];
        $data['status'] = isset($data['status']) && in_array($data['status'], $valid_statuses, true) ? $data['status'] : 'empty';

        if ($data['status'] !== 'empty' && !$this->previous_days_completed($data['user_id'], $data['ramadhan_day'], $filled_statuses)) {
            return false;
        }

        if ($data['status'] === 'empty' && $this->has_later_progress($data['user_id'], $data['ramadhan_day'], $filled_statuses)) {
            return false;
        }

        $existing = $this->db
            ->where('user_id', $data['user_id'])
            ->where('ramadhan_day', $data['ramadhan_day'])
            ->get('fasting_logs')
            ->row_array();

        $payload = array(
            'user_id' => $data['user_id'],
            'ramadhan_day' => $data['ramadhan_day'],
            'status' => $data['status'],
            'note' => isset($data['note']) ? $data['note'] : null,
            'updated_at' => date('Y-m-d H:i:s')
        );

        if ($existing) {
            return $this->db
                ->where('id', $existing['id'])
                ->update('fasting_logs', $payload);
        }

        $payload['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('fasting_logs', $payload);
    }

    public function get_by_user($user_id)
    {
        return $this->db
            ->where('user_id', (int) $user_id)
            ->order_by('ramadhan_day', 'ASC')
            ->get('fasting_logs')
            ->result_array();
    }

    private function previous_days_completed($user_id, $day, array $filled_statuses)
    {
        if ($day <= 1) return true;

        $rows = $this->db
            ->select('ramadhan_day, status')
            ->where('user_id', (int) $user_id)
            ->where('ramadhan_day <', (int) $day)
            ->order_by('ramadhan_day', 'ASC')
            ->get('fasting_logs')
            ->result_array();

        $completed = array();
        foreach ($rows as $row) {
            if (in_array($row['status'], $filled_statuses, true)) {
                $completed[(int) $row['ramadhan_day']] = true;
            }
        }

        for ($previous = 1; $previous < (int) $day; $previous++) {
            if (empty($completed[$previous])) return false;
        }

        return true;
    }

    private function has_later_progress($user_id, $day, array $filled_statuses)
    {
        return (bool) $this->db
            ->where('user_id', (int) $user_id)
            ->where('ramadhan_day >', (int) $day)
            ->where_in('status', $filled_statuses)
            ->limit(1)
            ->get('fasting_logs')
            ->row_array();
    }
}
