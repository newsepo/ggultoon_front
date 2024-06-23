<!-- 장르탭 메뉴 스와이퍼 -->
<div id="menuSwiperContainer">
    <div class="swiper-container menuSwiper">
        <div class="swiper-wrapper">
        </div>
    </div>
</div>

<!-- 메인 배너-->
{# mainBanner }

<div class="filter_wrap">
    <button class="rank_filter Text-sm">
        <span>전체
            <svg class="pointer" width="20" height="20" viewBox="0 0 20 20" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M14 8L10 12L6 8" stroke="#999999" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </span>
    </button>
    <div class="select_wrap">
        <button>
            <span>랭킹순</span>
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14 8L10 12L6 8" stroke="#999999" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </button>
        <div class="sort_list">
            <button class="sort_rank active">랭킹순</button>
            <button class="sort_new">최신순</button>
            <button class="sort_like">인기순</button>
        </div>
    </div>
</div>

<!-- 컨텐츠 스와이퍼 -->
<div id="mySwiperContainer">
    <!-- 결과 없음 -->
    { #noResult }
    <div class="swiper-container mySwiper">
        <div class="swiper-wrapper">
        </div>
    </div>
</div>