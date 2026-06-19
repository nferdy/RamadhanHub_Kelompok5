<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Fasting_model');
        $this->load->model('Quran_model');
        $this->load->model('Prayer_model');
        $this->load->model('State_model');
    }

    public function state()
    {
        $user_id = (int) ($this->input->get('user_id') ?: 1);
        $data = $this->State_model->get_state($user_id);
        return json_response(true, 'State loaded.', $data);
    }

    public function state_save()
    {
        $input = $this->json_input();
        $user_id = (int) (isset($input['user_id']) ? $input['user_id'] : 1);
        $state = isset($input['state']) && is_array($input['state']) ? $input['state'] : array();

        $saved = $this->State_model->save_state($user_id, $state);
        return json_response($saved, $saved ? 'State saved.' : 'State failed to save.', array('user_id' => $user_id), $saved ? 200 : 500);
    }

    public function fasting_save()
    {
        $input = $this->json_input();
        $payload = array(
            'user_id' => (int) (isset($input['user_id']) ? $input['user_id'] : 1),
            'ramadhan_day' => (int) (isset($input['ramadhan_day']) ? $input['ramadhan_day'] : $this->input->post('ramadhan_day')),
            'status' => isset($input['status']) ? $input['status'] : $this->input->post('status', TRUE),
            'note' => isset($input['note']) ? $input['note'] : $this->input->post('note', TRUE)
        );

        if ($payload['ramadhan_day'] < 1 || $payload['ramadhan_day'] > 30) {
            return json_response(false, 'Hari Ramadhan tidak valid.', array(), 422);
        }

        $saved = $this->Fasting_model->save_log($payload);
        return json_response($saved, $saved ? 'Data puasa tersimpan.' : 'Data puasa gagal tersimpan.', $payload, $saved ? 200 : 500);
    }

    public function quran_save()
    {
        $input = $this->json_input();
        $payload = array(
            'user_id' => (int) (isset($input['user_id']) ? $input['user_id'] : 1),
            'juz' => (int) (isset($input['juz']) ? $input['juz'] : $this->input->post('juz')),
            'surah' => isset($input['surah']) ? $input['surah'] : $this->input->post('surah', TRUE),
            'ayah' => (int) (isset($input['ayah']) ? $input['ayah'] : $this->input->post('ayah')),
            'page_number' => (int) (isset($input['page_number']) ? $input['page_number'] : $this->input->post('page_number')),
            'is_completed' => (int) (isset($input['is_completed']) ? $input['is_completed'] : $this->input->post('is_completed'))
        );

        if ($payload['juz'] < 1 || $payload['juz'] > 30) {
            return json_response(false, 'Juz tidak valid.', array(), 422);
        }

        $saved = $this->Quran_model->save_progress($payload);
        return json_response($saved, $saved ? 'Progress Quran tersimpan.' : 'Progress Quran gagal tersimpan.', $payload, $saved ? 200 : 500);
    }

    public function prayer_save()
    {
        $input = $this->json_input();
        $payload = array(
            'user_id' => (int) (isset($input['user_id']) ? $input['user_id'] : 1),
            'prayer_name' => isset($input['prayer_name']) ? $input['prayer_name'] : $this->input->post('prayer_name', TRUE),
            'prayer_date' => isset($input['prayer_date']) ? $input['prayer_date'] : $this->input->post('prayer_date', TRUE),
            'is_completed' => (int) (isset($input['is_completed']) ? $input['is_completed'] : $this->input->post('is_completed'))
        );

        $saved = $this->Prayer_model->save_log($payload);
        return json_response($saved, $saved ? 'Log sholat tersimpan.' : 'Log sholat gagal tersimpan.', $payload, $saved ? 200 : 500);
    }

    private function json_input()
    {
        $raw = $this->input->raw_input_stream;
        $json = json_decode($raw, true);
        if (is_array($json)) {
            return $json;
        }
        return $this->input->post(NULL, TRUE) ?: array();
    }
}
