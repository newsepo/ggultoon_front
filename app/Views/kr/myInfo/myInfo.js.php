<script>
    $(document).ready(function () {
        // 회원 등급 정보 노출
        $(".level").show();

        myinfo.member();

        // 닉네임 입력 확인
        $("#nickname").on('keyup keydown', function () {

            // 입력받은 닉네임
            let nick = $(this).val().replace(/ /g, "");

            // 입력값이 비어 있거나 글자수가 적은 경우
            if (nick == "" || nick.length < 2) {
                $(".info_wrap").find("li:eq(1)").find("span").removeClass("success").addClass("active");
                $(".info_wrap").find("li:eq(1)").find(".rule").html("2 ~ 12자의 한글, 영문, 숫자만 가능해요");
                $("#save_info").attr("disabled", true);

                // 글자수 초과한 경우
            } else if (nick.length > 12) {
                $("#nickname").val(nick.substring(0, 11));

            } else {
                // 닉네임 사용 여부 체크
                myinfo.checkNick(nick);
            }
        });

        // 비밀번호 보이기
        $(".pw_visivility").on("click",function () {
            $(this).children("svg").toggleClass("active");
            if ($(this).children("svg").eq(0).hasClass("active")) {
                $(this).prev("input").prop("type", "password");
            } else {
                $(this).prev("input").prop("type", "text");
            }
        });

        // 비밀번호 입력
        $("#change_password").on('keyup keydown', function () {
            const passwordRegex =
                /^(?=.*[A-Za-z])(?=.*[0-9!@#$%^&*()_+\-\=\[\]{};':"\\|,.<>\/?])[A-Za-z0-9!@#$%^&*()_+\-\=\[\]{};':"\\|,.<>\/?]{6,20}$/;

            // 입력받은 비밀번호
            let password =  $(this).val().replace(/ /g, "");

            // 비밀번호가 비어있거나 비밀번호 형식에 맞는 경우
            if (password == "" || passwordRegex.test(password)){
                $(this).parent().next("p").find(".rule").removeClass("active");
                $("#save_info").attr("disabled", false);
                $("#change_password_check").attr("disabled", false);

                // 글자수 초과한 경우
            }else if (password.length > 20) {
                $("#change_password").val(password.substring(0, 19));

            } else {
                // 영문, 숫자 또는 특수문자 포함한 6 ~ 20자만 가능해요
                $(this).parent().next("p").find(".rule").addClass("active");
                $("#save_info").attr("disabled", true);
                $("#change_password_check").attr("disabled", true);
            }
        });

        // 비밀번호 입력 확인
        $("#change_password_check").on('keyup keydown', function () {

            // 입력받은 비밀번호
            let password =  $(this).val().replace(/ /g, "");

            // 비밀번호가 비어있거나 위에 입력한 비밀번호와 일치하는 경우
            if (password == "" || $("#change_password").val() == password){
                $(this).parent().next("p").find(".rule").removeClass("active");
                $("#save_info").attr("disabled", false);

                // 글자수 초과한 경우
            } else if (password.length > 20) {
                $("#change_password_check").val(password.substring(0, 19));

            } else{
                // 영문, 숫자 또는 특수문자 포함한 6 ~ 20자만 가능해요
                $(this).parent().next("p").find(".rule").addClass("active");
                $("#save_info").attr("disabled", true);
            }
        });

        // 뒤로 가기
        $("#myInfo").find(".back").on("click",function () {
            movePage.member(); // 마이페이지로 이동
        });
    });

    /* 전역 변수 */
    let nick;

    let myinfo = {
      member:function () {

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

                      // 회원 아이디 정보
                      $("#user_id").text(memberInfo.id); // 회원 아이디

                      // 간편로그인은 아이디 대신 메일 정보
                      if (memberInfo.isSimple === 1){
                          $("#myInfo_id").text(memberInfo.email);
                      } else {
                          $("#myInfo_id").text(memberInfo.id);
                          $("#update_pass").show();
                      }

                      // 로그인 계정 타입 아이콘
                      if (memberInfo.simpleType == 'kakao'){
                          $("#myInfo_img").prop('src','/assets/images/kr/social/kakao.png');
                      } else if (memberInfo.simpleType == 'naver'){
                          $("#myInfo_img").prop('src','/assets/images/kr/social/naver.png');
                      } else {
                          $("#myInfo_img").prop('src','/assets/svgs/kr/main/ggultoon.svg');
                      }

                      if (memberInfo.nick){
                          $("#nickname").val(memberInfo.nick);
                          nick = memberInfo.nick;
                      }
                  }
              }
          });
      },
      update:function () {
            let data = {};
            data.nick = $("#nickname").val();
            data.newPassword = $("#change_password").val();
            data.newPasswordConfirm = $("#change_password_check").val();

              $.ajax({
                  url: '{ C.API_DOMAIN }/v1/member',
                  data:JSON.stringify(data),
                  method: 'PUT',
                  dataType: 'json',
                  processData: false,
                  contentType: 'application/json',
                  xhrFields: {
                      withCredentials: true
                  },
                  success: function (res) {
                      if (res.result) {
                          toast.alert(res.message);

                          // 로컬 스토리지 회원 닉네임 변경
                          let memberInfo = local.memberInfo();
                          memberInfo.data.nick = $("#nickname").val();
                          localStorage.setItem("memberInfo", JSON.stringify(memberInfo));
                      } else {
                          // ajax exception error
                          toast.alert(res.message);
                      }
                  },
                  error: function (request, status, error) {
                      // filter error
                      //toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
                  }
              });
      },
        // 닉네임 사용 가능 여부 체크
        checkNick: function (input) {

            $.ajax({
                url: '{ C.API_DOMAIN }/v1/member/nick/check?nick=' + input,
                cache: true,
                method: 'GET',
                dataType: 'json',
                processData: false,
                contentType: false,
                xhrFields: {
                    withCredentials: true
                },
                success: function (res) {

                    // 성공 시 결과 메세지 세팅
                    if (res.result) {
                        $(".info_wrap").find("li:eq(1)").find("span").addClass("success").addClass("active");
                        $(".info_wrap").find("li:eq(1)").find(".rule").html("멋진 닉네임이네요!");
                        $("#save_info").attr("disabled", false);

                        // 실패 시 결과 메세지 세팅
                    } else {
                        $(".info_wrap").find("li:eq(1)").find("span").removeClass("success").addClass("active");
                        $(".info_wrap").find("li:eq(1)").find(".rule").html(res.message);
                        $("#save_info").attr("disabled", true);
                    }
                },
                error: function (request, status, error) {
                    // filter error
                    //toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
                }
            });
            return false;
        }
    }
</script>