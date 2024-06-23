<script>
    $(document).ready(function () {

        /** 꿀툰 서비스 종료 -> 긴급 공지사항 안내 모달 노출 **/
        // 서비스 종료 공지 모달 호출
        gModal.showNotice();

        // 배너 리스트
        main.bannerList();

        // 큐레이션 리스트
        curation.setting(1);
    });

    /* 전역 변수 */
    let params = new Map();

    /* 전역 변수 기본값 세팅 */
    mainParams.default(params);
    if (local.pavilion() != null) {
        let pavilionIdx = setPavilionIdx();
        mainParams.set(params, 'pavilionIdx', pavilionIdx);
    }

    let libraryListData = {};

    let main = {
        // 배너 리스트
        bannerList: function () {

            let data = new Map();

            // 메인 배너 세팅
            data.set("type", 1);
            mainBanner.setting(data);

            // 서브 배너 세팅
            data.set("type", 2);
            subBanner.setting(data);

            // 내가 보던 꿀작 리스트
            main.myLibraryList();

            // 최신작 리스트
            main.newList();

            // 랭킹 리스트
            main.rankList();
        },
        // 내가 보던 꿀작 리스트
        myLibraryList: function () {

            // 비로그인
            if (local.memberInfo() == null) {
                $(".myLib").hide(); // 영역 숨기기

                // 로그인
            } else {

                // params value
                let page = params.get("page");
                let recordSize = params.get("recordSize");
                let searchType = params.get("searchType");

                $.ajax({
                    url: '{ C.API_DOMAIN }/v1/member/library?page=' + page + '&recordSize=' + recordSize + '&searchType=' + searchType,
                    cache: true,
                    method: 'GET',
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    xhrFields: {
                        withCredentials: true
                    },
                    beforeSend: function () {
                        let skeletonBox = '<div class="skeleton-box style01"></div>'
                        let skeletonList = '<div class="skeleton-list"><div class="img-box"></div><div class="title-box"></div><div class="info-box"></div></div>'

                        $('.tab_container.recent').append(skeletonBox);
                        for (let i = 0; i < 7; i++) {
                            $('.tab_container.recent .skeleton-box').append(skeletonList);
                        }
                    },
                    success: function (res) {
                        if (res.result) {

                            let listBody = "";
                            if (res.data.list.length > 0) {

                                $.each(res.data.list, function (index, el) {
                                    libraryListData[index] = el;

                                    let badge = badgeSvg(el.badgeList);

                                    let bottomSheetData = {
                                        contentsIdx: el.contentsIdx,
                                        episodeIdx: el.episodeIdx,
                                        regdate: el.regdate,
                                        badgeList: el.badgeList
                                    }

                                    listBody += `
                                        <div class="swiper-slide">
                                            <div href="javascript:void(0);" class="items">
                                              <!-- top_badge -->
                                              <div class="top_badge">
                                                <div class="left_top">
                                                ` + badge.thumbnailTopLeft.category + `
                                                </div>
                                                ` + badge.thumbnailTopRight + `
                                              </div>

                                              <figure>
                                              <a href="javascript:movePage.episode(` + el.contentsIdx + `);">
                                                <div class="img_wrap">
                                                    <img src="` + el.contentHeightImgList[0].url + `" alt=""/>
                                                </div>
                                               </a>
                                                <figcaption>
                                                  <p class="Text-xs">
                                                    <span class="info_title Subtitle-md">
                                                        ` + badge.title + `
                                                        ` + el.contentsTitle + `
                                                    </span>
                                                    <span class="sub_info">
                                                        ` + badge.up + `
                                                      <b class="episodeNum">` + el.episodeNumTitle + `</b>
                                                      <b class="point">·</b>
                                                      <b class="writer">` + el.writerList[0].name + `</b>
                                                    </span>
                                                  </p>
                                                  <button class="btn_continue Text-xs" onclick="myLibBottom('` + encodeURI(JSON.stringify(bottomSheetData)) + `');">이어보기</button>
                                                </figcaption>
                                              </figure>
                                            </div>
                                        </div>
                                    `;
                                });
                                $(".swiper_library .swiper-wrapper").html(listBody);
                                $(".myLib").children("div").children(".tab_container").show();
                                $(".no_result_wrap").removeClass("active");

                                // 관심 탭일 경우
                                if (searchType == "favorite") {
                                    $(".episodeNum, .point, .btn_continue").hide();
                                }
                            } else {
                                // 결과 없음 노출
                                $(".myLib").children("div").children(".tab_container").hide();
                                let text = `<span class="Text-lg">작품</span>이 없어요`;
                                noResult.setting("main", text);
                            }
                        } else {
                            // 영역 숨기기
                            $(".myLib").hide();
                        }
                    },
                    error: function (request, status, error) {
                        // filter error
                        // toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
                    },
                    complete: function () {
                        $('.tab_container.recent .skeleton-box').fadeOut(200, function () { $(this).remove() });
                    }
                });
                return false;
            }
        },
        // 최신작 리스트
        newList: function () {

            // params value
            let pavilionIdx = setPavilionIdx();
            let categoryIdx = params.get("categoryIdx");

            $.ajax({
                url: '{ C.API_DOMAIN }/v1/contents/new?pavilionIdx=' + pavilionIdx + '&categoryIdx=' + categoryIdx,
                cache: true,
                method: 'GET',
                dataType: 'json',
                processData: false,
                contentType: false,
                xhrFields: {
                    withCredentials: true
                },
                beforeSend: function () {
                    let skeletonBox = '<div class="skeleton-box style01"></div>'
                    let skeletonList = '<div class="skeleton-list"><div class="img-box"></div><div class="title-box"></div><div class="info-box"></div></div>'

                    $('.tab_container.new').append(skeletonBox);
                    for (let i = 0; i < 7; i++) {
                        $('.tab_container.new .skeleton-box').append(skeletonList);
                    }
                },
                success: function (res) {
                    if (res.result) {

                        // 최신작 영역의 기존 내용 비우기
                        $(".swiper_new .swiper-wrapper").empty();

                        let listBody = "";
                        if (res.data.newContentsList.length > 0) {
                            $.each(res.data.newContentsList, function (index, el) {
                                let badge = badgeSvg(el.badgeList);

                                listBody += `
                                    <div class="swiper-slide">
                                        <a href="javascript:movePage.episode(` + el.contentsIdx + `);" class="items">
                                            <div class="top_badge">
                                                <div class="left_top">
                                                    ` + badge.thumbnailTopLeft.ranking + `
                                                </div>
                                                ` + badge.thumbnailTopRight + `
                                            </div>
                                            <figure>
                                                <div class="img_wrap">
                                                    <img src="` + el.contentHeightImgList[0].url + `" alt="test" loading="lazy"/>
                                                </div>
                                                <figcaption>
                                                    <p class="Text-xs">
                                                        <span class="info_title Subtitle-md">
                                                            ` + badge.title + `
                                                            <b>` + el.title + `</b>
                                                        </span>
                                                        <span class="sub_info">
                                                            ` + badge.up + `
                                                            <b class="episodeNum">` + el.lastEpisodeNumber + `</b>
                                                            <b>·</b>
                                                            <b class="writer">` + el.writerList[0].name + `</b>
                                                        </span>
                                                    </p>
                                                </figcaption>
                                            </figure>
                                        </a>
                                    </div>
                                `;
                            });
                            $(".swiper_new .swiper-wrapper").html(listBody);

                        } else {
                            // 결과 없음 노출
                            let text = `<span class="Text-lg">작품</span>이 없어요`;
                            noResult.setting("main", text);
                        }
                    } else {
                        // 비로그인 OR 비성인 회원용 리스트 재호출
                        mainParams.set(params, "pavilionIdx", 0);
                        main.newList();
                    }
                },
                error: function (request, status, error) {
                    // filter error
                    toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
                },
                complete: function () {
                    $('.tab_container.new .skeleton-box').fadeOut(200, function () { $(this).remove() });
                }
            });
            return false;
        },
        // 랭킹 리스트
        rankList: function () {

            // params value
            let page = params.get('page');
            let recordSize = params.get("recordSize");
            let categoryIdx = params.get("categoryIdx");
            let pavilionIdx = setPavilionIdx();
            let period = params.get("period");
            let complete = params.get("complete");
            let monograph = params.get("monograph");

            $.ajax({
                url: '{ C.API_DOMAIN }/v1/contents?page=' + page + '&recordSize=' + recordSize + '&categoryIdx=' + categoryIdx + '&pavilionIdx=' + pavilionIdx + '&period=' + period + '&complete=' + complete + '&monograph=' + monograph,
                cache: true,
                method: 'GET',
                dataType: 'json',
                processData: false,
                contentType: false,
                xhrFields: {
                    withCredentials: true
                },
                beforeSend: function () {
                    let skeletonBox04 = '<div class="skeleton-box style04"></div>'
                    let skeletonList04 = '<div class="skeleton-list"><div class="number"></div><div class="img-box"></div><div class="title-box"></div><div class="info-box"></div></div>'

                    for (let i = 0; i < 3; i++) {
                        let skeletonBox = $(skeletonBox04);
                        for (let j = 0; j < 2; j++) {
                            let skeletonList = $(skeletonList04);
                            skeletonBox.append(skeletonList);
                        }
                        $('.tab_container.ranking').append(skeletonBox);
                    }
                },
                success: function (res) {
                    if (res.result) {

                        // 랭킹 영역의 기존 내용 비우기
                        $(".mainRankingSwiper .swiper-wrapper").empty();

                        let loop = 0; // 반복 횟수
                        let slideBody = "";
                        if (res.data.categoryContentsList.length > 0) {
                            $.each(res.data.categoryContentsList, function (index, el) {

                                let badge = badgeSvg(el.badgeList);

                                // tagList
                                let tagList = '';
                                if (el.tagList.length > 0) {
                                    $.each(el.tagList, (tagIdx, tagEl) => {
                                        tagList += '<b class="ranking_tag Text-xs">' + tagEl.name + '</b>';
                                    })
                                }

                                loop++;
                                slideBody += `
                                    <a href="javascript:movePage.episode(` + el.contentsIdx + `);" class="items ranking">
                                        <div class="top_badge">
                                          <div class="left_top">
                                            ` + badge.thumbnailTopLeft.ranking + `
                                          </div>
                                          ` + badge.thumbnailTopRight + `
                                        </div>
                                        <figure>
                                          <b>`+ loop + `</b>
                                          <div class="img_wrap">
                                            <img src="`+ el.contentHeightImgList[0].url + `" alt="test" loading="lazy"/>
                                          </div>
                                          <figcaption>
                                            <div>
                                              <p class="top_title">
                                                <span class="info_title Subtitle-lg">
                                                    ` + badge.title + `
                                                    <b>`+ el.title + `</b>
                                                </span>
                                              </p>
                                              <p class="Text-xs">
                                                <span class="sub_info">
                                                    ` + badge.up + `
                                                  <b class="episodeNum">`+ el.lastEpisodeNumber + `</b>
                                                  <b>·</b>
                                                  <b class="writer">`+ el.writerList[0].name + `</b>
                                                  <b>
                                                    <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                                                      xmlns="http://www.w3.org/2000/svg">
                                                      <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M2.23183 7.88924C3.0431 6.58042 4.89277 4.33331 8.00001 4.33331C11.1072 4.33331 12.9569 6.58042 13.7682 7.88924C14.0086 8.27713 14.0279 8.33312 14.0231 8.46207C14.0183 8.58961 13.9928 8.64831 13.7126 9.0328C13.2401 9.68135 12.4755 10.5996 11.487 11.3518C10.498 12.1043 9.31729 12.6666 8.00001 12.6666C6.68273 12.6666 5.50199 12.1043 4.51303 11.3518C3.52452 10.5996 2.75988 9.68135 2.28738 9.0328C2.00727 8.64831 1.98172 8.58961 1.97695 8.46207C1.97213 8.33312 1.9914 8.27713 2.23183 7.88924ZM8.00001 3.33331C4.35646 3.33331 2.24554 5.96904 1.38187 7.36239L1.35323 7.4085C1.14957 7.736 0.960476 8.04008 0.977649 8.49943C0.99483 8.95901 1.21134 9.25521 1.44454 9.57426L1.47913 9.62164C1.98332 10.3137 2.81354 11.3152 3.90749 12.1476C5.00098 12.9796 6.39027 13.6666 8.00001 13.6666C9.60975 13.6666 10.999 12.9796 12.0925 12.1476C13.1865 11.3152 14.0167 10.3137 14.5209 9.62164L14.5555 9.57426C14.7887 9.25521 15.0052 8.95901 15.0224 8.49943C15.0395 8.04008 14.8504 7.736 14.6468 7.4085L14.6182 7.36239C13.7545 5.96904 11.6436 3.33331 8.00001 3.33331ZM6.49997 8.5C6.49997 7.67157 7.17154 7 7.99997 7C8.8284 7 9.49997 7.67157 9.49997 8.5C9.49997 9.32843 8.8284 10 7.99997 10C7.17154 10 6.49997 9.32843 6.49997 8.5ZM7.99997 6C6.61926 6 5.49997 7.11929 5.49997 8.5C5.49997 9.88071 6.61926 11 7.99997 11C9.38068 11 10.5 9.88071 10.5 8.5C10.5 7.11929 9.38068 6 7.99997 6Z"
                                                        fill="#999999" />
                                                    </svg>
                                                  </b>
                                                  <b>`+ el.view + `</b>
                                                </span>
                                                <span class="rankin_tag_wrap">${tagList.toString()}</span>
                                                <span>${badge.bottom.toString()}</span>
                                              </p>
                                            </div>
                                          </figcaption>
                                        </figure>
                                    </a>
                                `;

                                // 한 슬라이드에 3줄씩 세팅
                                if (loop % 3 == 0) {

                                    // 슬라이드 클래스로 랩핑
                                    slideBody = `<div class="swiper-slide">` + slideBody + `</div>`;
                                    $(".mainRankingSwiper .swiper-wrapper").append(slideBody);

                                    // 다음 슬라이드를 위해 비우기
                                    slideBody = "";
                                }
                            });
                        } else {
                            // 결과 없음 노출
                            let text = `<span class="Text-lg">작품</span>이 없어요`;
                            noResult.setting("main", text);
                        }
                        // 스와이퍼 세팅
                        importJs.setting();
                    } else {
                        // 비로그인 OR 비성인 회원용 리스트 재호출
                        mainParams.set(params, "pavilionIdx", 0);
                        main.rankList();
                    }
                },
                error: function (request, status, error) {
                    // filter error
                    toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
                },
                complete: function () {
                    $('.tab_container.ranking .skeleton-box').fadeOut(200, function () { $(this).remove() });
                }
            });
            return false;
        }
    }

    let importJs = {
        /*기본 세팅*/
        setting: function () {

            /*내가 보던 꿀작 스와이프*/
            let librarySwiper = new Swiper('.swiper_library', {
                direction: 'horizontal',
                slidesPerView: 'auto',
                spaceBetween: 6,
                freeMode: true,
                loopAdditionalSlides: 1,
                slidesOffsetAfter: 16,
                observer: true,
                observeParents: true,
                lazyPreloadPrevNext: 5
            });

            /*최신작 스와이프*/
            let newSwiper = new Swiper('.swiper_new', {
                direction: 'horizontal',
                slidesPerView: 'auto',
                spaceBetween: 6,
                freeMode: true,
                loopAdditionalSlides: 1,
                slidesOffsetAfter: 16,
                observer: true,
                observeParents: true,
                lazyPreloadPrevNext: 5
            });

            /* 메인 랭킹 스와이프 */
            let mainRankingSwiper = new Swiper(".mainRankingSwiper", {
                slidesPerView: 1.2,
                centeredSlides: false,
                spaceBetween: 20,
                slidesOffsetAfter: 100,
                observer: true,
                observeParents: true,
                breakpoints: {
                    570: {
                        slidesPerView: 1.7,
                        slidesOffsetAfter: 200,
                        spaceBetween: 40
                    }
                },
                lazyPreloadPrevNext: 5
            });

            /*내가 보던 꿀작 카테고리 탭 클릭 이벤트*/
            $(".library_tab_link").click(function () {

                if ($(this).hasClass("active") == false) {
                    $(".library_tab_link").removeClass("active");
                    $("#lib_bottom_container").removeClass("active");
                    $(this).addClass("active");

                    // 최근
                    if ($(this).attr("id").match("1")) {
                        mainParams.set(params, "searchType", "view");

                        // 대여
                    } else if ($(this).attr("id").match("2")) {
                        mainParams.set(params, "searchType", "rent");

                        // 소장
                    } else if ($(this).attr("id").match("3")) {
                        mainParams.set(params, "searchType", "have");

                        // 관심
                    } else if ($(this).attr("id").match("4")) {
                        mainParams.set(params, "searchType", "favorite");
                    }
                    // 내가 보던 꿀작 리스트 호출
                    main.myLibraryList();
                }
            })

            /*내가 보던 꿀작 더보기 페이지 이동*/
            $(".library_all").click(function () {
                // 내 꿀단지 페이지로 이동
                movePage.myLibrary();
            })

            /*최신작 카테고리 탭 클릭 이벤트*/
            $(".new_tab_link").click(function () {
                if ($(this).hasClass("active") == false) {
                    $(".new_tab_link").removeClass("active");
                    $(this).addClass("active");

                    // 웹툰
                    if ($(this).attr("id").match("1")) {
                        mainParams.set(params, "categoryIdx", 1);

                        // 만화
                    } else if ($(this).attr("id").match("2")) {
                        mainParams.set(params, "categoryIdx", 2);

                        // 소설
                    } else if ($(this).attr("id").match("3")) {
                        mainParams.set(params, "categoryIdx", 3);
                    }
                    // 최신작 리스트 호출
                    main.newList();
                }
            })

            /*최신작 더보기 페이지 이동*/
            $(".new_all").click(function () {
                $(".new_tab_wrap li").each(function (index, el) {
                    if ($(this).hasClass("active")) {

                        // 웹툰 랭킹 이동
                        if ($(this).attr("id").match("1")) {
                            movePage.webtoon();

                            // 만화 랭킹 이동
                        } else if ($(this).attr("id").match("2")) {
                            movePage.comic();

                            // 소설 랭킹 이동
                        } else if ($(this).attr("id").match("3")) {
                            movePage.novel();
                        }
                    }
                });
            })

            /*랭킹 카테고리 탭 클릭 이벤트*/
            $(".tab_link").click(function () {
                if ($(this).hasClass("active") == false) {
                    $(".tab_link").removeClass("active");
                    $(this).addClass("active");

                    // 웹툰
                    if ($(this).attr("id").match("1")) {
                        mainParams.set(params, "categoryIdx", 1);

                        // 만화
                    } else if ($(this).attr("id").match("2")) {
                        mainParams.set(params, "categoryIdx", 2);

                        // 소설
                    } else if ($(this).attr("id").match("3")) {
                        mainParams.set(params, "categoryIdx", 3);
                    }
                    // 랭킹 리스트 호출
                    main.rankList();
                }
            })

            /*랭킹 더보기 페이지 이동*/
            $(".rank_all").click(function () {
                $(".tab_wrap li").each(function (index, el) {
                    if ($(this).hasClass("active")) {

                        // 웹툰 랭킹 이동
                        if ($(this).attr("id").match("1")) {
                            movePage.webtoon();

                            // 만화 랭킹 이동
                        } else if ($(this).attr("id").match("2")) {
                            movePage.comic();

                            // 소설 랭킹 이동
                        } else if ($(this).attr("id").match("3")) {
                            movePage.novel();
                        }
                    }
                });
            })
        }
    }
</script>