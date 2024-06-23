<header id="ott">
    <button class="event_back">
        <svg class="episode_back" width="32" height="32" viewBox="0 0 32 32" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path d="M20 8L12 16L20 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="#333" />
        </svg>
    </button>
    <p class="title">제휴사 쿠폰 이벤트</p>
</header>
<div id="ott_container">
    <div class="ott_wrap">
        <img src="/assets/images/kr/event/ottcoupon/title.png" alt="">
        <p><span>꿀툰</span><span>1천 마일리지</span> 지급!</p>
        <div class="box_wrap">
            <div>
                <p>꿀툰 쿠폰 번호</p>
                <input type="text" placeholder="꿀툰보다 싼데 없음">
            </div>
            <button id="coupon" alt="쿠폰 사용하기" onclick="ottevent.coupon();">
                <img src="/assets/images/kr/event/ottcoupon/btn_link_350x76.png" alt="">
            </button>
        </div>

    </div>
    <div class="bottom">
        <p class="Text-sm">
            <span>·</span>
            <span>쿠폰은 회원가입 및 본인 인증 후 사용이 가능합니다.</span>
        </p>
        <p class="Text-sm">
            <span>·</span>
            <span>쿠폰은 회원가입 완료 후 쿠폰 사용하기(버튼)를 통해 지급됩니다.</span>
        </p>
        <p class="Text-sm">
            <span>·</span>
            <span>마일리지의 유효기간은 30일이며 기간 만료 시 자동 소멸됩니다.</span>
        </p>
        <p class="Text-sm">
            <span>·</span>
            <span>1인 1계정만 이벤트 참여가 가능합니다.</span>
        </p>
        <p class="Text-sm">
            <span>·</span>
            <span>본 이벤트는 회사 사정에 따라 별도 공지 없이 조기 종료 및 변경될 수 있습니다.</span>
        </p>
        <p class="Text-sm">
            <span>·</span>
            <span>자세한 문의는 고객센터를 통하여 문의 하여 주시길 바랍니다.</span>
        </p>
    </div>
</div>

<script>
    /*뒤로 가기*/
    $("#ott .event_back").on("click", function () {
        // 이전 페이지가 있는 경우
        let currentDomain = '{ C.CNF_DOMAIN }';
        if (document.referrer.includes(currentDomain)) {
            history.back();

            // 외부 페이지에서 바로 접근한 경우
        } else {
            movePage.main();
        }
    })

    let ottevent = {
        coupon: function () {

            // 비로그인
            if (local.memberInfo() == null) {
                // 로그인 시도
                movePage.login();
                
                // 로그인
            } else {
                // 쿠폰번호 전송
                $.ajax({
                    url: '{ C.API_DOMAIN }/v1/event/coupon',
                    cache: true,
                    method: 'POST',
                    dataType: 'json',
                    data: JSON.stringify({coupon:"꿀툰보다 싼데 없음"}),
                    processData: false,
                    contentType: 'application/json',
                    xhrFields: {
                        withCredentials: true
                    },
                    success: function (res) {
                        // 쿠폰등록 결과
                        let params = new Map();
                        params.set("title", res.message);
                        params.set("detail", "");
                        params.set("color", "yellow");
                        gModal.alert(params, movePage.main);
                    },
                    error: function (request, status, error) {
                        // filter error
                        toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
                    }
                });
            }
        }
    }
</script>