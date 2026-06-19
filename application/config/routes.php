<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['dashboard'] = 'dashboard/index';
$route['kalender'] = 'calendar/index';
$route['puasa'] = 'fasting/index';
$route['sholat'] = 'prayer/index';
$route['quran'] = 'quran/index';
$route['achievement'] = 'achievements/index';

$route['api/state']['GET'] = 'api/state';
$route['api/state/save']['POST'] = 'api/state_save';
$route['api/fasting/save']['POST'] = 'api/fasting_save';
$route['api/quran/save']['POST'] = 'api/quran_save';
$route['api/prayer/save']['POST'] = 'api/prayer_save';
