<header id="charged">
    <a href="javascript:void(0);">
        <svg class="back" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 8L12 16L20 24" stroke="#222222" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </a>
  <p>이용 내역</p>
  <label class="switch">
    <span id="edit-btn" style="display:none;">
      <input type="checkbox" style="display:none;">
      <span class="Text-md edit-text">편집</span><span class="Text-md edit-text" style="display:none;">확인</span>
    </span>
  </label>

</header>

<div class="charged_top">
  {# money_info // 보유포인트}
</div>
<div class="charged_content">
  <div class="charged_tab">
    <span class="charge active">충전</span>
    <span class="use">사용</span>
    <span class="disappear">소멸</span>
  </div>
  <div class="contents">
    <div class="charge content active" name="charge_content">
      <!-- 평소 충전 탭 상단 -->
      <div class="charge_tab">
        <button class="select" id="charge_sort">
          <span class="Text-sm">꿀</span>
          <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M14 8L10 12L6 8" stroke="#999999" stroke-width="1.5" stroke-linecap="round"
              stroke-linejoin="round" />
          </svg>
        </button>
        <ul class="sort_list">
          <li class="Text-sm active" data-value="coin" data-name="꿀">꿀</li>
          <li class="Text-sm" data-value="mileage" data-name="마일리지">마일리지</li>
        </ul>
      </div>

        <!-- 결과 없음 -->
        { #noResult }
      <div class="coin content active" id="chargedList">
      </div>

    </div>

    <div class="use content" name="use_content">
      <!-- 일반적으로 사용되는 사용 탭 내부 상단 -->
      <div class="use_top">
        <button class="select" id="use_sort">
          <span class="Text-sm">대여</span>
          <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M14 8L10 12L6 8" stroke="#999999" stroke-width="1.5" stroke-linecap="round"
              stroke-linejoin="round" />
          </svg>
        </button>
        <ul class="sort_list">
          <li class="Text-sm active" value="rent">대여</li>
          <li class="Text-sm"  value="have">소장</li>
        </ul>
        <button>
          <svg class="filter_btn" width="32" height="32" viewBox="0 0 32 32" fill="none"
               xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M15 12.75C15 13.3023 14.5523 13.75 14 13.75C13.4477 13.75 13 13.3023 13 12.75C13 12.1977 13.4477 11.75 14 11.75C14.5523 11.75 15 12.1977 15 12.75ZM14 15.25C15.1194 15.25 16.067 14.5143 16.3855 13.5L23.5 13.5C23.9142 13.5 24.25 13.1642 24.25 12.75C24.25 12.3358 23.9142 12 23.5 12L16.3855 12C16.067 10.9858 15.1194 10.25 14 10.25C12.8806 10.25 11.933 10.9858 11.6144 12L9 12C8.58579 12 8.25 12.3358 8.25 12.75C8.25 13.1642 8.58579 13.5 9 13.5L11.6145 13.5C11.933 14.5143 12.8806 15.25 14 15.25ZM17.5 19.75C17.5 20.3023 17.9477 20.75 18.5 20.75C19.0523 20.75 19.5 20.3023 19.5 19.75C19.5 19.1977 19.0523 18.75 18.5 18.75C17.9477 18.75 17.5 19.1977 17.5 19.75ZM18.5 22.25C17.3806 22.25 16.433 21.5143 16.1145 20.5H9C8.58579 20.5 8.25 20.1642 8.25 19.75C8.25 19.3358 8.58579 19 9 19H16.1145C16.433 17.9858 17.3806 17.25 18.5 17.25C19.6194 17.25 20.567 17.9858 20.8856 19L23.5 19C23.9142 19 24.25 19.3358 24.25 19.75C24.25 20.1642 23.9142 20.5 23.5 20.5L20.8855 20.5C20.567 21.5143 19.6194 22.25 18.5 22.25Z"
                    fill="#999999" />
          </svg>
        </button>

      </div>

      <!-- 편집모드 사용 탭 내부 상단 -->
      <div class="edit_top active" style="display:none;">
        <input type="checkbox" id="select_all_use">
        <label for="select_all_use">
          <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M4 9.75L8.16327 14L16 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          <span class="Text-md">전체 선택</span>
        </label>
        <button id="used_delete" class="Text-md">삭제</button>
      </div>


        <!-- 결과 없음 -->
        { #noResult }
      <div class="rent content active" id="usedList">
      </div>
    </div>


    <div class="disappear content" name="expire_content">
      <!-- 일반 상태의 소멸 탭 상단 -->
      <div class="disappear_top">
      </div>

        <!-- 결과 없음 -->
        { #noResult }
      <div class="coin content active" id="expireList" >
      </div>
    </div>
  </div>
</div>