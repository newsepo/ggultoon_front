<?php

namespace App\Controllers\Contents;

use App\Controllers\BaseController;
use Exception;

class ContentComment extends BaseController
{
  /**
   * 작품 댓글 페이지
   *
   * @return void
   */
  public function index($idx)
  {
    try {
      // 뷰 페이지 설정
      $this->setDefaultView();

      // set view data
      $this->aSetData['HTML']['CSS'] = $this->linkCss(getAssetPath("/assets/css/" . $this->sLangDirectory . "/contents/comment.css"));
      $this->aSetData['HTML']['IDX'] = $idx;

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
          'body' => 'contents/comment',
          'menu' => 'common/sub_menu',
          'main_header' => 'common/no_header',
          'foot' => 'common/sub_footer',
          'import_js' => 'contents/content_comment.js'
        ];
    }
  }
}