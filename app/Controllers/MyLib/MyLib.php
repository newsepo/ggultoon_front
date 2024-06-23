<?php

namespace App\Controllers\MyLib;

use App\Controllers\BaseController;
use Exception;

class MyLib extends BaseController
{
    /**
     * 내서재
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
            $this->aSetData['HTML']['JS'] = $this->linkJs(getAssetPath("/assets/js/" . $this->sLangDirectory . "/myLib/myLib.js"));
            $this->aSetData['HTML']['CSS'] = $this->linkCss(getAssetPath("/assets/css/" . $this->sLangDirectory . "/myLib/myLib.css"));
            $this->aSetData['HTML']['TYPE'] = 'view';

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
     * 내 꿀단지 - 최근 본 작품
     * @return void
     */
    public function view()
    {
        try {
            // 뷰 페이지 설정
            $this->setDefaultView();

            // set view data
            $this->aSetData['HTML']['JS'] = $this->linkJs(getAssetPath("/assets/js/" . $this->sLangDirectory . "/myLib/myLib.js"));
            $this->aSetData['HTML']['CSS'] = $this->linkCss(getAssetPath("/assets/css/" . $this->sLangDirectory . "/myLib/myLib.css"));
            $this->aSetData['HTML']['TYPE'] = 'view';

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
     * 내 꿀단지 - 대여 작품
     * @return void
     */
    public function rent()
    {
        try {
            // 뷰 페이지 설정
            $this->setDefaultView();

            // set view data
            $this->aSetData['HTML']['JS'] = $this->linkJs(getAssetPath("/assets/js/" . $this->sLangDirectory . "/myLib/myLib.js"));
            $this->aSetData['HTML']['CSS'] = $this->linkCss(getAssetPath("/assets/css/" . $this->sLangDirectory . "/myLib/myLib.css"));
            $this->aSetData['HTML']['TYPE'] = 'rent';

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
     * 내 꿀단지 - 소장 작품
     * @return void
     */
    public function have()
    {
        try {
            // 뷰 페이지 설정
            $this->setDefaultView();

            // set view data
            $this->aSetData['HTML']['JS'] = $this->linkJs(getAssetPath("/assets/js/" . $this->sLangDirectory . "/myLib/myLib.js"));
            $this->aSetData['HTML']['CSS'] = $this->linkCss(getAssetPath("/assets/css/" . $this->sLangDirectory . "/myLib/myLib.css"));
            $this->aSetData['HTML']['TYPE'] = 'have';

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
     * 내 꿀단지 - 관심 작품
     * @return void
     */
    public function favorite()
    {
        try {
            // 뷰 페이지 설정
            $this->setDefaultView();

            // set view data
            $this->aSetData['HTML']['JS'] = $this->linkJs(getAssetPath("/assets/js/" . $this->sLangDirectory . "/myLib/myLib.js"));
            $this->aSetData['HTML']['CSS'] = $this->linkCss(getAssetPath("/assets/css/" . $this->sLangDirectory . "/myLib/myLib.css"));
            $this->aSetData['HTML']['TYPE'] = 'favorite';

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
     * 내가 보던 꿀작 - 하단 팝업
     * @return void
     */
    public function bottomSheet()
    {
        // 뷰 페이지 설정
        $this->setDefaultView('bottom');

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
            case "bottom":
                $this->aViewPage = [
                    'body' => 'myLib/myLibBottomSheet',
                    'main_header' => 'common/no_header',
                    'foot' => 'common/sub_footer',
                    'menu' => 'common/sub_menu',
                    'import_js' => 'myLib/myLibBottomSheet.js'
                ];
                break;
            case "main":
            default:
                $this->aViewPage = [
                    'body' => 'myLib/myLib',
                    'menu' => 'common/sub_menu',
                    'main_header' => 'common/no_header',
                    'foot' => 'common/sub_footer',
                    'import_js' => 'myLib/myLib.js',
                    'sideSection' => 'common/side_section',
                    'noResult' => 'common/no_result/no_result',
                    'curation' => 'common/curation/curation'
                ];
        }
    }
}