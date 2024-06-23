<header id="notice">
    <p class="myInfo title">고객센터</p>
    <a href="javascript:void(0);" class="notice-close" onclick="history.back();">
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd"
            d="M8.29289 22.2929C7.90237 22.6834 7.90237 23.3166 8.29289 23.7071C8.68342 24.0976 9.31658 24.0976 9.70711 23.7071L16 17.4142L22.2929 23.7071C22.6834 24.0976 23.3166 24.0976 23.7071 23.7071C24.0976 23.3166 24.0976 22.6834 23.7071 22.2929L17.4142 16L23.7071 9.70711C24.0976 9.31658 24.0976 8.68342 23.7071 8.29289C23.3166 7.90237 22.6834 7.90237 22.2929 8.29289L16 14.5858L9.70711 8.29289C9.31658 7.90237 8.68342 7.90237 8.29289 8.29289C7.90237 8.68342 7.90237 9.31658 8.29289 9.70711L14.5858 16L8.29289 22.2929Z"
            fill="#222222" />
        </svg>
    </a>
</header>
<div class="notice-container">
    <div class="inner">

        <!-- li에 active가 들어가면 스타일이 변경된다 -->
        <ul class="tab-list">
            <li class="active"><a href="javascript:void(0);">공지사항</a></li>
            <li><a href="javascript:void(0);">실시간 문의</a></li>
        </ul>

        <!-- tab-content는 display:none이였다가 active 클래스가 들어가면 노출된다 -->
        <div class="tab-content active" id="">
            <!-- 결과 없음 -->
            { #noResult }
            <ul class="notice-list">
            </ul>
        </div>
        <div class="tab-content">
            <p class="Text-md text-center">문의는 하단의 채널톡을 이용해 주세요</p>
            <button type="button" class="btn-channel">채널톡 시작하기</button>
        </div>  
    </div>
</div>