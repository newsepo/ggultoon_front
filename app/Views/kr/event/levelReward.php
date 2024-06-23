<header id="reward">
    <button class="event_back">
        <svg class="back" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 8L12 16L20 24" stroke="#222222" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
    </button>
    <p>등급별 리워드 이벤트</p>
</header>


<div id="reward_container">
    <div class="title_wrap">
        <img src="/assets/images/kr/event/levelReward/title.png" alt="">
    </div>
    <ul>
        <li>
            <div>
                <p><span>기본등급</span><i></i></p>
                <span>등급 기준 0 ~ 9,999원</span>
            </div>
            <img src="/assets/images/kr/event/levelReward/m_1.png" alt="">
        </li>
        <li>
            <div>
                <p><span>동색꿀단지</span><i></i></p>
                <span>등급 기준 10,000 ~ 49,999원</span>
            </div>
            <img src="/assets/images/kr/event/levelReward/m_2.png" alt="">
        </li>
        <li>
            <div>
                <p><span>은색꿀단지</span><i></i></p>
                <span>등급 기준 50,000 ~ 99,999원</span>
            </div>
            <img src="/assets/images/kr/event/levelReward/m_3.png" alt="">
        </li>
        <li>
            <div>
                <p><span>금색꿀단지</span><i></i></p>
                <span>등급 기준 100,000 ~ 149,999원</span>
            </div>
            <img src="/assets/images/kr/event/levelReward/m_4.png" alt="">
        </li>
        <li>
            <div>
                <p><span>루비꿀단지</span><i></i></p>
                <span>등급 기준 150,000 ~ 199,999원</span>
            </div>
            <img src="/assets/images/kr/event/levelReward/m_5.png" alt="">
        </li>
        <li class="point">
            <div>
                <p><span>다이아꿀단지</span><i></i></p>
                <span>등급 기준 200,000원 ~</span>
            </div>
            <img src="/assets/images/kr/event/levelReward/m_6.png" alt="">
        </li>
    </ul>
    <div class="coin">

        <img src="/assets/images/kr/event/levelReward/coin.png" alt="">

    </div>
    <div class="footer">
        <span class="Text-sm">알려드립니다!</span>
        <p class="Text-xs"><span>·</span><span>최근 2개월 + 당월기간 누적된 결제금액 합산 기준으로 매달 등급이 책정되며 실시간 등급이 갱신됩니다.</span></p>
        <p class="Text-xs"><span>·</span><span>하락 등급은 명월 1일에 적용 됩니다.</span></p>
        <p class="Text-xs"><span>·</span><span>회원 등급 혜택은 당사 사정에 의해 사전 예고 없이 변경 또는 중지될 수 있습니다.</span></p>
        <p class="Text-xs"><span>·</span><span>부정적 사례가 발견될 경우 해당 회원의 등급은 즉시 조정되며, 이후 선정 기준에 적합한 경우라도 영구적으로 등급이 박탈될 수
                있습니다.</span></p>
        <p class="Text-xs"><span>·</span><span>자세한 문의 사항은 1:1(채널톡) 또는 고객센터로 문의 주시길 바랍니다.</span></p>
    </div>
</div>

<script>
    /*뒤로 가기*/
    $("#reward .event_back").on("click", function () {
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