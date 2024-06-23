<script>
    $(document).ready(function () {
        // 구매 알림 확인
        memberSetting();
        // 상단 작품 상세 정보
        content.details();
    });

    /* 전역 변수 */
    let contentsIdx = { HTML.IDX };
    let categoryIdx;
    let params = new Map();
    let data = new Map();
    let totalEpisode = new Map();

    /* 전역 변수 기본값 세팅 */
    contentParams.default(params);
    scroll.default(data);

    let content = {
        // 상단 작품 상세 정보
        details: function () {

            $.ajax({
                url: '{ C.API_DOMAIN }/v1/contents/' + contentsIdx,
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
                        if (res.data.contentDetailsList.length > 0) {
                            $.each(res.data.contentDetailsList, function (index, el) {
                                // 카테고리 idx set
                                categoryIdx = el.categoryIdx;

                                // 배너 및 헤더 영역
                                if (el.categoryIdx == 1 || el.categoryIdx == 2) { // 카테고리가 웹툰 또는 만화인 경우

                                    // 노출할 배너 이미지가 있는 경우
                                    if (el.contentWidthImgList.length > 0) {
                                        $("#episode_container").removeClass();
                                        $(".banner").attr("src", el.contentWidthImgList[0].url);
                                    }
                                    // 헤더 세팅
                                    $("#episode_header").removeClass("active");

                                } else { // 카테고리가 소설인 경우
                                    // 헤더 세팅
                                    $("#episode_header").addClass("type_novel");
                                    $("#episode_header").removeClass("active");
                                }

                                // 썸네일 영역
                                let badge = badgeSvg(el.badgeList);
                                if (el.contentHeightImgList.length > 0) { // 노출할 썸네일이 있는 경우
                                    $("#episode_container .episode_wrap .top_badge .left_top").html(badge.thumbnailTopLeft.ranking);
                                    $("#episode_container .episode_wrap .top_badge").append(badge.thumbnailTopRight);
                                    $(".thumbnail").attr("src", el.contentHeightImgList[0].url);
                                }

                                // 제목
                                if (el.title != null) {
                                    $(".title").html(el.title);
                                    $("#episode_header .title").html(el.title);
                                }

                                // 글 작가
                                let writerBody = "";
                                if (el.writerList.length > 0) {
                                    let length = el.writerList.length;
                                    $.each(el.writerList, function (index, el) {
                                        writerBody += `
                                            <b class="search_author">` + el.name + `</b>
                                        `;
                                        if (parseInt(index) < (length - 1)) {
                                            writerBody += `<b>·</b>`;
                                        }
                                    });
                                    $("#writer .writer .title_writer").after(writerBody);

                                } else {
                                    $("#writer .writer").hide();
                                }

                                // 그림 작가
                                let painterBody = "";
                                if (el.painterList.length > 0) {
                                    let length = el.painterList.length;
                                    $.each(el.painterList, function (index, el) {
                                        painterBody += `
                                            <b class="search_author">` + el.name + `</b>
                                        `;
                                        if (parseInt(index) < (length - 1)) {
                                            painterBody += `<b>·</b>`;
                                        }
                                    });
                                    $("#writer .painter .title_painter").after(painterBody);

                                } else {
                                    $("#writer .painter").hide();
                                }

                                // 조회수
                                if (el.view != null) {
                                    $(".view").html(el.view);
                                }

                                // 좋아요 수
                                if (el.favorite != null) {
                                    $(".favorite").html(el.favorite);
                                }

                                // 소개글
                                if (el.description != null) {
                                    $(".description").html(el.description);
                                }

                                // 태그
                                if (el.tagList.length > 0) {
                                    let tagBody = "";
                                    $.each(el.tagList, function (index, el) {

                                        tagBody += `
                                            <span class="Text-sm" onclick="movePage.search('` + el.name + `')">` + el.name + `</span>
                                        `;
                                    });
                                    $(".hashtag_wrap").html(tagBody);
                                }

                                // 작품 보기 버튼
                                content.setViewButton(res.data);

                                // 찜하기 버튼
                                if (el.isMemberLike != undefined) {
                                    $("#like").addClass("active");
                                }

                                // 구매 유형 탭
                                let sellTypeBody = "";
                                if (el.sellType != null) {

                                    if (el.sellType == 1) { // 대여, 소장
                                        contentParams.set(params, "searchType", "rent");

                                        // 대여 & 소장 탭 노출
                                        sellTypeBody = `
                                            <span class="rent active">대여</span>
                                            <span class="have">소장</span>
                                        `;
                                        $(".episode_content .sticky_tab").html(sellTypeBody);

                                        /** 전작품 무료 감상 이벤트 **/
                                        // 이벤트 진행중 + OTT 접속 토큰이 있는 경우
                                        if (EVENT_STATE && checkEventState() && session.ottToken() != null) {
                                            if (el.categoryIdx == 3) {
                                                contentParams.set(params, "searchType", "have");

                                                // 전체 대여 삭제
                                                $("#episode_nav .rent_all").remove();

                                                // 소장 탭만 노출
                                                sellTypeBody = `
                                                    <span class="have active">소장</span>
                                                `;
                                                $(".episode_content .sticky_tab").html(sellTypeBody);
                                            }

                                            // 이벤트 진행중 + 가입 경로가 OTT인 회원의 경우
                                        } else if (EVENT_STATE && checkEventState() && local.memberInfo() != null && local.memberInfo().data.site != "ggultoon") {
                                            if (el.categoryIdx == 3) {
                                                contentParams.set(params, "searchType", "have");

                                                // 전체 대여 삭제
                                                $("#episode_nav .rent_all").remove();

                                                // 소장 탭만 노출
                                                sellTypeBody = `
                                                    <span class="have active">소장</span>
                                                `;
                                                $(".episode_content .sticky_tab").html(sellTypeBody);
                                            }
                                        }

                                    } else if (el.sellType == 2) { // 소장만
                                        contentParams.set(params, "searchType", "have");

                                        // 소장 탭만 노출
                                        sellTypeBody = `
                                            <span class="have active">소장</span>
                                        `;
                                        $(".episode_content .sticky_tab").html(sellTypeBody);

                                        // 전체 대여 삭제
                                        $("#episode_nav .rent_all").remove();

                                    } else if (el.sellType == 3) { // 대여만
                                        contentParams.set(params, "searchType", "rent");

                                        // 대여 탭만 노출
                                        sellTypeBody = `
                                            <span class="rent active">대여</span>
                                        `;
                                        $(".episode_content .sticky_tab").html(sellTypeBody);

                                        // 전체 소장 삭제
                                        $("#episode_nav .have_all").remove();
                                    }
                                }
                                /* 대여/소장 탭 선택값 세팅 */
                                let tab = $(".episode_content .sticky_tab .active").attr('class');
                                if (tab.includes("have")) { // 소장 탭 활성화
                                    localStorage.setItem("sellTypeTab", JSON.stringify({ 'tab': 'have'}));
                                } else { // 대여 탭 활성화
                                    localStorage.setItem("sellTypeTab", JSON.stringify({ 'tab': 'rent'}));
                                }
                            });
                        }
                        // 기본 세팅
                        importJs.setting();

                        // 베스트 댓글 리스트
                        content.commentList();

                        // 회차 리스트
                        content.episodeList();

                    } else {
                        // ajax exception error
                        toast.alert(res.message);
                        setTimeout("movePage.main();", 700);
                    }
                },
                error: function (request, status, error) {
                    // filter error
                    // toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
                }
            });
            return false;
        },
        // 작품 보기 버튼
        setViewButton: function (data) {
            let button = "";
            let episodeIdx = "";

            // 보던 회차가 있을 경우
            if (data.lastViewEpisodeIdx != "" && data.lastViewEpisodeNumber != "") {
                button = `<span>` + data.lastViewEpisodeNumber + ` 이어보기</span>`;
                episodeIdx = data.lastViewEpisodeIdx;
            } else {
                if (data.firstEpisodeFree == true) { // 첫 화가 무료인 경우
                    button = `<span>` + data.firstEpisodeNumber + ` 무료보기</span>`;
                    episodeIdx = data.firstEpisodeIdx;

                } else { // 첫 화가 유료인 경우
                    button = `<span>` + data.firstEpisodeNumber + ` 보기</span>`;
                    episodeIdx = data.firstEpisodeIdx;
                }
            }
            $("#continue").val(episodeIdx).html(button);

        },
        // 베스트 댓글 리스트
        commentList: function () {

            $.ajax({
                url: '{ C.API_DOMAIN }/v1/contents/' + contentsIdx + '/comments/preview',
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
                        if (res.data.contentCommentList.length > 0) {

                            let commentBody = "";
                            $.each(res.data.contentCommentList, function (index, el) {

                                commentBody += `
                                <div class="reple_item swiper-slide">
                                    <p class="reple_top">
                                          <svg width="25" height="18" viewBox="0 0 25 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect y="0.5" width="25" height="17" rx="3" fill="#FC324B" />
                                            <path
                                              d="M10.507 12.958V4.507H11.875V12.958H10.507ZM7.978 7.522H8.671V4.633H9.985V12.742H8.671V8.8H7.978V11.644H4.459V4.948H5.719V7.063H6.718V4.948H7.978V7.522ZM5.719 8.314V10.384H6.718V8.314H5.719ZM18.2982 6.469H19.4592V7.522H13.1412V6.469H14.3022V5.641H13.1412V4.597H19.4592V5.641H18.2982V6.469ZM16.9392 5.641H15.6612V6.469H16.9392V5.641ZM12.3042 8.989V7.9H20.2962V8.989H12.3042ZM19.4142 11.617H14.5902V12.004H19.6392V13.003H13.1862V10.672H18.0102V10.303H13.1412V9.34H19.4142V11.617Z"
                                              fill="white" />
                                          </svg>
                                          <span class="user_id Text-sm">` + el.writerNick + `</span>
                                          <span class="reple_date Text-xs">` + el.regdate + `</span>
                                    </p>
                                    <p class="reple_content Text-md">` + el.content + `</p>
                                    <p class="like_wrap">
                                          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M16.58 8.88H14.79L15.14 8C15.14 8 15.16 7.95 15.17 7.92C15.33 7.32 15.15 6.64 14.65 6.23L13.56 5.34C12.84 4.74 11.81 4.96 11.33 5.72L8.25 10.11C8.18 10.21 8.13 10.32 8.12 10.44H6.53C5.68 10.44 5 11.12 5 11.97V17.41C5 18.25 5.68 18.94 6.53 18.94H8.08C8.48 18.94 8.84 18.79 9.11 18.54C9.48 18.79 9.93 18.94 10.41 18.94H15.06C15.73 18.94 16.25 18.65 16.62 18.22C16.98 17.82 17.19 17.32 17.33 16.85L18.87 11.63C18.88 11.62 18.88 11.6 18.88 11.59C19.22 10.21 18.15 8.88 16.58 8.88ZM8.11 16.63V17.41C8.11 17.41 8.11 17.44 8.08 17.44H6.53C6.53 17.44 6.5 17.43 6.5 17.41V11.97C6.5 11.97 6.51 11.94 6.53 11.94H8.08C8.08 11.94 8.11 11.95 8.11 11.97V16.63ZM15.89 16.42C15.78 16.8 15.64 17.07 15.5 17.23C15.37 17.37 15.25 17.44 15.06 17.44H10.41C9.98 17.44 9.61 17.08 9.61 16.64V11.97V10.78L12.58 6.56C12.58 6.56 12.6 6.53 12.61 6.51H12.62L13.7 7.39C13.7 7.39 13.71 7.41 13.72 7.43C13.73 7.45 13.73 7.47 13.73 7.5L12.99 9.36C12.89 9.59 12.92 9.85 13.06 10.05C13.2 10.26 13.43 10.38 13.68 10.38H16.58C17.26 10.38 17.5 10.86 17.43 11.22L15.89 16.42Z"
                                              fill="#999999" />
                                          </svg>
                                          <span class="Text-sm">` + el.likeCnt + `</span>
                                    </p>
                              </div>
                            `;
                            });
                            $(".swiper .swiper-wrapper").html(commentBody);

                        } else {
                            // 베스트 댓글이 없다면 해당 영역 숨기기
                            $(".reple_wrap").hide();
                        }
                    } else {
                        // ajax exception error
                        toast.alert(res.message);
                    }
                },
                error: function (request, status, error) {
                    // filter error
                    // toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
                }
            });
            return false;
        },
        // 회차 리스트
        episodeList: function () {
            // params value
            let page = params.get("page");
            let recordSize = params.get("recordSize");
            let searchType = params.get("searchType");
            let sortType = params.get("sortType");
            let type = params.get("type");

            $.ajax({
                url: '{ C.API_DOMAIN }/v1/contents/' + contentsIdx + '/episodes?page=' + page + '&recordSize=' + recordSize + '&searchType=' + searchType + '&sortType=' + sortType + '&type=' + type,
                cache: true,
                method: 'GET',
                dataType: 'json',
                processData: false,
                contentType: false,
                xhrFields: {
                    withCredentials: true
                },
                beforeSend: function () {
                    let skeletonBox03 = '<li class="skeleton-box style03"></li>';
                    let skeletonList03 = '<div class="skeleton-list"><div class="img-box"></div><div class="title-box"></div><div class="info-box"></div></div>';

                    for (let i = 0; i < 10; i++) {
                        $('.content_list').append(skeletonBox03);
                        $('.content_list .skeleton-box').append(skeletonList03);
                    }
                },
                success: function (res) {
                    if (res.result) {
                        let episodeCnt = "";
                        let episodeBody = "";
                        if (res.data.contentEpisodeList.length > 0) {

                            // 전체 페이지 개수 세팅
                            scroll.set(data, "totalPageCnt", res.data.params.pagination.totalPageCount);

                            // 전체 회차 개수
                            episodeCnt = `
                                <span>전체</span>
                                <span>`+ res.data.params.pagination.totalRecordCount + `</span>
                            `;
                            $(".content_top_wrap .content_count").html(episodeCnt);

                            // 회차 리스트
                            $.each(res.data.contentEpisodeList, function (index, el) {
                                let badge = badgeSvg(el.badgeList);

                                // 회차 발행일 set
                                let pubdate = content.setEpisodePubdate(el);

                                // 회차 상태 정보 set
                                let info = content.setEpisodeInfo(el);

                                // 최종화일 경우 회차 제목 set
                                let title = el.title;
                                if (el.lastEpisodeText != undefined) {
                                    title = title + " - " + el.lastEpisodeText;
                                }

                                episodeBody += `
                                    <li value="`+ el.idx + `">
                                        <div class="img_wrap">
                                            <img src="`+ el.episodeWidthImgList[0].url + `" alt="">
                                        </div>
                                        <div class="list_info">
                                            <p class="episode_title Text-md">
                                                <span>`+ title + `</span>
                                                ` + badge.view + badge.freeTicket + `
                                            </p>
                                            <span class="episode_date Text-xs">`+ pubdate + `</span>
                                        </div>
                                        <div class="episode_btn">`+ info + `</div>
                                    </li>
                                `;
                            });
                        } else {
                            // 전체 페이지 개수 세팅
                            scroll.set(data, "totalPageCnt", 0);
                        }

                        // html set
                        if (page == 1) {
                            $(".content_list").html(episodeBody);
                        } else {
                            $(".content_list").append(episodeBody);
                        }
                    } else {
                        // ajax exception error
                        toast.alert(res.message);
                    }
                },
                error: function (request, status, error) {
                    // filter error
                    // toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
                },
                complete: function () {
                    $('.content_list .skeleton-box').fadeOut(200, function () { $(this).remove() });
                }
            });
            return false;
        },
        // 회차 발행일 세팅
        setEpisodePubdate: function (el) {

            let pubdate = "";
            if (el.pubdate != null) {

                const year = el.pubdate.slice(2, 4);
                const month = el.pubdate.slice(5, 7);
                const day = el.pubdate.slice(8, 10);

                let dateArr = new Array();
                dateArr.push(year);
                dateArr.push(month);
                dateArr.push(day);

                pubdate = dateArr.join(".");
            }
            return pubdate;
        },
        // 회차 정보 세팅
        setEpisodeInfo: function (el) {

            // API 데이터 key 배열
            let dataArr = Object.keys(el);

            // 회차 상태 set
            let info = "";
            if (dataArr.includes("isMemberRent")) { // 대여중
                info = `<button class="rent Text-xs active">` + el.convertExpireDate + `</button>`;

            } else if (dataArr.includes("isMemberHave")) { // 소장중
                info = `<button class="have Text-xs active">소장</button>`;

            } else if (dataArr.includes("isEpisodeFree")) { // 무료
                info = `<button class="free Text-xs active">무료</button>`;

            } else if (dataArr.includes("isEpisodeEventFree")) { // 이벤트 무료
                let coin = "";
                if (params.get("searchType") == "rent") {
                    coin = el.coinRent + "꿀";
                    info = `<button class="discount Text-xs active"><del>` + coin + `</del><b>무료</b></button>`;

                } else if (params.get("searchType") == "have") {
                    coin = el.coin + "꿀";
                    info = `<button class="discount Text-xs active"><del>` + coin + `</del><b>무료</b></button>`;
                }

            }  else if (dataArr.includes("isEpisodeTicketFree")) { // 이용권 무료
                let coin = "";
                if (params.get("searchType") == "rent") {
                    coin = el.coinRent + "꿀";
                    info = `<button class="discount Text-xs active"><del>` + coin + `</del><b>무료</b></button>`;

                } else if (params.get("searchType") == "have") {
                    coin = el.coin + "꿀";
                    info = `<button class="discount Text-xs active"><del>` + coin + `</del><b>무료</b></button>`;
                }

            } else if (dataArr.includes("isEpisodeEventDiscount")) { // 이벤트 할인
                let coin = "";
                let discount = "";
                if (params.get("searchType") == "rent") {
                    coin = el.coinRent + "꿀";
                    discount = el.eventCoinRent + "꿀";
                    if (coin == discount) {
                        info = `<button class="coin Text-xs active">` + coin + `</button>`;
                    } else {
                        info = `<button class="discount Text-xs active"><del>` + coin + `</del><b>` + discount + `</b></button>`;
                    }
                } else if (params.get("searchType") == "have") {
                    coin = el.coin + "꿀";
                    discount = el.eventCoin + "꿀";

                    if (coin == discount) {
                        info = `<button class="coin Text-xs active">` + coin + `</button>`;
                    } else {
                        info = `<button class="discount Text-xs active"><del>` + coin + `</del><b>` + discount + `</b></button>`;
                    }
                }

            } else { // 일반
                let coin = "";
                if (params.get("searchType") == "rent") {
                    coin = el.coinRent + "꿀";
                    info = `<button class="coin Text-xs active">` + coin + `</button>`;

                } else if (params.get("searchType") == "have") {
                    coin = el.coin + "꿀";
                    info = `<button class="coin Text-xs active">` + coin + `</button>`;
                }
            }
            return info;
        },
        // 작품 찜하기
        favorite: function () {

            $.ajax({
                url: '{ C.API_DOMAIN }/v1/contents/' + contentsIdx + '/favorite',
                cache: true,
                method: 'POST',
                dataType: 'json',
                processData: false,
                contentType: false,
                xhrFields: {
                    withCredentials: true
                },
                success: function (res) {
                    if (res.result) {
                        let favoriteSelector = $('.view_count .favorite');
                        let favoriteCount = Number(favoriteSelector.text());
                        favoriteSelector.html(favoriteCount + 1);

                        toast.alert(res.message);
                    } else {
                        // ajax exception error
                        toast.alert(res.message);
                    }
                },
                error: function (request, status, error) {
                    // filter error
                    //toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
                }
            });
            return false;
        },
        // 작품 찜하기 취소
        cancel: function () {

            $.ajax({
                url: '{ C.API_DOMAIN }/v1/contents/' + contentsIdx + '/favorite',
                cache: true,
                method: 'DELETE',
                dataType: 'json',
                processData: false,
                contentType: false,
                xhrFields: {
                    withCredentials: true
                },
                success: function (res) {
                    if (res.result) {
                        let favoriteSelector = $('.view_count .favorite');
                        let favoriteCount = Number(favoriteSelector.text());
                        favoriteSelector.html(favoriteCount - 1);
                        toast.alert(res.message);
                    } else {
                        // ajax exception error
                        toast.alert(res.message);
                    }
                },
                error: function (request, status, error) {
                    // filter error
                    //toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
                }
            });
            return false;
        },
        // 작품 신고하기
        report: function () {

            $.ajax({
                url: '{ C.API_DOMAIN }/v1/contents/' + contentsIdx + '/report',
                cache: true,
                method: 'POST',
                dataType: 'json',
                processData: false,
                contentType: false,
                xhrFields: {
                    withCredentials: true
                },
                success: function (res) {
                    if (res.result) {
                        toast.alert(res.message);
                    } else {
                        // ajax exception error
                        toast.alert(res.message);
                    }
                },
                error: function (request, status, error) {
                    // filter error
                    //toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
                }
            });
            return false;
        },
        // 닉네임 사용 가능 여부 체크
        checkNick: function (input) {

            $.ajax({
                url: '{ C.API_DOMAIN }/v1/member/nick/check?nick=' + input,
                cache: true,
                method: 'GET',
                dataType: 'json',
                processData: false,
                contentType: false,
                xhrFields: {
                    withCredentials: true
                },
                success: function (res) {

                    // 성공 시 결과 메세지 세팅
                    if (res.result) {
                        $(".notice .fail").removeClass("active");
                        $(".notice .success").addClass("active");
                        $(".notice .success").html("멋진 닉네임이네요!");
                        $("#submit").attr("disabled", false);

                        // 실패 시 결과 메세지 세팅
                    } else {
                        $(".notice .success").removeClass("active");
                        $(".notice .fail").addClass("active");
                        $(".notice .fail").html(res.message);
                        $("#submit").attr("disabled", true);
                    }
                },
                error: function (request, status, error) {
                    // filter error
                    //toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
                }
            });
            return false;
        },
        // 닉네임 등록
        registerNick: function (input) {
            // send data set
            let obj = { nick: input };
            let data = JSON.stringify(obj);

            $.ajax({
                url: '{ C.API_DOMAIN }/v1/member/nick',
                cache: true,
                method: 'PUT',
                data: data,
                dataType: 'json',
                processData: false,
                contentType: 'application/json',
                xhrFields: {
                    withCredentials: true
                },
                success: function (res) {
                    if (res.result) {
                        // 로컬 스토리지 회원 닉네임 변경
                        let memberInfo = local.memberInfo();
                        memberInfo.data.nick = input;
                        localStorage.setItem("memberInfo", JSON.stringify(memberInfo));

                        // 댓글 페이지로 이동
                        movePage.contentComment(contentsIdx);
                    } else {
                        // ajax exception error
                        toast.alert(res.message);
                    }
                },
                error: function (request, status, error) {
                    // filter error
                    // toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
                }
            });
            return false;
        }
    }

    let importJs = {
        /*기본 세팅*/
        setting: function () {
            /*베스트 댓글 스와이프*/
            let bestCommentSwiper = new Swiper('.reple_wrap', {
                direction: 'horizontal',
                loop: false,
                slidesPerView: 'auto',
                spaceBetween: 6,
                freeMode: true,
                loopAdditionalSlides: 1,
                slidesOffsetAfter: 60,
                observer: true,
                observeParents: true
            });

            /*뒤로 가기*/
            $("#episode_header").find(".episode_back").click(function () {
                // 이전 페이지가 있는 경우
                let currentDomain = '{ C.CNF_DOMAIN }';
                if (document.referrer.includes(currentDomain)) {
                    history.back();

                    // 외부 페이지에서 바로 접근한 경우
                } else {
                    movePage.main();
                }
            })

            /*점 3개(...) 메뉴 펼치기 & 숨기기*/
            $("#episode_header").find(".right_menu").find("button").click(function () {
                if ($(this).parent().children(".dot_wrap").hasClass("active") == false) {
                    $(".dot_wrap").addClass("active");
                } else {
                    $(".dot_wrap").removeClass("active");
                }
            })

            /*작가 검색 버튼 클릭 이벤트*/
            $("#writer .writer, #writer .painter").click(function () {
                // 검색 페이지로 이동
                let keyword = $(this).find(".search_author").html();
                movePage.search(keyword);
            })

            /*찜하기 버튼 클릭 이벤트*/
            $("#like, #right_menu_like").click(function () {
                // 회원 정보 조회
                if (local.memberInfo() == null) { // 비로그인
                    toast.alert("로그인 후 이용해주세요");
                    movePage.login();

                } else { // 로그인
                    if ($("#like").hasClass("active")) { // 찜하기 취소
                        $("#like").removeClass("active");
                        content.cancel();
                    } else { // 찜하기
                        $("#like").addClass("active");
                        content.favorite();
                    }
                }
                // 메뉴 닫기
                if ($(".dot_wrap").hasClass("active")) {
                    $(".dot_wrap").removeClass("active");
                }
            })

            /*신고하기 버튼 클릭 이벤트*/
            $("#right_menu_report").click(function () {
                // 회원 정보 조회
                if (local.memberInfo() == null) { // 비로그인
                    toast.alert("로그인 후 이용해주세요");
                    movePage.login();

                } else { // 로그인
                    content.report();
                }

                // 메뉴 닫기
                if ($(".dot_wrap").hasClass("active")) {
                    $(".dot_wrap").removeClass("active");
                }
            })

            /*구매 유형 탭 클릭 이벤트*/
            $(".sticky_tab .rent").click(function () { // 대여 탭
                if ($(".sticky_tab .rent").hasClass("active") == false) {
                    // html set
                    $(".sticky_tab .rent").addClass("active");
                    $(".sticky_tab .have").removeClass("active");

                    // 대여 회차리스트 호출
                    contentParams.set(params, "searchType", "rent");
                    contentParams.set(params, "page", 1);
                    startPoint = 0;
                    content.episodeList();

                    // 대여 탭 선택값 세팅
                    localStorage.setItem("sellTypeTab", JSON.stringify({ 'tab': 'rent' }));
                }
            })

            $(".sticky_tab .have").click(function () { // 소장 탭
                if ($(".sticky_tab .have").hasClass("active") == false) {
                    // html set
                    $(".sticky_tab .have").addClass("active");
                    $(".sticky_tab .rent").removeClass("active");

                    // 소장 회차리스트 호출
                    contentParams.set(params, "searchType", "have");
                    contentParams.set(params, "page", 1);
                    startPoint = 0;
                    content.episodeList();

                    // 소장 탭 선택값 세팅
                    localStorage.setItem("sellTypeTab", JSON.stringify({ 'tab': 'have' }));
                }
            })

            /*댓글 더보기 페이지로 이동*/
            let show = false;
            $(".all_reple").click(function () {
                // 회원 정보 조회
                let memberInfo = local.memberInfo();

                // 비로그인
                if (memberInfo == null) {
                    toast.alert("로그인 후 이용해주세요");
                    movePage.login();

                }
                // 로그인
                else {
                    // 닉네임 체크
                    if (memberInfo.data.nick == "") { // 닉네임 없음
                        if (show == false) {
                            $("#nickname_sheet_container").animate({ bottom: 0 }, 'fast');
                            show = true;
                        } else {
                            $("#nickname_sheet_container").animate({ bottom: -300 }, 'fast');
                            show = false;
                        }
                    } else { // 닉네임 있음
                        movePage.contentComment(contentsIdx); // 댓글 페이지로 이동
                    }
                }
            })

            /*닉네임 입력*/
            $(".nickname_wrap").children('input').on('keyup keydown', function (e) {
                // 입력받은 닉네임
                let nick = $(this).val().replace(/ /g, "");

                // 입력값이 비어 있을 경우
                if (nick == "") {
                    $(".notice .success").removeClass("active");
                    $(".notice .fail").removeClass("active");
                    $("#submit").removeClass("active");

                    // 글자수 초과한 경우
                } else if (nick.length > 12) {
                    $(".nickname_wrap").children('input').val(nick.substring(0, 11));
                } else {
                    // 닉네임 사용 여부 체크
                    content.checkNick(nick);
                }
            })

            /*닉네임 등록*/
            $("#submit").click(function () {
                // 입력받은 닉네임
                let nick = $(".nickname_wrap").children('input').val().replace(/ /g, "");

                // 닉네임 저장
                content.registerNick(nick);
            })
        }
    }


    // 회차 이어보기, 회차 선택
    $(document).on('click', '#continue, .content_list li', function () {
        let episodeIdx = $(this).val();
        episodeInfoCheck(contentsIdx, episodeIdx, params.get('searchType'));
    })


    /*스크롤 위치 감지 -> 다음 페이지 호출*/
    let lastScroll = 0;
    let startPoint = 0;
    let showCuration = false;
    $(window).scroll(function () {
        // 현재 스크롤 위치
        let current = $(window).scrollTop();

        /*전체 대여 & 전체 소장 버튼 노출*/
        if (current > lastScroll) { // scroll down
            $("#episode_nav").fadeIn();

        } else { // scroll up
            $("#episode_nav").fadeOut();
        }
        lastScroll = current;

        /*회차리스트 헤더 노출*/
        let headerPoint = $(".episode_wrap").offset().top; // 헤더 노출 기준 높이
        // 작품 제목을 가리는 시점이 왔을 때
        if (current > headerPoint) {
            // 헤더 노출하기
            $("#episode_header").addClass("active");
        } else {
            // 헤더 숨기기
            $("#episode_header").removeClass("active");
        }

        /*다음 페이지 회차리스트 호출*/
        let endPoint = $(".content_list").height(); // 회차 리스트 영역 높이

        // 스크롤 위치 감지
        if (startPoint <= current && current >= (endPoint - $(window).height())) {
            // 다음 페이지가 있을 경우
            if (params.get("page") < data.get("totalPageCnt")) {
                // 다음 페이지 세팅
                contentParams.set(params, "page", params.get("page") + 1);
                // 다음 회차 리스트 호출
                content.episodeList();
                // 다음 페이지 호출 위치 재설정
                startPoint = endPoint - data.get("maxScroll");

            } else {

                // 큐레이션 호출
                if (!showCuration) {
                    curation.setting(4);
                    showCuration = true;
                }
            }
        }
    });

    // 회차 정렬 - sortType (1:회차순, 2:최신순)
    $('.filter_wrap>button').click(function () {
        if (!$(this).hasClass('active')) {
            $('.filter_wrap>button').removeClass('active');
            $(this).addClass('active');
            contentParams.set(params, "page", 1);
            startPoint = 0;
            if ($(this).attr('id').indexOf('new') != -1) {
                // 최신순
                contentParams.set(params, "sortType", 2);
            } else {
                // 회차순
                contentParams.set(params, "sortType", 1);
            }
            content.episodeList();
        }
    })

    // 전체 구매 버튼
    $("#episode_nav button").click(function () {
        let type = 'rent';
        if ($(this).hasClass('have_all')) {
            type = 'have';
        }

        // 회원 정보 조회
        if (local.memberInfo() == null) { // 비로그인
            toast.alert("로그인 후 이용해주세요");
            movePage.login();
            return false;
        }

        // 회차 정보
        $.ajax({
            url: '{ C.API_DOMAIN }/v1/purchase/contents/' + contentsIdx + '/' + type,
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
                    let params = new Map();
                    let title;
                    let detail;
                    if (type == 'rent') {
                        let totalEpisodeInfo = res.data;
                        totalEpisode.set('totalEpisodeInfo', totalEpisodeInfo);
                        title = '전체 ' + totalEpisodeInfo.totalNumber + ' 중 총 ' + totalEpisodeInfo.rentNumber + '을(를) 대여 할게요.';
                        detail = '전체 대여 시 <span class="text-yellow">' + totalEpisodeInfo.rentCoin + '꿀</span>';

                        // 전체 대여 할인
                        if (totalEpisodeInfo.isDiscount) {
                            detail = '전체 대여 시 할인 혜택<br>' +
                                '<svg xmlns="http://www.w3.org/2000/svg" width="10" height="13" fill="none"><path fill="#FC324B" d="m5 11.438-.53.53a.75.75 0 0 0 1.06 0l-.53-.53Zm.75-9.876a.75.75 0 1 0-1.5 0h1.5ZM.47 7.968l4 4 1.06-1.06-4-4-1.06 1.06Zm5.06 4 4-4-1.06-1.06-4 4 1.06 1.06Zm.22-.53V1.562h-1.5v9.876h1.5Z"></path></svg>' +
                                '<span>' + totalEpisodeInfo.discountPercent + '%</span> ' +
                                '<del>' + totalEpisodeInfo.rentCoin + '꿀</del> ' +
                                '<span class="text-yellow">' + totalEpisodeInfo.discountPrice + '꿀</span>';
                        }
                        params.set("isFreeEpisode", false);
                    } else {
                        let totalEpisodeInfo = res.data.nonFreeInfo;
                        let totalEpisodeFreeInfo = res.data.freeInfo;
                        totalEpisode.set('totalEpisodeInfo', totalEpisodeInfo);
                        totalEpisode.set('totalEpisodeFreeInfo', totalEpisodeFreeInfo);
                        title = '전체 ' + totalEpisodeInfo.totalEpisodeCnt + ' 중 총 ' + totalEpisodeInfo.haveCnt + '을(를) 소장 할게요.';
                        detail = '전체 소장 시 <span class="text-yellow">' + totalEpisodeInfo.totalHaveCoin + '꿀</span>';
                        // 전체 대여 할인(defalut - 체크 안됨)
                        if (totalEpisodeInfo.hasDiscount) {
                            detail = '전체 소장 시 할인 혜택<br>' +
                                '<svg xmlns="http://www.w3.org/2000/svg" width="10" height="13" fill="none"><path fill="#FC324B" d="m5 11.438-.53.53a.75.75 0 0 0 1.06 0l-.53-.53Zm.75-9.876a.75.75 0 1 0-1.5 0h1.5ZM.47 7.968l4 4 1.06-1.06-4-4-1.06 1.06Zm5.06 4 4-4-1.06-1.06-4 4 1.06 1.06Zm.22-.53V1.562h-1.5v9.876h1.5Z"></path></svg>' +
                                '<span>' + totalEpisodeInfo.disCountPercent + '%</span> ' +
                                '<del>' + totalEpisodeInfo.totalHaveCoin + '꿀</del> ' +
                                '<span class="text-yellow">' + totalEpisodeInfo.disCountHaveCoin + '꿀</span>';
                        }

                        // 무료 회차 포함 여부
                        params.set("includeFree", false);
                        // 무료 회차 포함 체크박스 display
                        params.set("isFreeEpisode", true);

                        // 무료 회차 포함 버튼
                        $("#modalPurchaseTotal .modal-body p.modal-title").html(title);
                        $("#modalPurchaseTotal .modal-body p.modal-detail").html(detail);
                    }

                    // set params
                    params.set("title", title);
                    params.set("detail", detail);
                    params.set("type", type);

                    gModal.purchaseTotal(params, episodePurchaseTotal);

                } else {
                    toast.alert(res.message);
                }
            },
            error: function (request, status, error) {
                // filter error
                toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
            }
        });
        return false;
    })

    // 전체 소장 - 무료 회차 포함 체크 박스
    $(document).on('click', '#isFreeEpisode', function () {
        let title;
        let detail;
        let totalEpisodeInfo;
        if ($("#isFreeEpisode").is(":checked")) {
            totalEpisodeInfo = totalEpisode.get('totalEpisodeFreeInfo');

            params.set("includeFree", false);
        } else {
            totalEpisodeInfo = totalEpisode.get('totalEpisodeInfo');

            params.set("includeFree", true);
        }

        title = '전체 ' + totalEpisodeInfo.totalEpisodeCnt + ' 중 총 ' + totalEpisodeInfo.haveCnt + '을(를) 소장 할게요.';
        detail = '전체 소장 시 <span class="text-yellow">' + totalEpisodeInfo.totalHaveCoin + '꿀</span>'
        // 전체 대여 할인
        if (totalEpisodeInfo.hasDiscount) {
            detail = '전체 소장 시 할인 혜택<br>' +
                '<svg xmlns="http://www.w3.org/2000/svg" width="10" height="13" fill="none"><path fill="#FC324B" d="m5 11.438-.53.53a.75.75 0 0 0 1.06 0l-.53-.53Zm.75-9.876a.75.75 0 1 0-1.5 0h1.5ZM.47 7.968l4 4 1.06-1.06-4-4-1.06 1.06Zm5.06 4 4-4-1.06-1.06-4 4 1.06 1.06Zm.22-.53V1.562h-1.5v9.876h1.5Z"></path></svg>' +
                '<span>' + totalEpisodeInfo.disCountPercent + '%</span> ' +
                '<del>' + totalEpisodeInfo.totalHaveCoin + '꿀</del> ' +
                '<span class="text-yellow">' + totalEpisodeInfo.disCountHaveCoin + '꿀</span>';
        }

        $("#modalPurchaseTotal .modal-body p.modal-title").html(title);
        $("#modalPurchaseTotal .modal-body p.modal-detail").html(detail);
    })


</script>