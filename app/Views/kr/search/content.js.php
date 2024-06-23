<script>
    $(document).ready(function () {
        // 검색어 세팅
        searchAll.keyword();
    });

    /* 전역 변수 */
    let params = new Map();
    let data = new Map();

    /* 전역 변수 기본값 세팅 */
    searchParams.default(params);
    scroll.default(data);

    let searchAll = {
        // 검색어 세팅
        keyword: function () {

            // 검색어 조회
            let keyword = searchAll.checkKeyWord();

            // params set
            searchParams.set(params, "searchType", "all");
            searchParams.set(params, "searchWord", keyword);

            // 작품 검색 결과 더보기 리스트
            searchAll.contentList();
        },
        // 입력받은 검색어 조회
        checkKeyWord() {

            // URLSearchParams 객체 생성
            let currentUrl = new URL($(location).attr('href'));
            const urlParams = currentUrl.searchParams;

            // 검색어 파라미터 읽기
            let keyword = urlParams.get('keyword');
            return keyword;
        },
        // 작품 검색 결과 더보기 리스트
        contentList: function () {

            // params value
            let page = params.get("page");
            let recordSize = params.get("recordSize");
            let pavilionIdx = setPavilionIdx();
            let searchType = params.get("searchType");
            let searchWord = params.get("searchWord");
            let categoryIdx = params.get("categoryIdx");

            $.ajax({
                url: '{ C.API_DOMAIN }/v1/contents/search/content?page=' + page + '&recordSize=' + recordSize + '&pavilionIdx=' + pavilionIdx + '&searchType=' + searchType + '&searchWord=' + searchWord + '&categoryIdx=' + categoryIdx,
                cache : true,
                method: 'GET',
                dataType: 'json',
                processData: false,
                contentType: false,
                xhrFields: {
                    withCredentials: true
                },
                success: function (res) {
                    if (res.result) {

                        // 검색 결과 없음 영역 숨김
                        $("#content_container .content_wrap .tab_container .no_result_wrap").hide();

                        // 작품 검색 영역 노출
                        $("#content_container .content_wrap .tab_container .content").show();

                        // 최초 세팅 시 -> 작품 검색 영역 + 작품 카테고리 탭 + 활성화된 카테고리 기준 검색 결과
                        if (categoryIdx == 0) {

                            // 작품 검색 영역 세팅
                            let totalCnt = res.data.categoryCnt.webtoon + res.data.categoryCnt.comic + res.data.categoryCnt.novel;
                            let searchTitle = `
                                  <span>작품</span>
                                  <span>`+ totalCnt +`</span>
                            `;
                            $(".content_wrap .title_wrap").html(searchTitle);

                            // 카테고리별 검색 결과 개수 세팅
                            let searchTab = `
                                  <div class="tab_item webtoon">
                                    <span>웹툰</span>
                                    <span>`+ res.data.categoryCnt.webtoon +`</span>
                                  </div>
                                  <div class="tab_item comic">
                                    <span>만화</span>
                                    <span>`+ res.data.categoryCnt.comic  +`</span>
                                  </div>
                                  <div class="tab_item novel">
                                    <span>소설</span>
                                    <span>`+ res.data.categoryCnt.novel  +`</span>
                                  </div>
                            `;
                            $(".content_wrap .tab_wrap").html(searchTab);

                            // 활성화할 카테고리 탭 세팅
                            searchAll.setCategoryTab(res.data.categoryTab);

                            // 활성화된 카테고리 기준으로 검색 결과 세팅
                            $.ajax({
                                url: '{ C.API_DOMAIN }/v1/contents/search/content?page=' + page + '&recordSize=' + recordSize + '&pavilionIdx=' + pavilionIdx + '&searchType=' + searchType + '&searchWord=' + searchWord + '&categoryIdx=' + params.get("categoryIdx"),
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
                                        if (res.data.contentSearchList.length > 0) {

                                            // 전체 페이지 개수 세팅
                                            scroll.set(data, "totalPageCnt", res.data.params.pagination.totalPageCount);

                                            // 검색 결과 세팅
                                            let searchResult = "";
                                            $.each(res.data.contentSearchList, function (index, el) {
                                                let badge = badgeSvg(el.badgeList);

                                                searchResult += `
                                                    <a href="javascript:movePage.episode(` + el.contentsIdx + `);" class="items">
                                                      <figure>
                                                        <div class="img_wrap">
                                                            <img src="${el.contentHeightImgList[0].url.toString()}" alt="" loading="lazy"/>
                                                            <div class="badge_wrap">
                                                                <span> ${badge.thumbnailTopLeft.ranking.toString()}</span>
                                                                <span class="right-badge">${badge.thumbnailTopRight.toString()}</span>
                                                            </div>
                                                        </div>
                                                        <figcaption>
                                                          <p class="Text-xs">
                                                            <span class="info_title Subtitle-md">
                                                                ${badge.title.toString()}
                                                                <b>${el.title.toString()}</b>
                                                            </span>
                                                            <span class="sub_info Text-xs">
                                                              ${badge.up.toString()}
                                                              <b class="episodeNum">${el.lastEpisodeNumber.toString()}</b>
                                                              <b>·</b>
                                                              <b class="writer">${el.writerList[0].name.toString()}</b>
                                                            </span>
                                                            <span>${badge.bottom.toString()}</span>
                                                          </p>
                                                        </figcaption>
                                                      </figure>
                                                    </a>
                                                `;
                                            });
                                            // html set
                                            if (page == 1) {
                                                $("#content_container .content_wrap .tab_container .content").html(searchResult);
                                            } else {
                                                $("#content_container .content_wrap .tab_container .content").append(searchResult);
                                            }
                                        } else {
                                            // 전체 페이지 개수 세팅
                                            scroll.set(data, "totalPageCnt", 0);
                                        }
                                        // 기본 세팅
                                        importJs.setting();
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

                            // 특정 카테고리 탭 클릭 시 -> 활성화된 카테고리 기준 검색 결과
                        } else {
                            // 검색 결과 작품 리스트 세팅
                            if (res.data.contentSearchList.length > 0) {

                                // 전체 페이지 개수 세팅
                                scroll.set(data, "totalPageCnt", res.data.params.pagination.totalPageCount);

                                let searchResult = "";
                                $.each(res.data.contentSearchList, function (index, el) {
                                    let badge = badgeSvg(el.badgeList);
                                    searchResult += `
                                        <a href="javascript:movePage.episode(` + el.contentsIdx + `);" class="items">
                                          <figure>
                                            <div class="img_wrap">
                                                <img src="${el.contentHeightImgList[0].url.toString()}" alt="" loading="lazy"/>
                                                <div class="badge_wrap">
                                                    <span> ${badge.thumbnailTopLeft.ranking.toString()}</span>
                                                    <span class="right-badge">${badge.thumbnailTopRight.toString()}</span>
                                                </div>
                                            </div>
                                            <figcaption>
                                              <p class="Text-xs">
                                                <span class="info_title Subtitle-md">
                                                    ${badge.title.toString()}
                                                    <b>${el.title.toString()}</b>
                                                </span>
                                                <span class="sub_info Text-xs">
                                                    ${badge.up.toString()}
                                                    <b class="episodeNum">${el.lastEpisodeNumber.toString()}</b>
                                                    <b>·</b>
                                                    <b class="writer">${el.writerList[0].name.toString()}</b>
                                                </span>
                                                <span>${badge.bottom.toString()}</span>
                                              </p>
                                            </figcaption>
                                          </figure>
                                      </a>
                                    `;
                                });
                                // html set
                                if (page == 1) {
                                    $("#content_container .content_wrap .tab_container .content").html(searchResult);
                                } else {
                                    $("#content_container .content_wrap .tab_container .content").append(searchResult);
                                }
                            } else { // 현재 카테고리 검색 결과가 없는 경우
                                // 전체 페이지 개수 세팅
                                scroll.set(data, "totalPageCnt", 0);

                                // 결과 없음 노출
                                $("#content_container .content_wrap .tab_container .content").hide();
                                $("#content_container .content_wrap .tab_container .no_result_wrap").show();
                                let text = `<span class="Text-lg">작품</span>이 없어요`;
                                noResult.setting("search_content", text);
                            }
                        }
                        // 기본 세팅
                        importJs.setting();
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
        // 활성화할 카테고리 탭 세팅
        setCategoryTab(category) {
            let selected = $(".tab_wrap").find("." + category).addClass("active");
            $(".tab_wrap").find("." + category).not(selected).removeClass("active");

            // set params
            if (category == "webtoon") {
                searchParams.set(params, "categoryIdx" , 1);

            } else if (category == "comic") {
                searchParams.set(params, "categoryIdx" , 2);

            } else if (category == "novel") {
                searchParams.set(params, "categoryIdx" , 3);
            }
        }
    }

    let importJs = {
        /*기본 세팅*/
        setting: function () {

            /*뒤로 가기*/
            $("#content").children("a").click(function () {

                // 검색어 조회
                let keyword = params.get("searchWord");

                // 검색 메인 페이지로 이동
                movePage.search(keyword);
            })

            /*작품 검색 탭 메뉴*/
            $(".tab_item").click(function () {
                if ($(this).hasClass("active") == false) {

                    // 선택한 탭 메뉴 활성화
                    $(this).addClass("active");
                    $(".tab_item").not($(this)).removeClass("active");

                    // 페이지 번호 초기화
                    searchParams.set(params, "page", 1);

                    // set params
                    if ($(this).hasClass("webtoon")) {
                        searchParams.set(params, "categoryIdx" , 1);

                    } else if ($(this).hasClass("comic")) {
                        searchParams.set(params, "categoryIdx" , 2);

                    } else if ($(this).hasClass("novel")) {
                        searchParams.set(params, "categoryIdx" , 3);
                    }
                    // 작품 검색 결과 리스트 조회
                    searchAll.contentList();
                }
            })
        }
    }

    /*스크롤 위치 감지 -> 다음 페이지 호출*/
    let startPoint = 0;
    $(window).scroll(function () {

        // 현재 스크롤 위치
        let current = $(window).scrollTop();

        // 검색 결과 리스트 영역 높이
        let endPoint = $("#content_container .content_wrap .tab_container .content").height();

        // 스크롤 위치 감지
        if (startPoint <= current && current <= endPoint) {

            // 다음 페이지가 있을 경우
            if (params.get("page") < data.get("totalPageCnt")) {

                // 다음 페이지 세팅
                searchParams.set(params, "page", params.get("page") + 1);

                // 다음 검색 결과 리스트 호출
                searchAll.contentList();

                // 다음 페이지 호출 위치 재설정
                startPoint = endPoint - data.get("maxScroll");
            }
        }
    });
</script>