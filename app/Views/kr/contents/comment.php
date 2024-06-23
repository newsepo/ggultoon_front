<header id="comment">
    <a href="javascript:void(0);">
    <svg class="comment_back" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M20 8L12 16L20 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
    </svg>
  </a>
  <p class="title Subtitle-lg">꿀작 댓글</p>
</header>

<div id="comment_container">
  <div class="comment_top">
    <p class="comment_wrap">
      <span>댓글</span>
      <span class="comment_cnt"></span>
    </p>
    <div id="comment_filter" style="display: none;">
      <button id="filter">
        <span class="Text-sm">베플순</span>
        <svg class="pointer" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none">
          <path stroke="#999" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m14 8-4 4-4-4">
          </path>
        </svg>
      </button>
      <div class="filter_list">
        <button class="filter_like Text-sm active">베플순</button>
        <button class="filter_reply Text-sm">인기순</button>
        <button class="filter_new Text-sm">최신순</button>
      </div>
    </div>
  </div>
  <div class="write_box">
    <textarea placeholder="댓글 입력" class="Text-md" cols="40" row="5" maxlength="200" wrap="hard"></textarea>
    <span>
      <b class="Text-xs">0</b>
      <b class="Text-xs">200</b>
    </span>
    <hr class="line">
    <div class="box_bottom">
      <p class="Text-xs">※ 이 댓글에 대한 법적 책임은 작성자에게 귀속됩니다.</p>
      <button id="submit" class="submit_comment Text-xs">등록</button>
    </div>
  </div>
  <div class="list_wrap">
  </div>
</div>