<?php

namespace App\Controllers\Contents;

use App\Controllers\BaseController;
use Exception;

class Viewer extends BaseController
{
    /**
     * 뷰어 페이지
     *
     * @return void
     */
    public function index($contentsIdx, $episodeIdx)
    {
        try {
            // BF cache 캐시 생성
            $this->response->setCache(['max-age=86400']);
            // 뷰 페이지 설정
            $this->setDefaultView();

            // set view data
            $this->aSetData['HTML']['CSS'] = $this->linkCss(getAssetPath("/assets/css/" . $this->sLangDirectory . "/contents/viewer.css"));
            $this->aSetData['HTML']['contentsIdx'] = $contentsIdx;
            $this->aSetData['HTML']['episodeIdx'] = $episodeIdx;

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
                    'body' => 'contents/viewer',
                    'menu' => 'common/sub_menu',
                    'main_header' => 'common/no_header',
                    'foot' => 'common/sub_footer',
                    'curation' => 'common/curation/curation',
                    'import_js' => 'contents/viewer.js',
                    'scroll_indicator' => 'contents/scroll_indicator',
                    'sheet' => 'contents/nickname_sheet'
                ];
        }
    }
}