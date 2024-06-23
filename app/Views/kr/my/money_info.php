<div class="money_info">
    <div class="info_wrap">
        <p>
            <span class="Text-xs" >꿀</span>
            <b id="my_coin">0</b>
        </p>
        <hr id="vertical">
        <p>
            <span class="Text-xs" >마일리지</span>
            <b id="my_mileage">0</b>
        </p>
    </div>
    <a href="/charging">
        <span class="Text-sm">🎉 지금 꿀 충전 시 마일리지 추가 지급!</span>
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7 5L12 10L7 15" stroke="#222222" stroke-width="1.5" stroke-linecap="round"
                  stroke-linejoin="round" />
        </svg>
    </a>
</div>

<script>
    $(document).ready(function () {
        // 회원 정보(마이페이지) 조회
        $.ajax({
            url: '{ C.API_DOMAIN }/v1/member/mypage',
            cache : true,
            method: 'GET',
            dataType: 'json',
            processData: false,
            contentType: false,
            xhrFields: {
                withCredentials: true
            },
            success: function (res) {
                if (res.result) {

                    let memberInfo = res.data.member;

                    // 보유 코인
                    $("#my_coin").text(addComma(res.data.coin.coin));

                    // 보유 마일리지
                    $("#my_mileage").text(addComma(res.data.coin.mileage));

                    // 간편로그인은 아이디 대신 메일 정보
                    if (memberInfo.isSimple === 1){
                        $("#user_info figcaption").text(memberInfo.email);
                    } else {
                        $("#user_info figcaption").text(memberInfo.id);
                    }

                    // 로그인 계정 타입 아이콘
                    if(memberInfo.simpleType == 'kakao'){
                        $("#user_info img").prop('src','/assets/images/kr/social/kakao.png');
                    }else if(memberInfo.simpleType == 'naver'){
                        $("#user_info img").prop('src','/assets/images/kr/social/naver.png');
                    }else{

                        $("#user_info img").prop('src','/assets/svgs/kr/main/ggultoon.svg');
                    }
                }
            }
        });
    });
</script>