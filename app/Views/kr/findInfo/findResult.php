<div id="find_result_container">
  <div class="result_wrap">
    <div class="result_tab">
      <span class="result_tab_item Text-md active">아이디 찾기</span>
      <span class="result_tab_item Text-md">비밀번호 찾기</span>
    </div>
    <div class="result_content">
      <div class="content id_result active">
        <p class="Text-lg">고객님의 정보와 일치하는 아이디 목록입니다.</p>
        <figure>
          <img src="/assets/images/kr/social/google.png" alt="">
          <figcaption>
            <p class="Text-lg">
              <span class="personal_id">ach8282@gmail.com</span>
              <span class="join_date Text-sm">(가입일 2018-10-13)</span>
            </p>
          </figcaption>
        </figure>
        <div class="btn_wrap">
          <button class="Text-lg" id="find_pw">비밀번호 찾기</button>
          <button class="Text-lg" id="go_login">로그인 하기</button>
        </div>
      </div>
      <div class="content pw_result">
        <div class="change_pw_wrap">
          <input type="password" class="Text-lg" id="change_pw" placeholder="변경할 비밀번호">
          <p class="Text-xs">영문/숫자/특수문자 두가지 이상 포함 6~20자</p>
          <input type="password" class="Text-lg" id="change_pw_check" placeholder="비밀번호 확인">
        </div>
        <button class="Text-lg" id="changing_pw" disabled>비밀번호 변경</button>
      </div>
    </div>
  </div>
</div>