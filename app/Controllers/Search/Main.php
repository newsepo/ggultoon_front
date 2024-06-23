<?php

namespace App\Controllers\Search;

use App\Controllers\BaseController;
use Exception;

class Main extends BaseController
{
    /**
     * 검색 메인
     *
     * @return void
     */
    public function index()
    {
        try {
            // 뷰 페이지 설정
            $this->setDefaultView();

            // set view data
            $this->aSetData['HTML']['CSS'] = $this->linkCss(getAssetPath("/assets/css/" . $this->sLangDirectory . "/search/main.css"));

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
                    'body' => 'search/main',
                    'foot' => 'common/sub_footer',
                    'main_header' => 'common/main_header',
                    'curation' => 'common/curation/curation',
                    'import_js' => 'search/main.js',
                    'noResult' => 'common/no_result/no_result'
                ];
        }
    }
}
