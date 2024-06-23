<script>
    /* 전역 변수 */
    let params = new Map();
    let data = new Map();
    params.set("page",1);
    params.set("recordSize", 30);
    let getChargedLog = 'coin';

    $(document).ready(function () {
        // 회원 정보 조회
        let memberInfo = local.memberInfo();

        // 비로그인
        if (memberInfo == null) {
            // 로그인 모달 호출
            $(".charged_top").empty();
            $(".charged_content").empty();
            movePage.login();

            /*뒤로 가기*/
            $(".back").on("click", function() {
                // 메인 페이지로 이동
                movePage.main();
            });

            // 로그인
        } else {
            userlog.setting();
            scroll.default(data);
            switch (window.location.pathname){
                // 소멸
                case '/my/history/expired':
                    $(".disappear").trigger("click");
                    userlog.typeList("userlog.expire()");
                    break;

                // 사용
                case '/my/history/used':
                    $(".use").trigger("click");
                    userlog.typeList("userlog.used()");
                    break;

                // 충전
                default:
                    $(".charged").trigger("click");
                    if(getChargedLog =='coin'){
                        userlog.typeList("userlog.charged()");
                    } else {
                        userlog.typeList("userlog.mileage()");
                    }
                    break;
            }
            /*뒤로 가기*/
            $(".back").on("click", function() {
                // 마이페이지로 이동
                movePage.member();
            });

            /*스크롤 위치 감지 -> 다음 페이지 호출*/
            let startPoint = 0;
            $(window).scroll(function () {

                // 현재 스크롤 위치
                let current = $(window).scrollTop();

                // 이용 내역 리스트 영역 높이
                let endPoint = $(".contents").height();

                // 스크롤 위치 감지
                if (startPoint <= current && current <= endPoint) {

                    // 다음 페이지가 있을 경우
                    if (params.get("page") < data.get("totalPageCnt")) {

                        // 다음 페이지 세팅
                        params.set("page", params.get("page") + 1);

                        // 다음 작품 리스트 호출
                        eval(params.get("listType"));

                        // 다음 페이지 호출 위치 재설정
                        startPoint = endPoint - data.get("maxScroll");
                    }
                }
            });

            // 사용 - 필터
            $("input[name=type],input[name=genre]").change(function() {

                $("#use_sort, .use_top .sort_list, .use_top .sort_list li").removeClass("active");
                $(".use_top .sort_list li[value=" + $("input[name=type]:checked").val() + "]").addClass("active");
                $("#use_sort span").text($(".use_top .sort_list .active").text());
                params.set("useType",$("input[name=type]:checked").val());
                // 카테고리 설정
                params.set("useCate",$("input[name=genre]:checked").val());
                userlog.typeList("userlog.used()");
            });

            // 사용 - 필터
            $(".use_top .sort_list li").on("click",function() {
                $("#use_sort, .use_top .sort_list, .use_top .sort_list li").removeClass("active");
                $(this).addClass("active");
                $("#use_sort span").text($(".use_top .sort_list .active").text());
                // 타입선택
                $("input[value='" + $(this).attr("value") + "']").prop("checked",true);
                params.set("useType", $(this).attr("value"));
                userlog.typeList("userlog.used()");
            });

            // 편집버튼
            $(".switch input[type=checkbox]").click(function(){
                $(".switch span .edit-text").toggle();
                $(".use_top").toggle();
                $(".edit_top").toggle();
                $(".item label").toggle();
            });

            // 전체 선택
            $("#select_all_use").click(function() {
                if($("#select_all_use").is(":checked")) $("input[name='usedIdx']").prop("checked", true);
                else $("input[name='usedIdx']").prop("checked", false);
            });

            // 삭제
            $("#used_delete").click(function() {
                gModal.horizontalConfirm("선택한 사용 내역을 삭제할게요",userlog.setDelete);
            });

            $(".charge_tab .sort_list li").on("click",function() {
                $("#charge_sort, .charge_tab .sort_list, .charge_tab .sort_list li").removeClass("active");
                $(this).addClass("active");
                $("#charge_sort span").text($(this).data("name"));

                // 마일리지 충전 내역
                if ($(this).data("value") === 'mileage'){
                    userlog.typeList("userlog.mileage()");

                    // 코인 충전 내역
                } else{
                    userlog.typeList("userlog.charged()");
                }
            });

            // 필터 선택
            $('.select').click(function () {
                $(this).toggleClass('active');
                $(this).next(".sort_list").toggleClass('active');
            })
        }
    });
    let userlog = {
        charged: function () {
            getChargedLog = 'coin';
            $.ajax({
                url:'{ C.API_DOMAIN }/v1/member/payment?page=' + params.get("page") + '&recordSize=' + params.get("recordSize"),
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

                        let listTbody = '';
                        if (res.data.paymentList.length > 0) {

                            // 전체 페이지 개수 세팅
                            scroll.set(data, "totalPageCnt", res.data.params.pagination.totalPageCount);

                            // 충전 내역 세팅
                            $.each(res.data.paymentList, function (i,el) {
                                listTbody += `
                                    <div class="item">
                                      <div class="left">
                                        <span class="Text-xs">
                                          <b class="date">${el.regdate.toString()}</b>
                                        </span>
                                        <p class="item_title Text-sm">
                                          <span>${el.payTypeText.toString()}</span>
                                          <b>·</b>
                                          <span class="amount">${addComma(Math.floor(el.pay))}</span>
                                        </p>
                                      </div>
                                      <div class="right Text-sm">
                                        <span class="add_coin">${addComma(el.coin)}</span>
                                        <span class="add_mileage">${addComma(el.mileage)}</span>
                                      </div>
                                    </div>
                                `;
                            });
                            $("#chargedList").html(listTbody);
                            $("div[name='charge_content']").find(".no_result_wrap").removeClass("active");

                        } else {
                            // 전체 페이지 개수 세팅
                            scroll.set(data, "totalPageCnt", 0);

                            // 결과 없음 노출
                            $("#chargedList").children(".item").remove();
                            let text = `<span class="Text-lg">충전 내역</span>이 없어요`;
                            noResult.setting("charged", text);
                        }
                    }
                }
            });
        },mileage: function () {
            getChargedLog = 'mileage'
            $.ajax({
                url:'{ C.API_DOMAIN }/v1/member/coin/mileage?page=' + params.get("page") + '&recordSize=' + params.get("recordSize"),
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

                        let listTbody = '';
                        if (res.data.givenMileageList.length > 0) {

                            // 전체 페이지 개수 세팅
                            scroll.set(data, "totalPageCnt", res.data.params.pagination.totalPageCount);

                            $.each(res.data.givenMileageList,function (i,el) {
                                listTbody += `<div class="item">
                                              <div class="left">
                                                <span class="Text-xs">
                                                  <b class="date">${el.regdate.toString()}</b>
                                                </span>
                                                <p class="item_title Text-sm">
                                                  <span>${el.title.toString()}</span>
                                                </p>
                                              </div>
                                              <div class="right Text-sm">
                                                <span class="add_coin">${addComma(el.coin)}</span>
                                                <span class="add_mileage">${addComma(el.mileage)}</span>
                                              </div>
                                            </div>`;
                            });
                            $("#chargedList").html(listTbody);
                            $("div[name='charge_content']").find(".no_result_wrap").removeClass("active");

                        } else {
                            // 전체 페이지 개수 세팅
                            scroll.set(data, "totalPageCnt", 0);

                            // 결과 없음 노출
                            $("#chargedList").children(".item").remove();
                            let text = `<span class="Text-lg">충전 내역</span>이 없어요`;
                            noResult.setting("charged", text);
                        }
                    }
                }
            });
        },used: function () {
            let useType = params.get("useType") ? params.get("useType") : 'rent';
            let useCate = params.get("useCate") ? params.get("useCate") : 0;

            $.ajax({
                url: '{ C.API_DOMAIN }/v1/member/coin/use?page=' + params.get("page") + '&recordSize=' + params.get("recordSize") + '&searchType=' + useType + '&categoryIdx=' + useCate,
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

                        // 기존 영역 비우기
                        //$("#usedList").children(".item").remove();

                        let listTbody = '';
                        if (res.data.coinUsedList.length > 0) {

                            // 전체 페이지 개수 세팅
                            scroll.set(data, "totalPageCnt", res.data.params.pagination.totalPageCount);

                            $.each(res.data.coinUsedList,function (i,el) {
                                listTbody += `<div class="item edit">
                                            <div class="wrap">
                                              <div class="left">
                                                <span class="Text-xs">
                                                  <b class="date">${el.regdate.toString()}</b>
                                                </span>
                                                <p class="item_title Text-sm">
                                                  <span>${el.episodeTitle.toString()}</span>
                                                </p>
                                              </div>
                                              <div class="right Text-sm">
                                                 <span class="use_coin">${addComma(el.coin)}</span>
                                                 <span class="use_mileage">${addComma(el.mileage)}</span>
                                              </div>
                                            </div>
                                            <input type="checkbox" id="used${el.idx.toString()}" name="usedIdx" value="${el.idx.toString()}">
                                            <label for="used${el.idx.toString()}">
                                                <svg class="active" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                  <path d="M4 9.75L8.16327 14L16 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </label>
                                          </div>`;
                            });
                            $("#usedList").html(listTbody);
                            $("div[name='use_content']").find(".no_result_wrap").removeClass("active");

                        } else {
                            // 전체 페이지 개수 세팅
                            scroll.set(data, "totalPageCnt", 0);

                            // 결과 없음 노출
                            $("#usedList").children(".item").remove();
                            let text = `<span class="Text-lg">사용 내역</span>이 없어요`;
                            noResult.setting("used", text);
                        }
                    }
                }
            });
        },expire: function () {

            // 소멸 내역 담을 배열 생성
            let expireArr = new Array();

            // 코인 소멸 내역
            $.ajax({
                url: '{ C.API_DOMAIN }/v1/member/coin/expire?page=' + params.get("page") + '&recordSize=' + params.get("recordSize") + '&searchType=coin',
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
                        if (res.data.expireCoinList.length > 0) {
                            $.each(res.data.expireCoinList, function (i, el) {
                                expireArr.push(el);
                            });
                        }
                        // 마일리지 소멸 내역
                        $.ajax({
                            url: '{ C.API_DOMAIN }/v1/member/coin/expire?page=' + params.get("page") + '&recordSize=' + params.get("recordSize") + '&searchType=mileage',
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
                                    if (res.data.expireCoinList.length > 0) {
                                        $.each(res.data.expireCoinList, function (i, el) {
                                            expireArr.push(el);
                                        });
                                    }

                                    // 소멸 일자 기준 내림차순 정렬
                                    expireArr.sort(function(a, b) {
                                        let value_1 = a.expiredate.toUpperCase();
                                        let value_2 = b.expiredate.toUpperCase();
                                        if (value_1 < value_2) {
                                            return 1;
                                        } else if (value_1 > value_2) {
                                            return -1;
                                        }
                                        return 0;
                                    });

                                    // 코인 & 마일리지 소멸 내역 세팅
                                    let listTbody = '';
                                    if (expireArr.length > 0) {

                                        // 기존 영역 비우기
                                        $("#expireList").children(".item").remove();

                                        // 전체 페이지 개수 세팅
                                        scroll.set(data, "totalPageCnt", expireArr.length);

                                        $.each(expireArr, function(index, el){

                                            let className;
                                            if (el.type == 1) { // 코인
                                                className = "dis_coin";

                                            } else if (el.type == 3) { // 마일리지
                                                className = "dis_mileage";
                                            }

                                            listTbody += `
                                                    <div class="item">
                                                      <div class="left">
                                                        <span class="Text-xs">
                                                          <b class="date">${el.expiredate.toString()}</b>
                                                        </span>
                                                        <p class="item_title Text-sm">
                                                          <span>${el.expireTypeText.toString()}</span>
                                                        </p>
                                                      </div>
                                                      <div class="right Text-sm">
                                                        <span class="`+ className +`">${addComma(el.value)}</span>
                                                      </div>
                                                   </div>
                                                `;
                                        });
                                        $("#expireList").html(listTbody);
                                        $("div[name='expire_content']").find(".no_result_wrap").removeClass("active");

                                    } else {
                                        // 전체 페이지 개수 세팅
                                        scroll.set(data, "totalPageCnt", 0);

                                        // 결과 없음 노출
                                        $("#expireList").children(".item").remove();
                                        let text = `<span class="Text-lg">소멸 내역</span>이 없어요`;
                                        noResult.setting("expired", text);
                                    }
                                }
                            }
                        });
                    }
                }
            });
        },setDelete:function () {
            let chk_arr=[];
            $("input[name='usedIdx']:checked").each(function(){
                chk_arr.push($(this).val()); // push: 배열에 값 삽입
            });
            if(chk_arr.length < 1){
                // ajax exception error
                toast.alert("삭제 항목을 선택해주세요");
                return false;
            }
            $(".switch input[type=checkbox]").trigger("click");
            userlog.delete(chk_arr);
        },
        delete:function (arr) {
            $.ajax(
                '{C.API_DOMAIN}/v1/member/coin/use',
                {
                    type: 'DELETE',
                    contentType: 'application/json',
                    data:JSON.stringify({
                        idxList : arr,
                    }),
                    xhrFields: {
                        withCredentials: true
                    },
                    success: function (res) {
                        userlog.typeList("userlog.used()");
                    }
                }
            )
        },typeList:function (func) {
            // 기본 페이지 설정
            params.set("page",1);
            // 리스트 타입 할당
            params.set("listType",func);
            // 리스트 출력
            eval(params.get("listType"));

        },setting: function () {
            /*버튼 토글*/
            $(".charged_tab")
                .children("span")
                .click(function () {
                    $(".charged_tab>span").removeClass("active");
                    $(".contents>.content").removeClass("active");
                    $(this).addClass("active");
                    if ($(this).hasClass("charge active")) {
                        $(".content.charge").addClass("active");
                        $("#edit-btn").hide();
                    
                        if(getChargedLog =='coin'){
                            userlog.typeList("userlog.charged()");
                        } else {
                            userlog.typeList("userlog.mileage()");
                        }

                        history.pushState(null,null,'/my/history/charged');
                    } else if ($(this).hasClass("use active")) {
                        $(".content.use").addClass("active");
                        $("#edit-btn").show();
                        userlog.typeList("userlog.used()");
                        history.pushState(null,null,'/my/history/used');
                    } else if ($(this).hasClass("disappear active")) {
                        $(".content.disappear").addClass("active");
                        $("#edit-btn").hide();
                        userlog.typeList("userlog.expire()");
                        history.pushState(null,null,'/my/history/expired');
                    }
                });

            $(".charge_tab")
                .children("span")
                .click(function () {
                    $(".charge_tab>span").removeClass("active");
                    $(".charge.content").children(".content").removeClass("active");
                    $(this).addClass("active");

                    if ($(".charge_tab").children("span").hasClass("coin active")) {
                        // 코인
                        $(".coin.content").addClass("active");
                    } else if ($(".charge_tab").children("span").hasClass("mileage active")) {
                        // 마일리지
                        $(".mileage.content").addClass("active");
                    }
                });
        }
    }
</script>