<?php

namespace App\Controllers\Contents;

use App\Controllers\BaseController;
use Config\Services;
use Exception;

class Episode extends BaseController
{
    /**
     * 회차리스트 페이지
     *
     * @return void
     */
    public function index($idx)
    {
        try {
            // BF cache 캐시 생성 --> 구매 상태 바로 반영하기 위해 임시 주석처리
            //$this->response->setCache(['max-age=86400']);

            // 뷰 페이지 설정
            $this->setDefaultView();

            // set view data
            $this->aSetData['HTML']['CSS'] = $this->linkCss(getAssetPath("/assets/css/" . $this->sLangDirectory . "/contents/episode.css"));
            $this->aSetData['HTML']['IDX'] = $idx;
            $this->aSetData['HTML']['TITLE'] = $this->getTitle($idx);

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
                    'body' => 'contents/episode',
                    'foot' => 'common/sub_footer',
                    'main_header' => 'common/episode_header',
                    'menu' => 'common/episode_menu',
                    'curation' => 'common/curation/curation',
                    'import_js' => 'contents/episode.js',
                    'sheet' => 'contents/nickname_sheet'
                ];
        }
    }

    /**
     * 작품 제목 조회
     */
    protected function getTitle($idx)
    {
        try {
            $client   = Services::curlrequest();
            // TODO - Redis 캐싱 처리
            $response = $client->get(API_DOMAIN . '/v1/contents/'.$idx.'/title');
            $res      = json_decode($response->getBody());
            return $res->data->title;
        } catch (Exception $e) {
            return '';
        }
    }
}