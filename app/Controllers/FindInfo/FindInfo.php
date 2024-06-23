<?php

namespace App\Controllers\FindInfo;

use App\Controllers\BaseController;
use Exception;

class FindInfo extends BaseController
{
    /**
     * 아이디/비밀번호 찾기
     *
     * @return void
     */
    public function index()
    {
        try {
            // 뷰 페이지 설정
            $this->setDefaultView();

            // set view data
            $this->aSetData['HTML']['CSS'] = $this->linkCss(getAssetPath("/assets/css/" . $this->sLangDirectory . "/findInfo/findInfo.css"));

        } catch (Exception $e) {
            $this->aSetData['ERROR']['file'] = $e->getFile();
            $this->aSetData['ERROR']['line'] = $e->getLine();
            $this->aSetData['ERROR']['message'] = $e->getMessage();
            $this->displayError();
        }

        // run view page
        $this->display();
    }

    /**
     * 아이디 찾기 본인인증
     * @return void
     */
    public function findInfoAuthId()
    {
        // 뷰 페이지 설정
        $this->setDefaultView("findInfoAuthId");
        // run view page
        $this->displayPopup();
    }

    public function findInfoAuthPw()
    {
        // 뷰 페이지 설정
        $this->setDefaultView("findInfoAuthPw");
        // run view page
        $this->displayPopup();
    }

    /**
     * 뷰 페이지
     */
    protected function setDefaultView(string $sType = "main")
    {
        // set view page
        switch ($sType) {
            case "findInfoAuthId":
                $this->aViewPage = [
                    // 'adSection' => 'adSection',
                    'body' => '',
                    'import_js' => 'findInfo/findInfoAuthId.js',
                ];
                break;
            case "findInfoAuthPw":
                $this->aViewPage = [
                    // 'adSection' => 'adSection',
                    'body' => '',
                    'import_js' => 'findInfo/findInfoAuthPw.js',
                ];
                break;
            case "main":
            default:
                $this->aViewPage = [
                    // 'adSection' => 'adSection',
                    'body' => 'findInfo/findInfo',
                    'menu' => 'common/sub_menu',
                    'main_header' => 'common/find_header',
                    'foot' => 'common/sub_footer',
                    'import_js' => 'findInfo/findInfo.js',
                ];
        }
    }
}