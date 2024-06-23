<script>
    $(document).ready(function () {
        // 회원 정보 조회
        let memberInfo = local.memberInfo();

        // 비로그인
        if (memberInfo == null) {
            $(".gift-content").empty();
            movePage.login();

            // 로그인
        } else {
            // 선물함 리스트
            gift.list();
        }
    });

    /* 전역 변수 */
    let params = new Map();
    giftParams.default(params);

    let gift = {
        // 선물함 리스트
        list: function () {

            // params value
            let page = params.get("page");
            let recordSize = params.get("recordSize");

            $.ajax({
                url: '{ C.API_DOMAIN }/v1/gifts?page=' + page + '&recordSize=' + recordSize,
                cache: true,
                method: 'GET',
                dataType: 'json',
                processData: false,
                contentType: false,
                xhrFields: {
                    withCredentials: true
                },
                // 스켈레톤 UI 적용
                beforeSend: function () {
                    let skeletonBox03 = '<li class="skeleton-box style03"></li>';
                    let skeletonList03 = '<div class="skeleton-list"><div class="img-box"></div><div class="title-box" style="position:absolute; min-width:200px;"></div><div class="info-box" style="position:absolute; bottom:0rem; min-width:180px;"></div></div>';

                    for (let i = 0; i < 3; i++) {
                        $('.todayGiftList').append(skeletonBox03);
                        $('.todayGiftList .skeleton-box').append(skeletonList03);

                        $('.tomorrowGiftList').append(skeletonBox03);
                        $('.tomorrowGiftList .skeleton-box').append(skeletonList03);
                    }
                },
                success: function (res) {
                    if (res.result) {

                        // 쿠키 갱신(지급 받은 선물 총 개수)
                        if ($.cookie('giftCnt') != undefined) {
                            $.removeCookie("giftCnt");
                            $.cookie('giftCnt', res.data.giftIconCount, { path : '/', secure : true });
                        }

                        // 결과 없음 이미지 숨김
                        $(".no_result_wrap").removeClass("active");

                        // 오늘 받을 수 있는 선물 리스트
                        let todayListBody = "";
                        if (res.data.todayGiftList.list.length > 0) {

                            // 선물함 영역 노출
                            $(".todayGiftList").show();

                            $.each(res.data.todayGiftList.list, function (index, el) {

                                // 작품 이미지 세팅
                                let contentImg = gift.setContentImg(el);

                                // 배지 세팅
                                let badge = badgeSvg(el.badgeList);

                                // 이용권 버튼 세팅
                                let ticketBtn = gift.setTicketCnt(el);

                                // 지금 바로 사용 가능 여부
                                let available = ``;
                                if (el.available == false) {
                                    available = ` class="wait-free"`;
                                }

                                // list set
                                todayListBody += `
                                    <li`+ available +`>
                                        <a href="javascript:movePage.episode(` + el.contentsIdx + `);">
                                            <div class="img-box">
                                                <img src="`+ contentImg +`" alt="">
                                                <div class="badge_wrap">
                                                    <span class="left_top">${badge.thumbnailTopRight.toString()}</span>
                                                </div>
                                            </div>
                                            <div class="text-box">
                                                <p class="content-name">
                                                     ${badge.title.toString()}
                                                     ${el.contentsTitle.toString()}
                                                </p>
                                                <span class="time">${el.convertDateText.toString()}</span>
                                            </div>
                                            <button type="button" class="btn-gift" value="${el.contentsIdx.toString()}">`+ ticketBtn +`</button>
                                        </a>
                                    </li>
                                `;
                            });
                            $(".todayGiftList").html(todayListBody);

                        } else {
                            // 결과 없음 노출
                            $(".todayGiftList").hide();
                            let text = `<span class="Text-lg">받은 선물</span>이 없어요`;
                            noResult.setting("todayGiftList", text);
                        }

                        // 내일 받을 수 있는 선물 리스트
                        let tomorrowListBody = "";
                        if (res.data.tomorrowGiftList.list.length > 0) {

                            // 선물함 영역 노출
                            $(".tomorrowGiftList").show();

                            $.each(res.data.tomorrowGiftList.list, function (index, el) {

                                // 작품 이미지 세팅
                                let contentImg = gift.setContentImg(el);

                                // 배지 세팅
                                let badge = badgeSvg(el.badgeList);

                                // 이용권 버튼 세팅
                                let ticketBtn = gift.setTicketCnt(el);

                                // 지금 바로 사용 가능 여부
                                let available = ``;
                                if (el.available == false) {
                                    available = ` class="wait-free"`;
                                }

                                // list set
                                tomorrowListBody += `
                                    <li`+ available + `>
                                        <a href="javascript:movePage.episode(` + el.contentsIdx + `);">
                                            <div class="img-box">
                                                <img src="`+ contentImg +`" alt="">
                                                <div class="badge_wrap">
                                                    <span>${badge.thumbnailTopLeft.ranking.toString()}</span>
                                                    <span class="left_top">${badge.thumbnailTopRight.toString()}</span>
                                                </div>
                                            </div>
                                            <div class="text-box">
                                                <p class="content-name">
                                                    ${badge.title.toString()}
                                                    ${el.contentsTitle.toString()}
                                                </p>
                                                <span class="time">${el.convertDateText.toString()}</span>
                                            </div>
                                            <button type="button" class="btn-gift" value="${el.contentsIdx.toString()}">`+ ticketBtn +`</button>
                                        </a>
                                    </li>
                                `;
                            });
                            $(".tomorrowGiftList").html(tomorrowListBody);

                        } else {
                            // 결과 없음 노출
                            $(".tomorrowGiftList").hide();
                            let text = `<span class="Text-lg">받을 선물</span>이 없어요`;
                            noResult.setting("tomorrowGiftList", text);
                        }
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
        // 작품 이미지 세팅
        setContentImg: function (el) {

            // return value
            let contentImg = ``;

            if (el.contentWidthImgList != null && el.contentWidthImgList != undefined && el.contentWidthImgList.length > 0) {
                if (el.contentWidthImgList[0].url != null && el.contentWidthImgList[0].url != undefined) {
                    contentImg = el.contentWidthImgList[0].url;
                }
            } else {
                contentImg = el.contentHeightImgList[0].url;
            }
            return contentImg;
        },
        // 무료 이용권 개수 세팅
        setTicketCnt: function (el) {

            // return value
            let ticketBtn = ``;

            // 사용 완료
            if (el.restCnt == 0) {
                ticketBtn = "사용 완료";
                el.available = false;

                // 기한 만료
            } else if (el.restCnt > 0 && el.convertDateText == "기한 만료") {
                ticketBtn = "사용 불가";
                el.available = false;

                // 미사용 OR 일부 사용
            } else {
                // 최초 지급 시 undefined 이슈 -> 지급 개수로 우선 노출
                if (el.restCnt == undefined) {
                    el.restCnt = el.ticketCnt;
                }
                ticketBtn = el.restCnt + "장 무료";
            }
            return ticketBtn;
        }
    }
</script>