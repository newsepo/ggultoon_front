<script>
    $(document).ready(function () {
        // 비로그인
        if (local.memberInfo() == null) {
            // 로그인 페이지로 이동
            window.location.href = "/guest";

            // 로그인
        } else {
            // 회원 등급 정보 노출
            $(".level").show();

            // 코인 및 마일리지, 내가 보던 꿀작
            mypage.myPageInfo();
        }
    });

    let mypage = {

        // 코인 및 마일리지, 내가 보던 꿀작
        myPageInfo: function () {
            $.ajax({
                url: '{ C.API_DOMAIN }/v1/member/mypage',
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

                        // 회원이 읽지 않은 알림 개수 & 회원 아이디 & 보유 코인 & 보유 마일리지 정보
                        let memberInfo = res.data.member;
                        $("#my_coin").text(addComma(res.data.coin.coin)); // 보유 코인
                        $("#my_mileage").text(addComma(res.data.coin.mileage)); // 보유 마일리지
                        $("#user_id").text(memberInfo.id); // 회원 아이디

                        // 회원이 읽지 않은 알림 개수 정보
                        if (memberInfo.unreadNotiCnt != 0) {
                            $(".alert_icon").find("svg").find("circle").show();
                            $("#alert_count").text(memberInfo.unreadNotiCnt);
                        }

                        // 간편 로그인
                        if (memberInfo.isSimple === 1) {
                            // 이메일 세팅
                            $("#user_info figcaption").text(memberInfo.email);

                            // 일반 로그인
                        } else {
                            // 아이디 세팅
                            $("#user_info figcaption").text(memberInfo.id);
                        }

                        // 로그인 계정 타입 아이콘
                        if (memberInfo.simpleType == 'kakao') {
                            $("#user_info img").prop('src', '/assets/images/kr/social/kakao.png');

                        } else if (memberInfo.simpleType == 'naver') {
                            $("#user_info img").prop('src', '/assets/images/kr/social/naver.png');

                        } else {
                            $("#user_info img").prop('src', '/assets/svgs/kr/main/ggultoon.svg');
                        }

                        // 내가 보던 꿀작
                        let lastViewBody = "";
                        if (res.data.lastViewList.length > 0) {
                            $.each(res.data.lastViewList, function (i, el) {
                                let badge = badgeSvg(el.badgeList);

                                lastViewBody += `
                                  <div class="swiper-slide">
                                    <a href="javascript:movePage.episode(` + el.contentsIdx + `);" class="items">
                                      <!-- top_badge -->
                                      <div class="top_badge">
                                        <div class="left_top">
                                          ${badge.thumbnailTopLeft.category.toString()}
                                        </div>
                                        ${badge.thumbnailTopRight.toString()}
                                      </div>
                                      <figure>
                                        <div class="img_wrap">
                                          <img src="${el.contentHeightImgList[0].url.toString()}" alt="" />
                                        </div>
                                        <figcaption>
                                          <p class="Text-xs">
                                            <span class="info_title Subtitle-md"> ${badge.title.toString()} ${el.contentsTitle.toString()}</span>
                                            <span class="sub_info">
                                               ${badge.up.toString()}
                                              <b class="episodeNum">${el.episodeNumTitle.toString()}</b>
                                              ${el.writerList.length > 0 ? `
                                              <b class="point">·</b>
                                              <b class="writer">${el.writerList[0].name.toString()}</b>` : ``}
                                            </span>
                                            <span>${badge.bottom.toString()}</span>
                                          </p>
                                        </figcaption>
                                      </figure>
                                    </a>
                                  </div>
                              `;
                            });
                            $("#lastViewList").html(lastViewBody);

                        } else {
                            // 작품이 없는 경우 -> 스와이프 숨김
                            $(".lastViewSwiper").hide();
                        }

                        /*내가 보던 꿀작 스와이프*/
                        let librarySwiper = new Swiper('.lastViewSwiper', {
                            direction: 'horizontal',
                            loop: false,
                            slidesPerView: 'auto',
                            spaceBetween: 0,
                            freeMode: true,
                            loopAdditionalSlides: 1,
                            slidesOffsetAfter: 60,
                            observer: true,
                            observeParents: true
                        });

                        // 서브 풀 배너 세팅
                        let data = new Map();
                        data.set("type", 8);
                        subFullBanner.setting(data);
                    }
                }
            });
        }
    }
</script>