<div id="find_container">
    <div class="find_wrap">
        <div class="find_tab">
            <span class="find_tab_item Text-md active">아이디 찾기</span>
            <span class="find_tab_item Text-md">비밀번호 찾기</span>
        </div>
        <div class="tab_content">
            <!-- 아이디 찾기 -->
            <div class="content find_id active">
                <input type="checkbox" id="findId" checked disabled>
                <label for="findId">
                    <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0.5" y="1" width="19" height="19" rx="9.5"/>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M15.1696 7.1119C15.5346 7.45661 15.5511 8.03198 15.2064 8.39702L9.19713 14.7607C9.02539 14.9425 8.7863 15.0456 8.53616 15.0456C8.28602 15.0456 8.04693 14.9425 7.87519 14.7607L4.79354 11.4973C4.44883 11.1322 4.46531 10.5568 4.83035 10.2121C5.19539 9.86742 5.77076 9.8839 6.11547 10.2489L8.53616 12.8124L13.8844 7.14871C14.2292 6.78367 14.8045 6.76719 15.1696 7.1119Z"/>
                    </svg>
                    <p>
                        <span class="Text-lg">본인인증 정보로 찾기</span>
                        <br>
                        <span class="Text-sm">내 명의로 가입한 아이디 정보를 볼 수 있습니다.</span>
                    </p>
                </label>
                <hr class="line">
                <p>
                    <span class="Text-sm"><b>·</b>아이디/비밀번호 찾기 시 문제가 있으면 고객센터로 연락주세요</span>
                    <span class="Text-sm"><b>·</b>고객지원 : help@ggultoons.com</span>
                </p>
                <button id="next" name="verification_btn" class="Text-lg">다음</button>
            </div>
            <!-- 아이디 찾기 result -->
            <div class="content id_result">
                <p class="Text-lg">고객님의 정보와 일치하는 아이디 목록입니다.</p>
                <div class="btn_wrap">
                    <button id="find_pw" onclick="findPassword()">비밀번호 찾기</button>
                    <button id="go_login" onclick="movePage.login()">로그인 하기</button>
                </div>
            </div>
            <!-- 비밀번호 찾기 -->
            <div class="content find_pw">
                <input type="text" placeholder="아이디" id="findPw" name="findPw" class="Text-lg"/>
                <button id="result_pw" name="resultPw" disabled>다음</button>
            </div>
            <!-- 비밀번호 찾기 result -->
            <div class="content pw_result">
                <div class="change_pw_wrap">
                    <input type="password" class="Text-lg" id="change_pw" name="changePw" placeholder="변경할 비밀번호">
                    <p class="Text-xs">영문/숫자/특수문자 두가지 이상 포함 6~20자</p>
                    <input type="password" class="Text-lg" id="change_pw_check" name="changePwCheck" placeholder="비밀번호 확인">
                </div>
                <button id="changing_pw" name="changingPw" disabled>비밀번호 변경</button>
            </div>
        </div>
    </div>
</div>