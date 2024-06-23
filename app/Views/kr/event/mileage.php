<header id="mileage">
    <button class="event_back">
        <svg class="back" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 8L12 16L20 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="#333" />
        </svg>
    </button>
    <p class="title">로그인 마일리지 지급 이벤트</p>
</header>

<div id="mileage_container">
    <img src="/assets/images/kr/event/mileage/etoland.jpg" alt="">
    <button onclick="movePage.login();">
        <img src="" alt="">
    </button>
</div>

<script>
    /*뒤로 가기*/
    $("#mileage .event_back").on("click", function () {
        // 이전 페이지가 있는 경우
        let currentDomain = '{ C.CNF_DOMAIN }';
        if (document.referrer.includes(currentDomain)) {
            history.back();

            // 외부 페이지에서 바로 접근한 경우
        } else {
            movePage.main();
        }
    })
</script>