<div class="guest_container">
  <div class="guest_top">
    <p class="Text-lg">지금 로그인하고 더 다양한 작품을 만나보세요!</p>
    <button class="Text-md" id="guest_login" onclick="movePage.login()">꿀툰 로그인</button>
  </div>
  <div class="guest_content">
    <div class="wrap">
      <a href="/help/notice">
        <h4>
          <span>📢 고객센터</span>
          <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
              d="M9 15C9 15.5523 9.44772 16 10 16C10.5523 16 11 15.5523 11 15V11H15C15.5523 11 16 10.5523 16 10C16 9.44772 15.5523 9 15 9H11V5C11 4.44772 10.5523 4 10 4C9.44772 4 9 4.44772 9 5V9H5C4.44772 9 4 9.44772 4 10C4 10.5523 4.44772 11 5 11H9V15Z"
              fill="#333333" />
          </svg>
        </h4>
      </a>
    </div>
  </div>
  <!-- 서브 풀 배너-->
  {# subFullBanner }
</div>

<script>
  $(document).ready(function () {

    // 로그인 상태 -> 마이페이지 이동
    if (local.memberInfo() != null) {
      window.location.href = "/member";

      // 비로그인 -> 서브 풀 배너 세팅
    } else {
      let data = new Map();
      data.set("type", 7);
      subFullBanner.setting(data);
    }
  });
</script>