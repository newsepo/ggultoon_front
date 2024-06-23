<?php
/*
[큐레이션 노출 정책]
- 현재) 선택한 토글 상태값에 따라 노출
- 변경 예정) 회차리스트 & 회차 뷰어 페이지에 한해서 작품 기준 판단(API 수정 필요)
    (1) 해당 작품이 일반작 -> 일반 큐레이션
    (2) 해당 작품이 성인작 -> 일반+성인 큐레이션
*/
?>

<style>
    .curation {
        position: relative;
        width: 100%;
        box-sizing: border-box;
        padding-left: 1rem;
        overflow: hidden;
    }

    .curation > div {
        width: 100%;
    }

    .curation h4 {
        display: block;
        width: 100%;
        font-family: "NanumSquareNeo";
        font-size: 1rem;
        line-height: 120%;
        letter-spacing: -0.5px;
        font-weight: 800;
        text-align: left;
        padding-bottom: 10px;
    }

    .curation .swiper {
        margin-bottom: 40px;
        z-index: 10;
    }

    .curation .swiper .swiper-wrapper .swiper-slide {
        width: fit-content;
        padding-right: 6px;
    }

    .curation .swiper .swiper-notification {
        display: none;
    }

    /* 큐레이션 item*/
    .curation_wrap {
        width: 100%;
        min-height: 195px;
    }

    .curation_wrap .items {
        display: block;
        position: relative;
        width: 100%;
        max-width: 104px;
        height: 100%;
    }

    .curation_wrap figure {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
        width: 100%;
        max-width: 104px;
        gap: 0.5rem;
        padding: 0rem !important;
    }

    .curation_wrap figure > .img_wrap {
        display: block;
        width: 104px;
        aspect-ratio: 0.666667 / 1;
        box-sizing: border-box;
        border-radius: 3px 10px 10px 3px;
        overflow: hidden;
    }

    .curation_wrap figure > .img_wrap img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition-duration: 0.15s;
        transition-timing-function: ease-in-out;
    }

    .curation_wrap figure:hover > .img_wrap img {
        transform: scale(1.1);
    }

    .curation_wrap figure figcaption {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
        gap: 0.5rem;
        width: 100%;
        color: var(--text-333);
        padding: 0rem !important;
        }

    .curation_wrap figure figcaption p {
        margin-bottom: 0px;
        width: 100%;
    }

    .curation_wrap figure figcaption span {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        gap: 2px;
        width: 100%;
        overflow: hidden;
    }

    .curation_wrap figure figcaption p span.info_title,
    .curation_wrap figure figcaption p span.sub_info {
        display: -webkit-box;
        width: 100%;
        white-space: normal;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .curation_wrap figure figcaption span.sub_info {
        color: var(--text-primary);
    }

    .curation_wrap figure figcaption span.sub_info b {
        display: inline-block;
        width: fit-content;
        font-weight: normal;
    }

    .curation_wrap figure figcaption span.sub_info b:nth-of-type(2) {
        box-sizing: border-box;
    }


    /*  아이템 내부 이미지 상단 뱃지 */
    .curation_wrap > div .items .top_badge {
        position: absolute;
        top: 0px;
        left: 0px;
        z-index: 100;
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        box-sizing: border-box;
        padding: 4px;
    }

    .curation_wrap > div .items.ranking .top_badge {
        width: 80px;
        left: 20px;
        top: 0px;
    }

    .curation_wrap > div .items .top_badge .left_top > svg {
        display: none;
    }

    .curation_wrap > div .items .top_badge .left_top > svg.active {
        display: block;
    }
</style>

<div class="curation" name="curation_top"></div>
<!-- 서브 배너 -->
{ #subBanner }
<div class="curation" name="curation_bottom"></div>

<script>
    /* 큐레이션 전역 변수 */
    var curationArr = new Array(); // 큐레이션 담을 배열
    var curationFlag = true;       // 큐레이션 세팅 여부 체크
    var curationType = 1;          // 큐레이션 노출 영역

    /* 큐레이션 작품 세팅 */
    var curation = {
        curationSwiper: null,
        setting: function (type) {

            // set param
            curationType = type;

            // 큐레이션 배열 비우기
            curationArr.length = 0;

            // 기존 큐레이션 영역 비우기
            $(".curation").empty();

            // 서브 배너 숨김
            $("#subBannerSwiperContainer").hide();

            // 토글 상태값 조회
            let pavilionIdx = setPavilionIdx();

            $.ajax({
                url: '{ C.API_DOMAIN }/v1/contents/curation?type=' + type + '&pavilionIdx=' + pavilionIdx,
                cache: true,
                method: 'GET',
                dataType: 'json',
                processData: false,
                contentType: false,
                async: true,
                xhrFields: {
                    withCredentials: true
                },
                beforeSend: function () {
                    // 실제 큐레이션이 호출되었을 때만 스켈레톤 UI 세팅되도록 조건 추가
                    if (type != null) {
                        let curationBox = document.querySelectorAll('.curation');
                        for(let i =0; i<curationBox.length; i++){
                            curationBox[i].style.minHeight = '230px';
                        }

                        let skeletonBox = '<div class="skeleton-box style01" style="position:absolute; padding-top: 28px;"></div>'
                        let skeletonList = '<div class="skeleton-list"><div class="img-box"></div><div class="title-box"></div><div class="info-box"></div></div>'

                        $('.curation[name="curation_top"]').append(skeletonBox);
                        for (let i = 0; i < 7; i++) {
                            $('.curation[name="curation_top"] .skeleton-box').append(skeletonList);
                        }

                        $('.curation[name="curation_bottom"]').append(skeletonBox);
                        $('.curation[name="curation_bottom"] .skeleton-box').css('marginTop', '24px');
                        for (let i = 0; i < 7; i++) {
                            $('.curation[name="curation_bottom"] .skeleton-box').append(skeletonList);
                        }
                    }
                },
                success: function (res) {
                    if (res.result) {
                        let curationBody = "";
                        if (res.data.curationList.length > 0) {
                            $.each(res.data.curationList, function (index, el) {

                                // 큐레이션 작품 리스트 세팅
                                let contentBody = "";
                                if (el.contentList.length > 0) {
                                    $.each(el.contentList, function (idx, item) {

                                        // 배지 세팅
                                        let badge = badgeSvg(item.badgeList);

                                        contentBody += `
                                            <div class="swiper-slide">
                                              <a href="javascript:movePage.episode(` + item.contentsIdx + `);" class="items">
                                                  <div class="top_badge">
                                                        <div class="left_top">
                                                            ` + badge.thumbnailTopLeft.ranking + `
                                                        </div>
                                                        ` + badge.thumbnailTopRight + `
                                                    </div>
                                                <figure>
                                                  <div class="img_wrap">
                                                    <img src="` + item.contentHeightImgList[0].url + `" alt=""  width="105" height="155" loading="lazy">
                                                  </div>
                                                  <figcaption>
                                                    <p class="Text-xs">
                                                      <span class="info_title Subtitle-md">
                                                        ${badge.title.toString()}
                                                        ${item.title.toString()}
                                                      </span>
                                                      <span class="sub_info">
                                                        <b class="episodeNum">` + item.lastEpisodeNumber + `</b>
                                                        <b>·</b>
                                                        <b class="writer">` + item.writerList[0].name + `</b>
                                                      </span>
                                                      <span>${badge.bottom.toString()}</span>
                                                    </p>
                                                  </figcaption>
                                                </figure>
                                              </a>
                                            </div>
                                        `;
                                    });
                                }
                                // 큐레이션 그룹 리스트 세팅
                                curationBody = `
                                    <h4>` + el.curationTitle + `</h4>
                                    <div class="swiper curation-swiper">
                                        <div class="swiper-wrapper curation_wrap">
                                            ` + contentBody + `
                                        </div>
                                    </div>
                                `;
                                // 큐레이션 배열에 담기
                                let obj = {idx: parseInt(index) + 1, body: curationBody, show: false};
                                curationArr.push(obj);
                            });

                            // 최초 2줄 기본 세팅
                            if (curationArr != null && curationArr.length > 0) {
                                if (curationArr[0] != null && curationArr[0] != undefined) {
                                    curationArr[0].show = true;
                                    $("div[name='curation_top']").append(curationArr[0].body);
                                }
                                if (curationArr[1] != null && curationArr[1] != undefined) {
                                    curationArr[1].show = true;
                                    $("div[name='curation_top']").append(curationArr[1].body);
                                }
                            }

                            /* 큐레이션 스와이프 */
                            curation.curationSwiper = new Swiper('.curation-swiper', {
                                slidesPerView: 'auto',
                                freeMode: true,
                                slidesOffsetAfter: 16,
                                observer: true,
                                observeParents: true,
                                lazyPreloadPrevNext: 20
                            });

                            // 서브 배너 노출
                            $("#subBannerSwiperContainer").show();

                            // 큐레이션 하단에 세팅할 큐레이션이 없는 경우 -> 큐레이션 하단 영역 숨김 처리
                            if (res.data.curationList.length < 3) {
                                $("div[name='curation_bottom']").css('display', 'none');
                                curationFlag = false;
                            }

                            // 세팅할 큐레이션이 없는 경우 -> 큐레이션 전체 영역 숨김 처리
                        } else {
                            $("div[name='curation_top']").css('display', 'none');
                            $("div[name='curation_bottom']").css('display', 'none');
                            curationFlag = false;
                        }

                        // 스켈레톤 UI 지우기
                        $('.curation[name="curation_top"] .skeleton-box').fadeOut(300, function () {
                            $(this).remove();
                        });
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

    /* 스크롤 위치 감지 -> curation_bottom 영역에 큐레이션 2줄씩 세팅
    * 큐레이션 2줄 세팅(curation_top) -> 서브 배너 -> 나머지 큐레이션 세팅(curation_bottom)
    */
    $(window).scroll(function () {

        // 현재 스크롤 위치
        let current = Math.floor(($(window).scrollTop() / ($(document).height() - $(window).height())) * 100);

        // 스크롤 위치 감지
        if (current > 80 && curationFlag) {

            // 큐레이션 2줄 추가 세팅(curation_bottom)
            let nextIdx = 0;

            // 마지막으로 추가된 큐레이션 번호 체크
            curationArr.forEach(function (el, index) {
                if (el.show == true) {
                    nextIdx++;
                }
            });

            // 마지막으로 추가된 큐레이션 번호 + 1
            if (nextIdx < curationArr.length) {
                curationArr[nextIdx].show = true;
                $("div[name='curation_bottom']").append(curationArr[nextIdx].body);
            }

            // 마지막으로 추가된 큐레이션 번호 + 2
            if (nextIdx + 1 < curationArr.length) {
                curationArr[nextIdx + 1].show = true;
                $("div[name='curation_bottom']").append(curationArr[nextIdx + 1].body);
            }

            // 스켈레톤 UI 지우기
            $('.curation[name="curation_bottom"] .skeleton-box').fadeOut(300, function () {
                $(this).remove();
            });

            /* 큐레이션 스와이프 */
            curation.curationSwiper = new Swiper('.curation-swiper', {
                slidesPerView: 'auto',
                freeMode: true,
                slidesOffsetAfter: 16,
                observer: true,
                observeParents: true,
                lazyPreloadPrevNext: 20
            });
        }
    });
</script>