<?php

namespace App\Controllers\Category;

use App\Controllers\BaseController;
use Exception;

class Webtoon extends BaseController
{
    /**
     * 웹툰 페이지
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
            $this->aSetData['HTML']['CSS'] = $this->linkCss(getAssetPath("/assets/css/" . $this->sLangDirectory . "/category/webtoon.css"));

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
                    'body' => 'category/webtoon',
                    'main_header' => 'common/sub_header',
                    'foot' => 'common/sub_footer',
                    'layer' => 'category/categoryBottomSheet',
                    'menu' => 'common/menu',
                    'import_js' => 'category/webtoon.js',
                    'mainBanner' => 'common/banner/banner_main',
                    'noResult' => 'common/no_result/no_result'
                ];
        }
    }
}