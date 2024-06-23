<?php

namespace App\Controllers\Community;

use App\Controllers\BaseController;
use Exception;

class Community extends BaseController
{
    /**
     * 커뮤니티 메인 페이지
     *
     * @return void
     */
    public function index()
    {
        try {
            // 뷰 페이지 설정
            $this->setDefaultView();

            // set view data
            $this->aSetData['HTML']['CSS'] = $this->linkCss(getAssetPath("/assets/css/" . $this->sLangDirectory . "/community/community.css"));
            $this->aSetData['HTML']['JS'] = $this->linkJs(getAssetPath("/assets/js/" . $this->sLangDirectory . "/community/community.js"));

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
                    'body' => 'community/community',
                    'menu' => 'common/menu',
                    'main_header' => 'common/main_header',
                    'foot' => 'common/sub_footer',
                    // 'import_js' => 'help/notice.js'
                    'commu_list_item' => 'community/commu_list_item'
                ];
        }
    }
}