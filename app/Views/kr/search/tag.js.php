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

            // 태그 검색 결과 더보기 리스트
            searchAll.tagList();
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
        // 태그 검색 결과 더보기 리스트
        tagList: function () {

            // params value
            let page = params.get("page");
            let recordSize = params.get("recordSize");
            let pavilionIdx = setPavilionIdx();
            let searchType = params.get("searchType");
            let searchWord = params.get("searchWord");

            $.ajax({
                url: '{ C.API_DOMAIN }/v1/contents/search/tag?page=' + page + '&recordSize=' + recordSize + '&pavilionIdx=' + pavilionIdx + '&searchType=' + searchType + '&searchWord=' + searchWord,
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

                        let searchResult = "";
                        if (res.data.tagSearchList.length > 0) {

                            // 전체 페이지 개수 세팅
                            scroll.set(data, "totalPageCnt", res.data.params.pagination.totalPageCount);

                            // 검색 제목 세팅
                            let searchTitle = `
                              <span>태그</span>
                              <span>`+ res.data.params.pagination.totalRecordCount +`</span>
                            `;
                            $(".content_wrap .title_wrap").html(searchTitle);

                            // 검색 결과 세팅
                            $.each(res.data.tagSearchList, function (index, el) {
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
                                                ${el.title.toString()}
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
                        } else {
                            // 전체 페이지 개수 세팅
                            scroll.set(data, "totalPageCnt", 0);
                        }

                        // html set
                        if (page == 1) {
                            $(".content_wrap .tab_container .tab_content").html(searchResult);
                        } else {
                            $(".content_wrap .tab_container .tab_content").append(searchResult);
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
                    // toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
                }
            });
            return false;
        }
    }

    let importJs = {
        /*기본 세팅*/
        setting: function () {

            /*뒤로 가기*/
            $("#tag").children("a").click(function () {

                // 검색어 조회
                let keyword = params.get("searchWord");

                // 검색 메인 페이지로 이동
                movePage.search(keyword);
            })
        }
    }

    /*스크롤 위치 감지 -> 다음 페이지 호출*/
    let startPoint = 0;
    $(window).scroll(function () {

        // 현재 스크롤 위치
        let current = $(window).scrollTop();

        // 검색 결과 리스트 영역 높이
        let endPoint = $(".tab_content").height();

        // 스크롤 위치 감지
        if (startPoint <= current && current <= endPoint) {

            // 다음 페이지가 있을 경우
            if (params.get("page") < data.get("totalPageCnt")) {

                // 다음 페이지 세팅
                searchParams.set(params, "page", params.get("page") + 1);

                // 다음 검색 결과 리스트 호출
                searchAll.tagList();

                // 다음 페이지 호출 위치 재설정
                startPoint = endPoint - data.get("maxScroll");
            }
        }
    });
</script>