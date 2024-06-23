<?php
/* ===================================================================
    사용자정의 라이브러리
=================================================================== */

namespace App\Libraries;

use stdClass;

class Utils
{
    /**
     * JWT Access Token 인증토큰값 검증
     *
     * @return bool : bool
     */
    public static function isAuthorized(): bool
    {
        // 인증초기값 리턴값 설정
        $sHeaderAuthToken = self::getRequestHeader();

        $sToken = null;
        if (!empty($sHeaderAuthToken)) {
            if (preg_match('/Bearer\s(\S+)/', $sHeaderAuthToken, $matches)) {
                $sToken = $matches[1];
            }
        }

        if (is_null($sToken) === true || empty($sToken) === true) {
            return false;
        }

        return self::isAuth($sToken);
    }

    /**
     * jwt 복호화값 검증
     *
     * @param string $sToken
     * @return bool
     */
    public static function isAuth(string $sToken): bool
    {
        $oDecode = self::jwtDecode($sToken);
        $bIsAuth = true;
        if (is_object($oDecode) !== false && count(get_object_vars($oDecode)) > 0) {
            // 유효시간 비교
            if (empty($oDecode->expire_time) === true || $oDecode->expire_time < DB_TIMESTAMP) {
                $bIsAuth = false;
            }
            // 아이디 숫자형체크
            if (is_numeric($oDecode->user_id) !== true || (int)$oDecode->user_id < 1) {
                $bIsAuth = false;
            }
        } else {
            $bIsAuth = false;
        }
        return $bIsAuth;
    }

    /**
     * jwt decode 정보값 가져오기
     *
     * @param string $sToken
     * @return object
     */
    public static function jwtDecode(string $sToken): object
    {
        return JWT::decode($sToken, JWT_SECRET_KEY, array('HS256'));
    }

    /**
     *
     * @param string|null $sMessage
     * @param array|null $aData
     * @return object : Object
     */
    public static function customizeResponse(?string $sMessage = null, ?array $aData = null): object
    {
        $oResponse = new stdClass();
        if ($sMessage != null) $oResponse->message = $sMessage;
        if ($aData != null) $oResponse->data = $aData;

        return $oResponse;
    }

    /**
     * JWT 토큰정보 가져오기
     *
     * @return object
     */
    public static function getTokenInfo(): object
    {
        // 인증초기값 리턴값 설정
        $sHeaderAuthToken = self::getRequestHeader();

        $sToken = null;
        if (!empty($sHeaderAuthToken)) {
            if (preg_match('/Bearer\s(\S+)/', $sHeaderAuthToken, $matches)) {
                $sToken = $matches[1];
            }
        }

        return self::jwtDecode($sToken);
    }

    /**
     * JWT 토큰 인는지 확인
     *
     * @return bool
     */
    public static function isUserCheck(): bool
    {
        $request = service('request');
        // 인증초기값 리턴값 설정
        $sHeaderAuthToken = $request->header('Authorization');

        $sToken = null;
        if (!empty($sHeaderAuthToken)) {
            if (preg_match('/Bearer\s(\S+)/', $sHeaderAuthToken, $matches)) {
                $sToken = $matches[1];
            }
        }

        return !(is_null($sToken) === true);
    }

    /**
     * header Authorization 추출
     *
     * @return string
     */
    public static function getRequestHeader(): string
    {
        $request = service('request');
        // 인증초기값 리턴값 설정
        return $request->header('Authorization');
    }
}



