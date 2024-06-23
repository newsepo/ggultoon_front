<?php

namespace App\Controllers\Login;

use App\Controllers\BaseController;
use Exception;

class Login extends BaseController
{
    /**
     * 로그인 페이지
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
     * 뷰 페이지
     */
    protected function setDefaultView(string $sType = "main")
    {
        // set view page
        switch ($sType) {
            case "main":
            default:
                $this->aViewPage = [
                    'body' => 'login/login',
                    'main_header' => 'common/no_header',
                    'foot' => 'common/sub_footer',
                    'menu' => 'common/sub_menu',
                    'import_js' => 'login/login.js',
                    'sideSection' => 'common/side_section',
                ];
        }
    }
}