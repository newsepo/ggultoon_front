<?php

// 서버점검시 $isMaintenance = true로 변경
$isMaintenance = false;

if ($isMaintenance && file_exists('./maintenance.php')) {
    // 점검 시간 / 내용 설정
    $dateTime = '11월 14일 오전 10시 ~ 10시 30분';
    $description = '서비스 안정성 확보를 위한 점검';

    // 서버점검 제외 아이피 설정
    $iplist = array(
        '172.16.4.1',       // 4층 사무실
        '125.143.175.97',   // 5층 사무실(어비즈)
        '218.145.84.163',   // 3층 WIFI
        '121.134.33.233',   // 3층 사무실(엠버스랩)
        '220.118.87.105',   // 3층 사무실(엔티웍스)
        '121.135.254.185',  // 3층 사무실(미디랩스)
        '125.143.175.97',   // 3층 사무실(어비즈)
        '218.145.84.165',   // 2층 사무실
        '218.145.84.164',   // 2층 사무실
        '218.145.84.162',   // 2층 사무실
        '121.138.58.135',   // 5층 사무실 / VPN
        '121.138.58.134',   // 4층 사무실
        '220.127.239.249',  // 나영주대표님 재택
        '121.133.100.138',  // 왕님 재택
        '112.145.122.38',   // 더잼미디어
    );

    // 회원 아이피
    $clientIp = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
    if(!in_array( $clientIp,$iplist )) {
        include('./maintenance.php');
        exit;
    }
}

// Check PHP version.
$minPhpVersion = '7.4'; // If you update this, don't forget to update `spark`.
if (version_compare(PHP_VERSION, $minPhpVersion, '<')) {
    $message = sprintf(
        'Your PHP version must be %s or higher to run CodeIgniter. Current version: %s',
        $minPhpVersion,
        PHP_VERSION
    );

    exit($message);
}

// Path to the front controller (this file)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Ensure the current directory is pointing to the front controller's directory
chdir(FCPATH);

/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 * This process sets up the path constants, loads and registers
 * our autoloader, along with Composer's, loads our constants
 * and fires up an environment-specific bootstrapping.
 */

// Load our paths config file
// This is the line that might need to be changed, depending on your folder structure.
require FCPATH . '../app/Config/Paths.php';
// ^^^ Change this line if you move your application folder

$paths = new Config\Paths();

// Location of the framework bootstrap file.
require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';

// Load environment settings from .env files into $_SERVER and $_ENV
require_once SYSTEMPATH . 'Config/DotEnv.php';
(new CodeIgniter\Config\DotEnv(ROOTPATH))->load();

/*
 * ---------------------------------------------------------------
 * GRAB OUR CODEIGNITER INSTANCE
 * ---------------------------------------------------------------
 *
 * The CodeIgniter class contains the core functionality to make
 * the application run, and does all the dirty work to get
 * the pieces all working together.
 */

$app = Config\Services::codeigniter();
$app->initialize();
$context = is_cli() ? 'php-cli' : 'web';
$app->setContext($context);

/*
 *---------------------------------------------------------------
 * LAUNCH THE APPLICATION
 *---------------------------------------------------------------
 * Now that everything is set up, it's time to actually fire
 * up the engines and make this app do its thang.
 */

$app->run();
