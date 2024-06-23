<script>
  $(document).ready(function () {
      // 알림 리스트
      notification.list();
  });

  /* 전역 변수 */
  let params = new Map();
  let data = new Map();
  let deleteIdxArr = new Array();

  /* 전역 변수 기본값 세팅 */
  notiParams.default(params);
  scroll.default(data);

  let notification = {
      // 알림 리스트
      list: function() {

          // params value
          let page = params.get("page");
          let recordSize = params.get("recordSize");

          $.ajax({
              url: '{ C.API_DOMAIN }/v1/member/notifications?page='+ page + '&recordSize=' + recordSize,
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

                      let listBody = "";
                      if (res.data.notificationList.length > 0) {

                          // 전체 페이지 개수 세팅
                          scroll.set(data, "totalPageCnt", res.data.params.pagination.totalPageCount);

                          $.each(res.data.notificationList, function (index, el) {

                              // 알림 확인 여부 세팅
                              let read = "";
                              if (el.isChecked) {
                                  read = "read";
                              }

                              // 알림 카테고리 세팅
                              let icon = notification.setIcon(el.category);

                              listBody += `
                                    <li value="`+ el.url +`" class="`+ read +`">
                                        <em class="notify-icon">`+ icon +`</em>
                                        <div class="text-area">
                                            <p class="notify-txt Text-md">`+ el.title +`</p>
                                            <span class="notify-time Text-xs">`+ el.regdate +`</span>
                                        </div>
                                        <div class="notify-check">
                                            <input type="checkbox" name="notify-check" id="notify-check`+ el.idx +`" value="`+ el.idx +`">
                                            <label for="notify-check`+ el.idx +`" class="input-check">
                                                <svg class="" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M4 9.75L8.16327 14L16 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </label>
                                        </div>
                                    </li>
                              `;
                          });
                          // html set
                          if (page == 1) {
                              $(".notify-list").html(listBody);
                          } else {
                              $(".notify-list").append(listBody);
                          }
                      } else {
                          // 전체 페이지 개수 세팅
                          scroll.set(data, "totalPageCnt", 0);

                          // 결과 없음 노출
                          $(".notify-list").hide();
                          let text = `<span class="Text-lg">받은 알림</span>이 없어요`;
                          noResult.setting("notification", text);
                      }
                      // 기본 세팅
                      importJs.setting();

                  } else {
                      toast.alert("로그인 후 이용해주세요");
                      movePage.login();
                  }
              },
              error: function (request, status, error) {
                  // filter error
                  toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
              }
          });
          return false;
      },
      // 알림 카테고리별 아이콘 세팅
      setIcon: function (category) {

          let icon = "";

          if (category == "충전") {
              icon = `💳`;

          } else if (category == "소멸") {
              icon = `💸`;

          } else if (category == "작품") {
              icon = `📚`;

          } else if (category == "공지") {
              icon = `📢`;

          } else if (category == "이벤트") {
              icon = `🎉`;

          } else if (category == "취소") {
              icon = `💳`;

          } else if (category == "코인") {
              icon = `💳`;

          } else if (category == "마일리지") {
              icon = `💳`;

          }
          return icon;
      },
      // 선택 알림 읽음
      read: function () {

          // params value
          let notificationIdx = params.get("notificationIdx");

          $.ajax({
              url: '{ C.API_DOMAIN }/v1/member/notifications/' + notificationIdx,
              method: "PUT",
              dataType: 'json',
              processData: false,
              contentType: 'application/json',
              xhrFields: {
                  withCredentials: true
              },
              success: function (res) {
                  if (res.result) {
                      // 알림 읽음 성공
                      if ($("#edit").text() == "편집") { // 조회 화면일 때만 적용
                            movePage.selectedNoti(params.get("url")); // 선택한 알림 확인용 url로 이동
                      }
                  } else {
                      // 알림 읽음 실패
                      toast.alert(res.message);
                  }
              },
              error: function (request, status, error) {
                  // filter error
                  toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
              }
          });
          return false;
      },
      // 선택 알림 삭제
      delete: function () {

          // 선택한 알림이 없는 경우
          if (deleteIdxArr.length == 0) {
              toast.alert("삭제할 알림이 없습니다.");

              // 선택한 알림이 있는 경우
          } else {
              // send data set
              let obj = {idxList: deleteIdxArr};
              let data = JSON.stringify(obj);

              $.ajax({
                  url: '{ C.API_DOMAIN }/v1/member/notifications',
                  method: "DELETE",
                  data: data,
                  dataType: 'json',
                  processData: false,
                  contentType: 'application/json',
                  xhrFields: {
                      withCredentials: true
                  },
                  success: function (res) {
                      if (res.result) {
                          // 알림 리스트 재호출
                          notification.list();
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
  }

  let importJs = {
      /*기본 세팅*/
      setting: function() {

          /*알림 선택*/
          $("li").click(function () {

              // 조회 화면일 때만
              if ($("#edit").text() == "편집") {

                  // 선택한 알림 idx 세팅
                  let notificationIdx = $(this).find(".notify-check").find("input").val();
                  notiParams.set(params, "notificationIdx", notificationIdx);

                  // 선택한 알림 url 세팅
                  let url = $(this).attr('value');
                  notiParams.set(params, "url", url);

                  // 선택한 알림 읽음 처리
                  notification.read();
              }
          })

          /*편집 버튼*/
          $("#edit").off().click(function () {

              if ($(this).text() == "편집") {
                  // 편집 화면으로 변경
                  $(".lib_container").addClass("edit");
                  // 편집 -> 완료 텍스트로 변경
                  $(this).text("완료");

              } else if ($(this).text() == "완료") {
                  // 조회 화면으로 변경
                  $(".lib_container").removeClass("edit");
                  // 완료 -> 편집 텍스트로 변경
                  $(this).text("편집");
              }
          })

          /*전체 선택*/
          $("input:checkbox[id='select_all']").on("change", function () {

              // 전체 선택
              if ($("input:checkbox[id='select_all']").is(":checked")) {
                  $("input:checkbox[name='notify-check']").prop("checked", true);

                  // 전체 알림 idx 배열에 추가
                  $("input:checkbox[name='notify-check']:checked").each(function(index, value){
                      deleteIdxArr.push(value.value);
                  });

                  // 전체 선택 해제
              } else {
                  $("input:checkbox[name='notify-check']").prop("checked", false);

                  // 배열 비우기
                  deleteIdxArr.length = 0;
              }
          })

          /*일부 선택*/
          $("input:checkbox[name='notify-check']").on("change", function () {

              // 알림 선택
              if ($(this).is(":checked")) {
                  // 선택한 알림 idx 배열에 추가
                  deleteIdxArr.push($(this).val());

                  // 알림 선택 해제
              } else {
                  // 선택한 알림 idx 배열에서 삭제
                  deleteIdxArr = deleteIdxArr.filter((element) => element !== $(this).val());
              }

              // 개별 선택한 개수가 전체 개수와 같다면
              if (deleteIdxArr.length == $("li").length) {
                  // 전체 선택 체크
                  $("input:checkbox[id='select_all']").prop("checked", true);

              } else {
                  // 전체 선택 체크 해제
                  $("input:checkbox[id='select_all']").prop("checked", false);
              }
          })

          /*삭제 버튼*/
          $("#delete").click(function () {
              // 예 버튼 클릭 시 선택한 알림 삭제하는 모달창 호출
              let msg = "선택한 알림을 삭제할게요";
              gModal.horizontalConfirm(msg, notification.delete);
          })

          /*뒤로 가기*/
          $("#notify").find("a").click(function () {
              // 마이페이지로 이동
              movePage.member();
          })
      }
  }

  /*스크롤 위치 감지 -> 다음 페이지 호출*/
  let startPoint = 0;
  $(window).scroll(function () {

      // 현재 스크롤 위치
      let current = $(window).scrollTop();

      // 알림 리스트 영역 높이
      let endPoint = $(".notify-list").height();

      // 스크롤 위치 감지
      if (startPoint <= current && current <= endPoint) {

          // 다음 페이지가 있을 경우
          if (params.get("page") < data.get("totalPageCnt")) {

              // 다음 페이지 세팅
              notiParams.set(params, "page", params.get("page") + 1);

              // 다음 알림 리스트 호출
              notification.list();

              // 다음 페이지 호출 위치 재설정
              startPoint = endPoint - data.get("maxScroll");
          }
      }
  });
</script>