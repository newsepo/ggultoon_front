<?php

namespace App\Controllers\Home;

use App\Controllers\BaseController;
use Exception;

class Main extends BaseController
{
    /**
     * 메인 페이지
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
            $this->aSetData['HTML']['CSS'] = $this->linkCss(getAssetPath("/assets/css/" . $this->sLangDirectory . "/home/main.css"));

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
                    'body' => 'home/main',
                    'main_header' => 'common/main_header',
                    'foot' => 'common/foot',
                    'import_js' => 'home/main.js',
                    'curation' => 'common/curation/curation',
                    'mainBanner' => 'common/banner/banner_main',
                    'subBanner' => 'common/banner/banner_sub',
                    'noResult' => 'common/no_result/no_result'
                ];
        }
    }

//    public function bot()
//    {
//        // 검색봇 설정
//        $this->response->setContentType('Content-Type:text/plain');
//        if (CNF_DOMAIN == 'www.ggultoons.com') {
//            $botTxt = "User-agent: *\nAllow: /";
//        } else {
//            $botTxt = "User-agent: *\nDisallow: /";
//        }
//        echo $botTxt;
//    }
}