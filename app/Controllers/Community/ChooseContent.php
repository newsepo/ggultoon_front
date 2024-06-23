<?php

namespace App\Controllers\Community;

use App\Controllers\BaseController;
use Exception;

class ChooseContent extends BaseController
{
    /**
     * 커뮤니티 글쓰기 전 작품 선택 페이지
     *
     * @return void
     */
    public function index()
    {
        try {
            // 뷰 페이지 설정
            $this->setDefaultView();

            // set view data
            $this->aSetData['HTML']['CSS'] = $this->linkCss(getAssetPath("/assets/css/" . $this->sLangDirectory . "/community/chooseContent.css"));
            $this->aSetData['HTML']['JS'] = $this->linkJs(getAssetPath("/assets/js/" . $this->sLangDirectory . "/community/chooseContent.js"));

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
                    'body' => 'community/chooseContent',
                    'menu' => 'common/sub_menu',
                    'main_header' => 'common/no_header',
                    'foot' => 'common/sub_footer',
                    'import_js' => 'help/notice.js'
                ];
        }
    }
}