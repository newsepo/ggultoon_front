<div id="body_container">

  <!-- 메인 배너 영역 -->
  { #mainBanner }

  <!-- contents -->
  <div class="myLib container_wrap">
    <h4 class="title">
      <span>🔖 내가 보던 꿀작</span>
      <a href="javascript:void(0);" class="library_all">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd"
            d="M9 15C9 15.5523 9.44772 16 10 16C10.5523 16 11 15.5523 11 15V11H15C15.5523 11 16 10.5523 16 10C16 9.44772 15.5523 9 15 9H11V5C11 4.44772 10.5523 4 10 4C9.44772 4 9 4.44772 9 5V9H5C4.44772 9 4 9.44772 4 10C4 10.5523 4.44772 11 5 11H9V15Z"
            fill="#333333" />
        </svg>
      </a>
    </h4>

    <div>
      <ul class="library_tab_wrap">
        <li class="library_tab_link active" id="library_tab_1">최근</li>
        <li class="library_tab_link" id="library_tab_2">대여</li>
        <li class="library_tab_link" id="library_tab_3">소장</li>
        <li class="library_tab_link" id="library_tab_4">관심</li>
      </ul>

        <!-- 결과 없음 -->
        { #noResult }

      <div class="tab_container recent">
        <div id="library_tab_content" class="library_tab_content active">
          <div class="swiper_library swiper-container">
            <div class="swiper-wrapper">
            </div>
          </div>
        </div>
      </div>

        <div id="myLibBottomSheet">
        </div>
    </div>
  </div>
  <div class="new container_wrap">
    <h4 class="title">
      <span>📖 최신작 궁금허니?</span>
      <a href="javascript:void(0);" class="new_all">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd"
            d="M9 15C9 15.5523 9.44772 16 10 16C10.5523 16 11 15.5523 11 15V11H15C15.5523 11 16 10.5523 16 10C16 9.44772 15.5523 9 15 9H11V5C11 4.44772 10.5523 4 10 4C9.44772 4 9 4.44772 9 5V9H5C4.44772 9 4 9.44772 4 10C4 10.5523 4.44772 11 5 11H9V15Z"
            fill="#333333" />
        </svg>
      </a>
    </h4>
    <div>
      <ul class="new_tab_wrap">
        <li class="new_tab_link active" id="new_tab_1">웹툰</li>
        <li class="new_tab_link" id="new_tab_2">만화</li>
        <li class="new_tab_link" id="new_tab_3">소설</li>
      </ul>
      <div class="tab_container new">
        <div class="new_tab_content" id="new_tab_content">
          <div class="swiper_new swiper-container">
            <div class="swiper-wrapper"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="ranking container_wrap">
    <h4 class="title">
      <span>🥇 꿀툰 랭킹, 달달허니?</span>
      <a href="javascript:void(0);" class="rank_all">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd"
            d="M9 15C9 15.5523 9.44772 16 10 16C10.5523 16 11 15.5523 11 15V11H15C15.5523 11 16 10.5523 16 10C16 9.44772 15.5523 9 15 9H11V5C11 4.44772 10.5523 4 10 4C9.44772 4 9 4.44772 9 5V9H5C4.44772 9 4 9.44772 4 10C4 10.5523 4.44772 11 5 11H9V15Z"
            fill="#333333" />
        </svg>
      </a>
    </h4>
    <div>
      <ul class="tab_wrap">
        <li class="tab_link active" id="tab_1">웹툰</li>
        <li class="tab_link" id="tab_2">만화</li>
        <li class="tab_link" id="tab_3">소설</li>
      </ul>
    </div>
    <div class="tab_container ranking">
      <div class="tab_content active" id="tab_content">
        <div class="swiper mainRankingSwiper swiper-container">
          <div class="swiper-wrapper">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- 큐레이션 영역 -->
{ #curation }