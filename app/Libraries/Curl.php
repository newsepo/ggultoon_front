<?php
/* ===================================================================
    CURL 라이브러리
=================================================================== */
namespace App\Libraries;

class Curl
{
    protected int $iTimeOut;
    protected string $sUserAgent;
    protected string $sCookieFilename;
    protected ?int $iProxyPort = null;
    protected ?int $iErrorNo = null;
    protected ?string $sCurlType = null;
    protected ?string $sCookies = null;
    protected ?string $sProxy = null;
    protected ?string $sProxyType = null;
    protected ?string $sErrorMsg = null;
    protected ?string $sResult;
    protected ?array $aHeader = null;
    protected ?array $aCustomHeader = null;

    protected function __construct()
    {
        $this->sUserAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.81 Safari/537.36';
        $this->iTimeOut = 3;
        $this->sCookieFilename = "/cookies.txt";
    }

    /* ===================================================================
        Set Functions
    =================================================================== */
    /**
     * 헤더 초기화
     */
    public function setClearHeader()
    {
        $this->aHeader = null;
    }

    /**
     * curl 타입 설정
     */
    public function setCurlType($sType)
    {
        if (in_array($sType, [
                'get',
                'post',
                'json',
            ]) === true) {
            $this->sCurlType = $sType;
        } else {
            $this->sCurlType = 'get';
        }
    }

    /**
     * 기본 헤더 셋팅
     */
    public function setHeader()
    {
        switch ($this->sCurlType) {
            case 'json':
                if (empty($this->aCustomHeader) === true || count($this->aCustomHeader) <= 0) {
                    $this->aHeader = [];
                    $this->aHeader[] = 'Access-Control-Allow-Origin: *';
                    $this->aHeader[] = 'Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With';
                    $this->aHeader[] = 'Accept: application/json';
                    $this->aHeader[] = 'Connection: Keep-Alive';
                    $this->aHeader[] = 'Content-Type: application/json';
                } else {
                    $this->aHeader = $this->aCustomHeader;
                }
                break;

            case 'get':
            case 'post':
            default:
                if (empty($this->aCustomHeader) === true || count($this->aCustomHeader) <= 0) {
                    $this->aHeader = [];
                    $this->aHeader[] = 'Access-Control-Allow-Origin: *';
                    $this->aHeader[] = 'Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With';
                    $this->aHeader[] = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg';
                    $this->aHeader[] = 'Connection: Keep-Alive';
                    $this->aHeader[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
                } else {
                    $this->aHeader = $this->aCustomHeader;
                }
                break;
        }
    }

    public function setProxy($proxy, $proxyport = 80)
    {
        $this->sProxy = $proxy;
        $this->iProxyPort = $proxyport;
    }

    public function setProxyType($sProxyType)
    {
        $this->sProxyType = $sProxyType;
    }

    public function setTimeout($time)
    {
        $this->iTimeOut = $time;
    }

    /**
     * 사용자 헤더 설정
     */
    public function setCustomHeaders($headers)
    {
        if (empty($headers) === false) {
            if (is_array($headers) === true) {
                $this->aCustomHeader = $headers;
            } else {
                $this->aCustomHeader[] = $headers;
            }
        }
    }

    public function setAgent($agent)
    {
        $this->sUserAgent = $agent;
    }

    public function setCookie($cookie)
    {
        if (is_array($cookie) === true) {
            $aStr = [];
            foreach ($cookie as $k => $v) {
                $aStr[] = $k . '=' . $v;
            }

            $this->sCookies = implode('; ', $aStr);
        } else {
            $this->sCookies = $cookie;
        }
    }

    /* ===================================================================
        Get Functions
    =================================================================== */
    /**
     * 결과값 가져오기
     */
    public function getResult(): ?string
    {
        if ($this->iErrorNo) {
            return $this->sErrorMsg;
        } else {
            return $this->sResult;
        }
    }

    /* ===================================================================
        Modules
    =================================================================== */
    /**
     * get 방식으로 특정 URL 결과값 불러오기
     */
    public function get($sUrl)
    {
        $this->setCurlType('get');
        $this->setHeader();
        $this->execute($sUrl);
    }

    /**
     * post 방식으로 특정 URL 결과값 불러오기
     */
    public function post($sUrl, $data)
    {
        $this->setCurlType('post');
        $this->setHeader();
        $this->execute($sUrl, $data);
    }

    /**
     * json 방식으로 특정 URL 결과값 불러오기
     */
    public function json($sUrl, $data)
    {
        $this->setCurlType('json');
        $this->setHeader();
        $this->execute($sUrl, $data);
    }

    /* ===================================================================
        Sub Functions
    =================================================================== */
    private function execute($sUrl, $data = null)
    {
        $process = curl_init();
        curl_reset($process);

        if (empty($this->sProxy) === false) {
            curl_setopt($process, CURLOPT_PROXY, $this->sProxy);
            curl_setopt($process, CURLOPT_PROXYPORT, $this->iProxyPort);

            if (empty($this->sProxyType) === false) {
                curl_setopt($process, CURLOPT_PROXYTYPE, $this->sProxyType);
            }
        }

        curl_setopt($process, CURLOPT_URL, $sUrl);                                     // 접속할 URL 주소 설정
        curl_setopt($process, CURLOPT_FOLLOWLOCATION, true);                    // TRUE로 설정시 HTTP 헤더로 보내는 LOCATION 헤더의 내용을 따름
        curl_setopt($process, CURLOPT_HEADER, false);                           // TRUE로 설정시 헤더의 내용을 출력
        curl_setopt($process, CURLOPT_NOBODY, false);                           // TRUE로 설정시 본문의 내용을 받지 않음
        curl_setopt($process, CURLOPT_RETURNTRANSFER, true);                    // TRUE로 설정시 curl_exec()의 반환 값을 문자열로 반환
        curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false);                   // SSL인증서 유효성검사 설정
        curl_setopt($process, CURLOPT_VERBOSE, false);                          // 세팅시 STDERR로 출력되는데 이걸 임시로 만든 스트림으로 전환(자세한 정보를 출력)
        curl_setopt($process, CURLOPT_AUTOREFERER, true);                       // TRUE로 설정시 Location 리디렉션을 따라갈 때 자동으로 Referer필드를 요청에 추가
        curl_setopt($process, CURLOPT_COOKIESESSION, true);                     // TRUE로 설정시 쿠키 "세션"을 새로 시작
        curl_setopt($process, CURLOPT_HTTPHEADER, $this->aHeader);                    // 설정 HTTP 헤더의 배열입니다.
        curl_setopt($process, CURLOPT_USERAGENT, $this->sUserAgent);                  // HTTP 요청에 사용되는 User-Agent헤더의 내용
        curl_setopt($process, CURLOPT_TIMEOUT, $this->iTimeOut);                      // 반환 값에 대한 타임아웃 설정
        curl_setopt($process, CURLOPT_COOKIEJAR, PATH_LOG . $this->sCookieFilename);    // 연결을 닫을 때 모든 내부 쿠키를 저장할 파일의 이름
        curl_setopt($process, CURLOPT_COOKIEFILE, PATH_LOG . $this->sCookieFilename);   // 쿠키의 데이터를 저장할 파일 이름
        if ($this->sCookies) {
            curl_setopt($process, CURLOPT_COOKIE, $this->sCookies); // HTTP 요청에서 "Set - Cookie :"헤더의 내용.
        }

        switch ($this->sCurlType) {
            case 'post':
                curl_setopt($process, CURLOPT_POST, true);                    // 전송 메서드 설정
                curl_setopt($process, CURLOPT_POSTFIELDS, http_build_query($data)); // 'POST'로 보내는 데이터 정의
                break;

            case 'json':
                curl_setopt($process, CURLOPT_POST, true);
                curl_setopt($process, CURLOPT_POSTFIELDS, json_encode($data));
                break;
        }

        // curl 실행
        $this->sResult = curl_exec($process);
        if ($this->sResult === false) {
            $this->sErrorMsg = curl_error($process);
            $this->iErrorNo = curl_errno($process);
            pushAlarm($this->sErrorMsg);
        }

        curl_close($process);
    }
}
