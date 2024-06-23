<?php
/* ===================================================================
    모델 확장
=================================================================== */

namespace App\Models;

use App\Libraries\DatabaseDriver;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\UserAgent;
use CodeIgniter\Model;
use Config\Common;
use Config\Services;
use Exception;


class BaseModel extends Model
{
    protected Common $common;
    protected DatabaseDriver $dbm;
    protected DatabaseDriver $dbr;
    protected DatabaseDriver $dbl;
    protected IncomingRequest $request;

    protected array $aResultData;
    protected array $aBind = [];
    protected int $iUserIdx;

    public function __construct()
    {
        parent::__construct();

        $this->common = new Common();
        $this->request = Services::request();

        $this->dbm = $this->dbc('main');
        $this->dbr = $this->dbc('replica');
        $this->dbl = $this->dbc('log');
    }

    /* ===================================================================
        Set Functions
    =================================================================== */
    public function setResultData($data)
    {
        if (is_array($data) === true) {
            $this->aResultData = $data;
        }
    }

    public function addBindData(array $aBindData)
    {
        if (empty($this->aBind) === false) {
            $this->aBind = array_merge($this->aBind, $aBindData);
        } else {
            $this->aBind = $aBindData;
        }
    }

    /**
     * set Member.idx
     *
     * @param int $iUserIdx
     * @return void
     */
    public function setBaseUserIdx(int $iUserIdx): void
    {
        if ($iUserIdx > 0) {
            $this->iUserIdx = $iUserIdx;
        }
    }

    /* ===================================================================
        Get Functions
    =================================================================== */
    public function getIp(): string
    {
        $sGetIp = self::getIpCheck();

        if (strpos(trim($sGetIp), ',')) {
            $aWafIps = explode(',', $sGetIp);
            $sGetIp = $aWafIps[0]; // default
        }

        return $sGetIp;
    }

    public function getAgent(): UserAgent
    {
        return $this->request->getUserAgent();
    }

    public function getResultData(): array
    {
        return $this->aResultData;
    }

    /**
     * 회원 정보 가져오기
     * - 회원정보
     * - 결제정보
     * - 로그인카운트
     * - 포인트정보
     *
     * @return array
     */
    public function getMemberInfo(): array
    {
        // 필드
        $aField = [];
        $aField[] = "me.*";
        $aField[] = "fcreus.user_channel";
        $aField[] = "mepa.*";
        $aField[] = "megr.lv";
        $aField[] = "lomeco.pay_cnt";
        $aField[] = "megr.pay_money";
        $aField[] = "IF(ISNULL(topo.point) , 0 , topo.point) AS toptoon_point";
        $aField[] = "megr.counter_1";
        $aField[] = "IF( ISNULL(tbbjpa.cash_bj) , 0 , tbbjpa.cash_bj) AS cash_bj";
        $aField[] = "IFNULL(mbre.period_end , 0) AS block_period_end";

        // 테이블
        $aTable = [];
        $aTable[] = "_member AS me"; // 회원정보
        $aTable[] = "LEFT JOIN _webhard_pay AS mepa ON me.idx = mepa.idx"; // 포인트 정보
        $aTable[] = "LEFT JOIN _member_grid AS megr ON me.idx = megr.userid";
        $aTable[] = "LEFT JOIN __log_member_count AS lomeco ON lomeco.userid = me.idx"; // 로그인 카운트정보
        $aTable[] = "LEFT JOIN toptoon_point AS topo ON me.idx = topo.m_id"; // 탑툰포인트 정보
        $aTable[] = "LEFT JOIN __fc_res_user AS fcreus ON me.email = fcreus.user_email"; // 로그인 회원정보
        $aTable[] = "LEFT JOIN tbl_bj_pay AS tbbjpa ON me.idx = tbbjpa.nSeqTbl"; // bj 포인트
        $aTable[] = "LEFT JOIN _mb_restrain AS mbre ON me.idx = mbre.limit_userid"; // 제재테이블

        $sField = implode(",\n", $aField);
        $sTable = implode(" \n", $aTable);
        $sWhere = "me.idx = :idx:";
        $this->dbr->setBind(['idx' => $this->iUserIdx]);

        return $this->dbr->get($sTable, $sField, $sWhere);

    }

    /* ===================================================================
        Modules
    =================================================================== */
    /**
     * 정상적인 회원인지 체크
     *
     * @return void
     * @throws Exception
     */
    public function isCheckMemberBlock(): bool
    {
        $aMemberInfo = $this->getMemberInfo();
        $sDefaultMessage = "등록된 정보는 운영정책 위반으로 인하여 블록된 정보입니다. 고객센터에 문의하세요.";
        if (intval($aMemberInfo['state']) === 1) { // 정상회원
            return false;
        } elseif ($aMemberInfo['state'] == 2) { // 블록회원
            throw new Exception($sDefaultMessage, 9999);
        } elseif ($aMemberInfo['state'] == 3) { // 블록회원

            // 제재회원인데 제재테이블에 없는경우 비정상회원
            if (empty($aMemberInfo['block_period_end']) === true) {
                throw new Exception($sDefaultMessage, 9999);
            } else {
                if (intval($aMemberInfo['block_period_end']) > 0 && intval($aMemberInfo['block_period_end'] < DB_TIMESTAMP)) { // 제재기간 종료
                    // 회원 상태값  state = 1로 업데이트
                    $this->updateMemberState();
                    return false;
                } else {
                    throw new Exception($sDefaultMessage, 9999);
                }
            }
        }
        return true;
    }

    /**
     * Return Database Connection Instance
     */
    public function dbc($sServerName = 'main'): DatabaseDriver
    {
        return new DatabaseDriver($sServerName);
    }

    /**
     * Paging
     */

    public function paginator($iPage = 1, $iTotalCount = 0, $iRecords = 20, $iBlocks = 5, $aParam = []): array
    {
        $bView = 'false';
        $bFirst = 'false';
        $bLast = 'false';
        $bPrev = 'false';
        $bNext = 'false';

        $iTotalPage = ceil($iTotalCount / $iRecords);
        $iTotalBlock = ceil($iTotalPage / $iBlocks);
        $iNowBlock = ceil($iPage / $iBlocks);
        $iStartPage = ($iNowBlock - 1) * $iBlocks + 1;
        $iEndPage = $iStartPage + $iBlocks - 1;

        if ($iEndPage > $iTotalPage) {
            $iEndPage = $iTotalPage;
        }
        if ($iPage != 1) {
            $bFirst = 'true';
        }
        if ($iNowBlock < $iTotalBlock) {
            $bNext = 'true';
        }
        if ($iNowBlock > 1) {
            $bPrev = 'true';
        }
        if ($iPage < $iTotalPage) {
            $bLast = 'true';
        }

        $pages = [];
        if ($iEndPage > 1) {
            for ($i = $iStartPage; $i <= $iEndPage; $i++) {
                $pages[$i] = $i;
            }
            $bView = 'true';
        }

        $result['type'] = 'link';
        $result['view'] = $bView;
        $result['first'] = $bFirst;
        $result['first_page'] = 1;
        $result['prev'] = $bPrev;
        $result['prev_page'] = $iStartPage - 1;
        $result['now_page'] = $iPage;
        $result['pages'] = $pages;
        $result['next'] = $bNext;
        $result['next_page'] = $iStartPage + $iBlocks;
        $result['last'] = $bLast;
        $result['last_page'] = $iTotalPage;
        $result['current_url'] = current_url();
        unset($aParam['page']);
        $result['link'] = '?' . http_build_query($aParam);

        return $result;
    }

    /**
     * Paging By JS Function
     */
    public function paginatorJsFunc(int $iPage = 1, int $iTotalCount = 0, int $iRecords = 20, int $iBlocks = 5, string $sFunctionName = ''): array
    {
        $bView = 'false';
        $bFirst = 'false';
        $bLast = 'false';
        $bPrev = 'false';
        $bNext = 'false';

        $iTotalPage = ceil($iTotalCount / $iRecords);
        $iTotalBlock = ceil($iTotalPage / $iBlocks);
        $iNowBlock = ceil($iPage / $iBlocks);
        $iStartPage = ($iNowBlock - 1) * $iBlocks + 1;
        $iEndPage = $iStartPage + $iBlocks - 1;

        if ($iEndPage > $iTotalPage) {
            $iEndPage = $iTotalPage;
        }
        if ($iPage != 1) {
            $bFirst = 'true';
        }
        if ($iNowBlock < $iTotalBlock) {
            $bNext = 'true';
        }
        if ($iNowBlock > 1) {
            $bPrev = 'true';
        }
        if ($iPage < $iTotalPage) {
            $bLast = 'true';
        }

        $pages = [];
        if ($iEndPage > 1) {
            for ($i = $iStartPage; $i <= $iEndPage; $i++) {
                $pages[$i] = $i;
            }
            $bView = 'true';
        }

        $result['type'] = 'func';
        $result['view'] = $bView;
        $result['first'] = $bFirst;
        $result['first_page'] = 1;
        $result['prev'] = $bPrev;
        $result['prev_page'] = $iStartPage - 1;
        $result['now_page'] = $iPage;
        $result['pages'] = $pages;
        $result['next'] = $bNext;
        $result['next_page'] = $iStartPage + $iBlocks;
        $result['last'] = $bLast;
        $result['last_page'] = $iTotalPage;
        $result['func_name'] = $sFunctionName;

        return $result;
    }

    /**
     * 아이피 체크
     * @return string
     */
    private static function getIpCheck(): string
    {
        if (isset($_SERVER['HTTP_CLIENT_IP']) === true) {
            $sIpAddress = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) === true) {
            $sIpAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED']) === true) {
            $sIpAddress = $_SERVER['HTTP_X_FORWARDED'];
        } elseif (isset($_SERVER['HTTP_FORWARDED_FOR']) === true) {
            $sIpAddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_FORWARDED']) === true) {
            $sIpAddress = $_SERVER['HTTP_FORWARDED'];
        } else {
            $sIpAddress = $_SERVER['REMOTE_ADDR'];
        }

        return $sIpAddress;
    }

    /**
     * 배열정보 재정의 및 리턴
     *
     * @param array $aInfo
     * @return array
     */
    protected function remakeInfo(array $aInfo): array
    {
        if (empty($aInfo['result']) === true) {
            $aInfo['result'] = false;
        }
        if (empty($aInfo['code']) === true) {
            $aInfo['code'] = 9999;
        }
        if (empty($aInfo['message']) === true) {
            $aInfo['message'] = 'fail';
        }

        return $aInfo;
    }

    /**
     * 제재 해지된 회원 상태값 업테이트
     *
     * @param int $iState
     * @return void
     */
    private function updateMemberState(): void
    {

        if (empty($this->iUserIdx) === false) {
            $sTransKey = get_class($this) . '_' . __FUNCTION__;
            $this->dbm->transBegin($sTransKey);  // 트랜잭션 시작

            $aUpd = [];
            $aUpd['state'] = 1;
            $this->dbm->setBind(['idx' => $this->iUserIdx]);
            $this->dbm->update("_member", $aUpd, "user_id = :user_id:");

            if ($this->dbm->transStatus($sTransKey)) {
                $this->dbm->transCommit($sTransKey); // 트랜잭션 커밋
            } else {
                $this->dbm->transRollback($sTransKey);   // 트랜잭션 롤백
                pushAlarm(__METHOD__, 'lch');
            }
        }
    }
}
