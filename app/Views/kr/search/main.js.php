<script>
  $(document).ready(function () {
    // 검색어 세팅
    search.keyword();
    importJs.setting();
  });

  /* 전역 변수 */
  let params = new Map();
  let searchResultArr = new Array();

  /* 전역 변수 기본값 세팅 */
  searchParams.default(params);

  let search = {
    // 입력 받은 검색어로 입력창 세팅
    keyword: function () {

      // 검색 영역 큐레이션 리스트
      search.curationList();

      // 입력받은 검색어 조회
      let keyword = search.checkKeyWord();

      // 검색어가 있을 경우에만
      if (keyword != null && keyword != "") {

        // 입력창 세팅
        $("#side-container .side-wrap input").val(keyword);
        $("label[for='search_pg']").children('input').val(keyword);

        // 검색 결과 리스트 호출
        searchParams.set(params, "searchWord", keyword);
        search.contentList();
        search.authorList();
        search.tagList();
      }
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
    // 작품 검색 결과 리스트
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

            // 작품 검색 영역의 기존 내용 비우기
            $("#content .tab_container .content").empty();

            // 작품 검색 결과 총 개수
            let totalCnt = res.data.categoryCnt.webtoon + res.data.categoryCnt.comic + res.data.categoryCnt.novel;
            if (totalCnt > 0) {

              // 추천 키워드 숨김
              $(".keyword_wrap").hide();

              // 검색 결과 없음 영역 숨김
              $("#content .tab_container .no_result_wrap").hide();

              // 작품 검색 영역 노출
              $("#content").show();
              $("#content .tab_container .content").show();

                // 작품 검색 영역 세팅
                searchResultArr.push(totalCnt);
                let searchArea = `
                      <h4>
                        <span>작품</span>
                        <span>`+ totalCnt + `</span>
                      </h4>
                      <a href="javascript:void(0);" class="more_btn">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M9 15C9 15.5523 9.44772 16 10 16C10.5523 16 11 15.5523 11 15V11H15C15.5523 11 16 10.5523 16 10C16 9.44772 15.5523 9 15 9H11V5C11 4.44772 10.5523 4 10 4C9.44772 4 9 4.44772 9 5V9H5C4.44772 9 4 9.44772 4 10C4 10.5523 4.44772 11 5 11H9V15Z"
                            fill="#333333" />
                        </svg>
                      </a>
                    `;
                $("#content .title_wrap").html(searchArea);

                // 활성화할 카테고리 탭 세팅
                if (categoryIdx == 0) {
                    let searchTab = `
                          <div class="tab_item webtoon">
                            <span>웹툰</span>
                            <span class="webtoon_cnt">`+ res.data.categoryCnt.webtoon + `</span>
                          </div>
                          <div class="tab_item comic">
                            <span>만화</span>
                            <span class="comic_cnt">`+ res.data.categoryCnt.comic + `</span>
                          </div>
                          <div class="tab_item novel">
                            <span>소설</span>
                            <span class="novel_cnt">`+ res.data.categoryCnt.novel + `</span>
                          </div>
                    `;
                    $("#content .tab_wrap").html(searchTab);
                    search.setCategoryTab(res.data.categoryTab);

                } else {
                    $(".webtoon .webtoon_cnt").html(res.data.categoryCnt.webtoon);
                    $(".comic .comic_cnt").html(res.data.categoryCnt.comic);
                    $(".novel .novel_cnt").html(res.data.categoryCnt.novel);
                }

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
                                                  ${badge.up.toString()} ${el.lastEpisodeNumber.toString()} · ${el.writerList[0].name.toString()}
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
                                    $("#content .tab_container .content").html(searchResult);
                                } else {
                                    $("#content .tab_container .content").append(searchResult);
                                }

                                // 현재 카테고리 검색 결과가 없는 경우
                            } else {
                                // 결과 없음 노출
                                $("#content .tab_container .content").hide();
                                $("#content .tab_container .no_result_wrap").show();
                                let text = `<span class="Text-lg">작품</span>이 없어요`;
                                noResult.setting("search_content", text);
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

              // 작품 검색 결과가 없는 경우
            } else {
              // 작품 검색 영역 숨김
              $("#content").hide();
              $("#content .tab_container .content").hide();
              searchResultArr.push(0);
              importJs.setNoResult();
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
    },
    // 작가 검색 결과 리스트
    authorList: function () {

      // params value
      let page = params.get("page");
      let recordSize = params.get("recordSize");
      let pavilionIdx = setPavilionIdx();
      let searchType = params.get("searchType");
      let searchWord = params.get("searchWord");

      $.ajax({
        url: '{ C.API_DOMAIN }/v1/contents/search/author?page=' + page + '&recordSize=' + recordSize + '&pavilionIdx=' + pavilionIdx + '&searchType=' + searchType + '&searchWord=' + searchWord,
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

            // 작가 검색 영역의 기존 내용 비우기
            $("#author .tab_container .author").empty();

            if (res.data.authorSearchList.length > 0) {

              // 추천 키워드 숨김
              $(".keyword_wrap").hide();

              // 작가 검색 영역 세팅
              $("#author").show();

              let searchArea = `
                      <h4>
                        <span>작가</span>
                        <span>`+ res.data.totalCount + `</span>
                      </h4>
                      <a href="javascript:void(0);" class="more_btn">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M9 15C9 15.5523 9.44772 16 10 16C10.5523 16 11 15.5523 11 15V11H15C15.5523 11 16 10.5523 16 10C16 9.44772 15.5523 9 15 9H11V5C11 4.44772 10.5523 4 10 4C9.44772 4 9 4.44772 9 5V9H5C4.44772 9 4 9.44772 4 10C4 10.5523 4.44772 11 5 11H9V15Z"
                            fill="#333333" />
                        </svg>
                      </a>
              `;
              $("#author .title_wrap").html(searchArea);
              searchResultArr.push(res.data.totalCount);

              // 검색 결과 세팅
              let searchResult = "";
              $.each(res.data.authorSearchList, function (index, el) {
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
              $("#author .tab_container .author").html(searchResult);

            } else {
              // 결과 없음 노출
              searchResultArr.push(0);
              importJs.setNoResult();
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
    },
    // 태그 검색 결과 리스트
    tagList: function () {

      // params value
      let page = params.get("page");
      let recordSize = params.get("recordSize");
      let pavilionIdx = setPavilionIdx();
      let searchType = params.get("searchType");
      let searchWord = params.get("searchWord");

      $.ajax({
        url: '{ C.API_DOMAIN }/v1/contents/search/tag?page=' + page + '&recordSize=' + recordSize + '&pavilionIdx=' + pavilionIdx + '&searchType=' + searchType + '&searchWord=' + searchWord,
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

            // 태그 검색 영역의 기존 내용 비우기
            $("#tag .tab_container .tag").empty();

            if (res.data.tagSearchList.length > 0) {

              // 추천 키워드 숨김
              $(".keyword_wrap").hide();

              // 태그 검색 영역 세팅
              $("#tag").show();

              let searchArea = `
                  <h4>
                    <span>태그</span>
                    <span>`+ res.data.totalCount + `</span>
                  </h4>
                  <a href="javascript:void(0);" class="more_btn">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M9 15C9 15.5523 9.44772 16 10 16C10.5523 16 11 15.5523 11 15V11H15C15.5523 11 16 10.5523 16 10C16 9.44772 15.5523 9 15 9H11V5C11 4.44772 10.5523 4 10 4C9.44772 4 9 4.44772 9 5V9H5C4.44772 9 4 9.44772 4 10C4 10.5523 4.44772 11 5 11H9V15Z"
                        fill="#333333" />
                    </svg>
                  </a>
              `;
              $("#tag .title_wrap").html(searchArea);
              searchResultArr.push(res.data.totalCount);

              // 검색 결과 세팅
              let searchResult = "";
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
                                    <b>
                                    ${el.title.toString()}
                                    </b>
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
              $("#tag .tab_container .tag").html(searchResult);

            } else {
              // 결과 없음 노출
              searchResultArr.push(0);
              importJs.setNoResult();
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
    },
    // 활성화할 카테고리 탭 세팅
    setCategoryTab(category) {

        if (category != "" && category != undefined) {
            let selected = $(".tab_wrap").find("." + category).addClass("active");
            $(".tab_wrap").find("." + category).not(selected).removeClass("active");

            if (category == "webtoon") {
                searchParams.set(params, "categoryIdx", 1);

            } else if (category == "comic") {
                searchParams.set(params, "categoryIdx", 2);

            } else if (category == "novel") {
                searchParams.set(params, "categoryIdx", 3);
            }
        }
    },
    // 검색 영역 큐레이션 리스트
    curationList: function () {

      // 비로그인 OR 비성인 회원
      if (local.memberInfo() == null || local.memberInfo().data.adult == 0) {
        searchParams.set(params, "pavilionIdx", 0);

        // 성인 회원
      } else {
        searchParams.set(params, "pavilionIdx", 1);
      }
      // 큐레이션 세팅
      curation.setting(3);
    }
  }

  let importJs = {
    /* 기본 세팅 */
    setting: function () {

      /*작품 검색 입력창 감지*/
      $("label[for='search_pg']").children('input').keydown(function (key) {

        // 검색어 공백 제거
        let keyword = $(this).val().replace(/ /g, "");

        // 엔터키 눌렀을 때
        if (key.keyCode === 13) {
          // 검색어가 있을 때만
          if (keyword != "") {
            // 검색어 세팅
            searchParams.set(params, "searchWord", keyword);
            // 검색어 파라미터 세팅 및 검색 페이지로 이동
            movePage.search(keyword);
          }
        }
      });

      /*추천 장르 태그 클릭*/
      $(".search_keyword .tag").click(function () {
        // 검색어 파라미터 세팅 및 검색 페이지로 이동
        movePage.search($(this).html());
      });

      /*작품 검색 탭 메뉴*/
      $("#content .tab_wrap .tab_item").click(function () {
        if ($(this).hasClass("active") == false) {

          // 선택한 탭 메뉴 활성화
          $(this).addClass("active");
          $(".tab_item").not($(this)).removeClass("active");

          // set params
          if ($(this).hasClass("webtoon")) {
            searchParams.set(params, "categoryIdx", 1);

          } else if ($(this).hasClass("comic")) {
            searchParams.set(params, "categoryIdx", 2);

          } else if ($(this).hasClass("novel")) {
            searchParams.set(params, "categoryIdx", 3);
          }
          // 작품 검색 결과 리스트 조회
          search.contentList();
        }
      });

      /*작품 & 작가 & 태그 검색 결과 더보기*/
      $(".more_btn").click(function () {

        // 클릭 위치 감지
        let selected = $(this).parent().parent().attr("id");

        // 현재 검색어
        let keyword = params.get("searchWord");

        // 검색 결과 더보기 페이지로 이동
        movePage.searchAll(selected, keyword);
      });
    },
    /* 작품 & 작가 & 태그 검색 결과 없는 경우 -> 결과 없음 이미지 세팅 */
    setNoResult: function () {
      if (searchResultArr.length == 3) {

        let nullCnt = 0;
        searchResultArr.forEach(function (el, index) {
          if (el == 0) {
            nullCnt++;
          }
        });

        if (nullCnt == 3) {
          $("#search_container .search_top .no_result_wrap").show();
          let keyword = params.get("searchWord");
          let text = `'<span class="keyword Text-lg">` + keyword + `</span>'에 대한 검색 결과가 없어요`;
          noResult.setting("search_main", text);
        }
      }
    }
  }
</script>