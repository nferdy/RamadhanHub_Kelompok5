<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prayer_model extends CI_Model
{
    public function save_log(array $data)
    {
        $existing = $this->db
            ->where('user_id', $data['user_id'])
            ->where('prayer_name', $data['prayer_name'])
            ->where('prayer_date', $data['prayer_date'])
            ->get('prayer_logs')
            ->row_array();

        $payload = array(
            'user_id' => $data['user_id'],
            'prayer_name' => $data['prayer_name'],
            'prayer_date' => $data['prayer_date'],
            'is_completed' => isset($data['is_completed']) ? $data['is_completed'] : 0,
            'updated_at' => date('Y-m-d H:i:s')
        );

        if ($existing) {
            return $this->db
                ->where('id', $existing['id'])
                ->update('prayer_logs', $payload);
        }

        $payload['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('prayer_logs', $payload);
    }
}
