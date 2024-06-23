<script>
    $(document).ready(function () {
        // 소설 장르 탭 세팅
        novel.genreList();
    });

    /* 전역 변수 */
    let params = new Map();
    let data = new Map();

    // bottomSheet slide
    let flag = false;

    /* 전역 변수 기본값 세팅 */
    categoryParams.default(3, params);
    if (local.pavilion() != null) {
        categoryParams.set(params, 'pavilionIdx', local.pavilion().state.pavilionIdx);
    }
    scroll.default(data);

    let novel = {
        // 소설 장르 탭 세팅
        genreList: function () {

            // 소설 장르 idx 배열 생성
            var genreArr = new Array();

            // 카테고리 idx set
            let categoryIdx = params.get("categoryIdx");

            $.ajax({
                url: '{ C.API_DOMAIN }/v1/genre?categoryIdx=' + categoryIdx,
                cache: true,
                method: 'GET',
                dataType: 'json',
                processData: false,
                contentType: false,
                xhrFields: {
                    withCredentials: true
                },
                beforeSend: function () {
                    let skeletonWrap = '<div class="skeleton-wrap"></div>'
                    let skeletonBox02 = '<div class="skeleton-box style02"></div>'
                    let skeletonList02 = '<div class="skeleton-list"><div class="img-box"></div><div class="title-box"></div><div class="info-box"></div></div>'
                    $('#mySwiperContainer').append(skeletonWrap);

                    for (let i = 0; i < 4; i++) {
                        let skeletonBox = $(skeletonBox02);
                        for (let j = 0; j < 6; j++) {
                            let skeletonList = $(skeletonList02);
                            skeletonBox.append(skeletonList);
                        }
                        $('#mySwiperContainer .skeleton-wrap').append(skeletonBox);
                    }
                },
                success: function (res) {
                    if (res.result) {

                        // 배열 세팅 : 랭킹 idx
                        genreArr.push(0);

                        // 랭킹 탭 세팅
                        let listBody = `
                                                <div class="swiper-slide">
                                                    <button type="button" id="btn_0" class="btn menu_btn" value="0">랭킹</button>
                                                </div>
                                            `;

                        // 랭킹 슬라이드 세팅
                        let slideBody = `
                                                <div class="swiper-slide">
                                                    <div id="slide_0"></div>
                                                </div>
                                            `;

                        // 검색 필터 바텀 시트 세팅
                        let sheetBody = `
                                            <input type="radio" name="novel_genre" id="genre_all" value="0" checked />
                                            <label for="genre_all">전체</label>
                                        `;

                        if (res.data.list.length > 0) {
                            $.each(res.data.list, function (index, el) {

                                // 배열 세팅 : 장르 idx
                                genreArr.push(el.idx);

                                // 소설 장르 탭 세팅
                                listBody += `
                                                    <div class="swiper-slide">
                                                        <button type="button" id="btn_` + (parseInt(index) + 1) + `" class="btn menu_btn" value="` + el.idx + `" disabled>` + el.name + `</button>
                                                    </div>
                                                `;

                                // 장르별 슬라이드 세팅
                                slideBody += `
                                                    <div class="swiper-slide">
                                                        <div id="slide_` + el.idx + `"></div>
                                                    </div>
                                                `;

                                // 검색 필터 바텀 시트 세팅
                                sheetBody += `
                                                <input type="radio" name="novel_genre" id="genre_`+ el.idx + `" value="` + el.idx + `"/>
                                                <label for="genre_`+ el.idx + `">` + el.name + `</label>
                                            `;

                            });
                            $(".menuSwiper .swiper-wrapper").html(listBody);
                            $(".mySwiper .swiper-wrapper").html(slideBody);
                            $(".genre .wrap").html(sheetBody);
                        }
                        // 기본 세팅
                        importJs.setting();

                        // 소설 배너 리스트 세팅
                        novel.bannerList();

                        // 소설 작품 리스트 세팅
                        novel.contentList();
                    } else {
                        // ajax exception error
                        toast.alert(res.message);
                    }
                },
                error: function (request, status, error) {
                    // filter error
                    //toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
                },
                complete: function () {
                    $('#mySwiperContainer .skeleton-wrap').fadeOut(300, function () { $(this).remove() });
                }
            });
            return false;
        },
        // 소설 배너 리스트 세팅
        bannerList: function () {

            // params value
            let categoryIdx = params.get("categoryIdx");
            let genreIdx = params.get("genreIdx");

            // 메인 배너 리스트
            let data = new Map();
            data.set("categoryIdx", categoryIdx);
            data.set("genreIdx", genreIdx);
            if (mainBanner.swiper != undefined) {
                mainBanner.swiper.destroy();
            }
            mainBanner.setting(data);
        },
        // 소설 랭킹 리스트 세팅
        rankList: function () {

            // params value
            let page = params.get("page");
            let recordSize = params.get("recordSize");
            let categoryIdx = params.get("categoryIdx");
            let genreIdx = params.get("genreIdx");
            let pavilionIdx = setPavilionIdx();
            let period = params.get("period");
            let complete = params.get("complete");
            let monograph = params.get("monograph");

            // 랭킹용 genreIdx set
            let genre = "";
            if (genreIdx != 0) {
                genre = "&genreIdx=" + genreIdx;
            }

            // 바텀 시트 검색 필터 버튼 노출하기
            $(".rank_filter").addClass("active");

            // 정렬 기준 필터 버튼 숨기기
            $(".select_wrap").removeClass("active");

            $.ajax({
                url: '{ C.API_DOMAIN }/v1/contents?page=' + page + '&recordSize=' + recordSize + '&categoryIdx=' + categoryIdx + genre + '&pavilionIdx=' + pavilionIdx + '&period=' + period + '&complete=' + complete + '&monograph=' + monograph,
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

                        let listBody = "";
                        if (res.data.categoryContentsList.length > 0) {

                            $('.no_result_wrap').removeClass('active');

                            // 전체 페이지 개수 세팅
                            scroll.set(data, "totalPageCnt", res.data.params.pagination.totalPageCount);

                            $.each(res.data.categoryContentsList, function (index, el) {
                                let badge = badgeSvg(el.badgeList);

                                // 랭킹 등락 표시
                                let variance = "";
                                if (el.variance == 0) {
                                    variance = `<i class="none active">-</i>`;
                                } else if (el.variance > 0) {
                                    variance = `<i class="up active"></i>`;
                                } else {
                                    variance = `<i class="down active"></i>`;
                                }

                                listBody += `
                                   <a href="javascript:movePage.episode(` + el.contentsIdx + `);">
                                        <figure>
                                            <div class="img_wrap">
                                                <img src="` + el.contentHeightImgList[0].url + `" alt=""  loading="lazy"/>
                                                <div class="badge_wrap">
                                                    <span>${badge.thumbnailTopLeft.ranking.toString()}</span>
                                                    <span class="left_top">${badge.thumbnailTopRight.toString()}</span>
                                                </div>
                                            </div>
                                            <figcaption>
                                                <span class="rank_info">
                                                    <b class="rank_num Text-xs">${el.ranking.toString()}</b>
                                                    <b class="rank_change_info">${variance.toString()}</b>
                                                </span>
                                                <p class="info_title Subtitle-md">
                                                    ${badge.title.toString()}
                                                    <span>${el.title.toString()}</span>
                                                </p>
                                            </figcaption>
                                        </figure>
                                    </a>
                                `;
                            });
                        } else {
                            // 전체 페이지 개수 세팅
                            scroll.set(data, "totalPageCnt", 0);
                        }
                        // 랭킹 영역 세팅
                        if (page == 1) {
                            $(".mySwiper .swiper-wrapper").find("#slide_0").html(listBody);
                        } else {
                            $(".mySwiper .swiper-wrapper").find("#slide_0").append(listBody);
                        }

                        /* 장르 탭 메뉴 스와이프 */
                        if (importJs.menuSwiper != undefined) {
                            importJs.menuSwiper.destroy();
                        }
                        importJs.menuSwiper = new Swiper(".menuSwiper", {
                            spaceBetween: 0,
                            slidesPerView: 'auto',
                            freeMode: true,
                            watchSlidesProgress: true,
                            centeredSlides: false,
                            observer: true,
                            observeParents: true
                        });

                        /*컨텐츠 스와이프*/
                        if (importJs.contentSwiper != undefined) {
                            importJs.contentSwiper.destroy();
                        }
                        importJs.contentSwiper = new Swiper(".mySwiper", {
                            on: {
                                // 초기화 이벤트
                                init: function(){
                                    // 슬라이드 높이 설정
                                    setSlideHeight(this);
                                },
                                // 스와이프 이벤트
                                activeIndexChange: function () {

                                    // 페이지 최상단으로 이동
                                    $('html, body').animate({scrollTop: 0}, '10');

                                    // 결과 없음 이미지 숨김
                                    $('.no_result_wrap').removeClass('active');

                                    // 메뉴 이동
                                    let slider = this;
                                    importJs.menuSwiper.slideTo(slider.activeIndex, 1000, false);

                                    // 화면 사이즈 + 50px
                                    let windowHeight = $(window).height() + 50;
                                    // bottomSheet 위치
                                    let bottomSheetTop = $(".bottom_sheet").position().top;

                                    // 바텀 시트 열려 있을 때 스와이프 시
                                    if (bottomSheetTop <= windowHeight) {
                                        let bottomSheetHeight = document.querySelector('.sheet_wrap').clientHeight;
                                        // 바텀 시트 닫기
                                        bottomSheetSlide(-bottomSheetHeight);

                                        // 필터 화살표 180도 회전
                                        $(".pointer").animate({ rotate: 0 }, 300);
                                    }

                                    // 페이지 초기화
                                    categoryParams.set(params, "page", 1);

                                    // 장르 idx set
                                    categoryParams.set(params, "genreIdx", $("#btn_" + slider.activeIndex).val());

                                    // 배너 및 작품 리스트 호출
                                    reloadList();
                                }
                            },
                            thumbs: {
                                swiper: importJs.menuSwiper
                            },
                            slidesPerView: 1,
                            spaceBetween: 16,
                            centeredSlides: true,
                            observer: true,
                            observeParents: true
                        });

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
        // 소설 작품 리스트 세팅
        contentList: function () {

            // params value
            let page = params.get("page");
            let recordSize = params.get("recordSize");
            let categoryIdx = params.get("categoryIdx");
            let genreIdx = params.get("genreIdx");
            let pavilionIdx = setPavilionIdx();
            let sortType = params.get("sortType");

            // 선택한 장르가 없을 경우 -> 랭킹 리스트 조회
            if (genreIdx == 0) {
                // 랭킹 리스트 조회
                novel.rankList();

                // 선택한 장르가 있을 경우 -> 선택한 장르에 해당하는 작품 리스트 조회
            } else {

                // 검색 필터 버튼 숨기기
                $(".rank_filter").removeClass("active");

                // 정렬 기준 필터 버튼 노출하기
                $(".select_wrap").addClass("active");

                $.ajax({
                    url: '{ C.API_DOMAIN }/v1/contents?page=' + page + '&recordSize=' + recordSize + '&categoryIdx=' + categoryIdx + '&genreIdx=' + genreIdx + '&pavilionIdx=' + pavilionIdx + '&sortType=' + sortType,
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

                            let listBody = "";
                            let slideDiv = "#slide_" + genreIdx;

                            if (res.data.categoryContentsList.length > 0) {

                                // 전체 페이지 개수 세팅
                                scroll.set(data, "totalPageCnt", res.data.params.pagination.totalPageCount);

                                $.each(res.data.categoryContentsList, function (index, el) {
                                    let badge = badgeSvg(el.badgeList);

                                    listBody += `
                                                   <a href="javascript:movePage.episode(` + el.contentsIdx + `);">
                                                        <figure>
                                                            <div class="img_wrap">
                                                                <img src="${el.contentHeightImgList[0].url.toString()}" alt=""  loading="lazy"/>
                                                                <div class="badge_wrap">
                                                                    <span>${badge.thumbnailTopLeft.ranking.toString()}</span>
                                                                    <span class="left_top">${badge.thumbnailTopRight.toString()}</span>
                                                                </div>
                                                            </div>
                                                            <figcaption>
                                                                <p class="info_title Subtitle-md">
                                                                    ${badge.title.toString()}
                                                                    ${el.title.toString()}
                                                                </p>
                                                                <div class="sub_info Text-xs">
                                                                    <span>${el.lastEpisodeNumber.toString()}</span>
                                                                    <b>·</b>
                                                                    <span>${el.writerList[0].name.toString()}</span>
                                                                </div>
                                                                <div>
                                                                    <div class="bottom_img_info">${badge.bottom.toString()}</div>
                                                                </div>
                                                            </figcaption>
                                                        </figure>
                                                    </a>
                                                `;
                                });
                            } else {
                                // 전체 페이지 개수 세팅
                                scroll.set(data, "totalPageCnt", 0);

                                // 결과 없음 노출
                                if ($(".mySwiper .swiper-wrapper").find(slideDiv).is(':empty')) {
                                    $('.no_result_wrap').addClass('active');
                                    let text = `<span class="Text-lg">작품</span>이 없어요`;
                                    noResult.setting("category", text);
                                }
                            }
                            // html set
                            if (page == 1) {
                                $(".mySwiper .swiper-wrapper").find(slideDiv).html(listBody);
                            } else {
                                $(".mySwiper .swiper-wrapper").find(slideDiv).append(listBody);
                            }
                            // 슬라이드 높이 설정
                            setSlideHeight(importJs.contentSwiper);

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

    let importJs = {
        /*기본 세팅*/
        setting: function () {

            /* 이용관 버튼 토글 변경 감지 */
            $(".sub #header_nav li:first").click(function () {

                // 회원 정보 조회
                let memberInfo = local.memberInfo();

                // 비로그인
                if (memberInfo == null) {
                    // 로그인 모달 호출
                    toast.alert("로그인 후 이용해주세요");
                    movePage.login();

                    // 로그인
                } else {
                    // 세션 저장용 param
                    let pavilionIdx;

                    // 성인 회원인 경우
                    if (memberInfo.data.adult == 1) {

                        // 현재 ON 상태인 경우
                        if ($(this).find(".toggle-wrap").hasClass("active")) {
                            $(this).find(".toggle-wrap").removeClass("active");
                            pavilionIdx = 0;

                            // 현재 OFF 상태인 경우
                        } else {
                            $(this).find(".toggle-wrap").addClass("active");
                            pavilionIdx = 1;
                        }

                        // 미성년 회원인 경우
                    } else {

                        // 현재 OFF 상태인 경우
                        if ($(this).find(".toggle-wrap").hasClass("active") == false) {
                            toast.alert("성인인증 후 이용 가능합니다");
                        }
                        pavilionIdx = 0;
                    }
                    // 시청연령 선택 정보 저장
                    localStorage.setItem("pavilion", JSON.stringify({ 'state': { 'pavilionIdx': pavilionIdx }, 'version': 0 }));

                    // 갱신된 파라미터로 카테고리 페이지 재호출
                    if (params.get("genreIdx") == 0) {
                        // 페이지 초기화
                        categoryParams.set(params, "page", 1);
                        // 랭킹 리스트 호출
                        novel.rankList();

                    } else {
                        // 페이지 초기화
                        categoryParams.set(params, "page", 1);
                        // 카테고리 리스트 호출
                        novel.contentList();
                    }

                    // 메인 배너 재호출
                    let data = new Map();
                    data.set("categoryIdx", params.get("categoryIdx"));
                    data.set("genreIdx", params.get("genreIdx"));
                    mainBanner.swiper.destroy();
                    mainBanner.setting(data);
                }
            });

            /*장르탭 메뉴*/
            $(window).scroll(function () {
                $("#menuSwiperContainer").addClass('sticky');

                let scrollTop = $(this).scrollTop(); //스크롤바 수직 위치 가져오기
                if (scrollTop > 25) {
                    $("#menuSwiperContainer").addClass('sticky');

                } else {
                    $("#menuSwiperContainer").removeClass('sticky');
                }
            });

            /*장르탭 메뉴*/
            let lastScrollTop = 0;
            $(window).scroll(function () {

                let scrollTop = $(this).scrollTop(); //스크롤바 수직 위치 가져오기
                if (scrollTop >= 80) {
                    if ((scrollTop > lastScrollTop) && (lastScrollTop > 0)) {
                        $("#menuSwiperContainer").css("top", "-38px");
                    } else {
                        $("#menuSwiperContainer").css("top", "0px");
                    }
                    lastScrollTop = scrollTop;
                }
            })

            /*작품 정렬 필터용 바텀 시트 펼치기 OR 숨기기*/
            $(".rank_filter").click(function () {
                let bottomSheetHeight = document.querySelector('.sheet_wrap').clientHeight;
                let angle = 0;
                // 바텀 시트 펼치기
                if (flag == false) {
                    angle = 180;
                    bottomSheetSlide(0);
                }
                // 바텀 시트 숨기기
                else {
                    bottomSheetSlide(-bottomSheetHeight);
                }

                // 필터 화살표 180도 회전
                $(".pointer").animate({ rotate: angle }, 300);
            });

            /*작품 정렬 필터용 바텀 시트 확인 버튼*/
            $(".sheet_top").find('button').click(function () {
                // 바텀 시트 닫기
                let bottomSheetHeight = document.querySelector('.sheet_wrap').clientHeight;
                bottomSheetSlide(-bottomSheetHeight)

                // 필터 화살표 180도 회전 애니메이션
                $(".pointer").animate({ rotate: 0 }, 300);
            });

            /*바텀 시트 장르 선택값 감지*/
            $("input:radio[name='novel_genre']").change(function () {

                // 장르 idx set
                let genreIdx = $("input[name='novel_genre']:checked").val();
                categoryParams.set(params, "genreIdx", genreIdx);
                categoryParams.set(params, "page", 1);

                // 랭킹 리스트 재호출
                novel.rankList();
            });

            /*바텀 시트 단행본 선택값 감지*/
            $(".paperback").click(function () {

                // 단행본 검색 제외
                if ($(this).hasClass("active")) {
                    $(this).removeClass("active");
                    categoryParams.set(params, "monograph", 0);

                    // 단행본 검색 추가
                } else {
                    $(this).addClass("active");
                    categoryParams.set(params, "monograph", 1);
                }
                categoryParams.set(params, "page", 1);

                // 랭킹 리스트 재호출
                novel.rankList();
            });

            /*바텀 시트 완결작 선택값 감지*/
            $(".completed").click(function () {

                // 완결작 검색 제외
                if ($(this).hasClass("active")) {
                    $(this).removeClass("active");
                    categoryParams.set(params, "complete", 0);

                    // 완결작 검색 추가
                } else {
                    $(this).addClass("active");
                    categoryParams.set(params, "complete", 1);
                }
                categoryParams.set(params, "page", 1);

                // 랭킹 리스트 재호출
                novel.rankList();
            });

            /*바텀 시트 조회 기간 선택값 감지*/
            $("input:radio[name='filter_date']").change(function () {

                // 조회 기간 set
                let period = $("input[name='filter_date']:checked").val();
                categoryParams.set(params, "period", period);
                categoryParams.set(params, "page", 1);

                // 랭킹 리스트 재호출
                novel.rankList();
            });

            /*작품 정렬 필터 펼치기 OR 숨기기*/
            $(".select_wrap").children("button").click(function () {
                $(this).find('svg').toggleClass('active');
                $('.sort_list').toggleClass('active');
            });

            /*작품 정렬 필터 - 랭킹순 정렬*/
            $(".sort_rank").click(function () {

                // 선택값 세팅
                $(".select_wrap").children("button").children("span").html($(this).text());
                $(this).addClass("active");
                $(".sort_new").removeClass("active");
                $(".sort_like").removeClass("active");
                $(".sort_list").toggleClass("active");
                $(this).parent().parent().find("svg").toggleClass("active");

                // 정렬기준 set
                categoryParams.set(params, "sortType", 1);
                categoryParams.set(params, "page", 1);

                // 작품 리스트 재호출
                novel.contentList();
            })

            /*작품 정렬 필터 - 최신순 정렬*/
            $(".sort_new").click(function () {
                if ($(this).hasClass("active") == false) {

                    // 선택값 세팅
                    $(".select_wrap").children("button").children("span").html($(this).text());
                    $(this).addClass("active");
                    $(".sort_rank").removeClass("active");
                    $(".sort_like").removeClass("active");
                    $(".sort_list").toggleClass("active");
                    $(this).parent().parent().find("svg").toggleClass("active");

                    // 정렬기준 set
                    categoryParams.set(params, "sortType", 2);
                    categoryParams.set(params, "page", 1);

                    // 작품 리스트 재호출
                    novel.contentList();
                }
            })

            /*작품 정렬 필터 - 인기순 정렬*/
            $(".sort_like").click(function () {

                // 선택값 세팅
                $(".select_wrap").children("button").children("span").html($(this).text());
                $(this).addClass("active");
                $(".sort_rank").removeClass("active");
                $(".sort_new").removeClass("active");
                $(".sort_list").toggleClass("active");
                $(this).parent().parent().find("svg").toggleClass("active");

                // 정렬기준 set
                categoryParams.set(params, "sortType", 3);
                categoryParams.set(params, "page", 1);

                // 작품 리스트 재호출
                novel.contentList();
            })
        },
        // 메뉴 스와이프
        menuSwiper: null,
        // 컨텐츠 스와이프
        contentSwiper: null
    }

    // bottomSheet 슬라이드
    let bottomSheetSlide = function (bottomSheetHeight) {
        $(".bottom_sheet").animate({
            bottom: bottomSheetHeight
        }, 'fast', function () {
            flag = (bottomSheetHeight >= 0);
        });
    }

    /*스크롤 위치 감지 -> 다음 페이지 호출*/
    let startPoint = 0;
    $(window).scroll(function () {

        // 현재 스크롤 위치
        let current = $(window).scrollTop();

        // 작품 리스트 슬라이드 높이
        let endPoint = $(".mySwiper .swiper-wrapper .swiper-slide-active").height();

        // 현재 메뉴 탭
        let nowMenuTab = params.get("genreIdx");

        // 스크롤 위치 감지
        if (startPoint <= current && current <= endPoint) {

            // 다음 페이지가 있을 경우
            if (params.get("page") < data.get("totalPageCnt")) {

                // 다음 페이지 세팅
                categoryParams.set(params, "page", params.get("page") + 1);

                // 다음 작품 리스트 호출
                if (nowMenuTab == 0) {
                    novel.rankList();
                } else {
                    novel.contentList();
                }

                // 다음 페이지 호출 위치 재설정
                startPoint = endPoint - data.get("maxScroll");
            }
        }
    });

    /* 갱신된 파라미터로 리스트 호출 */
    function reloadList() {

        // page 초기화
        categoryParams.set(params, 'page', 1);
        startPoint = 0;

        // 배너 리스트 호출
        novel.bannerList();

        // 작품 리스트 호출
        novel.contentList();
    }

    /* 스와이퍼 슬라이드 높이 세팅 */
    function setSlideHeight(that){
        $('.mySwiper .swiper-wrapper, .mySwiper .swiper-wrapper .swiper-slide').css({ height: '' });
        let currentSlide = that.activeIndex;
        let newHeight = $(that.slides[currentSlide]).find('div').height() + 50;
        $('.mySwiper .swiper-wrapper, .mySwiper .swiper-wrapper .swiper-slide').css({ height : newHeight });
        that.update();
    }
</script>