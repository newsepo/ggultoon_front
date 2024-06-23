<?php

namespace App\Controllers\Search;

use App\Controllers\BaseController;
use Exception;

class Tag extends BaseController
{
  /**
   * 태그 검색 결과 더보기
   *
   * @return void
   */
  public function index()
  {
    try {
      // BF cache 캐시 생성
      $this->response->setCache(['max-age=86400']);

      // 뷰 페이지 설정
      $this->setDefaultView();

      // set view data
      $this->aSetData['HTML']['CSS'] = $this->linkCss(getAssetPath("/assets/css/" . $this->sLangDirectory . "/search/tag.css"));

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
          'body' => 'search/tag',
          'foot' => 'common/sub_footer',
          'main_header' => 'common/no_header',
          'import_js' => 'search/tag.js',
        ];
    }
  }
}
