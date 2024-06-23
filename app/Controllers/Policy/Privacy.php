<?php

namespace App\Controllers\Policy;

use App\Controllers\BaseController;
use Exception;

class Privacy extends BaseController
{
    /**
     * 개인정보처리방침
     *
     * @return void
     */
    public function index()
    {
        try {
            // 뷰 페이지 설정
            $this->setDefaultView();

        } catch (Exception $e) {
            $this->aSetData['ERROR']['file'] = $e->getFile();
            $this->aSetData['ERROR']['line'] = $e->getLine();
            $this->aSetData['ERROR']['message'] = $e->getMessage();
            $this->displayError();
        }

        // run view page
        $this->display();
    }

    public function privacyPopup()
    {
        try {
            // 뷰 페이지 설정
            $this->setDefaultView('popup');

            $this->aSetData['TYPE'] = 'privacy';

        } catch (Exception $e) {
            $this->aSetData['ERROR']['file'] = $e->getFile();
            $this->aSetData['ERROR']['line'] = $e->getLine();
            $this->aSetData['ERROR']['message'] = $e->getMessage();
            $this->displayError();
        }

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
            case "popup":
                $this->aViewPage = [
                    'body' => 'modal/signUpTerms',
                    'menu' => 'common/sub_menu',
                    'main_header' => 'common/no_header',
                    'foot' => 'common/sub_footer',
                ];
                break;
            case "main":
            default:
                $this->aViewPage = [
                    'body' => 'policy/privacy',
                    'menu' => 'common/sub_menu',
                    'main_header' => 'common/no_header',
                    'foot' => 'common/sub_footer',
                ];
        }
    }
}