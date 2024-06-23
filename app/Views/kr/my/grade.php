<div class="level" style="display: none;">
    <figure>
        <img id="level_icon" src="/assets/svgs/kr/main/ggultoon.svg" alt=""/>
        <figcaption>
            <span class="Title-sm"></span>
            <p class="has_next_level Text-md" style="display: none;">
                <span>내 등급은 <b class="level_title"></b>이고</span>
                <span><b id="next_level"></b>까지 <b id="next_point"></b>원 남았어요</span>
            </p>
            <p class="last_level Text-md" style="display: none;">
                <span>축하드립니다! 최고 레벨인 <b class="level_title"></b>까지 도달하셨습니다!</span>
                <span>앞으로도 많은 혜택을 드리도록 하겠습니다!</span>
            </p>
        </figcaption>
    </figure>
    <div>
        <div class="level_graph">
            <div class="fill"></div>
        </div>
        <label for="">
            <span id="level1">동단지</span>
            <span id="level2">은단지</span>
            <span id="level3">금단지</span>
            <span id="level4">루비단지</span>
            <span id="level5">다이아단지</span>
        </label>
    </div>
</div>

<script>
    $(document).ready(function () {
        // 등급 표시
        grade.getGrade();
    });

    let grade = {
        getGrade:function () {
            $.ajax({
                url: '{ C.API_DOMAIN }/v1/grade',
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
                        // 회원 정보 조회
                        let memberInfo = local.memberInfo();
                        if (memberInfo != null) { // 로그인

                            // 회원 닉네임
                            let memberNick = memberInfo.data.nick;

                            // 닉네임 없는 경우
                            if (memberNick == "") {

                                // 간편 로그인
                                if (memberInfo.data.isSimple == 1) {
                                    // 이메일 세팅
                                    let memberEmail = memberInfo.data.email;
                                    $(".level").children("figure").children("figcaption").children("span").html(memberEmail);

                                    // 일반 로그인
                                } else {
                                    // 아이디 세팅
                                    let memberId = memberInfo.data.id;
                                    $(".level").children("figure").children("figcaption").children("span").html(memberId);
                                }

                                // 닉네임 있는 경우
                            } else {
                                // 닉네임 세팅
                                $(".level").children("figure").children("figcaption").children("span").html(memberNick);
                            }

                            /************* 회원 등급 그래프 세팅 *************/
                            let sum     = 0; // 포인트 합계
                            let point   = 0; // 포인트 그래프 크기
                            let level   = 0; // 현재 등급
                            let nextLevel   = 0; // 다음 등급
                            let next    = 0; // 다음 등급까지 남음 포인트
                            let step    = 0; // 1등급의 길이

                            // 총 결제 금액
                            $.each(res.data.amount, function (i, el) {
                                sum = sum + el.amount;
                            });

                            // 등급 그래프 달성 비율
                            $.each(res.data.gradeList, function (i, el) {

                                step = (100 / (res.data.gradeList.length - 2));

                                if (i >= 1 && sum >= el.condition){
                                    point = point + step;
                                    level = i

                                } else if (sum < el.condition){
                                    next = el.condition - sum;

                                    if (i > 0) {
                                        let p = res.data.gradeList[i-1].condition;
                                        point = point + ((sum - p) / (el.condition - p) * step) - step;
                                    }
                                    return false;
                                }
                            });

                            // 현재 레벨
                            $(".level_title").text(grade.gradeTitle(level));

                            // 현재 레벨 아이콘
                            $("#level_icon").prop('src', grade.gradeImg(level));

                            // 현재 등급 텍스트 활성화
                            $(".level label span .active").removeClass("active");
                            $("#level"+level).addClass("active");

                            // 등급 비율
                            $(".level_graph > .fill").animate({width: point+"%"}, 200);

                            // 다음 레벨이 있는 경우
                            if (level < res.data.gradeList.length - 1) {

                                $(".has_next_level").show();

                                // 다음 등급까지 남은 포인트
                                $("#next_point").text(addComma(next));

                                // 다음 레벨 안내
                                nextLevel = level + 1;
                                $("#next_level").text(grade.gradeTitle(nextLevel));
                                
                                // 다음 레벨이 없는 경우
                            } else {
                                $(".last_level").show();
                            }

                            // 마일리지 추가 적립 표시 및 다음달 등급 유지 표시
                            let gradeNoticeHtml = "";
                            let keepGradePoint = res.data.gradeList[level].condition - (sum - res.data.amount[0].amount);
                            if (nextLevel > 0) {
                                gradeNoticeHtml += '<span>' + grade.gradeTitle(nextLevel) + '</span> 등급 달성시 마일리지 <span>' + res.data.gradeList[nextLevel].addMileage + '%</span> 추가 적립';
                                if (keepGradePoint > 0) {
                                    gradeNoticeHtml += '<br />';
                                }
                            }
                            if (keepGradePoint > 0) {
                                gradeNoticeHtml += '다음달 등급 유지까지 <span>' + keepGradePoint + '원</span> 남았어요!';
                            }
                            if (gradeNoticeHtml != "") {
                                // 등급 달성 시 마일리지 추가 적립 안내 박스 노출
                                $('.charging_content .grade_section .grade_notice').html(gradeNoticeHtml);
                                $('.charging_content .grade_section .grade_notice').show();
                            }
                        }
                    }
                }
            });
        },gradeTitle:function (level) {
            let grade;
            switch(level){
                case 0:
                    grade='일반';
                    break;
                case 1:
                    grade='동단지';
                    break;
                case 2:
                    grade='은단지';
                    break;
                case 3:
                    grade='금단지';
                    break;
                case 4:
                    grade='루비단지';
                    break;
                case 5:
                    grade='다이아단지';
                    break;
                default:
                    grade='일반';
                    break;
            }
            return grade;
        },gradeImg:function (level) {
            let grade;
            switch(level){
                case 0:
                    grade='/assets/svgs/kr/member/icon_grade_00.svg';
                    break;
                case 1:
                    grade='/assets/svgs/kr/member/icon_grade_01.svg';
                    break;
                case 2:
                    grade='/assets/svgs/kr/member/icon_grade_02.svg';
                    break;
                case 3:
                    grade='/assets/svgs/kr/member/icon_grade_03.svg';
                    break;
                case 4:
                    grade='/assets/svgs/kr/member/icon_grade_04.svg';
                    break;
                case 5:
                    grade='/assets/svgs/kr/member/icon_grade_05.svg';
                    break;
                default:
                    grade='/assets/svgs/kr/member/icon_grade_00.svg';
                    break;
            }
            return grade;
        }
    }
</script>