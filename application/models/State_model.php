<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class State_model extends CI_Model
{
    private $valid_cities = array('jakarta', 'bandung','purbalingga', 'surabaya', 'makassar');

    public function ensure_user($user_id)
    {
        $exists = $this->db->where('id', (int) $user_id)->get('users')->row_array();
        if (!$exists) {
            $this->db->insert('users', array(
                'id' => (int) $user_id,
                'name' => 'Demo User',
                'email' => 'demo' . (int) $user_id . '@ramadhan.local',
                'timezone' => 'Asia/Jakarta',
                'city' => 'jakarta'
            ));
        }

        $pref = $this->db->where('user_id', (int) $user_id)->get('user_preferences')->row_array();
        if (!$pref) {
            $this->db->insert('user_preferences', array(
                'user_id' => (int) $user_id,
                'ramadhan_start' => date('Y-m-d'),
                'city' => 'jakarta',
                'selected_fasting_day' => 1
            ));
        }
    }

    public function get_state($user_id)
    {
        $user_id = (int) $user_id;
        $this->ensure_user($user_id);

        $pref = $this->db->where('user_id', $user_id)->get('user_preferences')->row_array();
        $state = array(
            'version' => 3,
            'ramadhanStart' => $pref['ramadhan_start'],
            'city' => $pref['city'],
            'remindersEnabled' => (bool) $pref['reminders_enabled'],
            'fasting' => new stdClass(),
            'fastingNotes' => new stdClass(),
            'quran' => new stdClass(),
            'lastRead' => array(
                'surah' => (string) $pref['last_surah'],
                'ayah' => (string) $pref['last_ayah'],
                'page' => (string) $pref['last_page']
            ),
            'prayerLogs' => new stdClass(),
            'sunnahLogs' => new stdClass(),
            'ayahReadDates' => array(),
            'selectedFastingDay' => (int) $pref['selected_fasting_day'],
            'notified' => new stdClass(),
            'dailyAyah' => $this->daily_ayah($pref['ramadhan_start'])
        );

        $has_data = false;
        $fasting = array();
        $fasting_notes = array();
        foreach ($this->db->where('user_id', $user_id)->order_by('ramadhan_day', 'ASC')->get('fasting_logs')->result_array() as $row) {
            if ($row['status'] !== 'empty') $fasting[(string) $row['ramadhan_day']] = $row['status'];
            if (!empty($row['note'])) $fasting_notes[(string) $row['ramadhan_day']] = $row['note'];
            $has_data = true;
        }
        $state['fasting'] = (object) $fasting;
        $state['fastingNotes'] = (object) $fasting_notes;

        $quran = array();
        foreach ($this->db->where('user_id', $user_id)->where('is_completed', 1)->get('quran_progress')->result_array() as $row) {
            $quran[(string) $row['juz']] = true;
            $has_data = true;
        }
        $state['quran'] = (object) $quran;

        $prayer_logs = array();
        foreach ($this->db->where('user_id', $user_id)->get('prayer_logs')->result_array() as $row) {
            $date = $row['prayer_date'];
            if (!isset($prayer_logs[$date])) $prayer_logs[$date] = array();
            $prayer_logs[$date][$row['prayer_name']] = (bool) $row['is_completed'];
            $has_data = true;
        }
        $state['prayerLogs'] = (object) $prayer_logs;

        $sunnah_logs = array();
        foreach ($this->db->where('user_id', $user_id)->get('sunnah_logs')->result_array() as $row) {
            $date = $row['sunnah_date'];
            if (!isset($sunnah_logs[$date])) $sunnah_logs[$date] = array();
            $sunnah_logs[$date][$row['sunnah_name']] = (bool) $row['is_completed'];
            $has_data = true;
        }
        $state['sunnahLogs'] = (object) $sunnah_logs;

        foreach ($this->db->where('user_id', $user_id)->where('type', 'ayah')->order_by('content_date', 'ASC')->get('daily_content_reads')->result_array() as $row) {
            $state['ayahReadDates'][] = $row['content_date'];
            $has_data = true;
        }

        return array('state' => $state, 'is_empty' => !$has_data);
    }

    public function save_state($user_id, array $state)
    {
        $user_id = (int) $user_id;
        $this->ensure_user($user_id);
        $this->db->trans_start();

        $last_read = isset($state['lastRead']) && is_array($state['lastRead']) ? $state['lastRead'] : array();
        $city = isset($state['city']) && in_array($state['city'], $this->valid_cities, true) ? $state['city'] : 'jakarta';
        $this->db->replace('user_preferences', array(
            'user_id' => $user_id,
            'ramadhan_start' => !empty($state['ramadhanStart']) ? $state['ramadhanStart'] : date('Y-m-d'),
            'city' => $city,
            'reminders_enabled' => !empty($state['remindersEnabled']) ? 1 : 0,
            'selected_fasting_day' => max(1, min(30, (int) (isset($state['selectedFastingDay']) ? $state['selectedFastingDay'] : 1))),
            'last_surah' => isset($last_read['surah']) ? $last_read['surah'] : null,
            'last_ayah' => isset($last_read['ayah']) ? $last_read['ayah'] : null,
            'last_page' => isset($last_read['page']) ? $last_read['page'] : null,
            'updated_at' => date('Y-m-d H:i:s')
        ));

        foreach (array('fasting_logs', 'quran_progress', 'prayer_logs', 'sunnah_logs', 'daily_content_reads') as $table) {
            $this->db->where('user_id', $user_id)->delete($table);
        }

        $fasting = isset($state['fasting']) && is_array($state['fasting']) ? $state['fasting'] : array();
        $notes = isset($state['fastingNotes']) && is_array($state['fastingNotes']) ? $state['fastingNotes'] : array();
        $valid_fasting_statuses = array('done', 'excused', 'missed');
        $sequence_locked = false;
        for ($day = 1; $day <= 30; $day++) {
            $status = isset($fasting[(string) $day]) ? $fasting[(string) $day] : 'empty';
            $status = in_array($status, array('done', 'excused', 'missed', 'empty'), true) ? $status : 'empty';
            $note = isset($notes[(string) $day]) ? trim($notes[(string) $day]) : '';

            if ($sequence_locked) continue;

            if (!in_array($status, $valid_fasting_statuses, true)) {
                if ($note !== '') {
                    $this->db->insert('fasting_logs', array('user_id' => $user_id, 'ramadhan_day' => $day, 'status' => 'empty', 'note' => $note));
                }
                $sequence_locked = true;
                continue;
            }

            $this->db->insert('fasting_logs', array('user_id' => $user_id, 'ramadhan_day' => $day, 'status' => $status, 'note' => $note));
        }

        $quran = isset($state['quran']) && is_array($state['quran']) ? $state['quran'] : array();
        for ($juz = 1; $juz <= 30; $juz++) {
            if (empty($quran[(string) $juz])) continue;
            $this->db->insert('quran_progress', array('user_id' => $user_id, 'juz' => $juz, 'is_completed' => 1));
        }

        $this->insert_nested_logs($user_id, 'prayer_logs', isset($state['prayerLogs']) ? $state['prayerLogs'] : array(), 'prayer_date', 'prayer_name', array('subuh','dzuhur','ashar','maghrib','isya'));
        $this->insert_nested_logs($user_id, 'sunnah_logs', isset($state['sunnahLogs']) ? $state['sunnahLogs'] : array(), 'sunnah_date', 'sunnah_name', array('tahajud','dhuha','rawatib','tarawih'));

        $reads = isset($state['ayahReadDates']) && is_array($state['ayahReadDates']) ? array_unique($state['ayahReadDates']) : array();
        foreach ($reads as $date) {
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                $this->db->insert('daily_content_reads', array('user_id' => $user_id, 'content_date' => $date, 'type' => 'ayah'));
            }
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    private function insert_nested_logs($user_id, $table, $logs, $date_field, $name_field, array $valid_names)
    {
        if (!is_array($logs)) return;
        foreach ($logs as $date => $items) {
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', (string) $date) || !is_array($items)) continue;
            foreach ($valid_names as $name) {
                if (empty($items[$name])) continue;
                $this->db->insert($table, array(
                    'user_id' => $user_id,
                    $date_field => $date,
                    $name_field => $name,
                    'is_completed' => 1
                ));
            }
        }
    }

    private function daily_ayah($ramadhan_start)
    {
        $start = new DateTime($ramadhan_start ?: date('Y-m-d'));
        $today = new DateTime(date('Y-m-d'));
        $day = max(1, min(30, ((int) $start->diff($today)->format('%r%a')) + 1));

        return $this->db
            ->select("quran_ayahs.arabic_text, quran_ayahs.translation_id AS translation, CONCAT('QS. ', quran_surahs.name_latin, ': ', quran_ayahs.ayah_number) AS source", false)
            ->from('daily_contents')
            ->join('quran_ayahs', 'quran_ayahs.id = daily_contents.ayah_id')
            ->join('quran_surahs', 'quran_surahs.id = quran_ayahs.surah_id')
            ->where('daily_contents.type', 'ayah')
            ->where('daily_contents.ramadhan_day', $day)
            ->limit(1)
            ->get()
            ->row_array();
    }
}
