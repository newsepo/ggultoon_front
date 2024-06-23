<style>
    <?php
        require_once ("assets/css/kr/login/login.css");
    ?>
</style>
<div class="modal" id="modalLogin">
    <div id="login_container">
        <div class="login_wrap modal-content">
            <div class="login_tab">
                <span class="login_tab_item Text-lg active">로그인</span>
                <!-- -->
                <span class="login_tab_item Text-lg" style="display: none;">회원가입</span>
            </div>
            <div class="login_content">
                <div class="content login active">
                    <p>
                        <span class="Text-lg">sns 로그인</span>
                    </p>
                    <div class="social_login_wrap">
                        <button class="social_login kakao"></button>
                        <button class="social_login naver"></button>
                        <!--<button class="social_login google"></button>-->
                    </div>
                    <p>
                        <span class="Text-lg">아이디 로그인</span>
                    </p>
                    <form id="loginFrm" onsubmit="return loginAuth();">
                        <!-- 아이디 입력창 -->
                        <input type="text" id="login_id" name="id" class="Text-lg" placeholder="아이디" required />
                        <!-- 패스워드 입력창 -->
                        <label for="login_pw">
                            <input type="password" id="login_pw" name="password" class="Text-lg" placeholder="비밀번호" minlength="6" autocomplete="off" required/>
                            <svg class="show" width="24" height="24" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg" onclick="passwordDisplay(this)">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.4999 8.25C8.98743 8.25 6.9291 11.0225 6.07971 12.5214C5.96743 12.7196 5.92011 12.8062 5.89311 12.8743C5.87769 12.9132 5.87651 12.9259 5.87762 12.9541C5.8786 12.9792 5.8802 12.9924 5.90089 13.0342C5.93528 13.1038 5.9925 13.1912 6.12331 13.3849C6.61781 14.1171 7.46697 15.2266 8.58366 16.1461C9.70299 17.0678 11.0306 17.75 12.4999 17.75C13.9692 17.75 15.2967 17.0678 16.4161 16.1461C17.5328 15.2266 18.3819 14.117 18.8764 13.3849C19.0072 13.1912 19.0644 13.1038 19.0988 13.0342C19.1195 12.9924 19.1211 12.9792 19.1221 12.9541C19.1232 12.9259 19.122 12.9132 19.1066 12.8743C19.0796 12.8062 19.0323 12.7196 18.92 12.5214C18.0706 11.0225 16.0123 8.25 12.4999 8.25ZM4.77468 11.7819C5.67419 10.1945 8.11853 6.75 12.4999 6.75C16.8812 6.75 19.3255 10.1945 20.225 11.7819C20.2358 11.8009 20.2468 11.8201 20.2578 11.8394C20.4376 12.1547 20.6407 12.5107 20.6209 13.0129C20.6012 13.5155 20.3666 13.8608 20.1587 14.1665C20.1455 14.186 20.1324 14.2053 20.1195 14.2244C19.5824 15.0196 18.6402 16.2577 17.3696 17.304C16.1016 18.3482 14.4458 19.25 12.4999 19.25C10.5539 19.25 8.89817 18.3482 7.63016 17.304C6.35952 16.2577 5.41728 15.0196 4.88026 14.2244C4.86732 14.2053 4.8542 14.186 4.84097 14.1665C4.63317 13.8608 4.3985 13.5155 4.37877 13.0129C4.35906 12.5107 4.56212 12.1547 4.74193 11.8394C4.75295 11.8201 4.76389 11.8009 4.77468 11.7819Z" fill="#999999"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.5 11.25C11.5335 11.25 10.75 12.0335 10.75 13C10.75 13.9665 11.5335 14.75 12.5 14.75C13.4665 14.75 14.25 13.9665 14.25 13C14.25 12.0335 13.4665 11.25 12.5 11.25ZM9.25 13C9.25 11.2051 10.7051 9.75 12.5 9.75C14.2949 9.75 15.75 11.2051 15.75 13C15.75 14.7949 14.2949 16.25 12.5 16.25C10.7051 16.25 9.25 14.7949 9.25 13Z" fill="#999999"/>
                            </svg>
                            <svg class="hide active" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" onclick="passwordDisplay(this)">
                                <g clip-path="url(#clip0_2177_35014)">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M9.28 12.08C9.26 12.21 9.25 12.35 9.25 12.49C9.25 14.29 10.7 15.74 12.5 15.74C12.64 15.74 12.78 15.73 12.91 15.71L9.28 12.08Z" fill="#999999"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M14.15 16.94C13.63 17.13 13.07 17.23 12.5 17.23C11.03 17.23 9.70005 16.55 8.58005 15.63C7.47005 14.71 6.62005 13.6 6.12005 12.87C5.99005 12.67 5.94005 12.58 5.90005 12.51C5.88005 12.47 5.88005 12.46 5.88005 12.43C5.88005 12.41 5.88005 12.39 5.89005 12.35C5.92005 12.29 5.97005 12.2 6.08005 12C6.37005 11.49 6.80005 10.83 7.39005 10.18L6.33005 9.12C5.60005 9.91 5.09005 10.7 4.77005 11.26L4.74005 11.32C4.56005 11.64 4.36005 11.99 4.38005 12.49C4.40005 13 4.63005 13.34 4.84005 13.65L4.88005 13.7C5.42005 14.5 6.36005 15.74 7.63005 16.78C8.90005 17.83 10.55 18.73 12.5 18.73C13.52 18.73 14.46 18.48 15.31 18.1L14.15 16.94Z" fill="#999999"/>
                                    <path d="M20.26 11.33L20.23 11.27C19.33 9.68003 16.88 6.24003 12.5 6.24003C10.97 6.24003 9.68004 6.66003 8.60004 7.28003L6.95004 5.62003C6.65004 5.33003 6.18004 5.33003 5.89004 5.62003C5.59004 5.91003 5.59004 6.38003 5.89004 6.68003L17.55 18.34C17.85 18.64 18.32 18.64 18.61 18.34C18.76 18.2 18.84 18 18.84 17.81C18.84 17.62 18.76 17.43 18.61 17.28L17.77 16.44C18.84 15.48 19.64 14.41 20.12 13.7L20.16 13.65C20.37 13.34 20.6 13 20.62 12.49C20.64 11.99 20.44 11.64 20.26 11.32V11.33ZM12.11 10.79C12.24 10.76 12.37 10.74 12.5 10.74C13.47 10.74 14.25 11.52 14.25 12.49C14.25 12.62 14.23 12.75 14.2 12.88L12.11 10.79ZM19.1 12.52C19.06 12.59 19.01 12.68 18.88 12.88C18.42 13.55 17.68 14.53 16.71 15.39L15.36 14.04C15.61 13.58 15.75 13.05 15.75 12.49C15.75 10.7 14.29 9.24003 12.5 9.24003C11.94 9.24003 11.41 9.38003 10.95 9.63003L9.71004 8.39003C10.52 7.99003 11.44 7.74003 12.5 7.74003C16.01 7.74003 18.07 10.51 18.92 12.01C19.03 12.21 19.08 12.3 19.11 12.36C19.12 12.4 19.12 12.42 19.12 12.44C19.12 12.47 19.12 12.48 19.1 12.52Z" fill="#999999"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0_2177_35014">
                                        <rect width="16.24" height="13.33" fill="white" transform="translate(4.38 5.40002)"/>
                                    </clipPath>
                                </defs>
                            </svg>
                        </label>
                        <!-- 자동로그인 및 아이디저장  -->
                        <div class="auto_save_wrap">
                            <input type="checkbox" id="auto_login" name="autoLogin"/>
                            <label for="auto_login">
                                <svg width="20" height="21" viewBox="0 0 20 21" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <rect x="0.5" y="1" width="19" height="19" rx="9.5"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.1696 7.1119C15.5346 7.45661 15.5511 8.03198 15.2064 8.39702L9.19713 14.7607C9.02539 14.9425 8.7863 15.0456 8.53616 15.0456C8.28602 15.0456 8.04693 14.9425 7.87519 14.7607L4.79354 11.4973C4.44883 11.1322 4.46531 10.5568 4.83035 10.2121C5.19539 9.86742 5.77076 9.8839 6.11547 10.2489L8.53616 12.8124L13.8844 7.14871C14.2292 6.78367 14.8045 6.76719 15.1696 7.1119Z"/>
                                </svg>
                                <span class="Text-md">자동 로그인</span>
                            </label>
                            <input type="checkbox" id="save_id" name="saveId"/>
                            <label for="save_id">
                                <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="0.5" y="1" width="19" height="19" rx="9.5"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.1696 7.1119C15.5346 7.45661 15.5511 8.03198 15.2064 8.39702L9.19713 14.7607C9.02539 14.9425 8.7863 15.0456 8.53616 15.0456C8.28602 15.0456 8.04693 14.9425 7.87519 14.7607L4.79354 11.4973C4.44883 11.1322 4.46531 10.5568 4.83035 10.2121C5.19539 9.86742 5.77076 9.8839 6.11547 10.2489L8.53616 12.8124L13.8844 7.14871C14.2292 6.78367 14.8045 6.76719 15.1696 7.1119Z"/>
                                </svg>
                                <span class="Text-md">아이디 저장</span>
                            </label>
                        </div>
                        <button id="login" type="submit">로그인</button>
                    </form>

                    <p class="find">
                        <a href="/findInfo" class="Text-md">아이디 <b class="point">·</b> 비밀번호 찾기</a>
                    </p>
                </div>

                <div class="content join">
                    <!-- 회원가입 내 소셜 회원가입 및 인풋창 추가 -->
                    <div class="join_content">
                        <p>
                            <span class="Text-lg">sns 회원가입</span>
                        </p>
                        <div class="social_join_wrap">
                            <button class="social_join kakao" id="kakaojoin"></button>
                            <button class="social_join naver" id="naverjoin"></button>
                            <div id="naverIdLogin" style="display: none;"><a id="naverIdLogin_loginButton" href="#"><img src="https://static.nid.naver.com/oauth/big_g.PNG?version=js-2.0.1" height="58"></a></div>
                            <!--<button class="social_join google"></button>-->
                        </div>
                        <p>
                            <span class="Text-lg">아이디 회원가입</span>
                        </p>
                        <form id="joinFrm" action="">
                            <!-- 아이디 입력창 -->
                            <div>
                                <input type="text" id="join_id" name="id" class="Text-lg" placeholder="아이디" required/>
                                <span class="Text-sm">4~15자의 영문 소문자,숫자</span>
                            </div>
                            <!-- 패스워드 입력창 -->
                            <div>
                                <label for="join_pw">
                                    <input type="password" id="join_pw" name="password" class="Text-lg" placeholder="비밀번호" autocomplete="off" required/>
                                    <svg class="show" width="24" height="24" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg" onclick="passwordDisplay(this)">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.4999 8.25C8.98743 8.25 6.9291 11.0225 6.07971 12.5214C5.96743 12.7196 5.92011 12.8062 5.89311 12.8743C5.87769 12.9132 5.87651 12.9259 5.87762 12.9541C5.8786 12.9792 5.8802 12.9924 5.90089 13.0342C5.93528 13.1038 5.9925 13.1912 6.12331 13.3849C6.61781 14.1171 7.46697 15.2266 8.58366 16.1461C9.70299 17.0678 11.0306 17.75 12.4999 17.75C13.9692 17.75 15.2967 17.0678 16.4161 16.1461C17.5328 15.2266 18.3819 14.117 18.8764 13.3849C19.0072 13.1912 19.0644 13.1038 19.0988 13.0342C19.1195 12.9924 19.1211 12.9792 19.1221 12.9541C19.1232 12.9259 19.122 12.9132 19.1066 12.8743C19.0796 12.8062 19.0323 12.7196 18.92 12.5214C18.0706 11.0225 16.0123 8.25 12.4999 8.25ZM4.77468 11.7819C5.67419 10.1945 8.11853 6.75 12.4999 6.75C16.8812 6.75 19.3255 10.1945 20.225 11.7819C20.2358 11.8009 20.2468 11.8201 20.2578 11.8394C20.4376 12.1547 20.6407 12.5107 20.6209 13.0129C20.6012 13.5155 20.3666 13.8608 20.1587 14.1665C20.1455 14.186 20.1324 14.2053 20.1195 14.2244C19.5824 15.0196 18.6402 16.2577 17.3696 17.304C16.1016 18.3482 14.4458 19.25 12.4999 19.25C10.5539 19.25 8.89817 18.3482 7.63016 17.304C6.35952 16.2577 5.41728 15.0196 4.88026 14.2244C4.86732 14.2053 4.8542 14.186 4.84097 14.1665C4.63317 13.8608 4.3985 13.5155 4.37877 13.0129C4.35906 12.5107 4.56212 12.1547 4.74193 11.8394C4.75295 11.8201 4.76389 11.8009 4.77468 11.7819Z" fill="#999999"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.5 11.25C11.5335 11.25 10.75 12.0335 10.75 13C10.75 13.9665 11.5335 14.75 12.5 14.75C13.4665 14.75 14.25 13.9665 14.25 13C14.25 12.0335 13.4665 11.25 12.5 11.25ZM9.25 13C9.25 11.2051 10.7051 9.75 12.5 9.75C14.2949 9.75 15.75 11.2051 15.75 13C15.75 14.7949 14.2949 16.25 12.5 16.25C10.7051 16.25 9.25 14.7949 9.25 13Z" fill="#999999"/>
                                    </svg>
                                    <svg class="hide active" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" onclick="passwordDisplay(this)">
                                        <g clip-path="url(#clip0_2177_35014)">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.28 12.08C9.26 12.21 9.25 12.35 9.25 12.49C9.25 14.29 10.7 15.74 12.5 15.74C12.64 15.74 12.78 15.73 12.91 15.71L9.28 12.08Z" fill="#999999"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M14.15 16.94C13.63 17.13 13.07 17.23 12.5 17.23C11.03 17.23 9.70005 16.55 8.58005 15.63C7.47005 14.71 6.62005 13.6 6.12005 12.87C5.99005 12.67 5.94005 12.58 5.90005 12.51C5.88005 12.47 5.88005 12.46 5.88005 12.43C5.88005 12.41 5.88005 12.39 5.89005 12.35C5.92005 12.29 5.97005 12.2 6.08005 12C6.37005 11.49 6.80005 10.83 7.39005 10.18L6.33005 9.12C5.60005 9.91 5.09005 10.7 4.77005 11.26L4.74005 11.32C4.56005 11.64 4.36005 11.99 4.38005 12.49C4.40005 13 4.63005 13.34 4.84005 13.65L4.88005 13.7C5.42005 14.5 6.36005 15.74 7.63005 16.78C8.90005 17.83 10.55 18.73 12.5 18.73C13.52 18.73 14.46 18.48 15.31 18.1L14.15 16.94Z" fill="#999999"/>
                                            <path d="M20.26 11.33L20.23 11.27C19.33 9.68003 16.88 6.24003 12.5 6.24003C10.97 6.24003 9.68004 6.66003 8.60004 7.28003L6.95004 5.62003C6.65004 5.33003 6.18004 5.33003 5.89004 5.62003C5.59004 5.91003 5.59004 6.38003 5.89004 6.68003L17.55 18.34C17.85 18.64 18.32 18.64 18.61 18.34C18.76 18.2 18.84 18 18.84 17.81C18.84 17.62 18.76 17.43 18.61 17.28L17.77 16.44C18.84 15.48 19.64 14.41 20.12 13.7L20.16 13.65C20.37 13.34 20.6 13 20.62 12.49C20.64 11.99 20.44 11.64 20.26 11.32V11.33ZM12.11 10.79C12.24 10.76 12.37 10.74 12.5 10.74C13.47 10.74 14.25 11.52 14.25 12.49C14.25 12.62 14.23 12.75 14.2 12.88L12.11 10.79ZM19.1 12.52C19.06 12.59 19.01 12.68 18.88 12.88C18.42 13.55 17.68 14.53 16.71 15.39L15.36 14.04C15.61 13.58 15.75 13.05 15.75 12.49C15.75 10.7 14.29 9.24003 12.5 9.24003C11.94 9.24003 11.41 9.38003 10.95 9.63003L9.71004 8.39003C10.52 7.99003 11.44 7.74003 12.5 7.74003C16.01 7.74003 18.07 10.51 18.92 12.01C19.03 12.21 19.08 12.3 19.11 12.36C19.12 12.4 19.12 12.42 19.12 12.44C19.12 12.47 19.12 12.48 19.1 12.52Z" fill="#999999"/>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_2177_35014">
                                                <rect width="16.24" height="13.33" fill="white" transform="translate(4.38 5.40002)"/>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </label>
                                <span class="Text-sm">6~20자 영문/숫자/특수 문자 중 두가지 이상 포함</span>
                            </div>
                        </form>
                    </div>

                    <button id="verification_btn">본인인증</button>
                    <form action="" class="passAuthFrm terms_agree">
                        <input type="checkbox" id="all"/>
                        <!-- 전체동의 -->
                        <div class="all_wrap">
                            <label for="all" class="Text-lg">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="0.5" y="0.5" width="23" height="23" rx="11.5"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M18.2036 7.93398C18.6416 8.34764 18.6614 9.03808 18.2477 9.47613L11.0366 17.1125C10.8306 17.3307 10.5437 17.4544 10.2435 17.4544C9.94332 17.4544 9.65642 17.3307 9.45033 17.1125L5.75234 13.1964C5.33869 12.7584 5.35847 12.0679 5.79652 11.6543C6.23456 11.2406 6.92501 11.2604 7.33866 11.6984L10.2435 14.7746L16.6614 7.97815C17.0751 7.54011 17.7655 7.52033 18.2036 7.93398Z"/>
                                </svg>
                                <span>전체동의</span>
                            </label>
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" onclick="showTerms(this);" class="active">
                                <path d="M14 8L10 12L6 8" stroke="#999999" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>

                        <div class="terms_container active">
                            <!-- 이용약관 및 개인정보 수집 이용 동의 -->
                            <input type="checkbox" id="privacy" required/>
                            <label for="privacy" class="Text-md">
                                <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="0.5" y="1" width="19" height="19" rx="9.5"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.1696 7.1119C15.5346 7.45661 15.5511 8.03198 15.2064 8.39702L9.19713 14.7607C9.02539 14.9425 8.7863 15.0456 8.53616 15.0456C8.28602 15.0456 8.04693 14.9425 7.87519 14.7607L4.79354 11.4973C4.44883 11.1322 4.46531 10.5568 4.83035 10.2121C5.19539 9.86742 5.77076 9.8839 6.11547 10.2489L8.53616 12.8124L13.8844 7.14871C14.2292 6.78367 14.8045 6.76719 15.1696 7.1119Z"/>
                                </svg>
                                <p>
                                    <a href="javascript:void(0);" id="serviceModal">이용약관 및 개인정보 수집 이용 동의</a><b class="essential">(필수)</b>
                                </p>
                            </label>

                            <!-- 만 14세 이상 동의 -->
                            <input type="checkbox" id="age" required/>
                            <label for="age" class="Text-md">
                                <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="0.5" y="1" width="19" height="19" rx="9.5"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.1696 7.1119C15.5346 7.45661 15.5511 8.03198 15.2064 8.39702L9.19713 14.7607C9.02539 14.9425 8.7863 15.0456 8.53616 15.0456C8.28602 15.0456 8.04693 14.9425 7.87519 14.7607L4.79354 11.4973C4.44883 11.1322 4.46531 10.5568 4.83035 10.2121C5.19539 9.86742 5.77076 9.8839 6.11547 10.2489L8.53616 12.8124L13.8844 7.14871C14.2292 6.78367 14.8045 6.76719 15.1696 7.1119Z"/>
                                </svg>
                                <p>
                                    <a href="javascript:void(0);">만 14세 이상</a><b class="essential">(필수)</b>
                                </p>
                            </label>

                            <!-- 마케팅 광고 동의 -->
                            <input type="checkbox" id="marketing"/>
                            <label for="marketing" class="Text-md">
                                <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="0.5" y="1" width="19" height="19" rx="9.5"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.1696 7.1119C15.5346 7.45661 15.5511 8.03198 15.2064 8.39702L9.19713 14.7607C9.02539 14.9425 8.7863 15.0456 8.53616 15.0456C8.28602 15.0456 8.04693 14.9425 7.87519 14.7607L4.79354 11.4973C4.44883 11.1322 4.46531 10.5568 4.83035 10.2121C5.19539 9.86742 5.77076 9.8839 6.11547 10.2489L8.53616 12.8124L13.8844 7.14871C14.2292 6.78367 14.8045 6.76719 15.1696 7.1119Z"/>
                                </svg>
                                <p>
                                    <a href="javascript:void(0);" id="marketingModal">마케팅 광고 동의</a><b class="essential">(선택)</b>
                                </p>
                            </label>
                        </div>

                    </form>

                    <!-- 가입 버튼 -->
                    <button id="join" disabled>가입하기</button>
                </div>
            </div>
        </div>
    </div>
    <div class="dimmed btn-modal-close"></div>
</div>

<!-- Login script -->
<script src="/assets/js/kr/login/kakao_js_sdk_v1_kakao.min.js"></script>

<!-- 소셜 api -->
<script>
    <!-- kakao api -->
    var kakao = {
        // 카카오 설정
        config: {
            errmsg : new Array(
                '현재 카카오로그인 서비스를 이용할 수 없습니다.',
                '카카오로그인 서비스 인증정보가 올바르지 않습니다.',
                '카카오로그인 정보 호출에 실패하였습니다.',
                '예기치 못한 오류가 발생하였습니다.'
            )
        },
        // 카카오 SDK 초기화
        init: function () {
            try{
                Kakao.init('{C.NEXT_PUBLIC_KAKAO_KEY}');
                if (Kakao.isInitialized() !== true){
                    throw kakao.config.errmsg[0];
                }
            } catch(e) {
                toast.alert(e);
            }
        },
        // 카카오 인증
        auth: function (type) {
            try {
                Kakao.Auth.login({
                    success: function (res) {
                        try {
                            if (res.access_token) {
                                socialJoinParams.accessToken = res.access_token;
                                socialJoinParams.recentlySocialType = "kakao";

                                if (type == "login") {
                                    kakao.login(socialJoinParams);
                                } else if (type == "join") {
                                    // 입력 부분 숨김
                                    $(".join_content").removeClass("active");
                                    $(".join_content").css('display', 'none');

                                    // 약관 동의 펼치기
                                    if (!$(".all_wrap > svg").hasClass("active")) {
                                        $(".all_wrap > svg").addClass("active");
                                        $(".terms_container").addClass("active");
                                    }
                                    return true;
                                }
                            } else {
                                toast.alert(kakao.config.errmsg[1]);
                            }
                        } catch (e) {
                            toast.alert(e);
                        }
                    },
                    fail: function (e) {
                        toast.alert(kakao.config.errmsg[1]);
                    }
                });
            } catch(e) {
                toast.alert(kakao.config.errmsg[1]);
            }
        },
        // 카카오 로그인
        login: function (response) {
            try {
                $.ajax(
                    '{C.API_DOMAIN}/v1/login/kakao',
                    {
                        type: 'POST',
                        contentType: 'application/json; charset=utf-8;',
                        data:JSON.stringify({
                            accessToken : response.accessToken,
                        }),
                        xhrFields: {
                            withCredentials: true
                        },
                        success: function (res) {
                            let data = JSON.parse(res);
                            if (data.result) {

                                // 1. 현재 시간(로컬)
                                const nowDate = new Date();
                                // 2. UTC 시간 계산
                                const UTC = nowDate.getTime() + (nowDate.getTimezoneOffset() * 60 * 1000);
                                // 3. UTC to KST (UTC + 9시간 + 60일)
                                const KR_TIME_DIFF = (9 * 60 * 60 * 1000) + (60 * 24 * 60 * 60 * 1000);
                                const krDate = new Date(UTC + (KR_TIME_DIFF));

                                // 회원 정보 세팅
                                data.expire = krDate; // 로컬 스토리지 만료시간 세팅(60일)
                                localStorage.setItem("memberInfo", JSON.stringify(data));

                                // 선물함 쿠키 세팅 : 받은 선물 정보
                                member.giftList();

                                // 모달 호출 체크용 쿠키 세팅
                                $.cookie('modal', true, { path : '/', secure : true });

                                // APP 알림 토큰 저장
                                appData.registerToken();

                                // APP AD ID 저장
                                appData.registerAdid();

                                // 시청연령 정보 저장
                                if (data.data.adult == 1) { // 성인
                                    localStorage.setItem("pavilion", JSON.stringify({ 'state': { 'pavilionIdx': 1 }, 'version': 0 }));
                                } else { // 비성인
                                    localStorage.setItem("pavilion", JSON.stringify({ 'state': { 'pavilionIdx': 0 }, 'version': 0 }));
                                }

                                // 자동로그인 셋팅
                                settingSave(data).then(
                                    function () {
                                        window.location.reload();
                                    }
                                )
                            } else {
                                if (data.code === loginErrorCode.UNREGISTERED) {
                                    $('.login_tab_item:last-of-type').click();
                                    kakao.auth('join');
                                } else {
                                    toast.alert("잘못된 요청입니다.");
                                }
                            }
                            return false;
                        }
                    }
                )
            } catch(e) {
                toast.alert(kakao.config.errmsg[2]);
            }
        }
    }

    <!-- naver api -->
    var naver = {
        auth : function (accessToken,type) {
            try {
                // 네이버 인증 완료
                if (accessToken) {
                    socialJoinParams.accessToken = accessToken;
                    socialJoinParams.recentlySocialType = "naver";

                    // 로그인
                    if (type !== 'join') {
                        naver.login(socialJoinParams);
                    }
                    // 회원 가입
                    else {
                        $(".join_content").removeClass("active");
                        $(".join_content").css('display', 'none');

                        // 약관 동의 펼치기
                        if (!$(".all_wrap > svg").hasClass("active")) {
                            $(".all_wrap > svg").addClass("active");
                            $(".terms_container").addClass("active");
                        }
                    }
                    return false;
                }
            } catch(e) {
                toast.alert(e);
            }
        },
        // 네이버 로그인
        login: function (response) {
            try {
                $.ajax(
                    '{C.API_DOMAIN}/v1/login/naver',
                    {
                        type: 'POST',
                        contentType: 'application/json; charset=utf-8;',
                        data:JSON.stringify({
                            accessToken : response.accessToken,
                        }),
                        xhrFields: {
                            withCredentials: true
                        },
                        success: function (res) {
                            let data = JSON.parse(res);
                            if (data.result) {

                                // 1. 현재 시간(로컬)
                                const nowDate = new Date();
                                // 2. UTC 시간 계산
                                const UTC = nowDate.getTime() + (nowDate.getTimezoneOffset() * 60 * 1000);
                                // 3. UTC to KST (UTC + 9시간 + 60일)
                                const KR_TIME_DIFF = (9 * 60 * 60 * 1000) + (60 * 24 * 60 * 60 * 1000);
                                const krDate = new Date(UTC + (KR_TIME_DIFF));

                                // 회원 정보 세팅
                                data.expire = krDate; // 로컬 스토리지 만료시간 세팅(60일)
                                localStorage.setItem("memberInfo", JSON.stringify(data));

                                // 선물함 쿠키 세팅 : 받은 선물 정보
                                member.giftList();

                                // 모달 호출 체크용 쿠키 세팅
                                $.cookie('modal', true, { path : '/', secure : true });

                                // APP 알림 토큰 저장
                                appData.registerToken();

                                // APP AD ID 저장
                                appData.registerAdid();

                                // 시청연령 정보 저장
                                if (data.data.adult == 1) { // 성인
                                    localStorage.setItem("pavilion", JSON.stringify({ 'state': { 'pavilionIdx': 1 }, 'version': 0 }));
                                } else { // 비성인
                                    localStorage.setItem("pavilion", JSON.stringify({ 'state': { 'pavilionIdx': 0 }, 'version': 0 }));
                                }

                                // 자동로그인 셋팅
                                settingSave(data).then(
                                    function () {
                                        window.location.href = "/";
                                    }
                                )
                            } else {
                                if (data.code === loginErrorCode.UNREGISTERED) {
                                    //toast.alert("미가입 계정으로 가입 화면으로 이동합니다.");
                                    $('.login_tab_item:last-of-type').click();
                                    naver.auth(response.accessToken,'join');

                                } else {
                                    toast.alert("잘못된 요청입니다.");
                                }
                            }
                            return false;
                        }
                    }
                )
            } catch(e) {
                toast.alert("ajax error : " + e);
            }
        }
    }

    // 선물함 리스트 조회 및 선물 지급
    let memberSocialGift = {
        // 선물함 리스트
        list: function () {

            // params value
            let giftMap = new Map();
            giftParams.default(giftMap);
            let page = giftMap.get("page");
            let recordSize = giftMap.get("recordSize");

            $.ajax({
                url: '{ C.API_DOMAIN }/v1/gifts?page=' + page + '&recordSize=' + recordSize,
                cache: true,
                method: 'GET',
                dataType: 'json',
                processData: false,
                async: false,
                contentType: 'application/json',
                xhrFields: {
                    withCredentials: true
                },
                success: function (res) {
                    if (res.result) {

                        // 지급 받을 총 선물 개수 쿠키 세팅
                        if ($.cookie('giftCnt') != undefined) {
                            $.removeCookie("giftCnt");
                        }
                        $.cookie('giftCnt', res.data.giftIconCount, { path : '/', secure : true });

                    } else {
                        // ajax exception error
                        toast.alert(res.message);
                    }
                },
                error: function (request, status, error) {
                    // filter error
                    // toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
                }
            });
            return false;
        }
    }

</script>

<script>
    $(window).resize(function() {
        sizeCheck();
    });

    function sizeCheck(){
        if(document.body.clientWidth <= 1024){
            $('.all_wrap > svg').removeClass("active");
            $(".terms_container").removeClass("active");
        }
    }
    // 로그인 에러 코드
    let loginErrorCode = {
        UNREGISTERED : "ELGI-9999",
        TOKENERROR : "EBAD-3999",
        IDDUPLE : "EJOI-3998"
    }

    // 약관 동의 setting
    let joinTerms = {
        txseq: '',
        privacy: 'N',
        age: 'N',
        marketing:'N'
    }

    // 일반 가입 setting
    let joinParams = {
        ...joinTerms,
        id: '',
        password: '',
        isSimple: 0,
        edata: (session.ottToken()) ? session.ottToken() : null
    }

    // 소셜 가입 setting
    let socialJoinParams = {
        recentlySocialType: '일반',
        accessToken: '',
        isSimple: 1,
        edata: (session.ottToken()) ? session.ottToken() : null
    }

    let defaultSetting = {
        // setting 재설정
        reset : function () {
            // 자동 로그인 체크 여부
            if (loginSettings.state.autoLoginEnabled) {
                $("#loginFrm input[name=autoLogin]").prop("checked", true);
            }

            // 아이디 저장 체크 여부
            if (loginSettings.state.saveId) {
                $("#loginFrm input[name=saveId]").prop("checked", true);
                $("#loginFrm input[name=id]").val(loginSettings.state.previousLoginId);
            }

            // sns 회원가입 폼 default show
            /*if (!($(".join_content").hasClass("active"))) {
                $(".join_content").addClass("active");
            }*/
        }
    }

    // 일반 로그인
    let loginAuth = function () {
        let formSerializeArray = $('#loginFrm').serializeArray();
        let object = {};
        for (let i = 0; i < formSerializeArray.length; i++){
            if (formSerializeArray[i]['value'] == null || formSerializeArray[i]['value'] === "") {
                if (formSerializeArray[i]['name'] === "id") {
                    toast.alert("아이디를 입력해 주세요.");
                    return false;
                } else {
                    toast.alert("비밀번호를 입력해 주세요.");
                    return false;
                }
            }
            object[formSerializeArray[i]['name']] = formSerializeArray[i]['value'];
        }
        let serializeObject = JSON.stringify(object);

        // 로그인 ajax
        loginAjax(serializeObject);
        return false;
    }

    // 본인인증
    $("#verification_btn").on("click", function () {
        window.addEventListener("message", passAuth);
        window.open(
            '{C.API_DOMAIN}/v1/check/popup?url=' + window.location.origin + '/passAuth',
            'PASS',
            'width=500,height=900',
        );
    })

    // 인증 완료
    let passAuth = (e) => {
        if (e.origin !== window.location.origin) {
            return;
        }

        const authData = e.data;
        if (authData.type != null && authData.type == 'passAuth' && authData.txseq != null) {
            // 인증 성공
            $("#verification_btn").attr("disabled", true).text("인증 완료");
            joinTerms.txseq = authData.txseq;

            // 가입 버튼 활성화
            joinButton();

            window.removeEventListener('message', passAuth);
        }
    }

    /** 꿀툰 서비스 종료 -> 회원가입 불가 처리 **/
    // 회원 가입
    // $("#join").on('click', () => {
    //     // 약관 동의
    //     let policy = $(".terms_container input[type=checkbox]");
    //     policy.each(function () {
    //         let policyId = $(this).attr('id');
    //         if ($(this).is(':checked')) {
    //             joinTerms[policyId] = 'Y';
    //         } else {
    //             joinTerms[policyId] = 'N';
    //         }
    //     })
    //
    //     // validation
    //     if (joinTerms.privacy != 'Y' || joinTerms.age != 'Y') {
    //         toast.alert("약관 필수값에 동의해주세요.")
    //         return false;
    //     }
    //     if (joinTerms.txseq == '') {
    //         toast.alert("본인인증이 필요합니다.")
    //         return false;
    //     }
    //     // ott 이벤트 할당
    //     socialJoinParams.edata = joinParams.edata = (session.ottToken()) ? session.ottToken() : null;
    //
    //     let socialType = socialJoinParams.recentlySocialType;
    //     let params;
    //     let url;
    //     // SNS 가입
    //     if (socialJoinParams.accessToken != '') {
    //         url = '{C.API_DOMAIN}/v1/join/' + socialType;
    //         params = $.extend(socialJoinParams, joinTerms);
    //     }
    //     // 일반 가입
    //     else {
    //         joinParams.id = $("#joinFrm input[name=id]").val();
    //         joinParams.password = $("#joinFrm input[name=password]").val();
    //         url = '{C.API_DOMAIN}/v1/join';
    //         params = $.extend(joinParams, joinTerms);
    //     }
    //
    //     $.ajax({
    //         url: url,
    //         cache: true,
    //         method: 'POST',
    //         data: JSON.stringify(params),
    //         dataType: 'json',
    //         processData: false,
    //         contentType: 'application/json',
    //         xhrFields: {
    //             withCredentials: true
    //         },
    //         success: function (res) {
    //             // 가입 성공
    //             if (res.result) {
    //                 if (socialJoinParams.accessToken != '') {
    //                     if (socialType == 'kakao') {
    //                         kakao.login(socialJoinParams);
    //                     } else if (socialType == 'naver') {
    //                         naver.login(socialJoinParams);
    //                     }
    //                 } else {
    //                     loginAjax(JSON.stringify(joinParams));
    //                 }
    //             } else {
    //                 if (socialJoinParams.accessToken != '' && loginErrorCode.IDDUPLE == res.code) {
    //                     // 이미 가입된 아이디 이면 로그인
    //                     if (socialType == 'kakao') {
    //                         kakao.login(socialJoinParams);
    //                     } else if (socialType == 'naver') {
    //                         naver.login(socialJoinParams);
    //                     }
    //                 } else {
    //                     toast.alert(res.message);
    //                 }
    //             }
    //         }
    //     });
    // })

    // SNS 로그인
    $(document).on("click", ".social_login, .social_join", function() {
        if ($(this).hasClass("kakao")) {
            kakao.auth("login");
        } else if ($(this).hasClass("naver")) {
            document.getElementById('naverIdLogin_loginButton').click();
        }
    })

    /*// SNS 회원가입
    $(document).on("click", ".social_join", function() {
        if ($(this).hasClass("kakao")) {
            kakao.auth("join");
        } else if ($(this).hasClass("naver")) {
            document.getElementById('naverIdLogin_loginButton').click();
        }
    })*/

    // 로그인, 회원가입 탭 선택
    $('.login_tab_item').on("click", function () {
        $(".login_tab_item").removeClass("active");
        $(".login_content .content").removeClass("active");
        $(this).addClass("active");
        if ($('.login_tab_item:first-of-type').hasClass("active")) {
            $('.login_content .content.login').addClass("active");
        } else {
            $('.login_content .content.join').addClass("active");
        }
        defaultSetting.reset();
    })

    // 자동 로그인 체크
    $("#loginFrm input[name=autoLogin]").on("click", () => {
        if ($("#loginFrm input[name=autoLogin]").is(":checked")) {
            loginSettings.state.autoLoginEnabled = true;
        } else {
            loginSettings.state.autoLoginEnabled = false;
        }
        localStorage.setItem("loginSettings", JSON.stringify(loginSettings));
    })

    // 아이디 저장 체크
    $("#loginFrm input[name=saveId]").on("click", () => {
        if ($("#loginFrm input[name=saveId]").is(":checked")) {
            loginSettings.state.saveId = true;
        } else {
            loginSettings.state.saveId = false;
        }
        localStorage.setItem("loginSettings", JSON.stringify(loginSettings));
    })

    // 약관 펼치기
    let showTerms = (_this) => {
        $(_this).toggleClass("active");
        $(".terms_container").toggleClass("active");
    }

    // 전체 동의
    $(".terms_agree #all").on('click', () => {
        checkboxCount('all');
    })

    // 동의 체크
    $(".terms_container input[type=checkbox]").on('click', () => {
        checkboxCount();
    })

    // 동의 체크 여부
    var checkboxCount = (type) => {
        const _seletor = ".terms_container input[type=checkbox]";

        // 전체 동의 체크
        if (type == 'all') {
            if ($(".terms_agree #all").is(':checked')) {
                $(_seletor).prop("checked", true);
            } else {
                $(_seletor).prop("checked", false);
            }
        }
        // 개별 체크
        else {
            // 전체 체크 되면 전체 동의 클릭
            if ($(_seletor).length == $(_seletor+":checked").length) {
                $(".terms_agree #all").prop("checked", true);
            } else {
                $(".terms_agree #all").prop("checked", false);
            }
        }

        // 가입 버튼 활성화
        joinButton();
    }

    // 가입 버튼 활성화
    let joinButton = () => {
        if (joinTerms.txseq != '' && $(".terms_container #privacy").is(':checked') && $(".terms_container #age").is(':checked')) {
            $(".content.join > #join").attr("disabled", false);
        } else {
            $(".content.join > #join").attr("disabled", true);
        }
    }

    // 비밀번호 보기
    let passwordDisplay = (_this) => {
        $(_this).removeClass('active').siblings('svg').addClass('active');
        if ($(_this).siblings('svg').hasClass('show')) {
            $(_this).siblings('input').attr('type', 'text');
        } else {
            $(_this).siblings('input').attr('type', 'password');
        }
    }

    // 약관, 마케팅 모달
    $(document).on('click', '.terms_container label a', function (e) {
        e.stopPropagation();
        let paramsPolicy = new Map();
        let checkId = $(this).attr('id');

        if (checkId === 'serviceModal') {
            paramsPolicy.set('url', '/policy/service/popup');
        } else if (checkId === 'privacyModal') {
            paramsPolicy.set('url', '/policy/privacy/popup');
        } else if (checkId === 'marketingModal') {
            paramsPolicy.set('url', '/policy/marketing');
        }

        if (paramsPolicy.get('url') != undefined) {
            gModal.terms(paramsPolicy, '');
        }
    })

    $(document).ready(function () {

        // 로그인 셋팅
        defaultSetting.reset();

        // 카카오 로그인 API 초기화
        kakao.init();

        // 네이버 로그인 API 초기화
        naverLogin.init();

        sizeCheck();
    });
</script>