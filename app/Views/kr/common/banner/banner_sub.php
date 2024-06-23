<?php
/*
[배너 노출 정책]
- 선택한 토글 상태값에 따라 노출
*/
?>

<style>
    #subBannerSwiperContainer {
        margin-bottom: 40px;
    }

    .subBannerSwiper {
        width: 100%;
        overflow: hidden;
    }

    .subBannerSwiper .swiper-wrapper .swiper-slide {
        padding: 0 1rem;
    }
</style>

<!-- 서브 배너 -->
<div id="subBannerSwiperContainer">
    <div class="swiper-container subBannerSwiper">
        <div class="swiper-wrapper">
        </div>
    </div>
</div>

<script>
    /* 전역 변수 */
    var subBanner = {
        // 서브 배너 스와이프
        swiper: null,
        // 서브 배너
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
                        }
                        // 배너 영역 세팅
                        $(".subBannerSwiper .swiper-wrapper").html(listBody);

                        /* 서브 배너 스와이프*/
                        subBanner.swiper = new Swiper(".subBannerSwiper", {
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
                    toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
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
                toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
            }
        });
    }
</script>