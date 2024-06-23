<?php

namespace App\Controllers\Help;

use App\Controllers\BaseController;
use Exception;

class Notice extends BaseController
{
    /**
     * 고객센터
     * 공지사항 페이지
     *
     * @return void
     */
    public function index()
    {
        try {
            // 뷰 페이지 설정
            $this->setDefaultView();

            // set view data
            $this->aSetData['HTML']['CSS'] = $this->linkCss(getAssetPath("/assets/css/" . $this->sLangDirectory . "/help/notice.css"));
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
                'body' => 'help/notice',
                'menu' => 'common/sub_menu',
                'main_header' => 'common/no_header',
                'foot' => 'common/sub_footer',
                'import_js' => 'help/notice.js',
                'noResult' => 'common/no_result/no_result'
              ];
        }
    }
}