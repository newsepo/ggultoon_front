<?php
/* ===================================================================
    토큰
    # 토큰
        - Access Token 갱신
        - 푸시토큰 생성 OR 업데이트
=================================================================== */

namespace App\Controllers\Api\V1;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use Psr\Log\LoggerInterface;
use App\Libraries\Utils;

class Token extends BaseController
{
    protected UserModel $oUser;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->oUser = new UserModel();
    }

    /**
     * Access Token 갱신
     *
     * @return void
     */
    public function updateToken(): void
    {
        try {
            $aRequestParam = [
                'token' => [
                    'label' => 'token',
                    'rules' => 'required',
                    'errors' => [
                        'required' => "토큰값이 없습니다.",
                    ],
                ],
            ];
            // params 유효성 체크
            $aParam = $this->chkParam($aRequestParam, "RawInput", true);

            // jwt token 유효한지 검증
            $bIsTokenAuth = Utils::isAuth($aParam['token']);
            // jwt 복호화
            $oToken = Utils::jwtDecode($aParam['token']);
            $this->oUser->setUserid($oToken->user_id);

            // 유효한 토큰값이 아닐경우
            if ($bIsTokenAuth === false) {
                if (empty($this->oUser->getUserid()) === false) {
                    // 토큰 정보가져오기
                    $aTokenInfo = $this->oUser->getTokenInfoByUserid();
                    if ($aTokenInfo['expire_time'] > DB_TIMESTAMP) { // 만료기간 체크
                        $bIsTokenAuth = true;
                    }
                }
            }

            // 정상적인 refresh token
            if ($bIsTokenAuth === true) {

                // 정상회원인지 체크
                $this->oUser->isUserCheck();
                if (empty($aTokenInfo) === true) {
                    // 토큰 정보가져오기
                    $aTokenInfo = $this->oUser->getTokenInfoByUserid();
                }

                // 토큰정보에 userid 있을경우
                if (empty($aTokenInfo['user_id']) === false) {
                    // access token 갱신 및 DB update
                    $sToken = $this->oUser->modifyTokenExpire($aTokenInfo);
                } else {
                    throw new Exception('유효한 인증토큰이 아닙니다 .', 9999);
                }

            }

            $this->getDefaultResult();
            if (isset($sToken) === true) {
                $this->aSetData['result'] = true;
                $this->aSetData['code'] = 200;
                $this->aSetData['message'] = "토큰갱신에 성공하였습니다.";
                $this->aSetData['token'] = $sToken;
            }
        } catch (Exception $e) {
            $this->aSetData['result'] = false;
            $this->aSetData['code'] = empty($e->getCode()) === true ?? 9999;
            if (ENVIRONMENT === 'development') {
                $this->aSetData['file'] = $e->getFile();
                $this->aSetData['line'] = $e->getLine();
            }
            $this->aSetData['message'] = $e->getMessage();
        }

        $this->displayJson($this->aSetData);
    }

    /**
     * 푸시토큰 생성 OR 업데이트
     *
     * @return void
     */
    public function duplicatePushToken(): void
    {
        try {
            $aRequestParam = [
                'token' => [
                    'label' => 'token',
                    'rules' => 'required',
                    'errors' => [
                        'required' => "토큰값이 없습니다.",
                    ],
                ],
                'deviceId' => [
                    'label' => 'deviceId',
                    'rules' => 'required',
                    'errors' => [
                        'required' => "디바이스값이 없습니다.",
                    ],
                ],
                'deviceType' => [
                    'label' => 'deviceType',
                    'rules' => 'required',
                    'errors' => [
                        'required' => "디바이스 타입이 없습니다.",
                    ],
                ],
                'ver' => [
                    'label' => 'ver',
                    'rules' => 'required',
                    'errors' => [
                        'required' => "앱버젼 정보가 없습니다.",
                    ],
                ],
            ];

            // params 유효성 체크
            $aParam = $this->chkParam($aRequestParam, "post", true);

            $this->oUser->setPushToken($aParam['token']);
            $this->oUser->setDeviceId($aParam['deviceId']);
            $this->oUser->setDeviceType($aParam['deviceType']);
            $this->oUser->setVer($aParam['ver']);

            // 푸시토큰 등록 및 업데이트
            $aResponse = $this->oUser->registPushToken();

            $this->getDefaultResult();
            if ($aResponse === true) {
                $this->aSetData['result'] = true;
                $this->aSetData['code'] = 200;
                $this->aSetData['message'] = "success";
            }
        } catch (Exception $e) {

            $this->aSetData['result'] = false;
            $this->aSetData['code'] = empty($e->getCode()) === true ?? 9999;
            if (ENVIRONMENT === 'development') {
                $this->aSetData['file'] = $e->getFile();
                $this->aSetData['line'] = $e->getLine();
            }
            $this->aSetData['message'] = $e->getMessage();
        }

        $this->displayJson($this->aSetData);
    }

    /**
     * 기본 리턴배열값 정의
     *
     * @return  array
     */
    protected function getDefaultResult(): array
    {
        return $this->aSetData = [
            'result' => false,
            'code' => 9999,
            'message' => 'fail'
        ];
    }


}
