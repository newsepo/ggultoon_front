<script>
    $(document).ready(function () {
        // 등급 정보 노출 여부 세팅
        let memberInfo = local.memberInfo();
        if (memberInfo != null) {
            $(".level").show();
        }
        // 배너 리스트
        charging.banner();
    });

    let charging = {
        // 배너 리스트
        banner: function () {

            // 메인 배너 세팅
            let data = new Map();
            data.set("type", 6);
            mainBanner.setting(data);

            // 결제 리스트
            charging.list();
        },
        // 결제 리스트
        list: function () {
            $.ajax({
                url: '{ C.API_DOMAIN }/v1/product/list',
                cache: true,
                method: 'GET',
                dataType: 'json',
                processData: false,
                contentType: false,
                xhrFields: {
                    withCredentials: true
                },
                success: function (res) {
                    if (res.result) {

                        // 결제 타이틀 설정
                        let title = '🎉 첫 결제니까 꿀혜택!';
                        switch (res.data.type) {
                            case 1:
                                title = '🎉 첫 결제니까 꿀혜택!';
                                break
                            case 2:
                                title = '😉 마일리지 혜택이 한 번 더!';
                                break
                            case 3:
                                title = '🎊 다시 돌아온 꿀 혜택!';
                                break
                        }
                        $("#charging_title").text(title);

                        $.each(res.data.list, function (i, el) {
                            let listTbody = `<li  onclick="charging.method(${el.idx.toString()},${el.coin.toString()},${el.mileage.toString()},${el.price.toString()})" id="charging_list${el.idx.toString()}">
                                              <div class="top_wrap">
                                                <div>
                                                  <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="11" cy="11" r="10.5" fill="#FFDF6B" stroke="#FBBD46" />
                                                    <circle cx="11" cy="11" r="7.5" fill="#FFC350" stroke="#FBBD46" />
                                                    <path
                                                      d="M13.3867 9.46875H15.168C14.9336 7.51758 13.457 6.39844 11.5 6.39844C9.26172 6.39844 7.55078 7.98633 7.55078 10.7578C7.55078 13.5176 9.23242 15.1172 11.5 15.1172C13.6562 15.1172 14.9746 13.6875 15.168 12.1172L13.3867 12.1055C13.2168 13.0254 12.4902 13.5527 11.5234 13.5586C10.2285 13.5527 9.34375 12.5859 9.34375 10.7578C9.34375 8.9707 10.2168 7.96289 11.5352 7.95703C12.5254 7.96289 13.2461 8.53125 13.3867 9.46875Z"
                                                      fill="#FFE794" />
                                                  </svg>
                                                  <span>${addComma(el.coin)}</span>
                                                </div>
                                                <p>${addComma(el.price)}</p>
                                              </div>
                                              <div class="bottom_wrap">
                                                <svg width="49" height="18" viewBox="0 0 49 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                  <path
                                                    d="M0 3C0 1.34315 1.34315 0 3 0H46C47.6569 0 49 1.34315 49 3V15C49 16.6569 47.6569 18 46 18H3C1.34314 18 0 16.6569 0 15V3Z"
                                                    fill="#3E7FFF" />
                                                  <path
                                                    d="M6.36 9.52L5.77 8.14C7.84 7.52 8.73 6.85 8.94 6.28H6.33V4.91H8.99V4.08H10.55V4.91H13.15V6.28H10.54C10.51 6.49 10.47 6.68 10.4 6.88L13.71 8.16L13.05 9.52L9.46 8.11C8.79 8.65 7.78 9.12 6.36 9.52ZM5.3 10.04H14.18V11.46H10.52V13.72H8.96V11.46H5.3V10.04ZM22.0024 7.49H23.2624V8.9H22.0024V13.62H20.4424V4.23H22.0024V7.49ZM17.6624 6.29H14.5924V4.87H19.2324V5.89C19.2324 8.58 17.8524 10.86 15.2324 12.62L14.2624 11.39C16.6824 9.84 17.6224 7.85 17.6624 6.29ZM32.1948 13.62V4.23H33.7048V13.62H32.1948ZM28.1448 5.41H29.4748V6.8H25.2348V5.41H26.5648V4.24H28.1448V5.41ZM29.4148 7.21H30.1448V4.37H31.6148V13.38H30.1448V11.12H29.4148V9.75H30.1448V8.58H29.4148V7.21ZM27.3648 7.38C28.4548 7.38 29.1748 8.28 29.1748 9.64V10.19C29.1748 11.55 28.4548 12.45 27.3648 12.45C26.2748 12.45 25.5448 11.55 25.5448 10.19V9.64C25.5448 8.28 26.2748 7.38 27.3648 7.38ZM27.7548 10.08V9.75C27.7548 9.12 27.6048 8.77 27.3548 8.77C27.1148 8.77 26.9548 9.12 26.9548 9.75V10.08C26.9548 10.72 27.1148 11.07 27.3548 11.07C27.6048 11.07 27.7548 10.72 27.7548 10.08ZM41.2273 6.14V4.23H42.6973V9.67H41.2273V7.51H40.5473V9.67H39.1373V4.33H40.5473V6.14H41.2273ZM38.5073 8.12L38.6573 9.3C38.0773 9.45 37.3773 9.53 36.2473 9.53H34.4573V4.58H38.3373V5.8H35.9773V6.42H38.2673V7.62H35.9773V8.3H36.5273C37.3273 8.3 37.9473 8.23 38.5073 8.12ZM41.1373 11.53H35.9573V10.11H42.6973V13.72H41.1373V11.53Z"
                                                    fill="white" />
                                                </svg>
                                                <p class="mileage_benefit">${addComma(el.mileage)}</p>
                                              </div>
                                            </li>`;
                            $("#charging_list").append(listTbody);
                        });

                        // 결제 내역이 없는 회원일 경우
                        // if (res.data.type == 1) {
                        //     // 첫결제 혜택 안내 모달 호출
                        //     let params = new Map();
                        //     let title = `<span><strong>첫 결제</strong> 회원님께 드리는 특별한 <strong>혜택</strong>!!</span>`;
                        //     let detail = `<span><strong>49,900원</strong>을 결제하면 무려 <strong>8,000원</strong>을 더 드려요!</span>`;
                        //     params.set("title", title);
                        //     params.set("detail", detail);
                        //     params.set("color", "yellow");
                        //     gModal.alert(params, "");
                        // }

                        /** 꿀툰 서비스 종료 -> 긴급 공지사항 안내 모달 노출 **/
                        // 서비스 종료 공지 모달 호출
                        gModal.showNotice();
                    }
                }
            });
        },
        // 결제 상품 리스트
        method: function (pid, coin, mileage, price) {

            $("#charging_list .active").removeClass("active");
            $("#charging_list" + pid).addClass("active");
            $("#select_product_coin").text(addComma(coin));
            $("#select_product_mileage").text(addComma(mileage));
            $("#select_product_price").text(addComma(price));

            $.ajax({
                url: '{ C.API_DOMAIN }/v1/product/method/' + pid,
                cache: true,
                method: 'GET',
                dataType: 'json',
                processData: false,
                contentType: false,
                xhrFields: {
                    withCredentials: true
                },
                success: function (res) {
                    if (res.result) {

                        $("#select_product").show();
                        $(".simple_pay").show();
                        $(".normal_pay").show();
                        $("#simple_pay").text("");
                        $("#normal_pay").text("");
                        $.each(res.data.list, function (index, el) {
                            let payid = 'coin'+ coin;
                            $("#simple_pay").append(charging.payMethod(pid, el.method, 'simple',payid));
                            $("#normal_pay").append(charging.payMethod(pid, el.method, 'normal',payid));
                        });
                        // 선택상품 정보 스크롤
                        $(document).scrollTop($("#select_product").offset().top - 100);

                    } else {
                        // 회원 정보 조회
                        let memberInfo = local.memberInfo();

                        // 비로그인
                        if (memberInfo == null) {
                            toast.alert("로그인 후 이용해주세요");
                            movePage.login();

                            // 로그인
                        } else {
                            toast.alert(res.message);
                        }
                    }
                }
            });
        },
        // 결제 수단 리스트
        payMethod: function (pid, method, type, payid) {
            let res;
            let oPay = {};
            let oPayId = {};
            if (type == 'simple') {
                oPay['KKP'] = `<img src="/assets/images/kr/payment_btn/kakao_pay.png" alt="" />`;
                oPay['NVP'] = `<img src="/assets/images/kr/payment_btn/naver_pay.png" alt="" />`;
                oPay['samsungPay'] = `<img src="/assets/images/kr/payment_btn/samsung_pay.png" alt="" />`;
                oPay['PAC'] = `페이코`;
                oPayId['KKP'] = 'kakaopay';
                oPayId['NVP'] = 'naverpay';
                oPayId['samsungPay'] = 'samsungpay';
            } else {
                oPay['point'] = `포인트다모아`;
                oPay['tmoney'] = `티머니`;
                oPay['booknlife'] = `도서상품권`;
                oPay['smartcash'] = `스마트문상`;
                oPay['culturecash'] = `컬쳐랜드`;
                oPay['happymoney'] = `해피머니`;
                oPay['teencash'] = `틴캐시`;
                oPay['mobile'] = `휴대폰`;
                oPay['vbank'] = `가상계좌`;
                oPay['bank'] = `계좌이체`;
                oPay['card'] = `신용(체크)카드`;
                oPayId['tmoney'] = 'tmoney';
                oPayId['booknlife'] = 'bookgift';
                oPayId['smartcash'] = 'smartgiftcard';
                oPayId['culturecash'] = 'culturland';
                oPayId['happymoney'] = 'happymoney';
                oPayId['teencash'] = 'tincash';
                oPayId['mobile'] = 'mobilepay';
                oPayId['vbank'] = 'virtualpay';
                oPayId['bank'] = 'accountpay';
                oPayId['card'] = 'creditcard';

            }
            if (oPay[method]) {
                /** 꿀툰 서비스 종료 -> 결제 API 호출 방지 **/
                //res = `<button class="Text-sm" id="` + payid + oPayId[method] + `" onclick="charging.sendPg(` + pid + `,'` + method + `')">` + oPay[method] + `</button>`;
                res = `<button class="Text-sm" id="` + payid + oPayId[method] + `">` + oPay[method] + `</button>`;
            }
            return res;
        },
        //용도 : SHA256 해쉬 처리 및 민감정보 AES256암호화
        sendPg: function (pid, method) {

            $.ajax({
                type: "GET",
                url: "{ C.API_DOMAIN }/v1/payment/info?methodType=" + method + "&pid=" + pid,
                xhrFields: {
                    withCredentials: true
                },
                dataType: "json",
                success: function (rsp) {
                    let userInfo = JSON.parse(rsp.data.mchtParam);
                    // 앱결제 처리
                    if(app.get3rdPartyPurchaseInfo){
                        let appInfo = app.get3rdPartyPurchaseInfo;
                        rsp.data.mchtParam = JSON.stringify($.extend(userInfo,appInfo));

                    }
                    SETTLE_PG.pay({
                        env: rsp.data.env,                    // 결제서버 URL
                        mchtId: rsp.data.mchtId,              // 상점아이디
                        method: rsp.data.method,              // 결제수단
                        trdDt: rsp.data.trdDt,                // 결제일
                        trdTm: rsp.data.trdTm,                // 결제시간
                        mchtTrdNo: rsp.data.mchtTrdNo,        // 결제번호
                        mchtName: rsp.data.mchtName,          // 상점명(한글)
                        mchtEName: rsp.data.mchtEName,        // 상점명(영문)
                        mchtCustId: rsp.data.mchtCustId,      // 회원아이디
                        pmtPrdtNm: rsp.data.pmtPrdtNm,        // 상품명
                        trdAmt: rsp.data.trdAmt,              // 상품가격
                        mchtCustNm: rsp.data.mchtCustNm,      // 회원이름
                        expireDt: rsp.data.expireDt,          // 상품제공일
                        notiUrl: rsp.data.notiUrl,            // 결제 완료 처리 서버 notiUrl
                        nextUrl: "{ C.URL_DOMAIN }/charging/complete",                   // 결제완료 시 이동 사용자 페이지 URL 설정
                        cancUrl: "{ C.URL_DOMAIN }/charging/cancel",                  // 결제중단 시 이동 사용자 페이지 URL 설정
                        mchtParam: rsp.data.mchtParam,         // 추가 파라메터 회원번호, 상품번호
                        pktHash: rsp.data.pktHash,             //SHA256 처리된 해쉬 값 세팅
                        prdtTerm: rsp.data.prdtTerm,           // 상품 제공기간
                        corpPayCode: rsp.data.corpPayCode,     // 간편결제 코드
                        cardGb: rsp.data.cardGb,                // 다이렉트 결제코드
                        methodSub: rsp.data.methodSub,          // 추가 결제 정보
                        ui: {
                            type: "popup",   //popup, iframe, self, blank
                            width: "430",   //popup창의 너비
                            height: "660"   //popup창의 높이
                        }
                    },
                        function (rsp) {
                            //iframe인 경우 전달된 결제 완료 후 응답 파라미터 처리
                            console.log(rsp);
                        });
                },
                error: function () {
                    toast.alert("다시 시도해주세요");
                }
            });
        }
    }
</script>