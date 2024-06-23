<!--확인 버튼 1개 모달 -->
<div class="modal" id="alert" style="z-index:1070 !important;">
    <div class="modal-content modal-sm">
        <div class="modal-body">
            <p class="Text-md modal-title"></p>
            <p class="Text-sm text-gray modal-detail"></p>
        </div>
        <div class="button-wrap">
            <button type="button" class="btn-modal-close" id="alertFunc">확인</button>
        </div>
    </div>
    <div class="dimmed btn-modal-close"></div>
</div>





<!-- 네, 아니요 버튼 2개 모달(좌우 배치)-->
<div class="modal" id="horizontalConfirm">
    <div class="modal-content modal-sm">
        <div class="modal-body">
            <p class="Text-md modal-title"></p>
            <p class="Text-sm text-gray modal-detail"></p>
        </div>
        <div class="button-wrap">
            <button type="button" class="btn-gray btn-modal-close">아니요</button>
            <button type="button" class="btn-yellow btn-modal-yes" id="horizontalConfirmFunc">네</button>
        </div>
    </div>
    <div class="dimmed btn-modal-close"></div>
</div>





<!-- 네, 아니요 버튼 2개 모달(상하 배치)-->
<div class="modal" id="verticalConfirm">
    <div class="modal-content modal-sm">
        <div class="modal-body">
            <p class="Text-md modal-title"></p>
            <p class="Text-sm text-gray modal-detail"></p>
        </div>
        <div class="button-wrap column">
            <button type="button" class="btn-modal-yes" id="verticalConfirmFunc"></button>
            <button type="button" class="btn-modal-no btn-modal-close"></button>
        </div>
    </div>
    <div class="dimmed btn-modal-close"></div>
</div>



<!-- 회차 구매 공통 모달 -->
<!-- 회차 구매 -->
<div class="modal" id="modalPurchase">
    <div class="modal-content modal-sm">
        <div class="modal-body">
            <div class="text-between">
                <span class="Text-md" id="modalPurchaseTxt"></span>
                <em class="Text-md text-yellow" id="modalPurchaseCoin"></em>
            </div>

            <div class="Text-md text-gray modal-detail" id="modalPurchaseDetail"></div>

            <!-- 체크박스 -->
            <label for="isNotSendAlarm" class="check-yellow">
                <input type="checkbox" id="isNotSendAlarm" name="isNotSendAlarm" />
                <span>다음 구매 시 물어보지 않음</span>
            </label>

        </div>
        <div class="button-wrap">
            <button type="button" class="btn-gray btn-modal-close">아니요</button>
            <button type="button" class="btn-yellow btn-modal-yes" id="modalPurchaseFunc">네</button>
        </div>
    </div>
    <div class="dimmed btn-modal-close"></div>
</div>

<!-- 전체 대여, 소장 -->
<div class="modal" id="modalPurchaseTotal">
    <div class="modal-content modal-sm">
        <div class="modal-body">
            <p class="Text-md modal-purchase-title"></p>
            <p class="Text-sm modal-purchase-detail"></p>

            <!-- 체크박스 -->
            <label for="isFreeEpisode" class="check-yellow">
                <input type="checkbox" id="isFreeEpisode" name="isFreeEpisode" checked />
                <span>무료 회차 포함해서 소장할게요</span>
            </label>
        </div>

        <div class="button-wrap">
            <button type="button" class="btn-gray btn-modal-no btn-modal-close">아니요</button>
            <button type="button" class="btn-yellow btn-modal-yes" id="modalPurchaseTotalFunc">네</button>
        </div>
    </div>
    <div class="dimmed btn-modal-close"></div>
</div>

<!-- 이용약관, 개인정보처리방침, 마케팅 동의 -->
<div class="modal" id="terms">
    <div class="modal-content modal-sm">
        <div class="modal-body">
        </div>
    </div>
    <div class="dimmed btn-modal-close"></div>
</div>




<!-- 카드포인트 전환 안내 -->
<div class="modal" id="point_container">
    <button>
        <img src="/assets/images/kr/point/card_popup/close.png" alt="">
    </button>
    <img src="/assets/images/kr/point/card_popup/point_main.png" alt="">
    <button class="check">무료포인트 조회</button>
    <div class="bottom">
        <input type="checkbox" id="notToday">
        <label for="notToday">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="0.5" y="0.5" width="23" height="23" rx="11.5" />
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M18.2036 7.93398C18.6416 8.34764 18.6614 9.03808 18.2477 9.47613L11.0366 17.1125C10.8306 17.3307 10.5437 17.4544 10.2435 17.4544C9.94332 17.4544 9.65642 17.3307 9.45033 17.1125L5.75234 13.1964C5.33869 12.7584 5.35847 12.0679 5.79652 11.6543C6.23456 11.2406 6.92501 11.2604 7.33866 11.6984L10.2435 14.7746L16.6614 7.97815C17.0751 7.54011 17.7655 7.52033 18.2036 7.93398Z" />
            </svg>
            <p class="Text-lg">오늘 하루 보지 않기</p>
        </label>
    </div>
</div>



<!-- 선물 지급 완료 안내 -->
<div class="modal" id="modalGift">
    <div class="modal-content modal-sm">
        <p class="Text-sm"><strong class="memberId"></strong>님! 꿀툰이 드리는<br>꿀 떨어지는 선물이 도착했어요~!</p>
        <div class="img-box">
            <img src="" alt="">
            <strong class="Text-lg"></strong>
        </div>
        <a href="/gift" class="go-view Text-md btn-yellow btn-modal-close">받은 선물 보러가기</a>
    </div>
    <div class="dimmed btn-modal-close"></div>
</div>

<!-- 긴급 공지 안내 -->
<div class="modal" id="noticeModal">
    <div class="modal-content modal-sm">
        <div class="modal-body">
            <div class="modal-body">
                <p class="Text-extra-lg modal-title"><strong>*중요 공지 안내*</strong></p>
                <p class="Text-md text-gray modal-detail">안녕하세요. 꿀툰입니다.<br>서비스 종료(2024-02-29 23:59)를 진행하게 되어 공지드립니다.<br>자세한 사항은 아래의 링크로 확인 부탁드립니다.</p>
            </div>
        </div>
        <div class="button-wrap">
            <button type="button" class="go-view btn-modal-close btn-yellow" onclick="movePage.notice();">공지 내용 확인하러 가기</button>
        </div>
    </div>
    <div class="dimmed btn-modal-close"></div>
</div>


<script>
    function modalPostion(){
        let loginModal = document.querySelector('#modalLogin .modal-content');

        loginModal.style.marginTop = - loginModal.clientHeight / 2 + 'px';
        loginModal.style.marginLeft= - loginModal.clientWidth / 2 + 'px';
    }

    $(document).ready(function () {
        // modal close
        let btnModalClose = document.querySelectorAll('.btn-modal-close,.btn-modal-yes');
        for (let i = 0; i < btnModalClose.length; i++) {
            btnModalClose[i].addEventListener('click', function () {
                /** 꿀툰 서비스 종료 -> 충전소 페이지 진입 시 결제 불가 모달 노출 **/
                // 꿀작 이벤트 로그인 모달 OR 충전소 노출 모달일 경우에 한해 모달 닫기 방지
                if (window.location.pathname == "/event/summer" && this.closest('.modal').id == "modalLogin" || window.location.pathname == "/charging") {
                    this.closest('.modal').style.display = 'block';
                } else {
                    this.closest('.modal').style.display = 'none';
                }
            });
        }
    });

    /**
     * 공통 모달
     * 페이지별로 적합한 모달 형식을 호출해서 사용
     * 아래 공통 모달에 정의되지 않은 모달은 html 양식 및 호출용 함수 추가
     * Views/kr/modal/modal.php 파일에서 전체 모달 양식 확인 가능
     */
    let gModal = {

        /*확인 버튼 1개 -> 질문 내용 + 설명 + 버튼 색깔 + 콜백함수*/
        alert: function (params, callback) {

            if (params != null) {
                // 알림 내용 세팅
                $(".modal-title").html(params.get("title"));
                $(".modal-detail").html(params.get("detail"));

                // 버튼 색깔 세팅
                if (params.get("color") == "gray") { // 회색
                    $(".button-wrap").find("button").addClass("btn-gray");

                } else if (params.get("color") == "yellow") { // 노란색
                    $(".button-wrap").find("button").addClass("btn-yellow");
                }
                $("#alert").show();
            }

            // 콜백함수 -> 중복 바인딩 방지
            let confirmBtn = $("#alertFunc");
            if (callback != null && callback != "") {
                confirmBtn.off().on("click", function () {
                    callback();
                });
            }
        },

        /*네, 아니요 버튼 2개(좌우로 배치) -> 알림 내용 + 콜백함수*/
        horizontalConfirm: function (msg, callback) {
            let yesBtn = $("#horizontalConfirmFunc");
            $("#horizontalConfirm").show();
            $(".modal-title").text(msg);

            // 콜백함수 -> 중복 바인딩 방지
            yesBtn.off().on("click", function () {
                $("#horizontalConfirm").hide(); // 모달창 닫기
                callback();
            });
        },

        /*네, 아니요 버튼 2개(상하로 배치) -> 질문 내용 + 예 버튼 텍스트 + 아니요 버튼 텍스트 + 콜백함수*/
        verticalConfirm: function (params, callback) {
            let yesBtn = $("#verticalConfirmFunc");
            $("#verticalConfirm").show();

            if (params != null) {
                // 알림 내용 세팅
                $(".modal-title").html(params.get("title"));
                $(".modal-detail").html(params.get("detail"));
                $(".btn-modal-yes").text(params.get("yes"));
                $(".btn-modal-no").text(params.get("no"));

                // 버튼 색깔 세팅
                if (params.get("color") == "red") { // 빨간색
                    $(".modal-title").addClass("text-red");
                    $(".btn-modal-yes").addClass("btn-red");
                    $(".btn-modal-no").addClass("btn-gray");

                } else if (params.get("color") == "yellow") { // 노란색
                    $(".btn-modal-yes").addClass("btn-gray");
                    $(".btn-modal-no").addClass("btn-yellow");
                }
            }

            // 콜백함수 -> 중복 바인딩 방지
            yesBtn.off().on("click", function () {
                $("#verticalConfirm").hide(); // 모달창 닫기
                callback();
            });
        },
        /* 로그인 */
        login: function () {
            $("#modalLogin").show();
            modalPostion();
        },
        /* 선물 지급 완료 안내 */
        showGift: function (params) {

            if (params != null) {
                // 알림 내용 세팅
                $("#modalGift").children(".modal-content").children("p").children(".memberId").html(params.get("memberId"));
                $("#modalGift").children(".modal-content").children(".img-box").children("img").attr("src", params.get("contentImgUrl"));
                $("#modalGift").children(".modal-content").children(".img-box").children("strong").html(params.get("contentTitle"));
                $("#modalGift").show();

                // 로그인 마일리지 모달과 동시에 노출되는 경우 -> 로그인 마일리지 모달 밑으로 깔리도록 z-index 제어
                if ($("#alert").css("display") == "block" && $("#modalGift").css("display") == "block") {
                    $("#alert").css("display", "block").css("z-index", "1070");
                    $("#modalGift .modal-content").css("z-index", "1071");
                }
            }
        },
        /* 긴급 공지 안내 */
        showNotice: function () {
            $("#noticeModal").show();
        },
        /**
         * 회차 구매 공통
         * @param purchaseParams
         * @param callback
         */
        /* 회차 구매 */
        purchase: function (purchaseParams, callback) {
            let yesBtn = $("#modalPurchaseFunc");
            $("#modalPurchase").show();

            if (purchaseParams != null) {
                // 알림 내용 세팅
                $("#modalPurchaseTxt").html(purchaseParams.msg);
                $("#modalPurchaseCoin").html(purchaseParams.coin);
                $("#modalPurchaseDetail").html(purchaseParams.detail);
                $("#modalPurchaseDetail").addClass("p-2");
            }

            // 콜백함수 -> 중복 바인딩 방지
            yesBtn.off().on("click", function () {
                callback(purchaseParams.contentIdx, purchaseParams.episodeIdx, purchaseParams.searchType);
            });
        },
        /* 전체 대여, 소장 */
        purchaseTotal: function (params, callback) {
            let yesBtn = $("#modalPurchaseTotalFunc");
            $("#modalPurchaseTotal").show();

            if (params != null) {
                // 알림 내용 세팅
                $(".modal-purchase-title").html(params.get("title"));
                $(".modal-purchase-detail").html(params.get("detail"));

                // 무료회차 소장 체크 박스
                if (params.get("isFreeEpisode") === true) {
                    $("#modalPurchaseTotal label").addClass("active");
                } else {
                    $("#modalPurchaseTotal label").removeClass("active");
                }
            }

            // 콜백함수 -> 중복 바인딩 방지
            yesBtn.off().on("click", function () {
                callback(params);
            });
        },
        /**
         * 약관 동의
         */
        terms: function (params, callback) {
            // 팝업 호출
            $("#terms .modal-content .modal-body").load(params.get("url").toString(), function () {
                $("#terms").show();
            });
        }
    }

    /**
     * 회차 구매 공통 스크립트
     */
    let isNotSendAlarm = false;

    // 회차 정보 체크
    let episodeInfoCheck = function (contentsIdx, episodeIdx, searchType) {
        // 회차 정보
        $.ajax({
            url: '{ C.API_DOMAIN }/v1/contents/' + contentsIdx + '/episode/' + episodeIdx + '?searchType=' + searchType,
            cache: true,
            method: 'GET',
            dataType: 'json',
            processData: false,
            contentType: false,
            xhrFields: {
                withCredentials: true
            },
            success: function (res) {
                if (res.result) {
                    let episodeData = res.data.contentEpisodeList[0];

                    // 비로그인 상태
                    if (local.memberInfo() == null) {
                        toast.alert("로그인 후 이용해주세요");
                        movePage.login();

                        // 로그인 상태
                    } else {

                        // 소장 or 대여 중인 경우
                        if (episodeData.isMemberRent || episodeData.isMemberHave) {
                            // 뷰어로 이동
                            movePage.viewer(contentsIdx, episodeIdx);

                            // 무료 또는 이벤트 무료 회차일 경우
                        } else if (episodeData.isEpisodeFree || episodeData.isEpisodeEventFree) {

                            // 이벤트 진행중 + OTT 접속 토큰이 있는 경우
                            if (EVENT_STATE && checkEventState() && session.ottToken() != null) {
                                // 이벤트 참여 내역 및 통계 집계
                                insertEventLog(episodeData, searchType, 1);
                                return false;

                                // 이벤트 진행중 + 가입 경로가 OTT인 회원의 경우
                            } else if (EVENT_STATE && checkEventState() && local.memberInfo().data.site != "ggultoon") {
                                // 이벤트 참여 내역 및 통계 집계
                                insertEventLog(episodeData, searchType, 2);
                                return false;
                            }
                            // 뷰어로 이동
                            movePage.viewer(contentsIdx, episodeIdx);
                            
                            // 유료 회차
                        } else {
                            // 구매 정보 모달 호출
                            purchasePopup(episodeData, searchType);
                        }
                    }
                } else {
                    toast.alert(res.message);
                }
            },
            error: function (request, status, error) {
                // filter error
                //toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
            }
        });
        return false;
    }

    /** 2024 설연휴 전작품 무료 감상 이벤트 참여 내역 및 통계 집계 **/
    let insertEventLog = function (episode, searchType, userType) {

        let contentsIdx = episode.contentIdx;
        let episodeIdx = episode.idx;

        // 이벤트 참여 내역 및 통계 데이터 등록용 API 호출
        $.ajax({
            url: '{C.API_DOMAIN}/v1/event/free/contents/' + contentsIdx + '/episodes/' + episodeIdx,
            cache: true,
            method: 'POST',
            dataType: 'json',
            data: JSON.stringify({
                type: (searchType == 'have') ? 2 : 1, // 1: 대여, 2:소장
                route: (app.isAppReady) ? 2 : 1, // 1.web, 2.app
                userType: userType // 1.신규, 2.기존
            }),
            processData: false,
            contentType: 'application/json',
            xhrFields: {
                withCredentials: true
            },
            success: function (res) {
                if (res.result) {
                    // 회차 뷰어로 이동
                    movePage.viewer(contentsIdx, episodeIdx);
                }
            },
            error: function (request, status, error) {
                // filter error
                //toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
            }
        });
        return false;
    }

    // 회차 구매 팝업
    let purchasePopup = function (episode, searchType) {
        let purchaseParams = {
            contentIdx: episode.contentIdx,
            episodeIdx: episode.idx,
            searchType: (searchType == 'have') ? 2 : 1,
            msg: "",
            coin: "",
            detail: ""
        }

        // 구매 확인 모달 비노출
        if (isNotSendAlarm) {
            // 회차 구매
            episodePurchase(episode.contentIdx, episode.idx, purchaseParams.searchType);
            
            // 구매 확인 모달 노출
        } else {
            if (searchType === 'rent') {
                purchaseParams.searchTypeCode = 1;
                purchaseParams.msg = "제 " + episode.episodeNumTitle + " 대여";

                // 이용권 소진
                if (episode.isEpisodeTicketFree && episode.restTicketCnt > 0) {
                    purchaseParams.coin = "남은 무료 이용권 " + episode.restTicketCnt + "장";
                    purchaseParams.detail = "무료 이용권 1장을 사용할까요?";

                    // 코인 소진
                } else {
                    purchaseParams.coin = episode.coinRent + "꿀 소진";
                    if (episode.isEpisodeEventDiscount) { // 이벤트 할인
                        purchaseParams.coin = "<del>" + episode.coinRent + "꿀</del> " + episode.eventCoinRent + "꿀 소진";
                    }
                }
            } else {
                purchaseParams.coin = episode.coin + "꿀 소진";
                purchaseParams.msg = "제 " + episode.episodeNumTitle + " 소장";
                if (episode.isEpisodeEventDiscount) { // 이벤트 할인
                    if (episode.coin != episode.eventCoin) {
                        purchaseParams.coin = "<del>" + episode.coin + "꿀</del> " + episode.eventCoin + "꿀 소진";
                    }
                }
                purchaseParams.searchTypeCode = 2;
            }

            // 회차 구매 modal
            gModal.purchase(purchaseParams, episodePurchase);
        }
    }

    // 회차 구매
    let episodePurchase = function (contentsIdx, episodeIdx, type = 1) {
        $.ajax({
            url: '{C.API_DOMAIN}/v1/purchase/contents/' + contentsIdx + '/episodes/' + episodeIdx,
            cache: true,
            method: 'POST',
            dataType: 'json',
            data: JSON.stringify({
                type: type, // 1: 대여, 2:소장
                isNotSendAlarm: $("input[name=isNotSendAlarm]").is(":checked"),
                route: (app.isAppReady) ? 2 : 1    // 1.web, 2.app
            }),
            processData: false,
            contentType: 'application/json',
            xhrFields: {
                withCredentials: true
            },
            success: function (res) {
                if (res.result) {

                    // 회원 선물함 갱신
                    memberGiftList();

                    // 구매하는 회차의 구매 상태 갱신 -> 사용자 피드백 목적
                    let purchaseText = "";
                    if (type == 1) { // 대여
                        // 텍스트 세팅
                        purchaseText = `<button class="rent Text-xs active">대여중</button>`;

                    } else if (type == 2) { // 소장
                        // 텍스트 세팅
                        purchaseText = `<button class="have Text-xs active">소장중</button>`;
                    }
                    // 구매 상태 텍스트 세팅
                    $(".episode_content .content_list").find('li[value=' + episodeIdx + ']').find(".episode_btn").html(purchaseText);

                    // 회차 뷰어로 이동
                    movePage.viewer(contentsIdx, episodeIdx);

                } else {
                    // 보유 코인 부족
                    if (res.code == 'ECOI-3999') {
                        // 충전소 이동
                        toast.alert("남은 코인이 부족해요");
                        setTimeout("movePage.charging();", 700);
                    } else {
                        toast.alert(res.message);
                    }
                }
            },
            error: function (request, status, error) {
                // filter error
                //toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
            }
        });
        return false;
    }

    // 회차 구매 - 전체
    let episodePurchaseTotal = function (_params) {
        if (local.memberInfo() == null) {
            toast.alert("로그인 후 이용해주세요");
            movePage.login();
            return false;
        }
        let data = {
            route: (app.isAppReady) ? 2 : 1,
        }
        // 소장 - 무료 회차 포함 여부
        if (_params.get('type') == 'have') {
            data.includeFree = _params.get("includeFree");
        } else {
            data.isFreeEpisode = _params.get("isFreeEpisode");
        }

        $.ajax({
            url: '{C.API_DOMAIN}/v1/purchase/contents/' + contentsIdx + '/' + _params.get('type'),
            cache: true,
            method: 'POST',
            dataType: 'json',
            data: JSON.stringify(data),
            processData: false,
            contentType: 'application/json',
            xhrFields: {
                withCredentials: true
            },
            success: function (res) {
                if (res.result) {
                    toast.alert(res.message);
                    content.episodeList();
                } else {
                    // 보유 코인 부족
                    if (res.code == 'ECOI-3999') {
                        // 충전소 이동
                        toast.alert("남은 코인이 부족해요");
                        setTimeout("movePage.charging();", 700);
                    } else {
                        toast.alert(res.message);
                    }
                }
            },
            error: function (request, status, error) {
                // filter error
                //toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
            }
        });
        return false;
    }

    /**
     * 구매 알림 확인
     * @returns {boolean}
     */
    let memberSetting = function () {
        $.ajax({
            url: '{ C.API_DOMAIN }/v1/member/settings',
            cache: true,
            method: 'GET',
            dataType: 'json',
            processData: false,
            contentType: false,
            xhrFields: {
                withCredentials: true
            },
            success: function (res) {
                if (res.result) {
                    if (res.data.settingList.length > 0) {
                        if (res.data.settingList[0].state == 1) {
                            isNotSendAlarm = true;
                        } else {
                            isNotSendAlarm = false;
                        }
                    }
                }
            },
            error: function (request, status, error) {
                // filter error
                // toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
            }
        });
        return false;
    }

    /**
     * 작품 bottomSheet
     */
    // 작품 이어보기 팝업
    let myLibBottom = function (bottomSheetData) {
        bottomSheetData = JSON.parse(decodeURI(bottomSheetData));
        let badge = badgeSvg(bottomSheetData.badgeList);

        if (bottomSheetData.episodeIdx != null) {
            $.ajax({
                url: '{ C.API_DOMAIN }/v1/member/library/episodes/' + bottomSheetData.episodeIdx,
                cache: true,
                method: 'GET',
                dataType: 'json',
                processData: false,
                contentType: false,
                xhrFields: {
                    withCredentials: true
                },
                success: function (res) {
                    if (res.result) {
                        let data = res.data.content;

                        $("#myLibBottomSheet").empty();
                        $("#myLibBottomSheet").load('/my/lib/bottomSheet', function (responseTxt, statusTxt, xhr) {
                            /** 썸네일 */
                            let bottomImgWrap = $("#lib_bottom_container .lib_bottom_wrap .img_wrap");
                            bottomImgWrap.find('img').attr("src", data.contentHeightImgList[0].url);

                            /** info wrap */
                            let bottomInfoWrap = $("#lib_bottom_container .lib_bottom_wrap .info_wrap");
                            bottomInfoWrap.find('.genre').html(data.category);
                            bottomInfoWrap.find('.title_wrap').prepend(badge.title);
                            bottomInfoWrap.find('.title_wrap > span').html(data.contentsTitle);
                            if (bottomSheetData.regdate) {
                                bottomInfoWrap.find('.bottom_wrap > span').html(dateFormat.contentsDate(bottomSheetData.regdate, '.'));
                            }

                            let searchTypeCode = 'rent';
                            if (data.sellType == 2) {
                                searchTypeCode = 'have';
                            }
                            /** 최근 본 회차 보기 */
                            let bottomContinueWrap = $("#lib_bottom_container .lib_bottom_wrap a.continue");
                            bottomContinueWrap.children("span").html(data.episodeNumTitle + " 보기");
                            bottomContinueWrap.data("contents-idx", data.contentsIdx)
                                .data("episode-idx", data.episodeIdx)
                                .data("search-type-code", searchTypeCode);

                            /** 다음 회차 */
                            // 버튼 조건
                            let purchaseParams = purchaseButton(data);
                            let bottomButtonWrap = $("#lib_bottom_container .lib_bottom_wrap .btn_wrap");
                            bottomButtonWrap.html(purchaseParams.nextButton);

                            // bottomSheet show
                            //$("#lib_bottom_container").addClass('active').slideDown();
                            $("#lib_bottom_container").addClass('active').css('bottom', '0px');

                        })
                    } else {
                        toast.alert(res.message);
                    }
                },
                error: function (request, status, error) {
                    // filter error
                    //toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
                }
            });
        }
    }

    /**
     * 회원 선물함 리스트 조회
     */
    let memberGiftList = function () {

        // set params
        let params = new Map();
        giftParams.default(params);
        let page = params.get("page");
        let recordSize = params.get("recordSize");

        $.ajax({
            url: '{ C.API_DOMAIN }/v1/gifts?page=' + page + '&recordSize=' + recordSize,
            cache: true,
            method: 'GET',
            dataType: 'json',
            processData: false,
            contentType: false,
            xhrFields: {
                withCredentials: true
            },
            success: function (res) {
                if (res.result) {
                    // 쿠키 갱신(지급 받은 선물 총 개수)
                    if ($.cookie('giftCnt') != undefined) {
                        $.removeCookie("giftCnt");
                        $.cookie('giftCnt', res.data.giftIconCount, { path : '/', secure : true });
                    }
                }
            },
            error: function (request, status, error) {
                // filter error
                //toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
            }
        });
        return false;
    }
</script>