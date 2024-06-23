<div class="member_container">
  <div class="member_top">
    <div class="my_wrap">
      <figure id="user_info">
        <img id="userImg" src="/assets/svgs/kr/main/ggultoon.svg" alt="" />
        <figcaption class="Text-lg" id="userId"></figcaption>
      </figure>
      <a href="/my/info" id="edit_btn">
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd"
            d="M13.0866 7.91363L14.25 6.75019L14.2501 6.75015C14.3297 6.67052 14.3695 6.6307 14.4015 6.59544C15.0949 5.83263 15.0949 4.66774 14.4015 3.90493C14.3695 3.86967 14.3297 3.82985 14.2501 3.75023L14.25 3.75019C14.1704 3.67053 14.1305 3.63071 14.0953 3.59865C13.3325 2.90527 12.1676 2.90527 11.4048 3.59865C11.3695 3.63071 11.3297 3.67053 11.25 3.75019L10.069 4.9312C10.7823 6.17635 11.8243 7.21029 13.0866 7.91363ZM8.6143 6.38591L3.8564 11.1438C3.43134 11.5689 3.21881 11.7814 3.07907 12.0425C2.93934 12.3036 2.88039 12.5983 2.7625 13.1878L2.3971 15.0148C2.33058 15.3474 2.29732 15.5137 2.39193 15.6083C2.48654 15.7029 2.65284 15.6696 2.98545 15.6031L4.81243 15.2377L4.81244 15.2377C5.40189 15.1198 5.69661 15.0609 5.95771 14.9211C6.2188 14.7814 6.43133 14.5689 6.85638 14.1438L6.85639 14.1438L6.8564 14.1438L11.6281 9.37212C10.4171 8.60388 9.38969 7.58337 8.6143 6.38591Z"
            fill="#999999" />
        </svg>
        <span class="Text-xs">편집</span>
      </a>
    </div>
    {# money_info // 보유포인트}
  </div>
  {# grade // 회원등급}
  <!-- *마이페이지 하단 컨텐츠  -->
  <div class="member_content">
    <div class="wrap">
      <a href="/my/lib">
        <h4>
          <span>🔖 내가 보던 꿀작</span>
          <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
              d="M9 15C9 15.5523 9.44772 16 10 16C10.5523 16 11 15.5523 11 15V11H15C15.5523 11 16 10.5523 16 10C16 9.44772 15.5523 9 15 9H11V5C11 4.44772 10.5523 4 10 4C9.44772 4 9 4.44772 9 5V9H5C4.44772 9 4 9.44772 4 10C4 10.5523 4.44772 11 5 11H9V15Z"
              fill="#333333" />
          </svg>
        </h4>
      </a>
      <div class="lastViewSwiper">
        <div class="swiper-wrapper" id="lastViewList">
        </div>
      </div>
    </div>
    <!--<hr class="line">
    <div class="wrap">
      <a href="/event">
        <h4>
          <span>🎉 꿀이득 이벤트</span>
          <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
              d="M9 15C9 15.5523 9.44772 16 10 16C10.5523 16 11 15.5523 11 15V11H15C15.5523 11 16 10.5523 16 10C16 9.44772 15.5523 9 15 9H11V5C11 4.44772 10.5523 4 10 4C9.44772 4 9 4.44772 9 5V9H5C4.44772 9 4 9.44772 4 10C4 10.5523 4.44772 11 5 11H9V15Z"
              fill="#333333" />
          </svg>
        </h4>
      </a>
      <div class="scroll">
        <a href="">
          <img src="/assets/images/kr/guest_event/guest_event_1.png" alt="">
        </a>
        <a href="">
          <img src="/assets/images/kr/guest_event/guest_event_1.png" alt="">
        </a>
        <a href="">
          <img src="/assets/images/kr/guest_event/guest_event_1.png" alt="">
        </a>
        <a href="">
          <img src="/assets/images/kr/guest_event/guest_event_1.png" alt="">
        </a>
        <a href="">
          <img src="/assets/images/kr/guest_event/guest_event_1.png" alt="">
        </a>
      </div>
    </div>
    <hr class="line">
    <div class="wrap">
      <a href="">
        <h4>
          <span>🎁 선물함</span>
          <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
              d="M9 15C9 15.5523 9.44772 16 10 16C10.5523 16 11 15.5523 11 15V11H15C15.5523 11 16 10.5523 16 10C16 9.44772 15.5523 9 15 9H11V5C11 4.44772 10.5523 4 10 4C9.44772 4 9 4.44772 9 5V9H5C4.44772 9 4 9.44772 4 10C4 10.5523 4.44772 11 5 11H9V15Z"
              fill="#333333" />
          </svg>
        </h4>
      </a>
    </div>-->
    <hr class="line">
    <div class="wrap">
      <a href="/my/history/charged">
        <h4>
          <span>📄 이용내역</span>
          <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
              d="M9 15C9 15.5523 9.44772 16 10 16C10.5523 16 11 15.5523 11 15V11H15C15.5523 11 16 10.5523 16 10C16 9.44772 15.5523 9 15 9H11V5C11 4.44772 10.5523 4 10 4C9.44772 4 9 4.44772 9 5V9H5C4.44772 9 4 9.44772 4 10C4 10.5523 4.44772 11 5 11H9V15Z"
              fill="#333333" />
          </svg>
        </h4>
      </a>
    </div>
    <hr class="line">
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
    <hr class="line">
    <div class="banner_wrap">
        <!-- 서브 풀 배너-->
        {# subFullBanner }
    </div>


    <button id="logout" class="Text-md">로그아웃</button>
  </div>