// csrf ajax 사용시 필요
/*$.ajaxPrefilter(function (options, originalOptions) {
    if (!options.processData && !options.contentType) {
        options.data.append('csrf_test_name', getCsrfCookie('csrf_test_name'));
    } else if (options.type.toLowerCase() === 'post') {
        options.data = $.param($.extend({}, originalOptions.data, {
            csrf_test_name: getCsrfCookie('csrf_test_name')
        }))
    }
});*/

function getCsrfCookie(cname) {
    let name = cname + '=';
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');

    for (const element of ca) {
		let c = element;
        while (c.charAt(0) === ' ') {
            c = c.substring(1);
        }

        if (c.indexOf(name) === 0) {
            return c.substring(name.length, c.length);
        }
    }

    return '';
}

// window.popup 함수
function js_popup(url, pop_name, w, h, z) {

    // 사이즈 처리
    if (!w) {
        w = 500;
    }
    if (!h) {
        h = 400;
    }
    if (!z) {
        z = 1;
    }

    let window_left = (screen.width / 2) - (w / 2);
    if (window_left < 0) {
        window_left = 0;
    }
    let window_top = (screen.height / 2) - (h / 2);
    if (window_top < 0) {
        window_top = 0;
    }

    let js_pop_form = window.open(url, pop_name, "top=" + window_top + ",left=" + window_left + ",toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=" + z + ",resizable=" + z + ",width=" + w + ",height=" + h);
    js_pop_form.resizeTo(w, h);
    js_pop_form.focus();
}

// 숫자 콤마 표시 1,999,000
function addComma(value) {
    value = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return value;
}

// bootstrap toast alert
let toast = {
    alert: function (message, options) {
        let timestamp = $.now();
        let html_toast = '<div  id="liveToast_' + timestamp + '" class="toast-box Text-md">'+message+'</div>';
        $(".toast-wrap").append(html_toast);
        let toastLive = $("#liveToast_" + timestamp);
        toastLive.delay(2500).slideUp(200);
    }
}

/**
 * 2024 설연휴 전작품 무료 감상 이벤트 변수
 */
let EVENT_STATE = true; // 이벤트 중지 시 false로 변경
let START_FREE_VIEW = "2024-02-05 00:00:00";
let END_FREE_VIEW = "2024-02-13 11:00:00";
function checkEventState() {
    
    // 이벤트가 현재 진행 중인지 여부
    let flag = false;
    
    // 현재 날짜
    let today = new Date();
    
    // 이벤트 시작일 및 종료일(String to Date)
    let start = new Date(START_FREE_VIEW);
    let end = new Date(END_FREE_VIEW);
    
    // 현재 날짜가 이벤트 기간 내에 있을 때
    if (start <= today && today <= end) {
        // 이벤트 진행중으로 판단
        flag = true;
    }
    return flag;
}

/**
 * 세션 스토리지 정보 조회
 */
let session = {
    // OTT 사이트에서 넘어온 토큰 정보
    ottToken: function () {
        return sessionStorage.getItem("ottToken");
    }
}

/**
 * 로컬 스토리지 정보 조회
 */
let local = {
    // 회원 정보
    memberInfo: function () {
        // 회원 정보 만료 시간 체크
        checkMemberInfoExpire();
        return JSON.parse(localStorage.getItem("memberInfo"));
    },
    // 회원 로그인 정보
    loginSettings: function () {
        return JSON.parse(localStorage.getItem("loginSettings"));
    },
    // 회원이 선택한 시청연령 정보
    pavilion: function () {
        // 회원 정보 만료 시간 체크
        checkMemberInfoExpire();
        return JSON.parse(localStorage.getItem("pavilion"));
    },
    // 가로모드 OR 세로모드 정보
    chkWrapWide: function () {
        return JSON.parse(localStorage.getItem("chkWrapWide"));
    },
    // 소설 감상 스타일 정보
    novelViewerStyle: function () {
        return JSON.parse(localStorage.getItem("novelViewerStyle"));
    },
    // 회차리스트 구매 유형 탭 정보
    sellTypeTab: function () {
        return JSON.parse(localStorage.getItem("sellTypeTab"));
    }
}

/**
 * 회원의 시청연령 정보 세팅
 */
let setPavilionIdx = function () {

    // 노출 기준
    let pavilionIdx;

    // 시청연령 토글 선택값 반영
    let pavilion = local.pavilion();

    // 비성인(일반)
    if (pavilion == null || pavilion.state.pavilionIdx == 0) {
        pavilionIdx = 0;

        // 성인(전체)
    } else {
        pavilionIdx = 1;
    }
    return pavilionIdx;
}

/**
 * 로컬 스토리지에 저장된 회원 정보 만료 시간 체크
 * 만료된 경우 로컬 스토리지에서 회원 정보 비우기
 */
let checkMemberInfoExpire = function () {

    // 1. 현재 시간(로컬)
    const nowDate = new Date();
    // 2. UTC 시간 계산
    const UTC = nowDate.getTime() + (nowDate.getTimezoneOffset() * 60 * 1000);
    // 3. UTC to KST (UTC + 9시간)
    const KR_TIME_DIFF = 9 * 60 * 60 * 1000;
    const krDate = new Date(UTC + (KR_TIME_DIFF));

    // 회원 정보 유효 시간(60일)이 만료된 경우
    let memberInfo = JSON.parse(localStorage.getItem("memberInfo"));
    if (memberInfo != null) {
        if (memberInfo.expire <= krDate) {
            // 로컬 스토리지 비우기
            localStorage.removeItem("memberInfo");
            localStorage.removeItem("pavilion");
        }
    }
}

/**
 * 페이지 이동
 */
let movePage = {

    // 메인 페이지
    main: function () {
        window.location.href = '/';
    },
    // 로그인 레이어 모달
    login: function () {
        // 회원 정보 조회
        let memberInfo = local.memberInfo();
        
        // 비로그인
        if (memberInfo == null) {
            gModal.login();
            
            // 로그인
        } else {
            movePage.main();
        }
    },
    // 검색 메인 페이지
    search: function (searchWord) {
        if (!searchWord) {
            window.location.href = '/search/main';
        } else {
            window.location.href = '/search/main?keyword=' + searchWord;
        }
    },
    // 검색 결과 더보기 페이지
    searchAll: function (type, searchWord) {
        window.location.href = '/search/' + type + '?keyword=' + searchWord;
    },
    // 웹툰 카테고리 페이지
    webtoon: function () {
        window.location.href = '/webtoon';
    },
    // 만화 카테고리 페이지
    comic: function () {
        window.location.href = '/comic';
    },
    // 소설 카테고리 페이지
    novel: function () {
        window.location.href = '/novel';
    },
    // 마이 페이지(로그인)
    member: function () {
        window.location.href = '/member';
    },
    // 작품 회차 리스트 페이지
    episode: function (contentsIdx) {
        window.location.href = '/contents/' + contentsIdx + '/episode';
    },
    // 작품 댓글 리스트 페이지
    contentComment: function (contentsIdx) {
        window.location.href = '/contents/' + contentsIdx + '/comments';
    },
    // 회차 댓글 리스트 페이지
    episodeComment: function (contentsIdx, episodeIdx) {
        window.location.href = '/contents/' + contentsIdx + '/episode/' + episodeIdx + '/comments';
    },
    // 회차 뷰어 페이지
    viewer: function (contentsIdx, episodeIdx) {
        window.location.href = '/contents/' + contentsIdx + '/episode/' + episodeIdx;
    },
    // 환경설정 페이지
    setting: function () {
        window.location.href = '/my/setting';
    },
    // 내 꿀단지 페이지
    myLibrary: function () {
        window.location.href = '/my/lib';
    },
    // 선택한 알림 확인용 페이지
    selectedNoti: function (url) {
        let origin = $(location).prop('origin');
        window.location.href = origin + url;
    },
    // 충전소 페이지
    charging: function () {
        window.location.href = '/charging';
    },
    // 선물함 페이지
    gift: function () {
        window.location.href = '/gift';
    },
    // 공지사항 페이지
    notice: function () {
        window.location.href = '/help/notice';
    }
}

/**
 * 스크롤 변수 세팅
 */
let scroll = {
    // 스크롤 변수 기본값 세팅
    default: function (params) {
        params.set("maxScroll", 1000); // 다음 페이지 호줄할 기준 높이값
        params.set("totalPageCnt", 0); // 호출할 총 페이지 개수
    },
    // 스크롤 변수 변경
    set: function (params, type, data) {

        // maxScroll
        if (type == "maxScroll") {
            params.set("maxScroll", data);
        }

        // totalPageCnt
        if (type == "totalPageCnt") {
            params.set("totalPageCnt", data);
        }
    }
}

/**
 * 메인 페이지
 * 파라미터 세팅
 */
let mainParams = {
    // 파라미터 기본값 세팅
    default: function (params) {
        params.set("page", 1);            // 페이지 기본값 set
        params.set("recordSize", 30);     // 레코드 개수 기본값 set
        params.set("pavilionIdx", 0);     // 이용관 기본값 set
        params.set("categoryIdx", 1);     // 카테고리 기본값 set
        params.set("searchType", "view"); // 내가 보던 꿀작 탭 기본값 set
        params.set("period", 1);          // 랭킹 기준 기본값 set
        params.set("complete", 0);        // 완결작 여부 기본값 set
        params.set("monograph", 0);       // 단행본 여부 기본값 set
    },
    // 파라미터 변경
    set: function (params, type, data) {

        // page
        if (type == "page") {
            params.set("page", data);
        }

        // recordSize
        if (type == "recordSize") {
            params.set("recordSize", data);
        }

        // pavilionIdx
        if (type == "pavilionIdx") {
            params.set("pavilionIdx", data);
        }

        // categoryIdx
        if (type == "categoryIdx") {
            params.set("categoryIdx", data);
        }

        // searchType
        if (type == "searchType") {
            params.set("searchType", data);
        }

        // period
        if (type == "period") {
            params.set("period", data);
        }

        // complete
        if (type == "complete") {
            params.set("complete", data);
        }

        // monograph
        if (type == "monograph") {
            params.set("monograph", data);
        }
    }
}

/**
 * 검색 페이지
 * 파라미터 세팅
 */
let searchParams = {
    // 파라미터 기본값 세팅
    default: function (params) {
        params.set("page", 1);               // 페이지 기본값 set
        params.set("recordSize", 30);        // 레코드 개수 기본값 set
        params.set("pavilionIdx", 0);        // 이용관 기본값 set
        params.set("searchType", "preview"); // 검색 유형 기본값 set
        params.set("searchWord", "");        // 검색어 기본값 set
        params.set("categoryIdx", 0);        // 카테고리 기본값 set
    },
    // 파라미터 변경
    set: function (params, type, data) {

        // page
        if (type == "page") {
            params.set("page", data);
        }

        // recordSize
        if (type == "recordSize") {
            params.set("recordSize", data);
        }

        // pavilionIdx
        if (type == "pavilionIdx") {
            params.set("pavilionIdx", data);
        }

        // searchType
        if (type == "searchType") {
            params.set("searchType", data);
        }

        // searchWord
        if (type == "searchWord") {
            params.set("searchWord", data);
        }

        // categoryIdx
        if (type == "categoryIdx") {
            params.set("categoryIdx", data);
        }
    }
}

/**
 * 카테고리 페이지
 * 파라미터 세팅
 */
let categoryParams = {
    // 파라미터 기본값 세팅
    default: function (categoryIdx, params) {
        params.set("page", 1);                  // 페이지 기본값 set
        params.set("recordSize", 60);           // 레코드 개수 기본값 set
        params.set("categoryIdx", categoryIdx); // 카테고리 기본값 set
        params.set("genreIdx", 0);              // 장르 기본값 set
        params.set("pavilionIdx", 0);           // 이용관 기본값 set
        params.set("period", 1);                // 랭킹 기준 기본값 set
        params.set("complete", 0);              // 완결작 여부 기본값 set
        params.set("monograph", 0);             // 단행본 여부 기본값 set
        params.set("sortType", 1);              // 정렬 기준 기본값 set
    },
    // 파라미터 변경
    set: function (params, type, data) {

        // page
        if (type == "page") {
            params.set("page", data);
        }

        // recordSize
        if (type == "recordSize") {
            params.set("recordSize", data);
        }

        // categoryIdx
        if (type == "categoryIdx") {
            params.set("categoryIdx", data);
        }

        // genreIdx
        if (type == "genreIdx") {
            params.set("genreIdx", data);
        }

        // pavilionIdx
        if (type == "pavilionIdx") {
            params.set("pavilionIdx", data);
        }

        // period
        if (type == "period") {
            params.set("period", data);
        }

        // complete
        if (type == "complete") {
            params.set("complete", data);
        }

        // monograph
        if (type == "monograph") {
            params.set("monograph", data);
        }

        // sortType
        if (type == "sortType") {
            params.set("sortType", data);
        }
    }
}

/**
 * 작품 회차 리스트 페이지
 * 파라미터 세팅
 */
let contentParams = {
    // 파라미터 기본값 세팅
    default: function (params) {
        params.set("page", 1);              // 페이지 기본값 set
        params.set("recordSize", 30);       // 레코드 개수 기본값 set
        params.set("sortType", 1);          // 정렬 기준 기본값 set(1:회차순 / 2:최신순)
        params.set("type", 1);              // API 호출 위치 set
        params.set("searchType", "rent");   // 구매 유형 기본값 set
    },
    // 파라미터 변경
    set: function (params, type, data) {

        // page
        if (type == "page") {
            params.set("page", data);
        }

        // recordSize
        if (type == "recordSize") {
            params.set("recordSize", data);
        }

        // searchType
        if (type == "searchType") {
            params.set("searchType", data);
        }

        // sortType
        if (type == "sortType") {
            params.set("sortType", data);
        }
    }
}

/**
 * 작품 뷰어 페이지
 * 파라미터 세팅
 */
let episodeParams = {
    // 파라미터 기본값 세팅
    default: function (params) {
        params.set("page", 1);              // 페이지 기본값 set
        params.set("recordSize", 500);      // 레코드 개수 기본값 set
        params.set("type", 2);              // API 호출 위치 set
        params.set("searchType", "rent");   // 구매 유형 기본값 set
    },
    // 파라미터 변경
    set: function (params, type, data) {

        // page
        if (type == "page") {
            params.set("page", data);
        }

        // recordSize
        if (type == "recordSize") {
            params.set("recordSize", data);
        }

        // searchType
        if (type == "searchType") {
            params.set("searchType", data);
        }
    }
}

/**
 * 작품 댓글 페이지
 * 파라미터 세팅
 */
let commentParams = {
    // 파라미터 기본값 세팅
    default: function (params) {
        params.set("page", 1);       // 페이지 기본값 set
        params.set("commentCnt", 30);// 댓글 개수 기본값 set
        params.set("replyCnt", 30);  // 대댓글 개수 기본값 set
        params.set("sortType", 1);   // 정렬 기준 기본값 set
    },
    // 파라미터 변경
    set: function (params, type, data) {

        // page
        if (type == "page") {
            params.set("page", data);
        }

        // commentCnt
        if (type == "commentCnt") {
            params.set("commentCnt", data);
        }

        // replyCnt
        if (type == "replyCnt") {
            params.set("replyCnt", data);
        }

        // sortType
        if (type == "sortType") {
            params.set("sortType", data);
        }
    }
}

/**
 * 알림 페이지
 * 파라미터 세팅
 */
let notiParams = {
    // 파라미터 기본값 세팅
    default: function (params) {
        params.set("page", 1);              // 페이지 기본값 set
        params.set("recordSize", 30);       // 레코드 개수 기본값 set
        params.set("notificationIdx", 0);   // 선택한 알림 idx 기본값 set
        params.set("url", "");               // 선택한 알림 url 기본값 set
    },
    // 파라미터 변경
    set: function (params, type, data) {

        // page
        if (type == "page") {
            params.set("page", data);
        }

        // recordSize
        if (type == "recordSize") {
            params.set("recordSize", data);
        }

        // notificationIdx
        if (type == "notificationIdx") {
            params.set("notificationIdx", data);
        }

        // url
        if (type == "url") {
            params.set("url", data);
        }
    }
}

/**
 * 내 꿀단지
 * 파라미터 세팅
 */
let libraryParams = {
    // 파라미터 기본값 세팅
    default: function (params) {
        params.set("page", 1);              // 페이지 기본값 set
        params.set("recordSize", 10);       // 레코드 개수 기본값 set
        params.set("type", 2);              // API 호출 위치 set
        params.set("searchType", 'view');   // 구매 유형 기본값 set
        params.set("searchWord", '');       // 검색어 기본값 set
    },
    // 파라미터 변경
    set: function (params, type, data) {

        // page
        if (type == "page") {
            params.set("page", data);
        }

        // recordSize
        if (type == "recordSize") {
            params.set("recordSize", data);
        }

        // searchType
        if (type == "searchType") {
            params.set("searchType", data);
        }

        // searchType
        if (type == "searchWord") {
            params.set("searchWord", data);
        }
    }
}

/**
 * 선물함 페이지
 * 파라미터 세팅
 */
let giftParams = {
    // 파라미터 기본값 세팅
    default: function (params) {
        params.set("page", 1);            // 페이지 기본값 set
        params.set("recordSize", 30);     // 레코드 개수 기본값 set
        params.set("contentsIdx", 0);     // 작품 idx 기본값 set
    },
    // 파라미터 변경
    set: function (params, type, data) {

        // page
        if (type == "page") {
            params.set("page", data);
        }

        // recordSize
        if (type == "recordSize") {
            params.set("recordSize", data);
        }

        // contentsIdx
        if (type == "contentsIdx") {
            params.set("contentsIdx", data);
        }
    }
}

// 페이지 로딩 후 처리
$(document).ready(function () {
    // Add active state to sidebar nav links
    let path = window.location.href; // because the 'href' property of the DOM element is the absolute path
    $("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function () {
        if (this.href === path) {
            $(this).addClass("active");
        }
    });

    // Toggle the side navigation
    $("#sidebarToggle").on("click", function (e) {
        e.preventDefault();
        $("body").toggleClass("sb-sidenav-toggled");
    });

    // dropdown
    let dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
    dropdownElementList.map(function (dropdownToggleEl) {
        return new bootstrap.Dropdown(dropdownToggleEl)
    });

    //메뉴열때 다른메뉴 닫기
    $(".collapse").on("show.bs.collapse", function (e) {
        //$(".collapse").removeClass('show');
    });

    try {
        //마지막 선택 메뉴 활성화
        let myCollapse = $("input[name=sel_admin_leftmenu]").val();
        $("#" + myCollapse).collapse('show');
    } catch (e) {

    }

    // 체크박스
    $("[type=checkbox][name='idx[]']").on("change", function () {
        let check = $(this).prop("checked");

        //전체 체크
        if ($(this).hasClass("allcheck")) {
            $("[type=checkbox][name='idx[]']").prop("checked", check);

            //단일 체크
        } else {
            let all = $("[type=checkbox][name='idx[]'].allcheck");
            let allcheck = all.prop("checked");

            if (check !== allcheck) {
                let len = $("[type=checkbox][name='idx[]']").not(".allcheck").length;
                let ckLen = $("[type=checkbox][name='idx[]']:checked").not(".allcheck").length;

                if (len === ckLen) {
                    all.prop("checked", true);
                } else {
                    all.prop("checked", false);
                }
            }
        }
    });

    // 입력시 히스토리 이슈로 인해 autocomplete:off 추가
    $(".sel_date")
        .attr("autocomplete", "off")
        .datepicker({
            changeMonth: true,
            changeYear: true,
            showMonthAfterYear: true,
            yearRange: 'c-5:c+5',
            dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'], // 요일의 한글 형식.
            monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            dateFormat: "yy-mm-dd",
            altFormat: "yy-mm-dd",
            showButtonPanel: true,
            nextText: '다음 달',
            prevText: '이전 달',
            currentText: '오늘',
            closeText: '닫기'
        });

    // 에러메시지 있을 경우 toast 띄우고 비우기
    let errorMsg = $("#error_toast");
    errorMsg.on("propertychange change keyup paste input", function() {
        // 현재 변경된 데이터 셋팅
        if (errorMsg.val().trim() !== '') {
            toast.alert(errorMsg.val());
        }
        errorMsg.val('');
    });
    errorMsg.trigger("change");
});

/**
 * 뱃지 이미지
 * ex) <img src="/assets/svgs/kr/badge/badge_comic.svg">
 * @param badgeList
 * @returns {{thumbnailTopLeft: {ranking: string, category: string}, view: string, titleTop: string, bottom: string, wait_free: string, best: string, up: string, title: string, thumbnailTopRight: string, free_ticket: string}}
 */
let badgeSvg = function (badgeList) {
    let src;
    // 썸네일 좌측 상단 - 카테고리
    const categoryBadges = ['comic', 'webtoon', 'novel', 'adult_pavilion'];
    // 썸네일 좌측 상단 - 뱃지
    const rankBadges = ['top', 'only'];
    // const thumbnailTopLeftCode = [...categoryBadges, ...rankBadges];
    // 썸네일 우측 상단 - 19
    const thumbnailTopRightCode = ['adult_19'];
    // 작품 제목
    const titleCode = ['new', 'complete'];
    // 작품 제목 상단
    const titleTopCode = ['original', 'book', 'revised'];
    // 하단
    const bottomCode = ['free', 'discount'];

    let badgeJson = {
        thumbnailTopLeft: {
            category: '',
            ranking: ''
        },
        thumbnailTopRight: '',
        title: '',
        titleTop: '',
        bottom: '',
        up: '',
        view: '',
        freeTicket: '',
        wait_free: '',
        best: '',
    }
    $.each(badgeList, function (key, value) {
        let code = value.code;

        // 썸네일 좌측 상단
        if (categoryBadges.indexOf(code) > -1) {

            switch (code) {
                case 'webtoon':
                    src = '/assets/svgs/kr/badge/badge_webtoon.svg';
                    break;
                case 'comic':
                    src = '/assets/svgs/kr/badge/badge_comic.svg';
                    break;
                case 'novel':
                    src = '/assets/svgs/kr/badge/badge_novel.svg';
                    break;
                case 'adult_pavilion':
                    src = '/assets/svgs/kr/badge/badge_adult_pavilion.svg';
                    break;
                default:
                    src = '';
            }
            if (src !== '') {
                badgeJson.thumbnailTopLeft.category += '<img src="' + src + '" >';
            }
        }
        // 썸네일 좌측 상단
        else if (rankBadges.indexOf(code) > -1) {
            switch (code) {
                case 'top':
                    src = '/assets/svgs/kr/badge/badge_top.svg';
                    break;
                case 'only':
                    src = '/assets/svgs/kr/badge/badge_only.svg';
                    break;
                default:
                    src = '';
            }
            if (src !== '') {
                badgeJson.thumbnailTopLeft.ranking += '<img src="' + src + '" >';
            }
        }
        // 썸네일 우측 상단
        else if (thumbnailTopRightCode.indexOf(code) > -1) {
            switch (code) {
                case 'adult_19':
                    src = '/assets/svgs/kr/badge/badge_adult_19.svg';
                    break;
                default:
                    src = '';
            }
            if (src !== '') {
                badgeJson.thumbnailTopRight += '<img src="' + src + '" >';
            }
        }
        // 작품 제목
        else if (titleCode.indexOf(code) > -1) {
            switch (code) {
                case 'complete':
                    src = '/assets/svgs/kr/badge/badge_complete.svg';
                    break;
                case 'new':
                    src = '/assets/svgs/kr/badge/badge_new.svg';
                    break;
                default:
                    src = '';
            }
            if (src !== '') {
                badgeJson.title += '<img class="d-inline-flex" src="' + src + '" >';
            }
        }
        // 작품 제목 상단
        else if (titleTopCode.indexOf(code) > -1) {
            switch (code) {
                case 'original':
                    src = '/assets/svgs/kr/badge/badge_original.svg';
                    break;
                case 'bok':
                    src = '/assets/svgs/kr/badge/badge_book.svg';
                    break;
                case 'revised':
                    src = '/assets/svgs/kr/badge/badge_revised.svg';
                    break;
                default:
                    src = '';
            }
            if (src !== '') {
                badgeJson.titleTop += '<img class="d-inline-flex" src="' + src + '" >';
            }
        }
        // 하단
        else if (bottomCode.indexOf(code) > -1) {
            switch (code) {
                case 'discount':
                    src = '/assets/svgs/kr/badge/badge_discount.svg';
                    break;
                case 'free':
                    src = '/assets/svgs/kr/badge/badge_free.svg';
                    break;
                default:
                    src = '';
            }
            if (src !== '') {
                badgeJson.bottom += '<img class="d-inline-flex" src="' + src + '" >';
            }
        } else {
            // const etcCode = ['up', 'view', 'free_ticket', 'wait_free', 'best'];
            switch (code) {
                case 'up':
                    src = '/assets/svgs/kr/badge/badge_up.svg';
                    badgeJson.up = '<img class="d-inline-flex" src="' + src + '" >';
                    break;
                case 'view':
                    src = '/assets/svgs/kr/badge/badge_view.svg';
                    badgeJson.view = '<img class="d-inline-flex" src="' + src + '" >';
                    break;
                case 'free_ticket':
                    src = '/assets/svgs/kr/badge/badge_free_ticket.svg';
                    badgeJson.freeTicket = '<img class="d-inline-flex" src="' + src + '" >';
                    break;
                case 'wait_free':
                    src = '';
                    break;
                case 'best':
                    src = '/assets/svgs/kr/badge/badge_best.svg';
                    badgeJson.best = '<img class="d-inline-flex" src="' + src + '" >';
                    break;
                default:
                    src = '';
            }
        }
    })

    return badgeJson;
}

/**
 * APP Bridge
 */
let app = {
    // app 사용 유무
    isAppReady:false,
    // app ID
    getAppId:'',
    // app 버전
    getAppVersion:'',
    // 앱 정보
    getAppInfo:'',
    // 원스토어 전달정보
    get3rdPartyPurchaseInfo:'',
    // ADID
    getADID:'',
    // 알림 토큰
    getFcmToken:'',
    // 알림 권한 여부
    checkAppNotificationPermission:false,
    // app 토스트 메세지
    showToastMessage:function (msg) {
        if(app.isAppReady) {
            window.flutter_inappwebview.callHandler('showToastMessage', msg).then(function(result) {
                return result;
            });
        }
    },
    // 앱 설정 열기
    openAppSetting:function () {
        if(app.isAppReady) {
            window.flutter_inappwebview.callHandler('openAppSetting').then(function(result) {
            });
        }
    }
}
try {
    window.addEventListener("flutterInAppWebViewPlatformReady", function(event) {
        app.isAppReady=true;
        //app.isAppReady=true;
        window.flutter_inappwebview.callHandler('getAdvertisingID').then(function(result) {
            app.getADID = result;
        });
        window.flutter_inappwebview.callHandler('getAppId').then(function(result) {
            app.getAppId = result;
        });
        window.flutter_inappwebview.callHandler('get3rdPartyPurchaseInfo').then(function(result) {
            app.get3rdPartyPurchaseInfo = result;
        });
        window.flutter_inappwebview.callHandler('getAppInfo').then(function(result) {
            app.getAppInfo = JSON.stringify(result);
        });
        window.flutter_inappwebview.callHandler('checkAppNotificationPermission').then(function(result) {
            app.checkAppNotificationPermission = result;
        });
        window.flutter_inappwebview.callHandler('getAppVersion').then(function(result) {
            app.getAppVersion = result;
        });
        window.flutter_inappwebview.callHandler('getAppVersion').then(function(result) {
            app.getAppVersion = result;
        });
        window.flutter_inappwebview.callHandler('getFcmToken').then(function(result) {
            app.getFcmToken = result;
        });
    });

} catch (err) {
    // 에러 핸들링
}

/**
 * 날짜 foramt
 * @type {{contentsDate: (function(*, string=): *)}}
 */
let dateFormat = {
    contentsDate: function (dt, dash = "-") {
        let _thisDate = new Date(dt);
        let _year = _thisDate.getFullYear().toString().padStart(2, "0");
        let _month = (_thisDate.getMonth() + 1).toString().padStart(2, "0");
        let _date = (_thisDate.getDate()).toString().padStart(2, "0");

        return _year + dash + _month + dash + _date;
    },
}

// UTM 쿠키 생성
function setUtmCookie() {
    let utm_names = ['utm_id','utm_source','utm_medium','utm_campaign','utm_term','utm_content'];
    let date = new Date();
    date.setTime(date.getTime() + (30 * 24 * 60 * 60 * 1000));
    let expires = "; expires=" + date.toUTCString();
    for (const name of utm_names) {

        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"), results = regex.exec(location.search), value = '';
        if (results != null) {
            value = decodeURIComponent(results[1].replace(/\+/g, ' '));
            document.cookie = name+'='+value + expires + '; path=/';
        }
    }
}
setUtmCookie();

// 개발자도구 차단
$(document).bind('keydown',function(e){
    if ( e.keyCode === 123 /* F12 */) {
        let origin = $(location).attr('origin');
        if (origin === "https://www.ggultoons.com") { // 실서버 한정
            e.preventDefault();
            e.returnValue = false;
        }
    }
});