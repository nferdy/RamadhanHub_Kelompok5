<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quran_model extends CI_Model
{
    public function save_progress(array $data)
    {
        $existing = $this->db
            ->where('user_id', $data['user_id'])
            ->where('juz', $data['juz'])
            ->get('quran_progress')
            ->row_array();

        $payload = array(
            'user_id' => $data['user_id'],
            'juz' => $data['juz'],
            'surah' => isset($data['surah']) ? $data['surah'] : null,
            'ayah' => isset($data['ayah']) ? $data['ayah'] : null,
            'page_number' => isset($data['page_number']) ? $data['page_number'] : null,
            'is_completed' => isset($data['is_completed']) ? $data['is_completed'] : 0,
            'updated_at' => date('Y-m-d H:i:s')
        );

        if ($existing) {
            return $this->db
                ->where('id', $existing['id'])
                ->update('quran_progress', $payload);
        }

        $payload['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('quran_progress', $payload);
    }

    public function get_by_user($user_id)
    {
        return $this->db
            ->where('user_id', (int) $user_id)
            ->order_by('juz', 'ASC')
            ->get('quran_progress')
            ->result_array();
    }
}
