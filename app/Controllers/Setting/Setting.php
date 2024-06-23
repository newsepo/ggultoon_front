<?php

namespace App\Controllers\Setting;

use App\Controllers\BaseController;
use Exception;

class Setting extends BaseController
{
    /**
     * 환경설정 페이지
     *
     * @return void
     */
    public function index()
    {
        try {
            // 뷰 페이지 설정
            $this->setDefaultView();

            // set view data
            $this->aSetData['HTML']['CSS'] = $this->linkCss(getAssetPath("/assets/css/" . $this->sLangDirectory . "/setting/setting.css"));

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
                    'body' => 'setting/setting',
                    'menu' => 'common/sub_menu',
                    'main_header' => 'common/no_header',
                    'foot' => 'common/sub_footer',
                    'import_js' => 'setting/setting.js',
                ];
        }
    }
}