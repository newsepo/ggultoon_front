<script>
  $(document).ready(function () {
      // 회원 정보 조회
      leave.memberInfo();
  });

  /* 전역 변수 */
  let memberIdx;

  let leave = {
      // 회원 정보 조회
      memberInfo: function() {

          $.ajax({
              url: '{ C.API_DOMAIN }/v1/member',
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
                      // 회원 idx 세팅
                      memberIdx = res.data.member.idx;

                      // 소멸 예정 코인 세팅
                      let coin = 0;

                      if (res.data.coin != undefined && res.data.coin.coin > 0 && res.data.member != undefined && res.data.member.idx > 0) {
                          coin = res.data.coin.coin;
                      }
                      $(".total").find(".Text-lg").html(coin);

                      // 기본 세팅
                      importJs.setting();
                  }
              },
              error: function (request, status, error) {
                  // filter error
                  toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
              }
          });
          return false;
      },
      // 회원 탈퇴
      deleteMember: function () {

          $.ajax({
              url: '{ C.API_DOMAIN }/v1/member?idx=' + memberIdx,
              method: "DELETE",
              dataType: 'json',
              processData: false,
              contentType: 'application/json',
              xhrFields: {
                  withCredentials: true
              },
              success: function (res) {
                  if (res.result) {

                      // 회원 정보 삭제
                      localStorage.removeItem("memberInfo");

                      // 탈퇴 확인 모달창 호출
                      importJs.callModal();

                  } else {
                      // 삭제 실패
                      toast.alert(res.message);
                  }
              },
              error: function (request, status, error) {
                  // filter error
                  toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
              }
          });
          return false;
      }
  }

  let importJs = {
      /*기본 세팅*/
      setting: function() {

          /*뒤로 가기*/
          $(".back").click(function () {
              // 환경설정 페이지로 이동
              movePage.setting();
          })

          /*안내사항 확인 체크*/
          $("input:checkbox[id='leave_me']").change(function () {
              if ($(this).is(':checked')) {
                  $("#leave_btn").attr("disabled", false);
              } else {
                  $("#leave_btn").attr("disabled", true);
              }
          })

          /*탈퇴하기 버튼*/
          $("#leave_btn").click(function () {

              // set params
              let params = new Map();
              params.set("title", `잠깐만요!<br>꿀툰 탈퇴를 고민하시나요?`);
              params.set("yes", "네, 지금 탈퇴할게요");
              params.set("no", "아니요, 조금 더 이용할게요");
              params.set("color", "yellow");

              // 예 버튼 클릭 시 회원 탈퇴 처리 되도록 콜백함수 세팅
              gModal.verticalConfirm(params, leave.deleteMember);
          })
      },
      /*확인 모달창 호출*/
      callModal: function () {

          // set params
          let params = new Map();
          params.set("title", "꿀툰 탈퇴가 완료되었어요");
          params.set("detail", "꿀툰을 이용해주셔서 감사합니다");
          params.set("color", "yellow");

          // 확인 버튼 클릭 시 메인 페이지로 이동하도록 콜백함수 세팅
          gModal.alert(params, movePage.main);
      }
  }
</script>