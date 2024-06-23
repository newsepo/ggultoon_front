<?php

namespace App\Controllers\Login;

use App\Controllers\BaseController;
use Exception;

class Join extends BaseController
{
    /**
     * 회원가입 페이지
     *
     * @return void
     */
    public function index()
    {
        // 뷰 페이지 설정
        $this->setDefaultView();

        // run view page
        $this->displayLayerPopup();
    }

    /**
     * 네이버 인증 완료
     * @return void
     */
    public function authSocial()
    {

        // 뷰 페이지 설정
        $this->setDefaultView("socialNaver");
        // run view page
        $this->displayPopup();
    }

    /**
     * 본인 인증
     * @return void
     */
    public function passAuth()
    {
        // 뷰 페이지 설정
        $this->setDefaultView("popup");
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
            case "socialNaver":
                $this->aViewPage = [
                    'body' => '',
                    'import_js' => 'login/socialAuth.js',
                ];
                break;
            case "popup":
                $this->aViewPage = [
                    'body' => '',
                    'import_js' => 'login/passAuth.js',
                ];
                break;
            case "main":
            default:
                $this->aViewPage = [
                    'body' => 'login/login',
                    'main_header' => 'common/no_header',
                    'foot' => 'common/sub_footer',
                    'menu' => 'common/sub_menu',
                    'import_js' => 'login/login.js',
                ];
        }
    }

}