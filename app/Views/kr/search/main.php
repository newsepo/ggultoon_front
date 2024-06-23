<div id="search_container">
  <div class="search_top">
    <!-- 검색 input -->
    <label for="search_pg">
      <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="11.7812" cy="11.7812" r="6.09375" stroke="#999999" stroke-width="2" />
        <path d="M20.3125 20.3125L16.25 16.25" stroke="#999999" stroke-width="2" stroke-linecap="round" />
      </svg>
      <input type="search" id="search_pg" class="Text-md" placeholder="작품, 작가, 태그 검색" alt="작품, 작가, 태그 검색" />
    </label>

    <!-- 결과 없음 -->
    { #noResult }

    <!-- 추천 키워드 -->
    <div class="keyword_wrap">
      <h4>추천 키워드</h4>
      <div>
        <p class="search_keyword">
          <span class="tag Text-sm">액션</span>
          <span class="tag Text-sm">무협</span>
          <span class="tag Text-sm">판타지</span>
          <span class="tag Text-sm">소설원작</span>
          <span class="tag Text-sm">드라마</span>
          <span class="tag Text-sm">로맨스</span>
          <span class="tag Text-sm">코믹</span>
          <span class="tag Text-sm">황성</span>
          <span class="tag Text-sm">묵검향</span>
          <span class="tag Text-sm">사마달</span>
          <span class="tag Text-sm">야설록</span>
          <span class="tag Text-sm">박봉성</span>
          <span class="tag Text-sm">하승남</span>
          <span class="tag Text-sm">김성동</span>
          <span class="tag Text-sm">천제황</span>
          <span class="tag Text-sm">신형빈</span>
          <span class="tag Text-sm">김성모</span>
          <span class="tag Text-sm">박인권</span>
          <span class="tag Text-sm">고행석</span>
        </p>
      </div>
    </div>
  </div>

  <!-- 작품 검색 결과 -->
  <div class="content_wrap" id="content" style="display: none;">
    <div class="title_wrap"></div>
    <div class="tab_wrap"></div>
    <div class="tab_container search_content">
        <!-- 결과 없음 -->
        { #noResult }
        <div class="content"></div>
    </div>
  </div>

  <!-- 작가 검색 결과 -->
  <div class="content_wrap" id="author" style="display: none;">
    <div class="title_wrap"></div>
    <div class="tab_container">
      <div class="content author"></div>
    </div>
  </div>

  <!-- 태그 검색 결과 -->
  <div class="content_wrap" id="tag" style="display: none;">
    <div class="title_wrap"></div>
    <div class="tab_container">
      <div class="content tag"></div>
    </div>
  </div>

  <!-- 큐레이션 추가 -->
  <div class="curation_container">
    { #curation // 큐레이션 }
  </div>
</div>