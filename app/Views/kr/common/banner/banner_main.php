<?php
/*
[배너 노출 정책]
- 선택한 토글 상태값에 따라 노출
*/
?>

<style>
    #mainBannerSwiperContainer {
        position: relative;
        min-height: 261px;
        overflow: hidden;
        padding: 0px;
    }

    @media screen and (max-width: 570px) {
        #mainBannerSwiperContainer {
            min-height: 46vw;
        }
    }

    .mainBannerSwiper {
        margin: 0;
        padding: 0;
        width: 100%;
        overflow:hidden;
    }

    .mainBannerSwiper .swiper-wrapper {
        width: 100%;
        transition-timing-function: linear;
    }

    .mainBannerSwiper .swiper-wrapper .swiper-slide {
        padding: 0 1rem;
    }

    .mainBannerSwiper .swiper-wrapper .swiper-slide a {
        display: block;
    }

    .mainBannerSwiper .swiper-wrapper .swiper-slide img {
        display: block;
        width: 100%;
        object-fit: cover;
    }

    @media screen and (max-width: 570px) {
        #mainBannerSwiperContainer {
            min-height: 45vw;
        }

        .mainBannerSwiper .swiper-wrapper .swiper-slide {
            padding: 0 1vw;
        }

    }
</style>

<!-- 메인 배너 -->
<div id="mainBannerSwiperContainer" class="swiper-container">
    <div class="mainBannerSwiper">
        <div class="swiper-wrapper">
        </div>
    </div>
</div>

<script>
    /* 전역 변수 */
    var mainBanner = {
        // 메인 배너 스와이프
        swiper: null,
        // 메인 배너
        setting: function (data) {

            // params value
            let type = data.get("type");
            let categoryIdx = data.get("categoryIdx");
            let genreIdx = data.get("genreIdx");
            let pavilionIdx = setPavilionIdx();

            if (type == null) {
                type = "";
            }
            if (categoryIdx == null) {
                categoryIdx = "";
            }
            if (genreIdx == null) {
                genreIdx = "";
            }
            if (pavilionIdx == 1) {
                pavilionIdx = 2;
            }

            $.ajax({
                url: '{ C.API_DOMAIN }/v1/banner?pavilionIdx=' + pavilionIdx + '&type=' + type + '&categoryIdx=' + categoryIdx + '&genreIdx=' + genreIdx,
                cache: true,
                method: 'GET',
                dataType: 'json',
                processData: false,
                contentType: false,
                xhrFields: {
                    withCredentials: true
                },
                beforeSend: function () {
                    let skeletonWrap = '<div class="skeleton-wrap" style="background:#fff;"></div>';
                    let skeletonBox = '<div class="skeleton-box style05"></div>';
                    let skeletonList = '<div class="skeleton-list"><div class="img-box"></div></div>';

                    $('#mainBannerSwiperContainer').append(skeletonWrap);
                    $('#mainBannerSwiperContainer .skeleton-wrap').append(skeletonBox);
                    $('#mainBannerSwiperContainer .skeleton-wrap .skeleton-box').append(skeletonList);
                },
                success: function (res) {
                    if (res.result) {
                        let listBody = "";
                        if (res.data.bannerList.length > 0) {
                            $.each(res.data.bannerList, function (index, el) {

                                // set params
                                let bannerMappingIdx = JSON.stringify(el.bannerMappingIdx);
                                let bannerLink = "'" + el.link + "'";

                                listBody += `
                                     <div class="swiper-slide">
                                        <a href="javascript:clickBanner(` + bannerMappingIdx + `,` + bannerLink + `);">
                                            <img src="` + el.url + `" alt=""/>
                                        </a>
                                    </div>
                                `;
                            });
                            // 배너 영역 세팅
                            $(".mainBannerSwiper .swiper-wrapper").html(listBody);
                            $('#mainBannerSwiperContainer').show();

                        } else {
                            // 배너 영역 숨기기
                            $('.mainBannerSwiper .swiper-wrapper').empty();
                            $('#mainBannerSwiperContainer').hide();
                        }

                        /*메인 배너 스와이프*/
                        mainBanner.swiper = new Swiper('.mainBannerSwiper', {
                            slidesPerView: 'auto',
                            initialSlide: 0,
                            centeredSlides: true,
                            loop: true,
                            loopedSlides: 1,
                            autoplay: {
                                delay: 2500,
                                disableOnInteraction: false
                            },
                            observer: true,
                            observeParents: true
                        });

                    }
                },
                error: function (request, status, error) {
                    // filter error
                    // toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
                },
                complete: function () {
                    // 스켈레톤 UI 지우기
                    $('#mainBannerSwiperContainer .skeleton-wrap').fadeOut(300, function () { $(this).remove() });
                }
            });
            return false;
        }
    }

    /* 배너 클릭 이벤트 */
    function clickBanner(bannerMappingIdx, bannerLink) {

        // 클릭한 배너 통계 집계
        $.ajax({
            url: '{ C.API_DOMAIN }/v1/banner/visit/' + bannerMappingIdx,
            cache : true,
            method: 'POST',
            processData: false,
            contentType: false,
            xhrFields: {
                withCredentials: true
            },
            success: function () {
                // 배너 링크가 있을 때만 페이지 이동
                if (bannerLink != "") {
                    window.location.href = bannerLink;
                }
            },
            error: function (request, status, error) {
                // filter error
                // toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
            }
        });
    }
</script>