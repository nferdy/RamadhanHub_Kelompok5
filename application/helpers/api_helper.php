<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('json_response')) {
    function json_response($success = true, $message = '', $data = array(), $http_status = 200)
    {
        $CI =& get_instance();
        return $CI->output
            ->set_status_header($http_status)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode(array(
                'success' => (bool) $success,
                'message' => (string) $message,
                'data' => $data
            ), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }
}
