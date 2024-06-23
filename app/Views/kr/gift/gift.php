<header id="gift">
    <button class="gift_back" onclick="movePage.main();">
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path d="M20 8L12 16L20 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </button>
    <p class="myInfo title">선물함</p>
</header>
<div class="gift-content">
    <div class="gift-banner">
        {#banner_sub_full}
    </div>
    <div class="inner">
        <div id="todayGiftList" class="gift-wrap">
            <strong class="gift-tit">🎉 오늘 받을 수 있는 선물!</strong>
            <!-- 결과 없음 -->
            { #noResult }
            <ul class="todayGiftList gift-list"></ul>
        </div>
        <div id="tomorrowGiftList" class="gift-wrap">
            <strong class="gift-tit">🎁 심장이 꿀떡꿀떡! 내일 받을 선물!</strong>
            <!-- 결과 없음 -->
            { #noResult }
            <ul class="tomorrowGiftList gift-list"></ul>
        </div>
    </div>
</div>