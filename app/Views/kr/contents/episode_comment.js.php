<script>
    $(document).ready(function () {
        // 회차 댓글 리스트
        comment.allCommentList();
    });

    /* 전역 변수 */
    let contentsIdx = {HTML.contentsIdx}; // 작품 idx
    let episodeIdx = {HTML.episodeIdx}; // 회차 idx
    let params = new Map();
    let data = new Map();

    /* 전역 변수 기본값 세팅 */
    commentParams.default(params);
    scroll.default(data);

    let comment = {
        // 전체 댓글 리스트
        allCommentList: function () {

            // params value
            let page = params.get("page");
            let recordSize = params.get("commentCnt");

            $.ajax({
                url: '{ C.API_DOMAIN }/v1/episodes/' + episodeIdx + '/comments?page=' + page + '&recordSize=' + recordSize,
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

                        let allComment = "";
                        if (res.data.commentList.length > 0) {

                            // 전체 페이지 개수 세팅
                            scroll.set(data, "totalPageCnt", res.data.params.pagination.totalPageCount);

                            // 전체 댓글 개수 set
                            $(".comment_cnt").html(res.data.params.pagination.totalRecordCount);

                            $.each(res.data.commentList, function (index, el) {

                                // 좋아요 누른 댓글 set
                                let checked = "";
                                if (el.isMemberLike) {
                                    checked = "active";
                                }

                                // 본인이 작성한 댓글이면 신고하기 -> 삭제하기 버튼으로 변경
                                let button = `<button class="report Text-sm" value="`+ el.idx +`">신고하기</button>`;
                                if (local.memberInfo().data.idx === el.memberIdx) {
                                    button = `<button class="delete Text-sm" value="`+ el.idx +`">삭제하기</button>`;
                                }

                                // 전체 댓글 영역 set
                                allComment += `
                                    <div class="item">
                                      <div class="top_wrap">
                                        <div class="left_wrap">
                                          <p class="Text-sm">
                                            <span>`+ el.writerNick + `</span>
                                            <span>`+ el.regdate + `</span>
                                          </p>
                                        </div>
                                        <div class="dot_wrap">
                                          <svg class="active" width="20" height="18" xmlns="http://www.w3.org/2000/svg" fill="none">
                                            <path fill="#999999"
                                              d="m16.5,4c0,0.6904 -0.5596,1.25 -1.25,1.25c-0.6904,0 -1.25,-0.5596 -1.25,-1.25c0,-0.69036 0.5596,-1.25 1.25,-1.25c0.6904,0 1.25,0.55964 1.25,1.25zm0,5c0,0.6904 -0.5596,1.25 -1.25,1.25c-0.6904,0 -1.25,-0.5596 -1.25,-1.25c0,-0.6904 0.5596,-1.25 1.25,-1.25c0.6904,0 1.25,0.5596 1.25,1.25zm-1.25,6.25c0.6904,0 1.25,-0.5596 1.25,-1.25c0,-0.6904 -0.5596,-1.25 -1.25,-1.25c-0.6904,0 -1.25,0.5596 -1.25,1.25c0,0.6904 0.5596,1.25 1.25,1.25z"
                                              clip-rule="evenodd" fill-rule="evenodd" />
                                          </svg>
                                          <div class="dot_select" style="display: none">`+ button +`</div>
                                        </div>
                                      </div>
                                      <p class="comment_text Text-lg">`+ cleanXSS(el.content) + `</p>
                                      <div class="bottom_wrap">

                                        <div class="like_` + el.idx + ' ' + checked +`" name="like" value="` + el.idx + `">
                                          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M16.58 8.88H14.79L15.14 8C15.14 8 15.16 7.95 15.17 7.92C15.33 7.32 15.15 6.64 14.65 6.23L13.56 5.34C12.84 4.74 11.81 4.96 11.33 5.72L8.25 10.11C8.18 10.21 8.13 10.32 8.12 10.44H6.53C5.68 10.44 5 11.12 5 11.97V17.41C5 18.25 5.68 18.94 6.53 18.94H8.08C8.48 18.94 8.84 18.79 9.11 18.54C9.48 18.79 9.93 18.94 10.41 18.94H15.06C15.73 18.94 16.25 18.65 16.62 18.22C16.98 17.82 17.19 17.32 17.33 16.85L18.87 11.63C18.88 11.62 18.88 11.6 18.88 11.59C19.22 10.21 18.15 8.88 16.58 8.88ZM8.11 16.63V17.41C8.11 17.41 8.11 17.44 8.08 17.44H6.53C6.53 17.44 6.5 17.43 6.5 17.41V11.97C6.5 11.97 6.51 11.94 6.53 11.94H8.08C8.08 11.94 8.11 11.95 8.11 11.97V16.63ZM15.89 16.42C15.78 16.8 15.64 17.07 15.5 17.23C15.37 17.37 15.25 17.44 15.06 17.44H10.41C9.98 17.44 9.61 17.08 9.61 16.64V11.97V10.78L12.58 6.56C12.58 6.56 12.6 6.53 12.61 6.51H12.62L13.7 7.39C13.7 7.39 13.71 7.41 13.72 7.43C13.73 7.45 13.73 7.47 13.73 7.5L12.99 9.36C12.89 9.59 12.92 9.85 13.06 10.05C13.2 10.26 13.43 10.38 13.68 10.38H16.58C17.26 10.38 17.5 10.86 17.43 11.22L15.89 16.42Z" />
                                          </svg>
                                          <span class="Text-sm">`+ el.likeCnt + `</span>
                                        </div>
                                      </div>
                                      <div class="reple_list"></div>
                                    </div>
                                `;
                            });
                        } else {
                            // 전체 페이지 개수 세팅
                            scroll.set(data, "totalPageCnt", 0);

                            // 전체 댓글 개수 set
                            $(".comment_cnt").html(0);
                        }
                        $(".list_wrap").html(allComment);

                        // 기본 세팅
                        importJs.setting();

                        // 댓글 이벤트 세팅
                        importJs.event();

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
        },
        // 댓글 좋아요
        favorite: function (commentIdx) {

            $.ajax({
                url: '{ C.API_DOMAIN }/v1/episodes/' + episodeIdx + '/comments/' + commentIdx + '/like',
                cache : true,
                method: 'POST',
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
        },
        // 댓글 신고하기
        report: function (commentIdx) {

            $.ajax({
                url: '{ C.API_DOMAIN }/v1/episodes/' + episodeIdx + '/comments/' + commentIdx + '/report',
                cache : true,
                method: 'POST',
                dataType: 'json',
                processData: false,
                contentType: false,
                xhrFields: {
                    withCredentials: true
                },
                success: function (res) {
                    if (res.result) {
                        // 댓글 리스트 재호출
                        comment.allCommentList();
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
        },
        // 댓글 삭제하기
        delete: function (commentIdx) {

            $.ajax({
                url: '{ C.API_DOMAIN }/v1/episodes/' + episodeIdx + '/comments/' + commentIdx,
                cache : true,
                method: 'DELETE',
                dataType: 'json',
                processData: false,
                contentType: false,
                xhrFields: {
                    withCredentials: true
                },
                success: function (res) {
                    if (res.result) {
                        // 댓글 리스트 재호출
                        comment.allCommentList();
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
        },
        // 댓글 등록하기
        registerComment: function (content) {

            // send data set
            let obj = {content: content};
            let data = JSON.stringify(obj);

            $.ajax({
                url: '{ C.API_DOMAIN }/v1/episodes/' + episodeIdx + '/comments',
                cache : true,
                method: 'POST',
                data: data,
                dataType: 'json',
                processData: false,
                contentType: 'application/json',
                xhrFields: {
                    withCredentials: true
                },
                success: function (res) {
                    if (res.result) {
                        // 댓글 리스트 재호출
                        comment.allCommentList();
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
        setting: function () {

            /*뒤로 가기*/
            $(".comment_back").click(function () {
                history.back();
            });
        },
        // 댓글 이벤트
        event: function () {

            /*댓글 신고하기 OR 삭제하기 메뉴*/
            $(".dot_wrap").off().click(function () {

                // 펼치기
                if ($(this).children(".dot_select").is(":visible") == false) {
                    $(this).children(".dot_select").show();
                    $(".dot_wrap").not($(this)).find(".dot_select").hide();

                    // 숨기기
                } else {
                    $(this).children(".dot_select").hide();
                }
            });

            /*댓글 신고하기 버튼*/
            $(".dot_select .report").off().click(function () {

                // 신고한 댓글 숨기기
                $(this).parent().parent().parent().parent().hide();

                // 댓글 신고하기
                let commentIdx = $(this).attr('value');
                comment.report(commentIdx);
            });

            /*댓글 삭제하기 버튼*/
            $(".dot_select .delete").off().click(function () {

                // 삭제한 댓글 숨기기
                $(this).parent().parent().parent().parent().hide();

                // 댓글 삭제하기
                let commentIdx = $(this).attr('value');
                comment.delete(commentIdx);
            });

            /*댓글 좋아요 개수 반영*/
            $("div[name=like]").off().click(function () {

                // 선택한 댓글 idx
                let commentIdx = $(this).attr('value');

                // 선택한 댓글의 클래스명
                let className;

                // 현재 좋아요 개수
                let likeCnt = parseInt($(this).find('span').text());

                // 좋아요
                if ($(this).hasClass("active") == false) {

                    // 선택한 댓글의 클래스명
                    className = "." + $(this).attr('class');

                    // 좋아요 버튼 활성화
                    $(className).addClass("active");

                    // 좋아요 개수 +1
                    likeCnt = likeCnt + 1;
                    $(className).find('span').text(likeCnt);

                    // 좋아요 취소
                } else {

                    // 선택한 댓글의 클래스명
                    className = "." + $(this).removeClass("active").attr('class');

                    // 좋아요 버튼 비활성화
                    $(className).removeClass("active");

                    // 좋아요 개수 -1
                    likeCnt = likeCnt - 1;
                    $(className).find('span').text(likeCnt);
                }
                // 댓글 좋아요 OR 좋아요 취소
                comment.favorite(commentIdx);
            });

            /*댓글 입력창 글자수 체크*/
            $(".write_box textarea").on('keyup keydown', function (e) {

                // 입력받은 내용
                let content = $(this).val();

                // 실시간 글자수 카운팅
                $(this).parent().find("span").find("b:eq(0)").html(content.length);

                // 최대 200자까지만 노출
                if (content.length > 200) {
                    $(this).val(content.substring(0, 199));
                    $(this).parent().find("span").find("b:eq(0)").html(200);
                }
            });

            /*댓글 등록*/
            $(".submit_comment").click(function () {

                // 댓글 내용
                let content = $(this).parent().parent().find("textarea").val();

                // 등록할 댓글이 있는 경우
                if (content.length > 0) {
                    // 댓글 등록
                    comment.registerComment(content);
                    // 댓글 입력창 초기화
                    $(this).parent().parent().find("textarea").val("");
                    // 댓글 글자수 초기화
                    $(this).parent().parent().find("span").find("b:eq(0)").html(0);
                }
            });
        }
    }

    /*스크롤 위치 감지 -> 다음 페이지 호출*/
    let startPoint = 0;
    $(window).scroll(function () {

        // 현재 스크롤 위치
        let current = $(window).scrollTop();

        // 댓글 리스트 영역 높이
        let endPoint = $(".list_wrap").height();

        // 스크롤 위치 감지
        if (startPoint <= current && current <= endPoint) {

            // 다음 페이지가 있을 경우
            if (params.get("page") < data.get("totalPageCnt")) {

                // 다음 페이지 세팅
                commentParams.set(params, "page", params.get("page") + 1);

                // 다음 댓글 리스트 호출
                comment.allCommentList();

                // 다음 페이지 호출 위치 재설정
                startPoint = endPoint - data.get("maxScroll");
            }
        }
    });

    /* XSS 공격 방지 - html 태그 이스케이프 처리 */
    function cleanXSS(content) {

        let convertText = content
            .replace(/</g, "&lt;") // 꺽새 변환
            .replace(/>/g, "&gt;") // 꺽새 변환
            .replace("\\(", "&#40;") // 괄호 변환
            .replace("\\)", "&#41;") // 괄호 변환
            .replace(/\"/g, "&quot;") // 큰따옴표 변환
            .replace(/\'/g, "&#39;") // 작은따옴표 변환
            .replace(/\n/g, "<br />"); // <br> 태그 변환

        // 변환된 텍스트 리턴
        return convertText;
    }
</script>