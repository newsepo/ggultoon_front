<header id="first">
    <button class="event_back">
        <svg class="back" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 8L12 16L20 24" stroke="#222222" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round" />
        </svg>
    </button>
    <p>첫 결제 마일리지 지급 이벤트</p>
</header>


<div id="first_container">
    <div class="title_wrap">
        <img src="/assets/images/kr/event/firstCharge/title.png" alt="">
    </div>
    <div class="list_wrap">
        <img src="/assets/images/kr/event/firstCharge/box_top.png" alt="">
        <ul>
            <li onclick="movePage.charging();">
                <p class="label">꿀처럼 달달한 첫 결제혜택!</p>
                <del>기존 혜택 100꿀 + 200 마일리지</del>
                <p class="item">
                    <span><b>100</b>꿀 + </span>
                    <span>1,000</span>
                    <span>마일리지</span>
                </p>
                <p class="bottom">
                    <i></i>
                    <span>9,900</span>
                </p>
            </li>
            <li onclick="movePage.charging();">
                <del>기존 혜택 200꿀 + 300 마일리지</del>
                <p class="item">
                    <span><b>200</b>꿀 + </span>
                    <span>3,000</span>
                    <span>마일리지</span>
                </p>
                <p class="bottom">
                    <i></i>
                    <span>19,900</span>
                </p>
            </li>
            <li onclick="movePage.charging();">
                <del>기존 혜택 300꿀 + 800 마일리지</del>
                <p class="item">
                    <span><b>300</b>꿀 + </span>
                    <span>5,000</span>
                    <span>마일리지</span>
                </p>
                <p class="bottom">
                    <i></i>
                    <span>29,900</span>
                </p>
            </li>
            <li onclick="movePage.charging();">
                <del>기존 혜택 500꿀 + 1,500 마일리지</del>
                <p class="item">
                    <span><b>500</b>꿀 + </span>
                    <span>8,000</span>
                    <span>마일리지</span>
                </p>
                <p class="bottom">
                    <i></i>
                    <span>49,900</span>
                </p>
            </li>
        </ul>
    </div>
    <div class="footer">
        <span>알려드립니다!</span>
        <p>
            <span>·</span>
            <span>첫 결제 혜택은 당사 사정에 의해 사전 예고 없이 변경 또는 중지될 수 있습니다.</span>
        </p>
        <p>
            <span>·</span>
            <span>부정적 사례가 발견될 경우 해당 회원은 영구정지 대상입니다.</span>
        </p>
        <p>
            <span>·</span>
            <span>자세한 문의 사항은 1:1(채널톡) 또는 고객센터로 문의 주시길 바랍니다.</span>
        </p>
    </div>
</div>

<script>
    /*뒤로 가기*/
    $("#first .event_back").on("click", function () {
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