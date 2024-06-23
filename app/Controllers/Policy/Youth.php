<?php

namespace App\Controllers\Policy;

use App\Controllers\BaseController;
use Exception;

class Youth extends BaseController
{
  /**
   * 청소년보호정책
   *
   * @return void
   */
  public function index()
  {
    try {
      // 뷰 페이지 설정
      $this->setDefaultView();

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
          'body' => 'policy/youth',
          'menu' => 'common/sub_menu',
          'main_header' => 'common/no_header',
          'foot' => 'common/sub_footer',
        ];
    }
  }
}