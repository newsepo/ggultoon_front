<?php

namespace App\Controllers;

use App\Libraries\Template_;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Exception;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    // ci4 attributes
    protected $validation;
    protected $request;
    protected $helpers = ['form', 'url', 'common', 'cookie'];
    protected $session;
    protected $language;

    // 라이브러리 로드
    protected Template_ $tpl;

    // 변수 설정
    protected array $aViewPage = [];         // 페이지 뷰
    protected array $aSetData = [];          // 페이지에 전달할 데이터
    protected string $sLangDirectory = '';   // 언어별 디렉토리 설정

    /**
     * Constructor
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        $this->validation = Services::validation();
        $this->tpl = new Template_();

        // http://ci4doc.cikorea.net/libraries/sessions.html
        // $this->session = Services::session();

        // set language
        $this->language = Services::language();
        $this->sLangDirectory = $this->setLanguage();
        $this->aSetData['CNF']['LANG'] = $this->sLangDirectory;
    }

    /**
     * 언어셋 설정
     */
    protected function setLanguage(): string
    {
        // 쿠키에서 로케일 정보 가져옴
        $sCookieLang = get_cookie('lang');
        if (in_array($sCookieLang, $this->request->config->supportedLocales) === false) {
            $sCookieLang = $this->request->getDefaultLocale();
        }

        // 없을 경우 기본 로케일 가져옴
        if (empty($sCookieLang)) {
            $sCookieLang = $this->request->getDefaultLocale();
        }

        // 로케일 설정
        $this->language->setLocale($sCookieLang);

        // 설정된 로케일 쿠키 생성
        setCookies('lang', $sCookieLang, 60 * 60 * 24 * 30);

        return $sCookieLang;
    }

    /**
     * 파라미터 체크 및 셋팅하기
     *
     * @param array $aParams
     * @param string $sType
     * @param bool $bAjax
     * @return array
     * @throws Exception
     */
    protected function chkParam(array $aParams, string $sType = "get_post", bool $bAjax = false)
    {
        $aParam = [];

        // 타입별로 값 입력
        $reqMethod = 'get' . Ucfirst(snakeToCamel($sType));
        $p = $this->request->{$reqMethod}();

        // 빈값일 경우, default 값이 존재하면 입력
        foreach ($p as $pk => $pv) {
            if (empty($pv) && isset($aParams[$pk]['errors']['default'])) {
                $aParam[$pk] = $aParams[$pk]['errors']['default'];
            } else {
                $aParam[$pk] = $pv;
            }
        }

        // trim 처리 후 데이터셋
        array_walk_recursive($aParam, function (&$v) {
            $v = trim($v);
        });
        if ($bAjax === false) {
            $this->aSetData['HTML']['param'] = $aParam;
        }

        // check validation
        if (empty($aParams) === false) {
            $this->validation->setRules($aParams);
            if (!$this->validation->run($aParam)) {
                $aErrors = $this->validation->getErrors();
                if (empty($aErrors) === false) {
                    if ($bAjax) {
                        // HTTP Responses 사용시
                        //return $this->displayHttpStatus(401);

                        $sErrorMessage = "";
                        foreach ($aErrors as $sKey => $sVal) {
                            if ($sVal) {
                                $sErrorMessage = $sKey . "" . $sVal;
                                break;
                            }
                        }

                        $aOutPut = [
                            'result' => false,
                            'code' => 9999,
                            'message' => $sErrorMessage,
                        ];
                        $this->displayJson($aOutPut);

                    } else {
                        foreach ($aErrors as $sV) {
                            throw new Exception($sV, 9999);
                        }
                    }
                }
            }
        }

        return $aParam;
    }

    /**
     * HttpStatus response 응답 처리
     *
     * https://codeigniter.com/user_guide/outgoing/response.html
     */
    protected function displayHttpStatus(int $iCode): ResponseInterface
    {
        return $this->response->setStatusCode($iCode);
    }

    /**
     * JS 링크 생성
     */
    protected function linkJs($filename): string
    {
        $result = [];
        if (is_array($filename) === true) {
            foreach ($filename as $file_arr) {
                $result[] = '<script src="' . $file_arr . '" type="text/javascript"></script>';
            }
        } else {
            $result[] = '<script src="' . $filename . '" type="text/javascript"></script>';
        }

        return "\n" . @implode("\n", $result);
    }

    /**
     * CSS 링크 생성
     */
    protected function linkCss($filename): string
    {
        $result = [];
        if (is_array($filename) === true) {
            foreach ($filename as $file_arr) {
                $result[] = '<link rel="stylesheet" type="text/css" media="all" href="' . $file_arr . '" />';
            }
        } else {
            $result[] = '<link rel="stylesheet" type="text/css" media="all" href="' . $filename . '" />';
        }

        return "\n" . @implode("\n", $result);
    }

    /**
     * Json 값 출력
     */
    protected function displayJson(array $val)
    {
        header('Content-Type: application/json');
        $sEncodeJson = json_encode($val);
        $sCallbackFunction = $this->request->getPostGet('callback');
        echo (empty($sCallbackFunction) === false) ? $sCallbackFunction . '(' . $sEncodeJson . ');' : $sEncodeJson;
        exit;
    }

    /**
     * 템플릿 뷰 설정 : 에러 페이지
     */
    protected function displayError(array $except = [], $fetch = false): bool
    {
        // error HTML
        $this->aViewPage = [
            'body' => 'common/error'
        ];

        $this->display($except, $fetch);
        exit;
    }

    /**
     * 템플릿 뷰 설정 : 일반 페이지
     */
    protected function display(array $except = [], bool $fetch = false): bool
    {
        // variables
        $sBlankPage = 'common/blank.php';

        // default page
        $default = [
            'head' => $this->sLangDirectory . DIRECTORY_SEPARATOR . 'common/head.php',
            'main_header' => $this->sLangDirectory . DIRECTORY_SEPARATOR . 'common/main_header.php',
            'menu' => $this->sLangDirectory . DIRECTORY_SEPARATOR . 'common/menu.php',
            'left_menu' => $this->sLangDirectory . DIRECTORY_SEPARATOR . 'common/left_menu.php',
            'body' => $this->sLangDirectory . DIRECTORY_SEPARATOR . $sBlankPage,
            'footer' => $this->sLangDirectory . DIRECTORY_SEPARATOR . 'common/footer.php',
            'layer' => $this->sLangDirectory . DIRECTORY_SEPARATOR . 'common/layer.php',
            'js' => $this->sLangDirectory . DIRECTORY_SEPARATOR . 'common/js.php',
            'import_js' => $this->sLangDirectory . DIRECTORY_SEPARATOR . $sBlankPage,
            'layout' => $this->sLangDirectory . DIRECTORY_SEPARATOR . 'common/layout.php',
            'sideSection' => $this->sLangDirectory . DIRECTORY_SEPARATOR . 'common/side_section.php',
            'login' => $this->sLangDirectory . DIRECTORY_SEPARATOR . 'login/login.php',
            'modal' => $this->sLangDirectory . DIRECTORY_SEPARATOR . 'common/modal.php',
            'mainBanner' => $this->sLangDirectory . DIRECTORY_SEPARATOR . $sBlankPage,
            'subBanner' => $this->sLangDirectory . DIRECTORY_SEPARATOR . $sBlankPage,
            'subFullBanner' => $this->sLangDirectory . DIRECTORY_SEPARATOR . $sBlankPage,
            'noResult' => $this->sLangDirectory . DIRECTORY_SEPARATOR . $sBlankPage
        ];

        return $this->displayProc($default, $except, $fetch);
    }

    /**
     * 템플릿 뷰 설정 :  팝업
     */
    protected function displayPopup(array $except = [], bool $fetch = false): bool
    {
        // variables
        $sBlankPage = 'common/blank.php';

        // default page
        $default = [
            'head' => $this->sLangDirectory . DIRECTORY_SEPARATOR . 'common/head.php',
            'body' => $this->sLangDirectory . DIRECTORY_SEPARATOR . $sBlankPage,
            'js' => $this->sLangDirectory . DIRECTORY_SEPARATOR . 'common/js.php',
            'import_js' => $this->sLangDirectory . DIRECTORY_SEPARATOR . $sBlankPage,
            'layout' => $this->sLangDirectory . DIRECTORY_SEPARATOR . 'common/layout_popup.php',
        ];

        return $this->displayProc($default, $except, $fetch);
    }


    /**
     * 템플릿 뷰 설정 : 레이어 팝업
     * @param array $except
     * @param bool $fetch
     * @return bool
     */
    protected function displayLayerPopup(array $except = [], bool $fetch = false): bool
    {
        // variables
        $sBlankPage = 'common/blank.php';

        // default page
        $default = [
            'body' => $this->sLangDirectory . DIRECTORY_SEPARATOR . $sBlankPage,
            'js' => $this->sLangDirectory . DIRECTORY_SEPARATOR . 'common/js.php',
            'import_js' => $this->sLangDirectory . DIRECTORY_SEPARATOR . $sBlankPage,
            'layout' => $this->sLangDirectory . DIRECTORY_SEPARATOR . 'common/layout_popup.php',
        ];

        return $this->displayProc($default, $except, $fetch);
    }

    /**
     * 템플릿 뷰 실행
     */
    private function displayProc($default, $except, $fetch): bool
    {
        // set default
        $aDef = [];
        foreach ($default as $k => $v) {
            if (in_array($k, $except) === false) {
                $aDef[$k] = $v;
            }
        }

        // set define file lists
        $this->aSetData['DEFINE'] = $aDef;
        $this->tpl->define($aDef);

        // set page
        foreach ($this->aViewPage as $type => $file) {
            if (empty($file) === false) {
                $this->tpl->define($type, $this->sLangDirectory . DIRECTORY_SEPARATOR . $file . '.php');
            } else {
                $this->tpl->define($type, $this->sLangDirectory . DIRECTORY_SEPARATOR . 'common/blank.php');
            }
        }

        // set variable
        foreach ($this->aSetData as $key => $val) {
            $this->tpl->assign($key, $val);
        }

        // print
        if ($fetch === false) {
            $this->tpl->print_('layout');
        } else {
            return $this->tpl->fetch('layout');
        }

        return true;
    }
}
