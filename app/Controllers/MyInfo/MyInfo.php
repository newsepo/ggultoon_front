<?php

namespace App\Controllers\MyInfo;

use App\Controllers\BaseController;
use Exception;

class MyInfo extends BaseController
{
  /**
   * 마이페이지(비로그인)
   *
   * @return void
   */
  public function index()
  {
    try {
      // 뷰 페이지 설정
      $this->setDefaultView();

      // set view data
      $this->aSetData['HTML']['JS'] = $this->linkJs(getAssetPath("/assets/js/" . $this->sLangDirectory . "/myInfo/myInfo.js"));
      $this->aSetData['HTML']['CSS'] = $this->linkCss(getAssetPath("/assets/css/" . $this->sLangDirectory . "/myInfo/myInfo.css"));

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
          'body'        => 'myInfo/myInfo',
          'menu'        => 'common/sub_menu',
          'main_header' => 'common/no_header',
          'foot'        => 'common/sub_footer',
          'grade'       => 'my/grade',
          'import_js'   => 'myInfo/myInfo.js',
        ];
    }
  }
}