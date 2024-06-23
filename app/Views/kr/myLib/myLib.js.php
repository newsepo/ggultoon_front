<script>
    /* 전역 변수 */
    let params = new Map();
    let data = new Map();

    /* 전역 변수 기본값 세팅 */
    libraryParams.default(params);
    scroll.default(data);
    let requestType = '{HTML.TYPE}';
    if (requestType) {
        libraryParams.set(params, 'searchType', '{HTML.TYPE}');
    }

    $(document).ready(function () {
        // 회원 정보 조회
        let memberInfo = local.memberInfo();

        // 비로그인
        if (memberInfo == null) {
            // 로그인 모달 호출
            $(".lib_container").empty();
            movePage.login();

            // 뒤로 가기
            $("#myLib").children("button").on('click', () => {
                // 메인 페이지로 이동
                movePage.main();
            })

            // 로그인
        } else {
            library.list(params.get('searchType'));
        }
    })

    /*스크롤 위치 감지 -> 다음 페이지 호출*/
    let startPoint = 0;
    $(window).scroll(function () {

        // 현재 스크롤 위치
        let current = $(window).scrollTop();

        // 내가 보던 꿀작 슬라이드 높이
        let endPoint = $(".lib_tab_content").height();

        // 스크롤 위치 감지
        if (startPoint <= current && current <= endPoint) {

            // 다음 페이지가 있을 경우
            if (params.get("page") < data.get("totalPageCnt")) {

                // 다음 페이지 세팅
                libraryParams.set(params, "page", params.get("page") + 1);

                // 다음 페이지 호출
                library.list(params.get('searchType'));

                // 다음 페이지 호출 위치 재설정
                startPoint = endPoint - data.get("maxScroll");
            }
        }
    });

    let library = {
        reset: function () {
            // 바텀 팝업 닫기
            $("#lib_bottom_container").removeClass("active");

            // 검색 초기화
            libraryParams.default(params);
            $(".lib_top input[name=librarySearch]").val('');

            // 편집 초기화
            $(".lib_container .tab_content a.item").find('svg').removeClass("active");
            $(".lib_container .lib_content > .edit_top #select_all").prop("checked", false);
            $(".lib_container").removeClass("edit");

        },
        // 작품 리스트(기본값 : 최근 본 작품)
        list: function (type='view') {

            $("#search_container .no_result_wrap").removeClass("active");
            $("#search_container .no_result_wrap .no_result").removeClass("active");
            libraryParams.set(params, 'searchType', type);

            let queryString = '?page=' + params.get('page') + '&recordSize=' + params.get('recordSize') + '&searchType=' + params.get('searchType') + '&searchWord=' + params.get('searchWord');

            $.ajax({
                url: '{ C.API_DOMAIN }/v1/member/library' + queryString,
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
                        // 큐레이션 영역 초기화
                        $("div[name='curation_top']").empty();
                        $("div[name='curation_bottom']").empty();

                        if (res.data.list.length > 0) {
                            // 전체 페이지 개수 세팅
                            scroll.set(data, "totalPageCnt", res.data.params.pagination.totalPageCount);

                            let listData = res.data.list;
                            let listHtml = "";

                            listData.forEach((el, index) => {
                                listHtml += rowsHtml(el);
                            })

                            // html set
                            if (params.get('page') == 1) {
                                $(".lib_tab_content .tab_content").html(listHtml);
                            } else {
                                $(".lib_tab_content .tab_content").append(listHtml);
                            }
                        } else {
                            // 전체 페이지 개수 세팅
                            scroll.set(data, "totalPageCnt", 0);

                            // 검색 결과 영역 초기화
                            $(".lib_tab_content .tab_content").empty();
                            // 결과 없음 노출
                            let text = `<span class="Text-lg">보고 있는 작품</span>이 없어요`;
                            noResult.setting("search_content", text);
                            // 큐레이션 세팅
                            curation.setting(5);
                        }
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
        },
        // 편집 삭제 선택
        removeTarget: function () {
            let removeTargets = [];
            $(".modal-content .modal-body p:last-of-type").text('');
            let target = $(".tab_content .btn_wrap svg.active");

            $.each(target, function (index, el) {
                removeTargets.push($(el).parents("a").data("idx"));
            })

            let targetName;
            if (removeTargets.length > 0) {
                targetName = target.eq(0).parents("a").find('h5').text();
                if (removeTargets.length > 1) {
                    targetName += ' 외 ' + (removeTargets.length - 1) + '개';
                }
                targetName += " 작품을 삭제할까요?"
            }
            // 삭제 알림 모달창 호출
            library.callModal(targetName);
        },
        // 삭제
        delete: function () {
            let removeTargets = [];
            let target = $(".tab_content .btn_wrap svg.active");
            $.each(target, function (index, el) {
                removeTargets.push($(el).parents("a").data("idx"));
            })
            // 최근
            let url = '';
            if (params.get('searchType') == 'view') {
                url = '{C.API_DOMAIN}/v1/member/library/view'
            } else if (params.get('searchType') == 'favorite') {
                url = '{C.API_DOMAIN}/v1/member/library/favorite';
            } else  if (params.get('searchType') == 'rent' || params.get('searchType') == 'have') {
                url = '{C.API_DOMAIN}/v1/member/library/purchase';
            }

            $.ajax({
                url: url,
                cache: true,
                method: 'DELETE',
                dataType: 'json',
                data: JSON.stringify({
                    idxList: removeTargets
                }),
                processData: false,
                contentType: 'application/json',
                xhrFields: {
                    withCredentials: true
                },
                success: function (res) {
                    if (res.result) {
                        // 페이지 새로고침
                        location.reload();
                        //target.parents("a").remove();
                    }
                    return false;
                },
                error: function (request, status, error) {
                    // filter error
                    toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
                }
            })
        },
        // 삭제 알림 모달창 호출
        callModal : function (targetName) {
            // set params
            let callParams = new Map();
            callParams.set("title", "작품을 삭제하면 구매 이력까지 모두 삭제돼요!");
            callParams.set("detail", targetName);
            callParams.set("yes", "네, 삭제할게요");
            callParams.set("no", "아니요");
            callParams.set("color", "red");

            // 예 버튼 클릭 시 내 서재 내역 삭제 되도록 콜백함수 세팅
            gModal.verticalConfirm(callParams, library.delete);
        }
    }


    let rowsHtml = (data) => {
        let badge = badgeSvg(data.badgeList);

        let date = '';
        if (data.regdate) {
            date = '<span class="date Text-xs">' + dateFormat.contentsDate(data.regdate, '.') + '</span>';
        }

        let episodeTitle = '';
        if (data.episodeNumTitle && data.episodeNumTitle != 0) {
            episodeTitle = '<div><span class="episode_count Text-xs">' +
                '<b>' + data.episodeNumTitle + '</b>' +
                '<b>' + data.lastEpisodeNumber + '</b>' +
                '</span></div>';
        }

        let continueBtn = '';
        if (params.get('searchType') != 'favorite') {
            continueBtn = '<button class="continue Text-xs">이어보기</button>';
        }

        // bottomSheet 전달 값
        let bottomSheetData = {
            contentsIdx: data.contentsIdx,
            episodeIdx: data.episodeIdx,
            regdate: data.regdate,
            badgeList: data.badgeList
        }

        return `
            <a href="javascript:void(0);" class="item" data-idx="` + data.idx + `" data-contents-idx="` + data.contentsIdx + `" data-episode-idx="` + data.episodeIdx + `" onclick="selectContent(this, '` + encodeURI(JSON.stringify(bottomSheetData)) + `');">
                <figure>
                    <div class="img_wrap">
                        <img src="` + data.contentHeightImgList[0].url + `" alt=""/>
                    </div>
                    <figcaption>
                        <div class="info_wrap">
                            <span class="genre Text-xs">` + data.category + `</span>
                            <div class=" flex w-full items-end d-inline-flex">
                                ` + badge.title + `
                                <h5 class="title Title-lg">` + data.contentsTitle + `</h5>
                            </div>
                            <div class="bottom_wrap">
                                ` + date + `
                                ` + episodeTitle + `
                            </div>
                        </div>
                        <div class="btn_wrap">
                            ` + continueBtn + `
                            <svg class="" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 9.75L8.16327 14L16 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </figcaption>
                </figure>
            </a>
        `;
    }

    // 작품 선택
    let selectContent = function (_this, bottomSheetData) {
        let contentsIdx = $(_this).data("contents-idx");

        // 삭제 중
        if ($(".lib_container").hasClass("edit")) {
            // 편집 - 삭제
            if ($(_this).find('svg').hasClass("active")) {
                $(_this).find('svg').removeClass("active");
            } else {
                $(_this).find('svg').addClass("active");
            }

            // 전체 선택 체크 여부
            if ($(".lib_container .tab_content a.item").find('svg').length == $(".lib_container .tab_content a.item").find('svg.active').length) {
                $(".lib_content > .edit_top #select_all").prop("checked", true);
            } else {
                $(".lib_content > .edit_top #select_all").prop("checked", false);
            }
        } else {
            if (params.get('searchType') == 'favorite') {
                movePage.episode(contentsIdx);

                // 이어보기
            } else {
                // 바텀 시트 펼치기
                if ($("#lib_bottom_container").hasClass("active") == false) {
                    myLibBottom(bottomSheetData);

                    // 바텀 시트 숨기기
                } else {
                    $("#lib_bottom_container").animate({ bottom: -500 }, 'fast', function () {
                        $("#lib_bottom_container").removeClass("active");
                    });
                }
            }
        }
        return false;
    }

    // 전체 선택
    $(".lib_content > .edit_top #select_all").on('click', () => {
        if ($(".lib_content > .edit_top #select_all").is(":checked")) {
            $(".lib_container .tab_content a.item").find('svg').addClass("active");
        } else {
            $(".lib_container .tab_content a.item").find('svg').removeClass("active");
        }
    })

    // 내서재 편집
    $(".lib_content > .lib_tab_top > button").on('click', function () {
        // 구매 레이어 닫기
        $("#lib_bottom_container").removeClass("active");
        // 체크 초기화
        $(".lib_content > .edit_top #select_all").prop("checked", false);
        $(".lib_container .tab_content a.item svg").removeClass("active")

        // 편집 버튼
        $(this).removeClass("active").siblings("button").addClass("active");
        if (this.id === "edit") {
            $(".lib_container").addClass("edit");
        } else if (this.id === "complete") {
            $(".lib_container").removeClass("edit");
        }
    })

    // 작품 검색
    $(".lib_top input[name=librarySearch]").keyup(function (key) {
        libraryParams.set(params, 'searchWord', $(".lib_top input[name=librarySearch]").val());
        libraryParams.set(params, 'page', 1);
        libraryParams.set(params, 'recordSize', 30);

        // 엔터키를 눌러 검색을 했거나 검색어를 모두 지운 경우
        if (key.keyCode == 13 || $(".lib_top input[name=librarySearch]").val() == "") {
            // 내 꿀단지 리스트 재호출
            library.list(params.get('searchType'));
        }
    })

    // 뒤로 가기
    $("#myLib").children("button").on('click', () => {
        history.back();
    })
</script>