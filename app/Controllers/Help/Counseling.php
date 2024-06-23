<?php

namespace App\Controllers\Help;

use App\Controllers\BaseController;
use Exception;

class Counseling extends BaseController
{
    /**
     * 고객센터
     * 실시간 문의 페이지
     *
     * @return void
     */
    public function index()
    {
        try {
            // 뷰 페이지 설정
            $this->setDefaultView();

            // set view data
            $this->aSetData['HTML']['CSS'] = $this->linkCss(getAssetPath("/assets/css/" . $this->sLangDirectory . "/help/counseling.css"));
            $this->aSetData['HTML']['JS'] = $this->linkJs(getAssetPath("/assets/js/" . $this->sLangDirectory . "/help/counseling.js"));

        } catch (Exception $e) {
            $this->aSetData['ERROR']['file'] = $e->getFile();
            $this->aSetData['ERROR']['line'] = $e->getLine();
            $this->aSetData['ERROR']['message'] = $e->getMessage();
            $this->displayError();
        }

        // run view page
        $this->display();
    }

    public function memberHash($idx)
    {
        // Content-Type 지정하여 디버그 툴바 출력 방지
        $this->response->setContentType('Content-Type:text/plain');
        $expectedHash = hash_hmac('sha256', $idx, pack("H*", '384c114a1890bfe6d12ee98d2ca475f581af56d49930b4f0f3d1ba1beb3853ec'));
        echo $expectedHash;
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
                    'body' => 'help/counseling',
                    'main_header' => 'common/no_header',
                    'menu' => 'common/sub_menu',
                    'foot' => 'common/sub_footer'
                ];
        }
    }


    public function info()
    {
        phpinfo();
        exit;
    }
}