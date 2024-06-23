<header id="event">
    <button class="event_back">
        <svg class="back" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 8L12 16L20 24" stroke="#222222" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </button>
  <p class="myInfo title">이벤트</p>
</header>

<div class="lib_container">
    <div class="lib_content">
        <ul class="event-list">
            <li>
                <a href="#">
                    <img src="/assets/images/kr/banner/720X260/comic/banner_comics_action_22.jpg" alt="신이라 불리운 사나이 피터팬의 과거, 신이라 불리운 사나이 보러가기">
                    <div class="label-wrap">
                        <span>#1인 한정</span>
                        <span>#선착순</span>
                    </div>
                    <span class="d-day">D-7</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="/assets/images/kr/banner/720X260/comic/banner_comics_action_22.jpg" alt="신이라 불리운 사나이 피터팬의 과거, 신이라 불리운 사나이 보러가기">
                    <div class="label-wrap">
                        <span>#코인무료</span>
                        <span>#선착순</span>
                    </div>
                    <span class="d-day">D-7</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="/assets/images/kr/banner/720X260/comic/banner_comics_action_22.jpg" alt="신이라 불리운 사나이 피터팬의 과거, 신이라 불리운 사나이 보러가기">
                    <div class="label-wrap">
                        <span>#1인 한정</span>
                    </div>
                    <span class="d-day">D-7</span>
                </a>
            </li>
        </ul>
    </div>
</div>

<script>
    /*뒤로 가기*/
    $("#event .event_back").on("click", function () {
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