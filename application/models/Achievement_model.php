<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Achievement_model extends CI_Model
{
    public function all()
    {
        return $this->db
            ->order_by('xp_reward', 'ASC')
            ->get('achievements')
            ->result_array();
    }
}
