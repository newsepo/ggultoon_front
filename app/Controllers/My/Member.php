<?php

namespace App\Controllers\My;

use App\Controllers\BaseController;
use Exception;

class Member extends BaseController
{
    /**
     * 마이페이지(로그인)
     *
     * @return void
     */
    public function index()
    {
        try {
            // BF cache 캐시 생성
            $this->response->setCache(['max-age=86400']);

            // 뷰 페이지 설정
            $this->setDefaultView();

            // set view data
            $this->aSetData['HTML']['CSS'] = $this->linkCss(getAssetPath("/assets/css/" . $this->sLangDirectory . "/my/member.css"));

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
     * 뷰 페이지
     */
    protected function setDefaultView(string $sType = "main")
    {
        // set view page
        switch ($sType) {
            case "main":
            default:
                $this->aViewPage = [
                    'body'          => 'my/member',
                    'menu'          => 'common/menu',
                    'main_header'   => 'common/member_header',
                    'foot'          => 'common/sub_footer',
                    'import_js'     => 'my/member.js',
                    'money_info'    => 'my/money_info',
                    'grade'         => 'my/grade',
                    'subFullBanner' => 'common/banner/banner_sub_full'
                ];
        }
    }
}