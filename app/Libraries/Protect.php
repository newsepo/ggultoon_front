<?php
/* ===================================================================
    암복호화 라이브러리
=================================================================== */
namespace App\Libraries;

class Protect
{
    protected string $sAlg;
    protected string $sSecureKey;
    protected string $sSecureIV;

    public function __construct()
    {
        // 암호화 알고리즘
        $this->sAlg = 'AES-256-CBC';

        // 암호화 키
        $this->sSecureKey = '9a1E5a1b2l6DeC9c06fC1e7uC2A41x8o5';
    }

    /* ===================================================================
        iv 셋팅
    =================================================================== */
    public function createIv($str = '')
    {
        if (empty($str) === true) {
            $this->sSecureIV = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->sAlg));
        } else {
            $this->sSecureIV = substr(hash('sha256', $str), 0, openssl_cipher_iv_length($this->sAlg));
        }
    }

    public function setIv($iv)
    {
        if (empty($iv) === true) {
            $this->sSecureIV = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->sAlg));
        } else {
            $this->sSecureIV = substr($iv . str_repeat('#', 15), 0, openssl_cipher_iv_length($this->sAlg));
        }
    }

    public function getIv(): string
    {
        return $this->sSecureIV;
    }

    /* ===================================================================
        암호화 처리
    =================================================================== */
    /**
     * 패스워드 암호화
     *
     * @param null $str
     * @return string
     */
    public function getPasswordHash($str = null): string
    {
        return hash('sha512', hash('md5', $this->sSecureKey . $str));
    }

    /**
     * 암호화
     */
    public function encrypt($val = null)
    {
        if (empty($val) === true) {
            return false;
        }

        if (is_array($val) === true) {
            $arr = $val;
        } else {
            $arr = [
                $this->sAlg => $val,
                't' => time(),
                'r' => rand(1, 1000),
                'u' => uniqid(),
            ];
        }

        return $this->encryptArr($arr);
    }

    /**
     * 복호화
     */
    public function decrypt($str)
    {
        if (empty($str) === true) {
            return false;
        }

        $arr = $this->decryptArr($str);
        return $arr[$this->sAlg] ?? $arr;
    }

    /* ===================================================================
        Basic Function
    =================================================================== */
    /**
     * 배열 암호화
     */
    protected function encryptArr($arr = [])
    {
        if (is_array($arr) === false || empty($arr) === true) {
            return false;
        }

        $aShuffle = $this->shuffleArr($arr);
        $str = json_encode($aShuffle);

        return $this->encryptProc($str);
    }

    /**
     * 배열 복호화
     */
    protected function decryptArr($str = '')
    {
        if (empty($str) === true) {
            return false;
        }

        $sDecoding = $this->decryptProc($str);

        return json_decode($sDecoding, true);
    }

    /**
     * 암호함수
     */
    protected function encryptProc($str = null)
    {
        if ($str == null || $str == '') {
            return false;
        }

        $sEncoding = openssl_encrypt($str, $this->sAlg, $this->sSecureKey, OPENSSL_RAW_DATA, $this->sSecureIV);

        return base64_encode($sEncoding);
    }

    /**
     * 복호함수
     */
    protected function decryptProc($str = null)
    {
        if ($str == null || $str == '') {
            return false;
        }

        $sDecoding = base64_decode($str);

        return openssl_decrypt($sDecoding, $this->sAlg, $this->sSecureKey, OPENSSL_RAW_DATA, $this->sSecureIV);
    }

    /**
     * 배열 랜덤 섞기
     */
    protected function shuffleArr($arr)
    {
        if (!is_array($arr)) {
            return $arr;
        }

        $keys = array_keys($arr);
        shuffle($keys);

        $result = [];
        foreach ($keys as $key) {
            $result[$key] = $arr[$key];
        }

        return $result;
    }
}
