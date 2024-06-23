<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
<meta name="description" content="꿀툰에서 매일매일 나만의 웹툰,만화,소설을 골라보는 재미">
<meta name="author" content="">
<meta name="keywords" content="웹툰,만화,소설,무료,유료,BL웹툰,로맨스,판타지,Webtoon,Comic,성인만화,성인웹툰,월요웹툰,화요웹툰,수요웹툰,목요웹툰,금요웹툰,토요웹툰,일요웹툰,무료웹툰사이트">

<!-- canonical -->
<!--<link rel="canonical" href="https://www.ggultoons.com/">-->

<!-- 기본적인 웹 og 메타태그 설정  -->
<meta property="og:site_name" content="꿀툰">
<meta property="og:type" content="website">
<meta property="og:url" content="https://www.ggultoons.com/">
<meta property="og:title" content="{? HTML.TITLE != ''}{HTML.TITLE} - {/}{C.CNF_TITLE}">
<meta property="og:image" content="https://webtoon-front.devlabs.co.kr/assets/images/kr/main/logo_og2.png">
<meta property="og:description" content="꿀툰에서 매일매일 나만의 웹툰,만화,소설을 골라보는 재미">
<meta property="og:image:width" content="470">
<meta property="og:image:height" content="250">

<!-- 트위터 미리보기 설정 -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="{? HTML.TITLE != ''}{HTML.TITLE} - {/}{C.CNF_TITLE}" />
<meta name="twitter:description" content="매일매일 나만의 웹툰,만화,소설을 골라보는 재미" />
<meta name="twitter:image" content="https://webtoon-front.devlabs.co.kr/assets/images/kr/main/logo_og2.png" />
<meta name="twitter:image:width" content="600" />
<meta name="twitter:image" content="600" />

<!-- 사이트 소유확인 -->
<meta name="google-site-verification" content="OH7Lhxm7m27sdX7K-0q5LMku8tbEowxjaOU5R0hZEio">
<meta name="naver-site-verification" content="585ef599a072ab0bbef245443ea178d088fe58b7" />

<title>{? HTML.TITLE != ''}{HTML.TITLE} - {/}{C.CNF_TITLE}</title>

<!-- favicon -->
<link rel="shortcut icon" href="/assets/images/favicon-16x16.ico">

<!-- reset css -->
<link rel="stylesheet" href="{=getAssetPath('/assets/css/common/reset.css')}">
<link href="{=getAssetPath('/assets/css/' + CNF.LANG + '/global.css')}" rel="stylesheet">

<!-- css -->
<link href="{=getAssetPath('/assets/vendor/bootstrap-5.3.0/css/bootstrap.min.css')}" rel="stylesheet" type="text/css">
<link href="{=getAssetPath('/assets/vendor/fontawesome-free-6.4.0-web/css/all.min.css')}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<link href="{=getAssetPath('/assets/vendor/jquery-ui-1.13.2/jquery-ui.css')}" rel="stylesheet">

<link href="{=getAssetPath('/assets/css/common/swiper-bundle.css')}" rel="stylesheet">
<link href="{=getAssetPath('/assets/css/' + CNF.LANG + '/modal/modal.css')}" rel="stylesheet">
<!-- Froala 에디터 라이브러리 -->
<!-- <link href="/node_modules/froala-editor/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" /> -->
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.css"> -->


{HTML.CSS}

<!-- js -->
<script type="text/javascript" src="{=getAssetPath('/assets/js/common/jquery-3.7.0.min.js')}"></script>
<script type="text/javascript" src="{=getAssetPath('/assets/vendor/bootstrap-5.3.0/js/bootstrap.bundle.js')}"></script>
<script type="text/javascript" src="{=getAssetPath('/assets/vendor/jquery-ui-1.13.2/jquery-ui.js')}"></script>
<script type="text/javascript" src="{=getAssetPath('/assets/vendor/ckeditor5/build/ckeditor.js')}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"
    integrity="sha512-0bEtK0USNd96MnO4XhH8jhv3nyRF0eK87pJke6pkYf3cM0uDIhNJy9ltuzqgypoIFXw3JSuiy04tVk4AjpZdZw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="{=getAssetPath('/assets/js/common/swiper-bundle.min.js')}"></script>
<script type="text/javascript" src="{=getAssetPath('/assets/js/common/common.js')}"></script>
<script type="text/javascript" src="{=getAssetPath('/assets/js/common/jquery.cookie.js')}"></script>
<script type="text/javascript" src="{=getAssetPath('/assets/js/common/jquery-animate-css-rotate-scale.js')}"></script>

<!-- 소셜 api -->
<script type="text/javascript" src="https://static.nid.naver.com/js/naveridlogin_js_sdk_2.0.2.js"></script>


<script>
    $(document).ready(function () {

        /** 로그인 상태 관리 : API 세션 만료 시 자동 로그인 키 체크
         *
         * 자동 로그인 키 있음 -> 로그인 처리
         * 자동 로그인 키 없음 -> OTT 접속한 성인 회원 여부 체크
         *
         * OTT 접속한 성인 회원일 경우 -> 전체 작품 노출되도록 로컬 스토리지 세팅
         * 일반 비로그인 상태 또는 OTT 접속한 비성인 회원일 경우 -> 일반 작품만 노출되도록 로컬 스토리지 세팅
         * **/
        $.ajax({
            url: '{ C.API_DOMAIN }/v1/member/check',
            cache: true,
            method: 'GET',
            dataType: 'json',
            processData: false,
            async: false, // 동기 방식으로 통신
            contentType: 'application/json',
            xhrFields: {
                withCredentials: true
            },
            success: function (res) {
                if (res.result) {

                    // 비로그인 상태일 경우
                    if (res.data.memberInfo == false) {

                        // 자동로그인 키가 있는 경우 -> 로그인 처리
                        if (loginSettings != null && loginSettings.state.autoLoginEnabled && loginSettings.state.autoLoginKey.key != '') {
                            let data = JSON.stringify({
                                auto: loginSettings.state.autoLoginKey.key
                            });
                            // 로그인 ajax
                            loginAjax(data);

                            // 자동로그인 키가 없는 경우 -> OTT 성인 회원 여부 체크
                        } else {
                            // 로컬 스토리지 비우기
                            localStorage.removeItem("memberInfo");

                            // OTT 접속한 성인 회원일 경우
                            if (res.data.ottVisitToken != undefined && res.data.ottVisitToken) {
                                
                                // 세션 스토리지에 OTT 접속 토큰이 있는 경우
                                if (session.ottToken() != null) {

                                    // 헤더 토글 버튼 활성화 처리
                                    localStorage.setItem("pavilion", JSON.stringify({ 'state': { 'pavilionIdx': 1 }, 'version': 0 }));
                                    $("#default #header_nav li:first").find(".toggle-wrap").addClass("active");
                                    $(".sub #header_nav li:first").find(".toggle-wrap").addClass("active");

                                    // 세션 스토리지에 OTT 접속 토큰이 없는 경우
                                } else {

                                    // API 쿠키 제거
                                    removeTokenCookie();

                                    // 헤더 토글 버튼 비활성화 처리
                                    localStorage.setItem("pavilion", JSON.stringify({ 'state': { 'pavilionIdx': 0 }, 'version': 0 }));
                                    $("#default #header_nav li:first").find(".toggle-wrap").removeClass("active");
                                    $(".sub #header_nav li:first").find(".toggle-wrap").removeClass("active");
                                }

                                // 일반 비로그인 또는 OTT 접속한 비성인 회원일 경우
                            } else {
                                // 로컬 스토리지 비우기
                                localStorage.removeItem("pavilion");
                            }
                        }
                    }
                }
            },
            error: function (request, status, error) {
                // filter error
                //toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
            }
        });

        /** 로그아웃 **/
        $("#logout").on("click", function () {
            $.ajax({
                url: '{C.API_DOMAIN}/v1/logout',
                cache: true,
                method: 'GET',
                processData: false,
                contentType: 'application/json; charset=utf-8;',
                xhrFields: {
                    withCredentials: true
                },
                success: function (res) {
                    let data = JSON.parse(res);
                    if (data.result) {

                        // 자동로그인 삭제
                        loginSettings.state.autoLoginEnabled = false;
                        settingSave(data);

                        // 회원 정보 삭제
                        localStorage.removeItem("memberInfo");

                        // 시청연령 선택 정보 삭제
                        localStorage.removeItem("pavilion");

                        // 쿠키 삭제
                        $.removeCookie("giftCnt");
                        $.removeCookie("modal");

                        // 로그아웃 1초 후 메인 이동
                        setTimeout(function () {
                            window.location.href = "/";
                        }, 1000);

                    } else {
                        toast.alert(data.message);
                    }
                    return false;
                }
            })
        })

        /** 꿀툰 서비스 종료 -> 선물함 및 마일리지 지급 불가 처리 **/
        ///** 1. 선물함 선물 지급 완료 모달 **/
        // giftModal 쿠키 정보 조회
        // let giftModal = $.cookie("giftModal");
        //
        // // 쿠키가 만료된 경우 -> 모달 호출
        // if (giftModal == undefined) {
        //
        //     // 선물함 선물 지급 완료 모달 노출용 데이터
        //     let memberId = "";
        //     let contentTitle = "";
        //     let contentImgUrl = "";
        //
        //     // 회원 정보 조회
        //     let memberInfo = local.memberInfo();
        //     if (memberInfo != null) {
        //
        //         // 닉네임이 없는 경우
        //         if (memberInfo.data.nick == "") {
        //
        //             // 간편 로그인
        //             if (memberInfo.data.isSimple == 1) {
        //                 // 이메일 세팅
        //                 memberId = memberInfo.data.email;
        //
        //                 // 일반 로그인
        //             } else {
        //                 // 아이디 세팅
        //                 memberId = memberInfo.data.id;
        //             }
        //
        //             // 닉네임이 있는 경우
        //         } else {
        //             // 닉네임 세팅
        //             memberId = memberInfo.data.nick;
        //         }
        //
        //         // 회원 선물함 리스트 조회
        //         let giftData = member.giftList();
        //
        //         // 선물함 리스트 조회
        //         if (giftData != "" && giftData != null && giftData != undefined) {
        //
        //             // 오늘 받을 선물이 있는 경우
        //             if (giftData.data.todayGiftList.list.length > 0) {
        //
        //                 // 기본 노출할 작품 정보 세팅 -> 사용 가능 선물 중 첫번째 선물 정보
        //                 let todayGiftData = giftData.data.todayGiftList.list[0];
        //
        //                 // 작품 제목
        //                 contentTitle = todayGiftData.contentsTitle;
        //
        //                 // 작품 썸네일(기본 : 가로 이미지 -> 없을 경우 세로 이미지)
        //                 if (todayGiftData.contentWidthImgList != null && todayGiftData.contentWidthImgList != undefined && todayGiftData.contentWidthImgList.length > 0) {
        //                     if (todayGiftData.contentWidthImgList[0].url != null && todayGiftData.contentWidthImgList[0].url != undefined) {
        //                         contentImgUrl = todayGiftData.contentWidthImgList[0].url;
        //                     }
        //                 } else {
        //                     contentImgUrl = todayGiftData.contentHeightImgList[0].url;
        //                 }
        //                 // 새 쿠키 굽기(1일 후 만료)
        //                 $.cookie('giftModal', true, { expires : 1, path : '/', secure : true });
        //
        //                 // 선물함 선물 지급 완료 모달 호출
        //                 let giftModalData = new Map();
        //                 giftModalData.set("memberId", memberId);
        //                 giftModalData.set("contentTitle", contentTitle);
        //                 giftModalData.set("contentImgUrl", contentImgUrl);
        //                 gModal.showGift(giftModalData);
        //
        //                 // 내일 받을 선물이 있는 경우
        //             } else if (giftData.data.tomorrowGiftList.list.length > 0) {
        //
        //                 // 기본 노출할 작품 정보 세팅 -> 사용 가능 선물 중 첫번째 선물 정보
        //                 let tomorrowGiftData = giftData.data.tomorrowGiftList.list[0];
        //
        //                 // 작품 제목
        //                 contentTitle = tomorrowGiftData.contentsTitle;
        //
        //                 // 작품 썸네일(기본 : 가로 이미지 -> 없을 경우 세로 이미지)
        //                 if (tomorrowGiftData.contentWidthImgList != null && tomorrowGiftData.contentWidthImgList != undefined && tomorrowGiftData.contentWidthImgList.length > 0) {
        //                     if (tomorrowGiftData.contentWidthImgList[0].url != null && tomorrowGiftData.contentWidthImgList[0].url != undefined) {
        //                         contentImgUrl = tomorrowGiftData.contentWidthImgList[0].url;
        //                     }
        //                 } else {
        //                     contentImgUrl = tomorrowGiftData.contentHeightImgList[0].url;
        //                 }
        //                 // 새 쿠키 굽기(1일 후 만료)
        //                 $.cookie('giftModal', true, { expires : 1, path : '/', secure : true });
        //
        //                 // 선물함 선물 지급 완료 모달 호출
        //                 let giftModalData = new Map();
        //                 giftModalData.set("memberId", memberId);
        //                 giftModalData.set("contentTitle", contentTitle);
        //                 giftModalData.set("contentImgUrl", contentImgUrl);
        //                 gModal.showGift(giftModalData);
        //             }
        //         }
        //     }
        // }
        //
        // /** 2. 로그인 마일리지 지급 완료 모달
        //  * 마일리지 사용 안한 회원에 한해 오전에 1번 + 오후에 1번 -> 하루에 총 2번 노출
        //  * 쿠키 만료 시간 세팅 : 오전 00시 00분 00초 ~ 오전 11시 59분 59초(오전) / 오후 12시 ~ 오후 23시 59분 59초(오후)
        //  **/
        // // mileageModal 쿠키 정보 조회
        // let mileageModal = $.cookie("mileageModal");
        //
        // // 쿠키가 만료된 경우 -> 모달 호출
        // if (mileageModal == undefined) {
        //
        //     // 회원 정보 조회
        //     let memberInfo = local.memberInfo();
        //     if (memberInfo != null) {
        //
        //         let title = "";
        //         let detail = "";
        //         let mileage = "";
        //         let regdate = "";
        //
        //         // 로그인 마일리지 지급된 경우
        //         if (memberInfo.data.loginMileage.result) {
        //
        //             // 회원가입한 회원이 최초 로그인한 경우
        //             if (memberInfo.data.loginMileage.new) {
        //
        //                 // 모달 호출 여부 체크
        //                 let checkModal = $.cookie("modal");
        //                 if (checkModal != undefined) { // 지급 후 최초 노출 시
        //
        //                     // 지급 마일리지
        //                     mileage = memberInfo.data.loginMileage.mileage;
        //
        //                     // 지급일
        //                     regdate = memberInfo.data.loginMileage.regdate.substring(8, 10);
        //
        //                     // 모달 텍스트 세팅
        //                     title = `<span>` + mileage + `M 지급이 완료되었습니다!</span>`;
        //                     detail = `<span>` + regdate + `일 오전 10시부터 매일 지급되는 마일리지로 무료 감상하세요~!</span>`;
        //
        //                     // 모달 호출용 쿠키 세팅
        //                     setModalCookie();
        //
        //                     // 로그인 마일리지 모달 호출
        //                     if (title != "" && detail != "") {
        //                         let params = new Map();
        //                         params.set("title", title);
        //                         params.set("detail", detail);
        //                         params.set("color", "yellow");
        //                         gModal.alert(params, "");
        //                     }
        //                 }
        //
        //                 // 기존 회원이 로그인한 경우
        //             } else {
        //
        //                 // 지급 마일리지
        //                 mileage = memberInfo.data.loginMileage.mileage;
        //
        //                 // 모달 호출 여부 체크
        //                 let checkModal = $.cookie("modal");
        //                 if (checkModal !== undefined) { // 지급 후 최초 노출 시
        //
        //                     // 모달 텍스트 세팅
        //                     title = `<span> "매일 지급되는 마일리지!" </span>`;
        //                     detail = `<span>` + mileage + `M 지급이 완료되었습니다!<br>소멸되기 전에 무료 감상으로 즐기세요~!</span>`;
        //
        //                     // 모달 호출용 쿠키 세팅
        //                     setModalCookie();
        //
        //                     // 로그인 마일리지 모달 호출
        //                     if (title != "" && detail != "") {
        //                         let params = new Map();
        //                         params.set("title", title);
        //                         params.set("detail", detail);
        //                         params.set("color", "yellow");
        //                         gModal.alert(params, "");
        //                     }
        //
        //                 } else {
        //
        //                     // 오늘 받은 로그인 마일리지 지급 내역 조회
        //                     let loginMileageInfo = member.loginMileage();
        //                     if (loginMileageInfo != "" && loginMileageInfo != undefined) {
        //
        //                         // 오늘 받은 로그인 마일리지를 아직 사용하지 않은 경우
        //                         if (mileage == loginMileageInfo.data.loginMileageInfo[0].restMileage) {
        //
        //                             // 모달 텍스트 세팅
        //                             title = `<span> "잠깐! 아직 사용하지 않은 마일리지가 있어요!" </span>`;
        //                             detail = `<span> 오전 10시부터 매일 지급되는 ` + mileage + `M!<br>소멸되기 전에 무료 감상으로 즐기세요~!</span>`;
        //
        //                             // 모달 호출용 쿠키 세팅
        //                             setModalCookie();
        //
        //                             // 로그인 마일리지 모달 호출
        //                             if (title != "" && detail != "") {
        //                                 let params = new Map();
        //                                 params.set("title", title);
        //                                 params.set("detail", detail);
        //                                 params.set("color", "yellow");
        //                                 gModal.alert(params, "");
        //                             }
        //                         }
        //                     }
        //                 }
        //             }
        //
        //             // 로그인 마일리지가 이미 지급된 경우
        //         } else {
        //
        //             // 오늘 받은 로그인 마일리지 지급 내역 조회
        //             let loginMileageInfo = member.loginMileage();
        //             if (loginMileageInfo != "" && loginMileageInfo != undefined) {
        //
        //                 // 오늘 받은 로그인 마일리지를 아직 사용하지 않은 경우
        //                 if (loginMileageInfo.data.loginMileageInfo[0].mileage == loginMileageInfo.data.loginMileageInfo[0].restMileage) {
        //
        //                     // 지급 마일리지
        //                     mileage = loginMileageInfo.data.loginMileageInfo[0].mileage;
        //
        //                     // 모달 텍스트 세팅
        //                     title = `<span> "잠깐! 아직 사용하지 않은 마일리지가 있어요!" </span>`;
        //                     detail = `<span> 오전 10시부터 매일 지급되는 ` + mileage + `M!<br>소멸되기 전에 무료 감상으로 즐기세요~!</span>`;
        //
        //                     // 모달 호출용 쿠키 세팅
        //                     setModalCookie();
        //
        //                     // 로그인 마일리지 모달 호출
        //                     if (title != "" && detail != "") {
        //                         let params = new Map();
        //                         params.set("title", title);
        //                         params.set("detail", detail);
        //                         params.set("color", "yellow");
        //                         gModal.alert(params, "");
        //                     }
        //                 }
        //             }
        //         }
        //     }
        // }

        /** 자동 로그인 체크(호출 순서 변경 금지) **/
        loginCheck();
    })

    /**
     * 네이버 로그인 API 초기화
     * @type {string}
     */
    let naverLogin = new window.naver.LoginWithNaverId({
        clientId: '{C.NEXT_PUBLIC_NAVER_CLIENT_ID}',
        callbackUrl: window.location.origin + '/auth/naver',
        isPopup: true,
        loginButton: { color: 'green', type: 3, height: 58 },
        callbackHandle: true,
    });

    // ott 파라미터 sessionStorage 저장 및 방문 통계 api
    const urlParamas = new URLSearchParams(window.location.search);
    const ottToken = urlParamas.get("e");
    if (ottToken != null) {
        $.ajax(
            '{C.API_DOMAIN}/v1/join/ott/visit',
            {
                type: 'POST',
                contentType: 'application/json; charset=utf-8;',
                data: JSON.stringify({
                    edata: ottToken,
                }),
                xhrFields: {
                    withCredentials: true
                },
                success: function (res) {
                    sessionStorage.setItem("ottToken", ottToken);

                    return false;
                }
            }
        )
    }

    /**
     * 로그인
     */
    // 로그인 셋팅
    let loginSettingsStorage = local.loginSettings();
    let loginSettings = {
        state: {
            autoLoginEnabled: (loginSettingsStorage != null) ? loginSettingsStorage.state.autoLoginEnabled : false,
            saveId: (loginSettingsStorage != null) ? loginSettingsStorage.state.saveId : false,
            previousLoginId: (loginSettingsStorage != null && loginSettingsStorage.state.saveId) ? loginSettingsStorage.state.previousLoginId : '',
            autoLoginKey: {
                id: (loginSettingsStorage != null && loginSettingsStorage.state.autoLoginEnabled) ? loginSettingsStorage.state.autoLoginKey.id : '',
                key: (loginSettingsStorage != null && loginSettingsStorage.state.autoLoginEnabled) ? loginSettingsStorage.state.autoLoginKey.key : '',
                simpleType: '일반'
            },
        }
    }

    // 셋팅 save
    let settingSave = async function (data) {
        // 자동 로그인
        if (loginSettings.state.autoLoginEnabled && data.result) {
            loginSettings.state.autoLoginKey.id = data.data.id;
            loginSettings.state.autoLoginKey.key = data.data.auto;
        } else {
            loginSettings.state.autoLoginEnabled = false;
            loginSettings.state.autoLoginKey.id = '';
            loginSettings.state.autoLoginKey.key = '';
        }

        // 아이디 저장
        if (loginSettings.state.saveId && data.result) {
            loginSettings.state.previousLoginId = $("#loginFrm input[name=id]").val();
        } else {
            loginSettings.state.saveId = false;
            loginSettings.state.previousLoginId = '';
        }
        localStorage.setItem("loginSettings", JSON.stringify(loginSettings));
        return true;
    }

    // 자동 로그인 체크
    let loginCheck = function () {
        // 비로그인 상태
        if (local.memberInfo() == null) {
            // 자동 로그인
            if (loginSettings != null && loginSettings.state.autoLoginEnabled && loginSettings.state.autoLoginKey.key != '') {
                let data = JSON.stringify({
                    auto: loginSettings.state.autoLoginKey.key
                });
                // 로그인 ajax
                loginAjax(data);
            }
        }
        return false;
    }

    // 로그인
    let loginAjax = function (strJsonData) {
        $.ajax({
            url: '{C.API_DOMAIN}/v1/login',
            cache: false,
            method: 'POST',
            async: false,
            dataType: 'json',
            processData: false,
            contentType: 'application/json',
            xhrFields: {
                withCredentials: true
            },
            data: strJsonData,
            success: function (res) {
                let data = res;
                if (data.result) {

                    // 1. 현재 시간(로컬)
                    const nowDate = new Date();
                    // 2. UTC 시간 계산
                    const UTC = nowDate.getTime() + (nowDate.getTimezoneOffset() * 60 * 1000);
                    // 3. UTC to KST (UTC + 9시간 + 60일)
                    const KR_TIME_DIFF = (9 * 60 * 60 * 1000) + (60 * 24 * 60 * 60 * 1000);
                    const krDate = new Date(UTC + (KR_TIME_DIFF));

                    // 회원 정보 세팅
                    data.expire = krDate; // 로컬 스토리지 만료시간 세팅(60일)
                    localStorage.setItem("memberInfo", JSON.stringify(data));

                    /** 꿀툰 서비스 종료 -> 선물함 및 마일리지 지급 불가 처리 **/
                    // // 선물함 쿠키 세팅 : 받은 선물 정보
                    // member.giftList();
                    //
                    // // 모달 호출 체크용 쿠키 세팅
                    // $.cookie('modal', true, { path : '/', secure : true });

                    // APP 알림 토큰 저장
                    appData.registerToken();
                    
                    // APP AD ID 저장
                    appData.registerAdid();

                    // 시청연령 정보 저장
                    if (data.data.adult == 1) { // 성인
                        localStorage.setItem("pavilion", JSON.stringify({ 'state': { 'pavilionIdx': 1 }, 'version': 0 }));
                    } else { // 비성인
                        localStorage.setItem("pavilion", JSON.stringify({ 'state': { 'pavilionIdx': 0 }, 'version': 0 }));
                    }

                    // 자동로그인 셋팅
                    settingSave(data).then(
                        function () {
                            // 로그인을 시도하고 있는 페이지
                            let currentUrl = $(location).attr('pathname');

                            // 마이페이지
                            if (currentUrl.match("guest")) {
                                movePage.main(); // 메인 페이지로 이동
                            }
                            // 그 외
                            else {
                                let jsonData = JSON.parse(strJsonData);
                                if (jsonData.auto != undefined) {
                                    toast.alert("로그인 되었습니다.");
                                } else {
                                    location.reload(); // 현재 페이지 새로고침
                                }
                            }
                        }
                    )
                } else {
                    toast.alert(data.message);

                    // 자동로그인 셋팅
                    settingSave(data).then(
                        function () {
                            defaultSetting.reset();
                        }
                    )
                }
            }
        });
        return false;
    }

    /** API OTT 토큰 쿠키 제거 **/
    function removeTokenCookie() {

        // 세션 스토리지에 OTT 토큰 정보가 없는 경우
        if (session.ottToken() == null) {
            
            // API 서버 OTT 토큰 쿠키 제거
            $.ajax({
                url: '{ C.API_DOMAIN }/v1/member/cookie',
                cache : true,
                method: 'DELETE',
                dataType: 'json',
                processData: false,
                contentType: false,
                async: false, // 동기 방식으로 통신
                xhrFields: {
                    withCredentials: true
                },
                success: function (res) {
                    if (res.result) {
                        // toast.alert(res.message);
                    } else {
                        // ajax exception error
                        // toast.alert(res.message);
                    }
                },
                error: function (request, status, error) {
                    // filter error
                    toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
                }
            });
        }
    }

    /** APP 접속 회원 알림 토큰 및 AD ID 저장 **/
    let appData = {
        // 알림 토큰 저장
        registerToken: function () {

            // 알림 토큰 조회
            let token = app.getFcmToken;
            if (token != '' && token != undefined) {

                // send data set
                let obj = {token: token};
                let data = JSON.stringify(obj);

                $.ajax({
                    url: '{ C.API_DOMAIN }/v1/member/app/token',
                    cache : true,
                    method: 'POST',
                    data: data,
                    dataType: 'json',
                    processData: false,
                    contentType: 'application/json',
                    xhrFields: {
                        withCredentials: true
                    },
                    success: function (res) {
                        if (res.result) {
                            // 저장 성공
                            // toast.alert(res.message);
                        } else {
                            // ajax exception error
                            // toast.alert(res.message);
                        }
                    },
                    error: function (request, status, error) {
                        // filter error
                        //toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
                    }
                });
                return false;
            }
        },
        // AD ID 저장
        registerAdid: function () {

            // AD ID 조회
            let adid = app.getADID;
            if (adid != '' && adid != undefined) {

                // send data set
                let obj = {adid: adid};
                let data = JSON.stringify(obj);

                $.ajax({
                    url: '{ C.API_DOMAIN }/v1/member/app/adid',
                    cache : true,
                    method: 'POST',
                    data: data,
                    dataType: 'json',
                    processData: false,
                    contentType: 'application/json',
                    xhrFields: {
                        withCredentials: true
                    },
                    success: function (res) {
                        if (res.result) {
                            // 저장 성공
                            // toast.alert(res.message);
                        } else {
                            // ajax exception error
                            // toast.alert(res.message);
                        }
                    },
                    error: function (request, status, error) {
                        // filter error
                        //toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
                    }
                });
                return false;
            }
        }
    }

    /** 꿀툰 서비스 종료 -> 선물함 및 마일리지 지급 불가 처리 **/
    // /** 회원 정보 조회 **/
    // let member = {
    //     // 선물함 리스트 조회 및 선물 지급
    //     giftList: function () {
    //
    //         // params value
    //         let giftData = "";
    //         let giftMap = new Map();
    //         giftParams.default(giftMap);
    //         let page = giftMap.get("page");
    //         let recordSize = giftMap.get("recordSize");
    //
    //         $.ajax({
    //             url: '{ C.API_DOMAIN }/v1/gifts?page=' + page + '&recordSize=' + recordSize,
    //             cache: true,
    //             method: 'GET',
    //             dataType: 'json',
    //             processData: false,
    //             async: false,
    //             contentType: 'application/json',
    //             xhrFields: {
    //                 withCredentials: true
    //             },
    //             success: function (res) {
    //                 if (res.result) {
    //                     // return value
    //                     giftData = res;
    //
    //                     // 지급 받을 총 선물 개수 쿠키 세팅
    //                     if ($.cookie('giftCnt') != undefined) {
    //                         $.removeCookie("giftCnt");
    //                     }
    //                     $.cookie('giftCnt', res.data.giftIconCount, { path : '/', secure : true });
    //                 }
    //             },
    //             error: function (request, status, error) {
    //                 // filter error
    //                 //toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
    //             },
    //             complete: function (request, status, error) {
    //                 let response = JSON.parse(request.responseText);
    //                 if (response.result == false) {
    //                     // 로컬 스토리지 비우기
    //                     localStorage.removeItem("memberInfo");
    //                     localStorage.removeItem("pavilion");
    //                 }
    //             }
    //         });
    //         return giftData;
    //     },
    //     // 오늘 받은 로그인 마일리지 내역 조회
    //     loginMileage: function () {
    //
    //         // return value
    //         let loginMileageInfo = "";
    //
    //         $.ajax({
    //             url: '{ C.API_DOMAIN }/v1/member/coin/mileage/login',
    //             cache: true,
    //             method: 'GET',
    //             dataType: 'json',
    //             processData: false,
    //             async: false,
    //             contentType: 'application/json',
    //             xhrFields: {
    //                 withCredentials: true
    //             },
    //             success: function (res) {
    //                 if (res.result) {
    //                     if (res.data.loginMileageInfo.length > 0) {
    //                         // return value
    //                         loginMileageInfo = res;
    //                     }
    //                 }
    //             },
    //             error: function (request, status, error) {
    //                 // filter error
    //                 //toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
    //             },
    //             complete: function (request, status, error) {
    //                 let response = JSON.parse(request.responseText);
    //                 if (response.result == false) {
    //                     // 로컬 스토리지 비우기
    //                     localStorage.removeItem("memberInfo");
    //                     localStorage.removeItem("pavilion");
    //                 }
    //             }
    //         });
    //         return loginMileageInfo;
    //     }
    // }

    ///** 로그인 마일리지 모달 호출용 쿠키 세팅 **/
    // function setModalCookie(){
    //
    //     // 1. 현재 시간(로컬)
    //     const nowDate = new Date();
    //     // 2. UTC 시간 계산
    //     const UTC = nowDate.getTime() + (nowDate.getTimezoneOffset() * 60 * 1000);
    //     // 3. UTC to KST (UTC + 9시간)
    //     const KR_TIME_DIFF = 9 * 60 * 60 * 1000;
    //     const krDate = new Date(UTC + (KR_TIME_DIFF));
    //
    //     // 쿠키 만료 시간 설정
    //     let expireTime;
    //     if (krDate.getHours() < 12) { // 접속 시간이 오전 -> 오늘 오후 12시 00분 00초부터 만료
    //         // UTC 시간으로 세팅
    //         expireTime = new Date(Date.UTC(krDate.getFullYear(), krDate.getMonth(), krDate.getDate(), 3, 0, 0));
    //
    //     } else { // 접속 시간이 오후 -> 오늘 오후 23시 59분 59초 이후부터 만료
    //         // UTC 시간으로 세팅
    //         expireTime = new Date(Date.UTC(krDate.getFullYear(), krDate.getMonth(), krDate.getDate(), 14, 59, 59));
    //     }
    //     // 쿠키 세팅
    //     $.cookie('mileageModal', true, { expires : expireTime, path : '/', secure : true });
    //     $.removeCookie('modal');
    // }
</script>