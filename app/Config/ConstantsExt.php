<?php

/**
 * Service Config
 */
// 프로젝트 구분값
defined('ENV_PRD') || define('ENV_PRD', 'prd');
defined('ENV_STG') || define('ENV_STG', 'stg');
defined('ENV_DEV') || define('ENV_DEV', 'dev');
defined('ENV_DOCKER') || define('ENV_DOCKER', 'docker');
// 서버에서 프로젝트별 구분하는 폴더
defined('SERVER_PRD') || define('SERVER_PRD', '/prd/');
defined('SERVER_STG') || define('SERVER_STG', '/stg/');
defined('SERVER_DEV') || define('SERVER_DEV', '/dev/');
defined('SERVER_DOCKER') || define('SERVER_DOCKER', '/docker/');
// 서버 설정 URL : cli용
defined('SERVER_URL_PRD') || define('SERVER_URL_PRD', 'www.ggultoons.com');
defined('SERVER_URL_STG') || define('SERVER_URL_STG', 'front.gtdev.kr');
defined('SERVER_URL_DEV') || define('SERVER_URL_DEV', 'webtoon-front.devlabs.co.kr');
defined('SERVER_URL_DOCKER') || define('SERVER_URL_DOCKER', 'test.test.com');
// 사이트 설정
defined('CNF_SUFFIX_LOG') || define('CNF_SUFFIX_LOG', '.log');
defined('CNF_SERVICE') || define('CNF_SERVICE', 'front');
defined('CNF_TITLE') || define('CNF_TITLE', '꿀툰');
// API 호출용
defined('SERVER_API_URL_PRD') || define('SERVER_API_URL_PRD', 'api.ggultoons.com');
defined('SERVER_API_URL_STG') || define('SERVER_API_URL_STG', 'api.gtdev.kr');
defined('SERVER_API_URL_DEV') || define('SERVER_API_URL_DEV', 'webtoon-api.devlabs.co.kr:18080');

/**
 * TELEGRAM
 */
defined('TG_BOT') || define('TG_BOT', 'ottAlertBot');
defined('TG_TOKEN') || define('TG_TOKEN', '6032686607:AAGSGuf4X-K_dVPRULCeTt4jlxd3LO-ZrF4');    // 텔레그램 관리자 봇

/**
 * dev , prd , stg DB접속정보
 */
// master db 정보
defined('MAIN_DATABASE_IP') || define('MAIN_DATABASE_IP', 'localhost');
defined('MAIN_DATABASE_USERNAME') || define('MAIN_DATABASE_USERNAME', '');
defined('MAIN_DATABASE_PASSWORD') || define('MAIN_DATABASE_PASSWORD', '');
defined('MAIN_DATABASE_DATABASE') || define('MAIN_DATABASE_DATABASE', '');
defined('MAIN_DATABASE_PORT') || define('MAIN_DATABASE_PORT', '3306');

// replica ip 정보
$aReplicaSlaveDb = ['localhost'];
$iSelectServer = mt_rand(0, count($aReplicaSlaveDb) - 1);
$sReplicaDBIp = $aReplicaSlaveDb[$iSelectServer];
defined('REPLICA_DATABASE_IP') || define('REPLICA_DATABASE_IP', $sReplicaDBIp);
defined('REPLICA_DATABASE_USERNAME') || define('REPLICA_DATABASE_USERNAME', '');
defined('REPLICA_DATABASE_PASSWORD') || define('REPLICA_DATABASE_PASSWORD', '');
defined('REPLICA_DATABASE_DATABASE') || define('REPLICA_DATABASE_DATABASE', '');
defined('REPLICA_DATABASE_PORT') || define('REPLICA_DATABASE_PORT', '3306');

// localhost db  -dev
defined('DEV_DATABASE_IP') || define('DEV_DATABASE_IP', 'localhost');
defined('DEV_DATABASE_USERNAME') || define('DEV_DATABASE_USERNAME', '');
defined('DEV_DATABASE_PASSWORD') || define('DEV_DATABASE_PASSWORD', '');
defined('DEV_DATABASE_DATABASE') || define('DEV_DATABASE_DATABASE', '');
defined('DEV_DATABASE_PORT') || define('DEV_DATABASE_PORT', '3306');

defined('DEV_REPLICA_DATABASE_IP') || define('DEV_REPLICA_DATABASE_IP', 'localhost');
defined('DEV_REPLICA_DATABASE_USERNAME') || define('DEV_REPLICA_DATABASE_USERNAME', '');
defined('DEV_REPLICA_DATABASE_PASSWORD') || define('DEV_REPLICA_DATABASE_PASSWORD', '');
defined('DEV_REPLICA_DATABASE_DATABASE') || define('DEV_REPLICA_DATABASE_DATABASE', '');
defined('DEV_REPLICA_DATABASE_PORT') || define('DEV_REPLICA_DATABASE_PORT', '3306');

/**
 * JWT Secret Key값
 */
defined('JWT_SECRET_KEY') || define('JWT_SECRET_KEY', 'vkdlfzotmxmeoqkr'); // 파일캐스트대박

/**
 * Time 설정값
 */
defined('DB_TIMESTAMP') || define('DB_TIMESTAMP', time());
defined('DB_DATETIME') || define('DB_DATETIME', date('Y-m-d H:i:s'));

/**
 * 소셜 KEY
 */
defined('NAVER_CLIENT_ID_PRD') || define('NAVER_CLIENT_ID_PRD', 'YysZe0r8Tsc1zwWHNIuL');
defined('NAVER_CLIENT_ID_DEV') || define('NAVER_CLIENT_ID_DEV', 'jpaN14xpC_Ii1CuDrr3W');
defined('KAKAO_CLIENT_ID_PRD') || define('KAKAO_CLIENT_ID_PRD', '273efd16538ca2406f3977fafdee4811');
defined('KAKAO_CLIENT_ID_DEV') || define('KAKAO_CLIENT_ID_DEV', '9bf5a0aad510a76b5fba6b9f029d2fae');
/*defined('NEXT_PUBLIC_CHANNEL_TALK_KEY', '4803137b-e885-4e62-847e-bdd0b99e35f9');
defined('NEXT_PUBLIC_CHANNEL_TALK_SECRETKEY', '384c114a1890bfe6d12ee98d2ca475f581af56d49930b4f0f3d1ba1beb3853ec');*/



/******************************************************************
 *
 * 아래는 가급적 수정하지 마세요!!
 *
 ******************************************************************/
// 서버 환경변수가 설정안되어 있을 경우 : cli 용
if (isset($_SERVER['ENV']) === false) {
    if (strpos($_SERVER['DOCUMENT_ROOT'], SERVER_PRD) !== false) {
        $_SERVER['ENV'] = ENV_PRD;
    } elseif (strpos($_SERVER['DOCUMENT_ROOT'], SERVER_STG) !== false) {
        $_SERVER['ENV'] = ENV_STG;
    } elseif (strpos($_SERVER['DOCUMENT_ROOT'], SERVER_DEV) !== false) {
        $_SERVER['ENV'] = ENV_DEV;
    } else {
        $_SERVER['ENV'] = ENV_DOCKER;
    }
}

// 프로토콜 설정
$CNF = [];
$cnfHTTPS = "https://";
if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
    $CNF['PROTOCOL'] = $_SERVER['HTTP_X_FORWARDED_PROTO'] . '://';
} else {
    $CNF['PROTOCOL'] = !isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on' ? 'http://' : $cnfHTTPS;
}
if ($CNF['PROTOCOL'] == $cnfHTTPS) {
    $_SERVER['HTTPS'] = 'on';
}

/**
 * URL 설정
 */
switch ($_SERVER['ENV']) {
    case ENV_PRD:
        $sConfigDomain = SERVER_URL_PRD;
        $sServiceUrl = $cnfHTTPS . $sConfigDomain;
        $sApiDomain = $cnfHTTPS.SERVER_API_URL_PRD;
        $kakaoClientId = KAKAO_CLIENT_ID_PRD;
        $naverClientId = NAVER_CLIENT_ID_PRD;
        break;

    case ENV_STG:
        $sConfigDomain = SERVER_URL_STG;
        $sServiceUrl = $cnfHTTPS . $sConfigDomain;
        $sApiDomain = $cnfHTTPS.SERVER_API_URL_STG;
        $kakaoClientId = KAKAO_CLIENT_ID_DEV;
        $naverClientId = NAVER_CLIENT_ID_DEV;
        defined('ENVIRONMENT') || define('ENVIRONMENT', 'development');
        break;

    default :
        $sConfigDomain = SERVER_URL_DEV;
        $sServiceUrl = $cnfHTTPS . $sConfigDomain;
        $sApiDomain = $cnfHTTPS.SERVER_API_URL_DEV;
        $kakaoClientId = KAKAO_CLIENT_ID_DEV;
        $naverClientId = NAVER_CLIENT_ID_DEV;
        defined('ENVIRONMENT') || define('ENVIRONMENT', 'development');
        break;
}

/**
 * Config
 */
defined('ENVIRONMENT') || define('ENVIRONMENT', 'production');
defined('CNF_ROOT') || define('CNF_ROOT', FCPATH . '../');
defined('CNF_DOMAIN') || define('CNF_DOMAIN', $sConfigDomain);
defined('API_DOMAIN') || define('API_DOMAIN', $sApiDomain);

/**
 * 소셜 client id
 */
defined('NEXT_PUBLIC_NAVER_CLIENT_ID') || define('NEXT_PUBLIC_NAVER_CLIENT_ID', $naverClientId);
defined('NEXT_PUBLIC_KAKAO_KEY') || define('NEXT_PUBLIC_KAKAO_KEY', $kakaoClientId);

/**
 * PATH
 */
defined('PATH_ROOT') || define('PATH_ROOT', CNF_ROOT . DIRECTORY_SEPARATOR);
defined('PATH_APP') || define('PATH_APP', PATH_ROOT . 'app' . DIRECTORY_SEPARATOR);
defined('PATH_CONFIG') || define('PATH_CONFIG', PATH_APP . 'Config' . DIRECTORY_SEPARATOR);
defined('PATH_VIEWS') || define('PATH_VIEWS', PATH_APP . 'Views' . DIRECTORY_SEPARATOR);
defined('PATH_PUBLIC') || define('PATH_PUBLIC', PATH_ROOT . 'public' . DIRECTORY_SEPARATOR);
defined('PATH_ASSET') || define('PATH_ASSET', PATH_PUBLIC . 'assets' . DIRECTORY_SEPARATOR);
defined('PATH_CPNT') || define('PATH_CPNT', PATH_ASSET . 'components' . DIRECTORY_SEPARATOR);
defined('PATH_JS') || define('PATH_JS', PATH_ASSET . 'js' . DIRECTORY_SEPARATOR);
defined('PATH_CSS') || define('PATH_CSS', PATH_ASSET . 'css' . DIRECTORY_SEPARATOR);
defined('PATH_EDITOR') || define('PATH_EDITOR', PATH_ASSET . 'editor' . DIRECTORY_SEPARATOR);
defined('PATH_WRITABLE') || define('PATH_WRITABLE', PATH_ROOT . 'writable' . DIRECTORY_SEPARATOR);
defined('PATH_LOG') || define('PATH_LOG', PATH_WRITABLE . 'logs' . DIRECTORY_SEPARATOR);
defined('PATH_TPL') || define('PATH_TPL', PATH_WRITABLE . 'cache/template' . DIRECTORY_SEPARATOR);
defined('PATH_TPL_COMPILE') || define('PATH_TPL_COMPILE', PATH_TPL . '_compile');
defined('PATH_TPL_CACHE') || define('PATH_TPL_CACHE', PATH_TPL . '_cache');

/**
 * URL
 */
$CNF['DOMAIN'] = CNF_DOMAIN;
if (isset($_SERVER['SERVER_NAME']) === true) {
    $CNF['SCRIPT_NAME'] = str_replace(basename($_SERVER['SCRIPT_NAME']), null, $_SERVER['SCRIPT_NAME']);
    $CNF['DOMAIN'] = rtrim($_SERVER['SERVER_NAME'] . $CNF['SCRIPT_NAME'], '/');
}

$CNF['PORT'] = '';
if (isset($_SERVER['SERVER_PORT']) === true && in_array($_SERVER['SERVER_PORT'], ['80', '443']) === false) {
    $CNF['PORT'] = ':' . $_SERVER['SERVER_PORT'];
}

defined('URL_DOMAIN') || define('URL_DOMAIN', $CNF['PROTOCOL'] . $CNF['DOMAIN'] . $CNF['PORT']);
defined('URL_COOKIE') || define('URL_COOKIE', '.' . $CNF['DOMAIN']);
defined('URL_TELEGRAM_BOT') || define('URL_TELEGRAM_BOT', 'https://api.telegram.org/bot');
