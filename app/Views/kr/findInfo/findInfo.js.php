<script>
// 비밀번호 변경 파라미터
var findPasswordParams = {
    id: '',
    ci: '',
    di: '',
    newPassword: '',
    newPasswordConfirm: ''
}

// 본인인증
$("button[name=verification_btn]").on("click", function () {
    findInfoAuthIdPopup();
})

//  아이디 찾기 - 본인인증 팝업
let findInfoAuthIdPopup = function () {
    window.addEventListener("message", findInfoAuthId);

    window.open(
        '{C.API_DOMAIN}/v1/check/popup/id?url=' + window.location.origin + '/findInfoAuthId',
        'PASS',
        'width=500,height=900',
    );
}

// 아이디 찾기 - 본인인증 완료
var findInfoAuthId = (e) => {
    if (e.origin !== window.location.origin) {
        return;
    }

    const authData = e.data;
    if (authData.type != null && authData.type == 'findInfoAuthId' && authData.mdl_tkn != null) {
        $.ajax(
            '{C.API_DOMAIN}/v1/check/find/id',
            {
                type: 'GET',
                contentType: 'application/json',
                xhrFields: {
                    withCredentials: true
                },
                data: {
                    mdl_tkn : authData.mdl_tkn
                },
                success : function (res) {
                    let data = JSON.parse(res);

                    if (data.result) {
                        let findMemberHtml = '';
                        data.data.findMemberList.forEach((el, index) => {
                            let icon = '<img src="/assets/images/kr/social/ggul.png" alt="">';
                            let id = el.id;
                            let regdate = '(가입일 ' + el.regdate + ')';
                            if (el.simpleType == 'kakao') {
                                icon = '<img src="/assets/images/kr/social/kakao.png" alt="">';
                                id = el.email;
                            } else  if (el.simpleType == 'naver') {
                                icon = '<img src="/assets/images/kr/social/naver.png" alt="">';
                                id = el.email;
                            }

                            findMemberHtml += `
                                <figure>
                                    ` + icon + `
                                    <figcaption>
                                        <p class="Text-lg">
                                            <span class="personal_id">` + id + `</span>
                                            <span class="join_date Text-sm">` + regdate + `</span>
                                        </p>
                                    </figcaption>
                                </figure>
                            `;
                        })
                        $(".content.id_result > p").after(findMemberHtml);

                        // 결과 페이지
                        $(".content").removeClass("active");
                        $(".content.id_result").addClass("active");
                    }
                }
            }
        )
        window.removeEventListener('message', findInfoAuthId);
    }
}

// 비밀번호 찾기
$(".content.find_pw button[name=resultPw]").on('click', function () {
    let id = $(".content.find_pw input[name=findPw]").val();
    $.ajax(
        '{C.API_DOMAIN}/v1/check/id',
        {
            type: 'POST',
            contentType: 'application/json',
            xhrFields: {
                withCredentials: true
            },
            data: JSON.stringify({
                id: id
            }),
            success: function (res) {
                let data = JSON.parse(res);
                if (data.result) {
                    toast.alert(data.message);
                    findInfoAuthPwPopup(id);
                } else {
                    toast.alert(data.message);
                }
            }
        }
    )
})

//  비밀번호 찾기 - 본인인증 팝업
var findInfoAuthPwPopup = function (id) {
    window.addEventListener("message", findInfoAuthPw);
    window.open(
        '{C.API_DOMAIN}/v1/check/popup/password?inputId=' + id + '&url=' + window.location.origin + '/findInfoAuthPw',
        'PASS',
        'width=500,height=900',
    );
}

//  비밀번호 찾기 - 본인인증 완료
var findInfoAuthPw = (e) => {
    if (e.origin !== window.location.origin) {
        return;
    }

    const authData = e.data;
    if (authData.type != null && authData.type == 'findInfoAuthPw' && authData.ci !== "" && authData.di !== "") {
        findPasswordParams.id = authData.id;
        findPasswordParams.ci = authData.ci;
        findPasswordParams.di = authData.di;

        $(".content").removeClass("active");
        $(".content.pw_result").addClass("active");
        window.removeEventListener('message', findInfoAuthPw);
    }
}


// 비밀번호 변경
$(".content.pw_result button[name=changingPw]").on('click', () => {
    findPasswordParams.newPassword = $(".content.pw_result input[name=changePw]").val();
    findPasswordParams.newPasswordConfirm = $(".content.pw_result input[name=changePwCheck]").val();

    $.ajax(
        '{C.API_DOMAIN}/v1/check/reset/password',
        {
            type: 'PUT',
            contentType: 'application/json',
            xhrFields: {
                withCredentials: true
            },
            data: JSON.stringify(findPasswordParams),
            success: function (res) {
                let data = JSON.parse(res);
                if (data.result) {
                    toast.alert(data.message);
                } else {
                    toast.alert(data.message);
                }
            }
        }
    )
})


// 비밀번호 찾기 버튼 활성화
$(".content.find_pw input[name=findPw]").on('input', () => {
    if ($(".content.find_pw input[name=findPw]").val().length > 0) {
        $(".content.find_pw button[name=resultPw]").attr("disabled", false);
    } else {
        $(".content.find_pw button[name=resultPw]").attr("disabled", true);
    }
})

// 비밀번호 변경 버튼 활성화
$(document).on('input', '.content.pw_result input[name=changePw], .content.pw_result input[name=changePwCheck]', () => {
    var chagePw = $(".content.pw_result input[name=changePw]").val().length;
    var changePwCheck = $(".content.pw_result input[name=changePwCheck]").val().length;
    if (chagePw > 0 && changePwCheck > 0) {
        $(".content.pw_result button[name=changingPw]").attr("disabled", false);
    } else {
        $(".content.pw_result button[name=changingPw]").attr("disabled", true);
    }
})

// 비밀번호 찾기 탭
let findPassword = function () {
    $('.find_tab_item:last-of-type').click();
}

/*버튼 토글*/
$('.find_tab_item').on('click', function () {
    $(".find_tab_item").removeClass("active");
    $(".content").removeClass("active");
    $(this).addClass("active");
    if ($('.find_tab_item:first-of-type').hasClass("active")) {
        $('.content.find_id').addClass("active");
    } else {
        $('.content.find_pw').addClass("active");
    }
})

</script>
