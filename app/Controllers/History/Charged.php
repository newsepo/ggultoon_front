<?php

namespace App\Controllers\History;

use App\Controllers\BaseController;
use Exception;

class Charged extends BaseController
{
  /**
   * 이용내역
   *
   * @return void
   */
  public function index()
  {
    try {
      // 뷰 페이지 설정
      $this->setDefaultView();

      // set view data
        //$this->aSetData['HTML']['JS'] = $this->linkJs(getAssetPath("/assets/js/" . $this->sLangDirectory . "/history/charged.js"));
      $this->aSetData['HTML']['CSS'] = $this->linkCss(getAssetPath("/assets/css/" . $this->sLangDirectory . "/history/charged.css"));

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
          'body' => 'history/charged',
          'menu'          => 'common/sub_menu',
          'main_header' => 'common/no_header',
          'foot' => 'common/sub_footer',
          'layer' => 'history/filterBottomSheet',
          'import_js' => 'history/charged.js',
          'money_info' => 'my/money_info',
          'noResult' => 'common/no_result/no_result'
        ];
    }
  }
}