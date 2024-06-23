<script>
  $(document).ready(function () {
    // 환경설정 리스트
    setting.list();
  });

  let setting = {
    // 환경설정 리스트
    list: function() {

      $.ajax({
        url: '{ C.API_DOMAIN }/v1/member/settings',
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
            if (res.data.settingList.length > 0) {

              $.each(res.data.settingList, function (index, el) {

                // 환경설정 상태 세팅
                let active = "";
                if (el.state == 1) {
                  active = "active";
                }
                listBody += `
                      <li class="`+ active +`">
                        <div class="left">
                          <h5>`+ el.title +`</h5>
                          <p class="Text-sm">`+ el.description +`</p>
                        </div>
                        <div class="toggle_wrap" value="`+ el.idx +`">
                          <span></span>
                        </div>
                      </li>
                `;
              });
            }
            $(".setting_content").html(listBody);

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
    // 환경설정 상태 변경
    changeState: function (settingIdx) {

        $.ajax({
            url: '{ C.API_DOMAIN }/v1/member/settings/' + settingIdx,
            cache : true,
            method: 'PUT',
            dataType: 'json',
            processData: false,
            contentType: false,
            xhrFields: {
                withCredentials: true
            },
            success: function (res) {
                if (res.result) {
                    //toast.alert(res.message);

                } else {
                    // ajax exception error
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

        /*토글 버튼*/
        $(".toggle_wrap").click(function () {

            // 설정 OFF
            if ($(this).parent().hasClass("active")) {
                $(this).parent("li").toggleClass();

            // 설정 ON
            } else {
                $(this).parent("li").toggleClass("active");
            }

            // 변경하려는 환경설정 idx
            let settingIdx = $(this).attr('value');

            // 환경설정 상태 변경
            setting.changeState(settingIdx);
        })

        /*뒤로 가기*/
        $(".back").click(function () {
            // 마이페이지로 이동
            movePage.member();
        })
    }
  }
</script>