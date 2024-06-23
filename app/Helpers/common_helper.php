<?php

use Config\Services;

/**
 * 디렉토리 생성
 */
function execMkdir($sDirName = '', $chmod = 0777): bool
{
    if (empty($sDirName) === true) {
        return false;
    }

    // 절대경로부터 시작함
    $dirs = explode('/', $sDirName);
    $d = '/';

    foreach ($dirs as $v) {
        if ($v === '') {
            continue;
        }

        $d .= $v . '/';
        if (!is_dir($d)) {
            umask(0);

            if (!mkdir($d, $chmod)) {
                return false;
            }
        }
    }

    @chmod($sDirName, $chmod);

    return true;
}

/**
 * 파일 로그 기록하기
 */
function writeLog($sFilename, $sMsg = '', $sFolder = '', $sTimeType = 'D'): bool
{
    $sWriteRootPath = PATH_LOG . rtrim($sFolder, DIRECTORY_SEPARATOR);
    $sWriteFilePath = $sWriteRootPath . $sFilename;

    if (empty($sFolder) === false) {
        execMkdir($sWriteRootPath);
    }

    switch ($sTimeType) {
        case 'Y':
            $sWritePath = $sWriteFilePath . '_' . date('Y', strtotime('NOW')) . CNF_SUFFIX_LOG;
            break;

        case 'M':
            $sWritePath = $sWriteFilePath . '_' . date('Ym', strtotime('NOW')) . CNF_SUFFIX_LOG;
            break;

        case 'D':
            $sWritePath = $sWriteFilePath . '_' . date('Ymd', strtotime('NOW')) . CNF_SUFFIX_LOG;
            break;

        case 'H':
            $sWritePath = $sWriteFilePath . '_' . date('YmdH', strtotime('NOW')) . CNF_SUFFIX_LOG;
            break;

        default:
            $sWritePath = $sWriteFilePath . CNF_SUFFIX_LOG;
            break;
    }

    $aDebug = debug_backtrace();
    $sFile = $aDebug[0]['file'];
    $iLine = $aDebug[0]['line'];

    $aLogs = [];
    $aLogs[] = '===========================================' . "\n";
    $aLogs[] = 'TIME : ' . date("Y-m-d H:i:s", strtotime('NOW')) . "\n";
    $aLogs[] = 'FILE : ' . $sFile . "\n";
    $aLogs[] = 'LINE : ' . $iLine . "\n";
    $aLogs[] = var_export($sMsg, true) . "\n";
    $aLogs[] = '===========================================' . "\n";
    $sLogMsg = implode("", $aLogs);

    return @error_log($sLogMsg . "\n", 3, $sWritePath);
}

/**
 * 문자열에서 숫자만 추출
 */
function onlyNum($str)
{
    return preg_replace("/\D*/s", "", $str);
}

/**
 * 스네이크 표기법 => 카멜 표기법 전환
 */
function snakeToCamel($str)
{
    return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $str))));
}

/**
 * 이미지 리사이즈
 */
function resizeImage($file, $w, $h, $crop = false, $degree = 0)
{
    [
        $width,
        $height,
        $sImageType,
    ] = getimagesize($file);
    $r = $width / $height;

    $src = null;
    if ($sImageType == IMAGETYPE_JPEG) {
        $src = imagecreatefromjpeg($file);
    } elseif ($sImageType == IMAGETYPE_GIF) {
        $src = imagecreatefromgif($file);
    } elseif ($sImageType == IMAGETYPE_PNG) {
        $src = imagecreatefrompng($file);
    }

    // 자르기
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width - ($width * abs($r - $w / $h)));
        } else {
            $height = ceil($height - ($height * abs($r - $w / $h)));
        }

        $iNewWidth = $w;
        $iNewHeight = $h;
    } else {
        $iNewWidth = $w;
        $iNewHeight = $w / $r;
    }

    $dst = imagecreatetruecolor($iNewWidth, $iNewHeight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $iNewWidth, $iNewHeight, $width, $height);

    // 회전
    if ($degree > 0) {
        $dst = imagerotate($dst, $degree, 0);
    }

    if ($sImageType == IMAGETYPE_JPEG) {
        imagejpeg($dst, $file, 100);
    } else {
        if ($sImageType == IMAGETYPE_GIF) {
            imagegif($dst, $file);
        } else {
            if ($sImageType == IMAGETYPE_PNG) {
                imagepng($dst, $file, 9);
            }
        }
    }

    imagedestroy($src);

    return $dst;
}

/**
 * 기간 배열 생성하기
 */
function getPeriod($startDate, $endDate, $sInterval = 'day'): array
{
    try {
        $start = new DateTime($startDate);
        $end = new DateTime($endDate);

        $sInterval = DateInterval::createFromDateString('1 ' . $sInterval);
        $period = new DatePeriod($start, $sInterval, $end);

        $aDate = [];
        foreach ($period as $dt) {
            $aDate[] = $dt->format('Y-m-d');
        }
        $aDate[] = date('Y-m-d', strtotime($endDate));

        return $aDate;
    } catch (Exception $e) {
        return [];
    }
}

/**
 * 쿠키 셋팅
 */
function setCookies($sKey, $sVal, $iExpire = 0): void
{
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
        $aCookieOptions = [
            'expires' => time() + $iExpire,
            'path' => '/',
            'domain' => URL_COOKIE,
            'secure' => true,   // false
            'samesite' => 'None',  // None | Lax | Strict
            'httponly' => true,   // false
        ];
        setcookie($sKey, $sVal, $aCookieOptions);
    } else {
        setcookie($sKey, $sVal, time() + $iExpire, '/', URL_COOKIE);
    }
}

/**
 * 바이트 사이즈 변환
 */
function sizeConvert($size): string
{
    if (is_numeric($size) === false || $size <= 0) {
        return false;
    }

    $unit = [
        'B',
        'KB',
        'MB',
        'GB',
        'TB',
        'PB',
    ];

    return round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
}

/**
 * URL 생성
 *
 * @param string $sPath
 * @return string
 */
function getAssetPath(string $sPath): string
{
    $sFileTime = time();

    if (is_file(FCPATH . $sPath)) {
        $sFileTime = filemtime(FCPATH . $sPath);
    }

    return $sPath . '?v=' . $sFileTime;
}

/**
 * 텔레그램 푸쉬 API
 * https://api.telegram.org/bot1989561465:AAF8KLK9ni-qUOuOMZZkh0_NeI7XOSHkT4g/getUpdates
 */
function pushAlarm($sMsg = '', $sTgId = 'ALL'): bool
{
    if (empty($sMsg) === true) {
        return false;
    }

    // 메시지 정제
    if (is_array($sMsg) === true) {
        $aMsgText = [];
        foreach ($sMsg as $k => $v) {
            if (is_numeric($k) === false) {
                $aMsgText[] = '[' . $k . '] : ' . var_export($v, true);
            } else {
                $aMsgText[] = $v;
            }
        }
        $sMsg = @implode("\n", $aMsgText);
    }

    // 텔레그램 발송 대상 아이디 가져오기
    $config = config('Common');
    $aTgAdmin = $config->aTgAdmin;
    $sDevNull = '" > /dev/null 2>/dev/null &';

    if ($sTgId !== 'ALL') {
        // 한명만 발송
        foreach ($aTgAdmin as $k => $iTgAdmin) {
            if (strtoupper($sTgId) == $k) {
                // 푸시발송
                $parameters = [
                    'chat_id' => $iTgAdmin,
                    'text' => mb_substr($sMsg, 0, 3700),
                ];

                $url = URL_TELEGRAM_BOT . TG_TOKEN . '/sendMessage?' . http_build_query($parameters);
                $url = urlencode(urlencode($url));
                shell_exec('php ' . PATH_PUBLIC . 'index.php tg send_cli "' . $url . $sDevNull);
            }
        }
    } else {
        // 전체 발송
        foreach ($aTgAdmin as $k => $iTgAdmin) {
            if ($k == 'ALL') {
                // 푸시발송
                $parameters = [
                    'chat_id' => $iTgAdmin,
                    'text' => mb_substr($sMsg, 0, 3700),
                ];
                $url = URL_TELEGRAM_BOT . TG_TOKEN . '/sendMessage?' . http_build_query($parameters);
                $url = urlencode(urlencode($url));
                shell_exec('php ' . PATH_PUBLIC . 'index.php tg send_cli "' . $url . $sDevNull);
            }
        }
    }

    return true;
}

/**
 * 언어 함수 확장
 */
function langs(string $sKey, array $aArgs = [], string $sLocale = null): string
{
    // 언어 위치 미지정시 기설정된 위치값 가져오기
    if (is_null($sLocale)) {
        $oLocale = Config\Services::language();
        $sLocale = $oLocale->getLocale();
    }

    // 설정된 위치값 기준으로 값 가져오기
    return lang($sKey, $aArgs, $sLocale);
}

/**
 * 디버깅
 */
function v()
{
    echo '<xmp class="text-danger">';
    $mArgs = func_get_args();
    call_user_func_array('var_dump', $mArgs);
    echo '</xmp>';
}

function vv()
{
    echo '<xmp class="text-danger">';
    $mArgs = func_get_args();
    call_user_func_array('var_dump', $mArgs);
    echo '</xmp>';
    exit;
}

/**
 * 남은시간계산
 *
 * @param int $iTimeSec
 * @return string
 */
function remainTimeToDateTime(int $iTimeSec): string
{
    if ($iTimeSec > 86400) {
        $sTmpDay = ceil($iTimeSec / 86400);
        return $sTmpDay . "일";
    } else if ($iTimeSec > 3600) {
        $sTmpHour = ceil($iTimeSec / 3600);
        return $sTmpHour . '시간';
    } else if ($iTimeSec > 60) {
        $sTmpMin = ceil($iTimeSec / 60);
        return $sTmpMin . '분';
    } else {
        return $iTimeSec . '초';
    }
}

/**
 * 경과시간 계산
 *
 * @param int $iOldTime
 * @param string $sType
 * @return string
 */
function sinceTime(int $iOldTime, string $sType = 'int'): string
{
    $iTime = ($sType == 'int') ? time() - $iOldTime : time() - strtotime($iOldTime);

    $aChunks = array(
        array(60 * 60 * 24 * 365, '년전'),
        array(60 * 60 * 24 * 30, '개월전'),
        array(60 * 60 * 24 * 7, '주전'),
        array(60 * 60 * 24, '일전'),
        array(60 * 60, '시간전'),
        array(60, '분전'),
        array(1, '초전'),
    );

    $iCount = "";
    $sName = "";
    for ($i = 0, $j = count($aChunks); $i < $j; $i++) {
        $iSeconds = $aChunks[$i][0];
        $sName = $aChunks[$i][1];

        if (($iCount = floor($iTime / $iSeconds)) != 0) {
            break;
        }
    }

    return $iCount . $sName;
}