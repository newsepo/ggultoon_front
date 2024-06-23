<script>
    // history.back 으로 이동된 경우 이전페이지로 이동
    window.addEventListener('pageshow', (event) => {
        if (event.persisted) {
            history.back();
        }
    });
    $(document).ready(function () {
        // 구매 알림 확인
        memberSetting();
        // 회차 뷰어
        episode.viewer();
    });

    /* 전역 변수 */
    let categoryIdx;
    let contentsIdx = { HTML.contentsIdx }; // 작품 idx
    let episodeIdx = { HTML.episodeIdx }; // 회차 idx
    let params = new Map();

    let episodeImgList = {};
    let thisEpisodeIndex = contentsIdx.toString() + episodeIdx.toString();

    let continueMode = localStorage.getItem('coimcMode' + thisEpisodeIndex)
    if (!continueMode) {
        continueMode = document.querySelector('#direction').classList.contains('column') ? 'row' : 'column';
        localStorage.setItem('coimcMode' + thisEpisodeIndex, continueMode);
    }

    let basicBottom = '';
    let nextEpisodeBox;

    /* 전역 변수 기본값 세팅 */
    episodeParams.default(params);

    function ChangeComicMode(conditional) {
        const contentBottom = document.querySelector('.content_bottom');
        if(contentBottom!==null){
            contentBottom.remove();
        }
      
        $(".viewer_img").empty(); // viewer_img 영역 비우기

        // 로컬스토리지 수정을 위한 함수
        function localComicPush(name, value) {
            localStorage.setItem(name, value);
        }

        // 카테고리 세팅
        let category = "";
        if (categoryIdx == 1) { // 웹툰
            category = ".webtoon";
        } else if (categoryIdx == 2) { // 만화
            category = ".comic";

        } else if (categoryIdx == 3) { // 소설
            category = ".novel";
        }

        if (conditional) {
            // 세로보기 시 있던 스크롤이벤트 제거
            $(window).off('scroll');

            // top 버튼
            $('.viewer_img').css('paddingTop', '50px');
            $('#scroll_top').hide();

            $(category).stop().fadeOut("slow");
            $('.viewer_bottom').stop().fadeOut("slow");

            // 가로 슬라이드 셋팅
            let rowViewerBody = `<div class="swiper row-viewer-slide"> <div class="swiper-wrapper">`;
            rowViewerBody += `<div class="swiper-slide"><img src="/assets/images/kr/contents/pre_view_noti.png" alt=""></div>`; // 꿀툰 기본 이미지
            if (episodeImgList.length > 0) {
                $.each(episodeImgList, function (index, el) {
                    rowViewerBody += `<div class="swiper-slide"><div id="img_slide_`+ index +`" class="img_slide"><img src="` + el.url + `" loading="lazy"></div></div>`;
                });
            }
            rowViewerBody += `</div><div class="swiper-button-next"></div><div class="swiper-button-prev"></div></div>`;
            $(".viewer_img").html(rowViewerBody);

            // 가로보기 스와이퍼 슬라이드
            let rowViewerSwiper = new Swiper(".row-viewer-slide", {
                initialSlide: localStorage.getItem(thisEpisodeIndex),
                lazyPreloadPrevNext: 5,
                allowTouchMove: true,
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                on:{
                    slideChange: function() {
                        // 마지막 슬라이드에 도달했을 때
                        if (this.activeIndex == this.slides.length - 1) {
                            let currentSlideIdx = this.activeIndex - 1;

                            // 기존 영역 비우기
                            $("#img_slide_" + currentSlideIdx).find(".content_bottom").remove();

                            // 다음 회차 정보 세팅
                            let bottomBody = `<div class="content_bottom"><div class="next_wrap"></div></div>`;
                            $("#img_slide_" + currentSlideIdx).append(bottomBody);
                            $("#img_slide_" + currentSlideIdx).children(".content_bottom").children(".next_wrap").append(nextEpisodeBox);
                        }
                    }
                }
            });

            // 현재 active되어있는 슬라이드 번호 체크후 세션스토리지 수정
            rowViewerSwiper.on('slideChange', function () {
                localComicPush(thisEpisodeIndex, rowViewerSwiper.realIndex);
            });

            // 뷰어 화면 클릭 시 헤더 및 바텀 노출 OR 숨김 처리
            $('.swiper-slide').click(function () {
                $(category).stop().fadeToggle("slow");
                $('.viewer_bottom').stop().fadeToggle("slow");
            });

        } else {
            $('.row-new-bottom').remove();
            // top 버튼
            $('.viewer_img').css('paddingTop', '120px');
            $('#scroll_top').show();

            // 세로 이미지 셋팅
            let columnViewerBody = `<img src="/assets/images/kr/contents/pre_view_noti.png" class="first-img" alt="">`; // 꿀툰 기본 이미지
            if (episodeImgList.length > 0) {
                $.each(episodeImgList, function (index, el) {
                    columnViewerBody += `<img src="` + el.url + `" loading="lazy">`;
                });
            };
            $(".viewer_img").html(columnViewerBody);


            let columnCurrentImgList = document.querySelectorAll('.viewer_img img');
            let imgLength = columnCurrentImgList.length - 1;
            let getSessionData = localStorage.getItem(thisEpisodeIndex);
            let columnCurrentImg = 0;

            $(".viewer_img img").eq(imgLength).on("load", function () {
                for (let i = 1; i < getSessionData; i++) {
                    columnCurrentImg += columnCurrentImgList[i].offsetHeight;
                }
                columnCurrentImg += columnCurrentImgList[0].offsetHeight;

                window.scrollTo({ left: 0, top: columnCurrentImg });
            });

            let viewerWrap = true;
            $(window).scroll(function () {
                let changeIndex = 0;
                let imgHeight = 0;
                let scrollLocation = document.documentElement.scrollTop;
                let getSessionData = localStorage.getItem(thisEpisodeIndex);
                let columnViewerWrap = document.querySelector('.viewer_img');
                let columnCurrentImgList = document.querySelectorAll('.viewer_img img');

                for (let i = 0; i < columnCurrentImgList.length; i++) {
                    imgHeight += columnCurrentImgList[i].offsetHeight;
                    if (scrollLocation <= imgHeight) {
                        changeIndex = i + 1;
                        break;
                    }
                }
                localComicPush(thisEpisodeIndex, changeIndex);

                if(columnViewerWrap.offsetHeight * 0.8 < scrollLocation && viewerWrap){
                    $(".viewer_img").after(basicBottom);
                    //episode.curationList(6);
                    viewerWrap = false;
                }
            });

            $('.first-img, .first-img ~ img').click(function () {
                $(category).stop().fadeToggle("slow");
                $('.viewer_bottom').stop().fadeToggle("slow");
            });
        }
    }

    // 초기 진입 시 원래 보던 보기모드를 가져와서 조건에 따라 direction에 column포함
    if (continueMode == 'column') {
        document.querySelector('#direction').classList.add('column');
    } else {
        document.querySelector('#direction').classList = '';
    }

    document.querySelector('#direction').addEventListener('click', function () {
        let directionClick = document.querySelector('#direction').classList.contains('column');

        ChangeComicMode(directionClick);

        let storwertest = localStorage.getItem('coimcMode' + thisEpisodeIndex)

        if (storwertest == 'column') {
            localStorage.setItem('coimcMode' + thisEpisodeIndex, 'row');
        } else {
            localStorage.setItem('coimcMode' + thisEpisodeIndex, 'column');
        }
    });

    let episode = {
        // 회차 뷰어 하단 큐레이션 리스트
        // curationList: function (type) {
        //
        //     // 회원 성인 여부 상태값 조회
        //     let pavilionIdx = setPavilionIdx();
        //
        //     $.ajax({
        //         url: '{ C.API_DOMAIN }/v1/contents/curation?type=' + type + '&pavilionIdx=' + pavilionIdx,
        //         cache : true,
        //         method: 'GET',
        //         dataType: 'json',
        //         processData: false,
        //         contentType: false,
        //         xhrFields: {
        //             withCredentials: true
        //         },
        //         beforeSend: function(){
        //             let skeletonBox = '<div class="skeleton-box style01"></div>'
        //             let skeletonList = '<div class="skeleton-list"><div class="img-box"></div><div class="title-box"></div><div class="info-box"></div></div>'
        //
        //             $('.curation').append(skeletonBox);
        //             for(let i=0; i<7; i++){
        //                 $('.curation .skeleton-box').append(skeletonList);
        //             }
        //         },
        //         success: function (res) {
        //             if (res.result) {
        //                 $(".curation").empty();
        //                 if (res.data.curationList.length > 0) {
        //                     $.each(res.data.curationList, function (index, el) {
        //                         // 큐레이션 영역 세팅
        //                         let curationBody = "";
        //                         if (el.contentList.length > 0) { // 큐레이션에 배정된 작품이 있을 경우에만
        //                             curationBody = `
        //                             <h4>`+ el.curationTitle +`</h4>
        //                             <div class="swiper curationSwiper">
        //                                 <div class="swiper-wrapper curation_wrap" id="curation_`+ (parseInt(index) + 1) +`"></div>
        //                             </div>
        //                         `;
        //                         }
        //                         $(".curation").append(curationBody);
        //
        //                         // 큐레이션별 작품 리스트 세팅
        //                         let contentBody = "";
        //                         $.each(el.contentList, function (idx, item) {
        //                             contentBody += `
        //                             <div class="swiper-slide">
        //                               <a href="javascript:movePage.episode(` + item.contentsIdx + `);" class="items">
        //                                 <figure>
        //                                   <div class="img_wrap">
        //                                     <img src="`+ item.contentHeightImgList[0].url +`" alt="">
        //                                   </div>
        //                                   <figcaption>
        //                                     <p class="Text-xs">
        //                                       <span class="info_title Subtitle-md">`+ item.title +`</span>
        //                                       <span class="sub_info">
        //                                         <b class="episodeNum">`+ item.lastEpisodeNumber + `</b>
        //                                         <b>·</b>
        //                                         <b class="writer">`+ item.writerList[0].name +`</b>
        //                                       </span>
        //                                     </p>
        //                                   </figcaption>
        //                                 </figure>
        //                               </a>
        //                             </div>
        //                         `;
        //                         });
        //                         $("#curation_" + (parseInt(index) + 1)).html(contentBody);
        //
        //                         /* 큐레이션 스와이프 */
        //                         let curationSwiper = new Swiper('.curationSwiper', {
        //                             direction: 'horizontal',
        //                             loop: false,
        //                             slidesPerView: 'auto',
        //                             spaceBetween: 6,
        //                             freeMode: true,
        //                             loopAdditionalSlides: 1,
        //                             slidesOffsetAfter: 60,
        //                             observer: true,
        //                             observeParents: true
        //                         });
        //                     });
        //                 }
        //             } else {
        //                 // ajax exception error
        //                 // toast.alert(res.message);
        //             }
        //         },
        //         error: function (request, status, error) {
        //             // filter error
        //             toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
        //         },
        //         complete: function(){
        //             $('.curation .skeleton-box').remove();
        //         }
        //     });
        //     return false;
        // },
        // 회차 뷰어
        viewer: function () {
            $.ajax({
                url: '{ C.API_DOMAIN }/v1/episodes/' + episodeIdx,
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

                        // 구매 유형 정보 세팅
                        if (res.data.sellType == '1') { // 데여 & 소장 가능

                            // 대여 탭 활성화 상태
                            if (local.sellTypeTab().tab == 'rent') {
                                episodeParams.set(params, 'searchType', 'rent');

                                // 소장 탭 활성화 상태
                            } else if (local.sellTypeTab().tab == 'have') {
                                episodeParams.set(params, 'searchType', 'have');
                            }

                        } else if (res.data.sellType == '2') { // 소장만 가능
                            episodeParams.set(params, 'searchType', 'have');

                        } else if (res.data.sellType == '3') { // 대여만 가능
                            episodeParams.set(params, 'searchType', 'rent');
                        }

                        // 카테고리별 뷰어 영역 세팅
                        categoryIdx = res.data.categoryCode;
                        episode.setViewerArea();

                        // 뷰어 헤더 회차 제목 세팅
                        $(".content_title").html(res.data.episodeTitle);

                        // 뷰어 이미지 세팅
                        let viewerBody = `<img src="/assets/images/kr/contents/pre_view_noti.png" alt="">`; // 꿀툰 기본 이미지
                        if (res.data.imgList.length > 0) {
                            episodeImgList = res.data.imgList;
                            $.each(res.data.imgList, function (index, el) {
                                // 소설
                                if (res.data.categoryCode == 3) {
                                    viewerBody += el.url;

                                    // 웹툰, 만화
                                } else if (res.data.categoryCode == 1 || res.data.categoryCode == 2) {
                                    viewerBody += `<img src="` + el.url + `" loading="lazy">`;
                                }
                            });
                        }
                        $(".viewer_img").html(viewerBody);

                        // 뷰어 푸터 댓글 수 세팅
                        $(".reple_count").html(res.data.commentCnt);

                        // 뷰어 푸터 이전 회차 이동 버튼 세팅
                        if (!jQuery.isEmptyObject(res.data.prevEpisodeInfo)) {
                            $("#pre").addClass("active");
                            $("#pre").val(res.data.prevEpisodeInfo.idx);
                        }

                        // 뷰어 푸터 다음 회차 이동 버튼 세팅
                        if (!jQuery.isEmptyObject(res.data.nextEpisodeInfo)) {
                            $("#next").addClass("active");
                            $("#next").val(res.data.nextEpisodeInfo.idx);

                            // 다음 회차 안내 박스 텍스트 세팅
                            let viewText = episode.setNextEpisodeBox(res.data.nextEpisodeInfo);

                            // 다음 회차 안내 박스 세팅
                            nextEpisodeBox = `
                              <figure  onclick="$('#next').click()">
                                <div class="img_wrap">
                                  <img src="`+ res.data.nextEpisodeInfo.episodeImg + `" alt="">
                                </div>
                                <figcaption>
                                  <div class="info">
                                    <p>
                                      <span class="Text-lg">다음회차</span>
                                      <span class="Text-lg">`+ res.data.nextEpisodeInfo.episodeTitle + `</span>
                                    </p>
                                    <span class="Text-sm">`+ viewText + `</span>
                                  </div>
                                  <button>
                                    <svg class="rotate-180" width="10" height="18" viewBox="0 0 10 18" fill="none"
                                      xmlns="http://www.w3.org/2000/svg">
                                      <path d="M9 1L1 9L9 17" stroke="#222222" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                      </path>
                                    </svg>
                                  </button>
                                </figcaption>
                              </figure>
                        `;
                            $(".next_wrap").html(nextEpisodeBox);
                            $(".next_wrap").val(res.data.nextEpisodeInfo.idx);

                        } else { // 다음 회차가 없을 경우
                            $(".next_wrap").hide();
                        }
                        // 회차리스트 세팅
                        episode.episodeList();

                        // 큐레이션 세팅
                        const contentBottom = document.querySelector('.content_bottom');
                        basicBottom = contentBottom.cloneNode(true); // 큐레이션 클론
                  
                        // 기본 세팅
                        importJs.setting();

                        // 이어보기 시 스크롤 위치와 모드 기억
                        if (res.data.categoryCode == 1 || res.data.categoryCode == 2) {
                            let initialMode = localStorage.getItem('coimcMode' + thisEpisodeIndex) !== 'column';
                            ChangeComicMode(initialMode);
                        }
                    } else {
                        // ajax exception error
                        toast.alert(res.message);
                        setTimeout("movePage.main();", 700);
                    }
                },
                error: function (request, status, error) {
                    // filter error
                    toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
                }
            });
            return false;
        },
        // 카테고리별 뷰어 영역 세팅
        setViewerArea() {
            // 뷰어 헤더 세팅
            if (categoryIdx == 1) { // 웹툰
                $(".viewer_header.webtoon").addClass("active");

            } else if (categoryIdx == 2) { // 만화
                $(".viewer_header.comic").addClass("active");

                // 만화 scroll indicator
                let comicIndicatorActive;
                document.querySelector('#direction').addEventListener('click', function () {
                    // 회차리스트 닫기
                    if ($(".viewer_header input[name=episode_list]").is(":checked")) {
                        $(".viewer_header input[name=episode_list]").prop("checked", false);
                    }

                    this.classList.toggle('column');

                    let comicIndicator = document.querySelector('.indicator_wrap');
                    comicIndicator.classList.add('active');

                    // direction버튼 다시 클릭 할 경우 기존에 실행 중이던 setInterval 함수 제거
                    clearInterval(comicIndicatorActive);

                    // 2초 뒤에 indicator_wrap에 active 클래스 제거
                    comicIndicatorActive = setInterval(function () {
                        comicIndicator.classList.remove('active');
                        clearInterval(comicIndicatorActive);
                    }, 2000);

                    if (this.classList.contains('column')) {
                        comicIndicator.id = 'vertical'
                    } else {
                        comicIndicator.id = 'horizontal'
                    }
                });
            } else if (categoryIdx == 3) { // 소설
                $(".viewer_header.novel").addClass("active");
                // 소설 setting_container
                $("#setting").on('click', function () {
                    // 회차리스트 닫기
                    if ($(".viewer_header input[name=episode_list]").is(":checked")) {
                        $(".viewer_header input[name=episode_list]").prop("checked", false);
                    }

                    if ($("#setting").is(':checked')) {
                        $('#setting_container').css('display', 'block');
                    } else {
                        $('#setting_container').css('display', 'none');
                    }
                });
            }
            // 뷰어 푸터 세팅
            $(".viewer_bottom").addClass("active");
        },
        // 다음 회차 안내 박스 텍스트 세팅
        setNextEpisodeBox(nextEpisodeInfo) {

            let viewText = "";
            if (nextEpisodeInfo.showViewer) {
                viewText = "무료 보기";
            } else {
                viewText = nextEpisodeInfo.episodeNumTitle + " 이어보기";
            }
            return viewText;
        },
        // 회차 리스트
        episodeList() {

            // params value
            let page = params.get("page");
            let recordSize = params.get("recordSize");
            let searchType = params.get("searchType");
            let type = params.get("type");

            $.ajax({
                url: '{ C.API_DOMAIN }/v1/contents/' + contentsIdx + '/episodes?page=' + page + '&recordSize=' + recordSize + '&searchType=' + searchType + '&type=' + type,
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
                        let episodeBody = "";
                        if (res.data.viewerEpisodeList.length > 0) {
                            $.each(res.data.viewerEpisodeList, function (index, el) {
                                let currentEpisode = '';
                                if (el.idx == episodeIdx) {
                                    currentEpisode = 'active';
                                }
                                episodeBody += '<a href="javascript:void(0);" class="episode Text-md ' + currentEpisode + '" data-value="' + el.idx + '">' + el.title + '</a>';
                            });

                            if (page < res.data.params.pagination.totalPageCount) {
                                // 스크롤
                                scrollFlag = true;
                            }
                        }

                        $(".viewer_header.active .list").append(episodeBody);

                    } else {
                        // ajax exception error
                        toast.alert(res.message);
                    }


                },
                error: function (request, status, error) {
                    // filter error
                    toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
                }
            });
            return false;
        },
    }



    // 뷰어 회차 리스트 스크롤 감지
    let scrollFlag = true;
    $(".viewer_header .list").on('scroll', function () {
        let bottomGap = 100;
        if ((this.scrollTop + this.clientHeight) >= (this.scrollHeight - bottomGap) && scrollFlag) {

            scrollFlag = false;
            params.page += 1;
            episodeParams.set(params, 'page', params.get('page') + 1)
            episode.episodeList();
        }
    })


    let importJs = {
        /*기본 세팅*/
        setting: function () {

            /*가로 보기*/
            $(".horizontal").click(function () {
                if ($(this).hasClass("active") == false) {
                    $(this).addClass("active");
                    $(".vertical").removeClass("active");
                }
            });

            /*세로 보기*/
            $(".vertical").click(function () {
                if ($(this).hasClass("active") == false) {
                    $(this).addClass("active");
                    $(".horizontal").removeClass("active");
                }
            });

            /*플러그인 커스텀*/
            if (categoryIdx == 3) { // categoryIdx 3 - 소설일때
                const novelViewer = document.querySelector('.viewer_img');

                // 로컬스토리지에서 값을 가져오거나 기본 값을 사용
                const novelStyle = local.novelViewerStyle() || {
                    'fontSize': '',
                    'letterSpacing': '',
                    'lineHeight': '',
                    'thema': 'white',
                    'fontWeight': '400'
                };

                // 처음 진입 시 로컬스토리지의 값을 가져와서 스타일을 적용
                novelViewer.style.fontSize = novelStyle.fontSize + 'px';
                novelViewer.style.letterSpacing = novelStyle.letterSpacing / 100 + 'px';
                novelViewer.style.lineHeight = novelStyle.lineHeight + '%';
                novelViewer.id = novelStyle.thema
                novelViewer.style.fontWeight = novelStyle.fontWeight;


                // novelStyle을 로컬스토리지에 저장(novelViewerStyle)
                localStorage.setItem('novelViewerStyle', JSON.stringify(novelStyle));

                // setting_container에서 수정한 값으로 로컬스토리지 데이터 수정
                function localNovelPush(styleProperty, value) {
                    let getLocalData = local.novelViewerStyle();
                    getLocalData[styleProperty] = value;
                    localStorage.setItem('novelViewerStyle', JSON.stringify(getLocalData));

                    let currentNovelStyle = local.novelViewerStyle();

                    // 소설뷰어 변경된 값으로 스타일 수정
                    novelViewer.style.fontSize = currentNovelStyle.fontSize + 'px';
                    novelViewer.style.letterSpacing = currentNovelStyle.letterSpacing / 100 + 'px';
                    novelViewer.style.lineHeight = currentNovelStyle.lineHeight + '%';
                    novelViewer.id = currentNovelStyle.thema
                    novelViewer.style.fontWeight = currentNovelStyle.fontWeight;
                }

                // 소설뷰어의 기본값 font-size: 16px; letter-spacing:-0.2px; line-hegiht:165%; font-weight: 400; thema = basic
                // font-size 글자크기
                $("#slider-range-min.size").slider({
                    range: "min",
                    value: parseInt(novelStyle.fontSize) || 16,
                    min: 10,
                    max: 30,
                    animate: "fast",
                    slide: function (event, ui) {
                        novelStyle.fontSize = ui.value
                        localNovelPush('fontSize', ui.value)
                    }
                });

                // letter-spacing 글자간격
                $("#slider-range-min.space").slider({
                    range: "min",
                    value: parseInt(novelStyle.letterSpacing) || 20,
                    min: -20,
                    max: 50,
                    animate: "fast",
                    slide: function (event, ui) {
                        novelStyle.letterSpacing = ui.value
                        localNovelPush('letterSpacing', ui.value)
                    }
                });

                // line-height 줄간격
                $("#slider-range-min.line_space").slider({
                    range: "min",
                    value: parseInt(novelStyle.lineHeight) || 165,
                    min: 100,
                    max: 300,
                    animate: "fast",
                    slide: function (event, ui) {
                        novelStyle.lineHeight = ui.value
                        localNovelPush('lineHeight', ui.value)
                    }
                });

                // 소설뷰어테마
                let basicThema = novelStyle.thema;
                let initialThema = document.querySelector('button.theme[data-thema="' + basicThema + '"]');
                initialThema.classList.add('active');

                let themaButton = document.querySelectorAll('button.theme');
                for (let i = 0; i < themaButton.length; i++) {
                    themaButton[i].addEventListener('click', function () {
                        let thisThema = themaButton[i].dataset.thema;
                        localNovelPush('thema', thisThema);
                    })
                }

                // 소설뷰어 기타 - 굵은글자
                let btnFontWeight = document.querySelector('#bold_text');

                let basicWeight = novelStyle.fontWeight;
                if (basicWeight == '400') {
                    btnFontWeight.checked = false;
                } else if (basicWeight == '600') {
                    btnFontWeight.checked = true;
                }

                btnFontWeight.addEventListener('click', function () {
                    if (btnFontWeight.checked) {
                        localNovelPush('fontWeight', 600);
                    } else {
                        localNovelPush('fontWeight', 400);
                    }
                });

                // 소설뷰어 - 초기화버튼
                // 초기값 설정
                const initialStyle = {
                    'fontSize': '16',
                    'letterSpacing': '20',
                    'lineHeight': '165',
                    'thema': 'white',
                    'fontWeight': '400'
                };

                const resetButton = document.querySelector('#reset');
                resetButton.addEventListener('click', function () {
                    // 로컬스토리지에 초기값 저장
                    localStorage.setItem('novelViewerStyle', JSON.stringify(initialStyle));

                    // 스타일 초기값으로 되돌리기
                    novelViewer.style.fontSize = initialStyle.fontSize + 'px';
                    novelViewer.style.letterSpacing = initialStyle.letterSpacing / 100 + 'px';
                    novelViewer.style.lineHeight = initialStyle.lineHeight + '%';
                    novelViewer.id = initialStyle.thema
                    novelViewer.style.fontWeight = initialStyle.fontWeight;

                    // 슬라이더 값 초기값으로 되돌리기
                    $("#slider-range-min.size").slider("value", initialStyle.fontSize);
                    $("#slider-range-min.space").slider("value", initialStyle.letterSpacing);
                    $("#slider-range-min.line_space").slider("value", initialStyle.lineHeight);

                    // 테마 버튼 초기값으로 되돌리기
                    for (let i = 0; i < themaButton.length; i++) {
                        if (themaButton[i].dataset.thema === initialStyle.thema) {
                            themaButton[i].classList.add('active');
                        } else {
                            themaButton[i].classList.remove('active');
                        }
                    }

                    // 굵은 글자 버튼 초기값으로 되돌리기
                    btnFontWeight.checked = initialStyle.fontWeight === '600';
                });

                /*테마 토글*/
                $(".theme").click(function () {
                    $(".theme").removeClass("active");
                    $(this).addClass("active");
                });
            }

            /*뒤로 가기*/
            $(".viewer_back").click(function () {
                history.back();
            })

            /*댓글 더보기 페이지로 이동*/
            let show = false;
            $("input:checkbox[id='reple_wrap']").off().on("change", function () {
                if ($(this).is(":checked")) {

                    // 회원 정보 조회
                    let memberInfo = local.memberInfo();
                    if (memberInfo == null) { // 비로그인
                        toast.alert("로그인 후 이용해주세요");
                        movePage.login();

                    } else { // 로그인
                        // 닉네임 체크
                        if (memberInfo.data.nick == "") { // 닉네임 없음
                            if (show == false) {
                                $("#nickname_sheet_container").animate({ bottom: 0 }, 'fast');
                                show = true;
                                $("#reple_wrap").prop("checked", true);
                            } else {
                                $("#nickname_sheet_container").animate({ bottom: -300 }, 'fast');
                                show = false;
                                $("#reple_wrap").prop("checked", false);
                            }
                        } else { // 닉네임 있음
                            // 댓글 페이지로 이동
                            movePage.episodeComment(contentsIdx, episodeIdx);
                        }
                    }
                }
            });

            /*닉네임 시트 영역 밖 클릭 시 시트 접기*/
            $("html").click(function (e) {
                if ($(e.target).parents("#nickname_sheet_container").length < 1) {
                    if (show) {
                        $("#nickname_sheet_container").animate({ bottom: -300 }, 'fast');
                        show = false;
                        $("#reple_wrap").prop("checked", false);
                    }
                }
            });

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
                    episode.checkNick(nick);
                }
            })

            /*닉네임 등록*/
            $("#submit").click(function () {
                // 입력받은 닉네임
                let nick = $(".nickname_wrap").children('input').val().replace(/ /g, "");

                // 닉네임 저장
                episode.registerNick(nick);
            })

            /*이전 회차 이동 버튼으로 회차 이동*/
            $("#pre").click(function () {

                // 이전 회차가 있을 경우
                if ($("#pre").hasClass("active")) {

                    // 이전 회차 idx
                    let prevIdx = $(this).val();

                    // 이전 회차 뷰어 호출 여부 판단
                    episodeInfoCheck(contentsIdx, prevIdx, params.get('searchType'));
                }
            })

            /*다음 회차 이동 버튼으로 회차 이동*/
            $("#next").click(function () {

                // 다음 회차가 있을 경우
                if ($("#next").hasClass("active")) {

                    // 다음 회차 idx
                    let nextIdx = $(this).val();

                    // 다음 회차 뷰어 호출 여부 판단
                    episodeInfoCheck(contentsIdx, nextIdx, params.get('searchType'));
                }
            })

            /*뷰어 하단의 다음 회차 이동*/
            $(".next_wrap").click(function () {

                // 다음 회차 idx
                let nextIdx = $(this).val();

                // 다음 회차 뷰어 호출 여부 판단
                episodeInfoCheck(contentsIdx, nextIdx, params.get('searchType'));
            })

            /*스크롤 탑 버튼 이벤트*/
            $("#scroll_top").click(function () {
                $('html, body').animate({
                    scrollTop: 0
                }, 10);
            });

            /*스크롤 위치 감지*/
            let lastScroll = 0;

            // 카테고리 세팅
            let category = "";
            if (categoryIdx == 1) { // 웹툰
                category = ".webtoon";
            } else if (categoryIdx == 2) { // 만화
                category = ".comic";

            } else if (categoryIdx == 3) { // 소설
                category = ".novel";
            }

            $(window).scroll(function () {
                // 폰트 셋팅중 스크를 감지 중지
                if (document.querySelector('#setting_container').style.display == 'block') {
                    return false;
                }

                // 현재 스크롤 위치
                let scrollTop = $(this).scrollTop();

                // 뷰어 이미지 영역이 끝나는 위치에 도달했을 때 -> 헤더 및 바텀 노출하기
                if (scrollTop >= ($(".viewer_img").height() - $(window).height())) {
                    $(category).filter(':not(:animated)').fadeIn("slow");
                    $('.viewer_bottom').filter(':not(:animated)').fadeIn("slow");
                } else {
                    // scroll down -> 헤더 및 바텀 숨기기
                    if (scrollTop >= lastScroll) {
                        $(category).filter(':not(:animated)').fadeOut("slow", function () {
                            $('#setting_container, input[class*="episode_list_"] + label .list').hide();
                            $('#setting, input[name="episode_list"]').prop("checked", false);
                        });
                        $(".viewer_bottom").filter(':not(:animated)').fadeOut("slow", function () {
                            $('#setting_container, input[class*="episode_list_"] + label .list').hide();
                            $('#setting, input[name="episode_list"]').prop("checked", false);
                        });

                        // scroll up -> 헤더 및 바텀 노출하기
                    } else {
                        $(category).filter(':not(:animated)').fadeIn("slow");
                        $('.viewer_bottom').filter(':not(:animated)').fadeIn("slow");
                    }
                    lastScroll = scrollTop;
                }
            });
        },
    }

    // 회차 리스트 버튼
    $(".viewer_header input[name=episode_list]").on("click", function () {
        if ($(".viewer_header input[id=setting]").is(":checked")) {
            $(".viewer_header input[id=setting]").prop("checked", false);
            $('#setting_container').css('display', 'none');
        }

        if ($(this).is(":checked")) {
            const element = document.querySelector(".list .episode.active");
            element.scrollIntoView({ block: "center" });
        }
    })

    // 뷰어 회차 리스트 선택
    $(document).on('click', ".viewer_header .list > .episode", function () {
        // 현재 보고 있는 회차가 아닐 때만 이동
        if ($(this).hasClass("active") == false) {
            // 선택한 회차 idx
            let selectedIdx = $(this).data('value');
            episodeInfoCheck(contentsIdx, selectedIdx, params.get('searchType'));
        }
    })

</script>