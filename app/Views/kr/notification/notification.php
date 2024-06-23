<header id="notify">
  <a href="javascript:void(0);">
    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M20 8L12 16L20 24" stroke="#222222" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
    </svg>
  </a>
  <p class="myInfo title">알림</p>
  <button id="edit" class="btn-edit Text-md">편집</button>
</header>

<!-- header내 편집버튼 클릭시 lib_container에 edit 클래스 추가
.edit-top과 notify-list내 notify-check 노출 -->
<div class="lib_container">
    <div class="lib_content">
        <div class="edit_top">
            <input type="checkbox" id="select_all">
            <label for="select_all" class="input-check">
                <svg class="" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 9.75L8.16327 14L16 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="Text-md">전체선택</span>
            </label>
            <button id="delete" class="Text-sm">삭제</button>
        </div>

        <!-- 결과 없음 -->
        { #noResult }

        <ul class="notify-list">
        </ul>
    </div>
</div>