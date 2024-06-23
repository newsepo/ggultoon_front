<?php

namespace App\Controllers\FindInfo;

use App\Controllers\BaseController;
use Exception;

class FindResult extends BaseController
{
  /**
   * 아이디/비밀번호 찾기 결과 화면
   *
   * @return void
   */
  public function index()
  {
    try {
      // 뷰 페이지 설정
      $this->setDefaultView();

      // set view data
      $this->aSetData['HTML']['JS'] = $this->linkJs(getAssetPath("/assets/js/" . $this->sLangDirectory . "/findInfo/findResult.js"));
      $this->aSetData['HTML']['CSS'] = $this->linkCss(getAssetPath("/assets/css/" . $this->sLangDirectory . "/findInfo/findResult.css"));

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
          // 'adSection' => 'adSection',
          'body' => 'findInfo/findResult',
          'menu' => 'common/sub_menu',
          'main_header' => 'common/find_header',
          'foot' => 'common/sub_footer',
        ];
    }
  }
}