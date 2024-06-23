<?php

namespace App\Controllers\Charging;

use App\Controllers\BaseController;
use Exception;

class Charging extends BaseController
{
    /**
     * 충전소 페이지
     *
     * @return void
     */
    public function index()
    {
        try {
            // 뷰 페이지 설정
            $this->setDefaultView();

            // js 파일 리스트
            $aJs[] = getAssetPath("/assets/js/" . $this->sLangDirectory . "/charging/charging.js");
            $aJs[] = "https://npg.settlebank.co.kr/resources/js/v1/SettlePG_v1.2.js";

            // set view data
            $this->aSetData['HTML']['JS'] = $this->linkJs($aJs);
            $this->aSetData['HTML']['CSS'] = $this->linkCss(getAssetPath("/assets/css/" . $this->sLangDirectory . "/charging/charging.css"));

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
     * 완료 페이지
     *
     * @return void
     */
    public function complete()
    {
        try {
            // 뷰 페이지 설정
            $this->setDefaultView("complete");

            // js 파일 리스트
            $aJs[] = getAssetPath("/assets/js/" . $this->sLangDirectory . "/charging/charging.js");
            $aJs[] = "https://npg.settlebank.co.kr/resources/js/v1/SettlePG_v1.2.js";

            // set view data
            $this->aSetData['HTML']['JS'] = $this->linkJs($aJs);
            $this->aSetData['HTML']['CSS'] = $this->linkCss(getAssetPath("/assets/css/" . $this->sLangDirectory . "/charging/charging.css"));

        } catch (Exception $e) {
            $this->aSetData['ERROR']['file'] = $e->getFile();
            $this->aSetData['ERROR']['line'] = $e->getLine();
            $this->aSetData['ERROR']['message'] = $e->getMessage();
            $this->displayError();
        }

        /// run view page
        $this->displayPopup();
    }

    /**
     * 취소 페이지
     *
     * @return void
     */
    public function cancel()
    {
        try {
            // 뷰 페이지 설정
            $this->setDefaultView("cancel");
        } catch (Exception $e) {
            $this->aSetData['ERROR']['file'] = $e->getFile();
            $this->aSetData['ERROR']['line'] = $e->getLine();
            $this->aSetData['ERROR']['message'] = $e->getMessage();
            $this->displayError();
        }

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
            case "complete":
                $this->aViewPage = [
                    'import_js' => 'charging/complete.js',
                ];
                break;
            case "cancel":
                $this->aViewPage = [
                    'import_js' => 'charging/cancel.js',
                ];
                break;
            case "main":
            default:
                $this->aViewPage = [
                    'body'          => 'charging/charging',
                    'main_header'   => 'common/sub_menu',
                    'foot'          => 'common/sub_footer',
                    'menu'          => 'common/menu',
                    'import_js'     => 'charging/charging.js',
                    'grade'         => 'my/grade',
                    'mainBanner'    => 'common/banner/banner_main'
                ];
        }
    }
}