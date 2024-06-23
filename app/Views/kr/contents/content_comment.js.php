<script>
    $(document).ready(function () {
        // 베스트 댓글 리스트
        comment.bestCommentList();
    });

    /* 전역 변수 */
    let contentsIdx = { HTML.IDX };
    let params = new Map();
    let data = new Map();

    /* 전역 변수 기본값 세팅 */
    commentParams.default(params);
    scroll.default(data);

    let comment = {
        // 베스트 댓글 리스트
        bestCommentList: function () {

            // 댓글 정렬 필터 노출
            $("#comment_filter").show();

            $.ajax({
                url: '{ C.API_DOMAIN }/v1/contents/' + contentsIdx + '/comments/preview',
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

                        // 베스트 댓글 영역의 기존 내용 비우기
                        $("#comment_container .list_wrap").empty();

                        let bestComment = "";
                        if (res.data.contentCommentList.length > 0) {

                            $.each(res.data.contentCommentList, function (index, el) {

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

                                // 베스트 댓글 영역 set
                                bestComment += `
                                <div class="item">
                                  <div class="top_wrap">
                                    <div class="left_wrap">
                                      <svg width="25" height="17" viewBox="0 0 25 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="25" height="17" rx="3" fill="#FC324B" />
                                        <path
                                          d="M10.507 12.458V4.007H11.875V12.458H10.507ZM7.978 7.022H8.671V4.133H9.985V12.242H8.671V8.3H7.978V11.144H4.459V4.448H5.719V6.563H6.718V4.448H7.978V7.022ZM5.719 7.814V9.884H6.718V7.814H5.719ZM18.2982 5.969H19.4592V7.022H13.1412V5.969H14.3022V5.141H13.1412V4.097H19.4592V5.141H18.2982V5.969ZM16.9392 5.141H15.6612V5.969H16.9392V5.141ZM12.3042 8.489V7.4H20.2962V8.489H12.3042ZM19.4142 11.117H14.5902V11.504H19.6392V12.503H13.1862V10.172H18.0102V9.803H13.1412V8.84H19.4142V11.117Z"
                                          fill="white" />
                                      </svg>
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
                                  <p class="comment_text Text-lg">`+ el.content + `</p>
                                  <div class="bottom_wrap">

                                    <div class="like_` + el.idx + ' ' + checked +`" name="like" value="` + el.idx + `">
                                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M16.58 8.88H14.79L15.14 8C15.14 8 15.16 7.95 15.17 7.92C15.33 7.32 15.15 6.64 14.65 6.23L13.56 5.34C12.84 4.74 11.81 4.96 11.33 5.72L8.25 10.11C8.18 10.21 8.13 10.32 8.12 10.44H6.53C5.68 10.44 5 11.12 5 11.97V17.41C5 18.25 5.68 18.94 6.53 18.94H8.08C8.48 18.94 8.84 18.79 9.11 18.54C9.48 18.79 9.93 18.94 10.41 18.94H15.06C15.73 18.94 16.25 18.65 16.62 18.22C16.98 17.82 17.19 17.32 17.33 16.85L18.87 11.63C18.88 11.62 18.88 11.6 18.88 11.59C19.22 10.21 18.15 8.88 16.58 8.88ZM8.11 16.63V17.41C8.11 17.41 8.11 17.44 8.08 17.44H6.53C6.53 17.44 6.5 17.43 6.5 17.41V11.97C6.5 11.97 6.51 11.94 6.53 11.94H8.08C8.08 11.94 8.11 11.95 8.11 11.97V16.63ZM15.89 16.42C15.78 16.8 15.64 17.07 15.5 17.23C15.37 17.37 15.25 17.44 15.06 17.44H10.41C9.98 17.44 9.61 17.08 9.61 16.64V11.97V10.78L12.58 6.56C12.58 6.56 12.6 6.53 12.61 6.51H12.62L13.7 7.39C13.7 7.39 13.71 7.41 13.72 7.43C13.73 7.45 13.73 7.47 13.73 7.5L12.99 9.36C12.89 9.59 12.92 9.85 13.06 10.05C13.2 10.26 13.43 10.38 13.68 10.38H16.58C17.26 10.38 17.5 10.86 17.43 11.22L15.89 16.42Z" />
                                      </svg>
                                      <span class="Text-sm">`+ el.likeCnt + `</span>
                                    </div>

                                    <div class="reple_` + el.idx + `" name="reple" value="` + el.idx + `">
                                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M12.3904 5.76225C10.871 5.66702 9.36897 6.12969 8.16645 7.06341C6.96393 7.99712 6.14357 9.33766 5.85938 10.8334C5.57519 12.3291 5.84672 13.8771 6.623 15.1867C6.72781 15.3636 6.75545 15.5757 6.69944 15.7735L6.0965 17.903L8.22604 17.3001C8.4324 17.2416 8.64305 17.2756 8.81389 17.3772C10.1233 18.1529 11.6709 18.4242 13.1662 18.1401C14.6619 17.8559 16.0024 17.0356 16.9361 15.8331C17.8698 14.6305 18.3325 13.1286 18.2373 11.6091C18.142 10.0896 17.4955 8.65713 16.4189 7.58059C15.3424 6.50405 13.9099 5.85747 12.3904 5.76225ZM8.33415 18.8284C9.89496 19.6663 11.6993 19.9457 13.4462 19.6138C15.3008 19.2614 16.9631 18.2441 18.1209 16.753C19.2787 15.2619 19.8524 13.3994 19.7343 11.5153C19.6163 9.6311 18.8145 7.85484 17.4796 6.51993C16.1447 5.18502 14.3684 4.38326 12.4843 4.26518C10.6001 4.1471 8.73764 4.72082 7.24651 5.87862C5.75538 7.03642 4.73814 8.69869 4.38574 10.5534C4.05384 12.3002 4.33323 14.1046 5.17109 15.6654L4.57075 17.7857C4.50499 18.013 4.50122 18.2538 4.55988 18.4831C4.61886 18.7137 4.73877 18.9242 4.90706 19.0925C5.07535 19.2607 5.2858 19.3807 5.51637 19.4396C5.74566 19.4983 5.98644 19.4945 6.21375 19.4288L8.33415 18.8284Z" />
                                      </svg>
                                      <span class="Text-sm">`+ el.commentCnt + `</span>
                                    </div>
                                  </div>
                                   <div class="reple_list"></div>
                                </div>
                            `;
                            });
                        }
                        $(".list_wrap").html(bestComment);

                        // 기본 세팅
                        importJs.setting();

                        // 전체 댓글 리스트
                        comment.allCommentList();

                    } else {
                        // ajax exception error
                        // toast.alert(res.message);
                    }
                },
                error: function (request, status, error) {
                    // filter error
                    toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
                }
            });
            return false;
        },
        // 전체 댓글 리스트
        allCommentList: function () {

            // params value
            let page = params.get("page");
            let recordSize = params.get("commentCnt");
            let sortType = params.get("sortType");

            $.ajax({
                url: '{ C.API_DOMAIN }/v1/contents/' + contentsIdx + '/comments/all?page=' + page + '&recordSize=' + recordSize + '&sortType=' + sortType,
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
                        if (res.data.contentCommentList.length > 0) {

                            // 전체 페이지 개수 세팅
                            scroll.set(data, "totalPageCnt", res.data.params.pagination.totalPageCount);

                            // 전체 댓글 개수 set
                            $(".comment_cnt").html(res.data.params.pagination.totalRecordCount);

                            $.each(res.data.contentCommentList, function (index, el) {

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

                                    <div class="reple_`+ el.idx + `" name="reple" value="` + el.idx + `">
                                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M12.3904 5.76225C10.871 5.66702 9.36897 6.12969 8.16645 7.06341C6.96393 7.99712 6.14357 9.33766 5.85938 10.8334C5.57519 12.3291 5.84672 13.8771 6.623 15.1867C6.72781 15.3636 6.75545 15.5757 6.69944 15.7735L6.0965 17.903L8.22604 17.3001C8.4324 17.2416 8.64305 17.2756 8.81389 17.3772C10.1233 18.1529 11.6709 18.4242 13.1662 18.1401C14.6619 17.8559 16.0024 17.0356 16.9361 15.8331C17.8698 14.6305 18.3325 13.1286 18.2373 11.6091C18.142 10.0896 17.4955 8.65713 16.4189 7.58059C15.3424 6.50405 13.9099 5.85747 12.3904 5.76225ZM8.33415 18.8284C9.89496 19.6663 11.6993 19.9457 13.4462 19.6138C15.3008 19.2614 16.9631 18.2441 18.1209 16.753C19.2787 15.2619 19.8524 13.3994 19.7343 11.5153C19.6163 9.6311 18.8145 7.85484 17.4796 6.51993C16.1447 5.18502 14.3684 4.38326 12.4843 4.26518C10.6001 4.1471 8.73764 4.72082 7.24651 5.87862C5.75538 7.03642 4.73814 8.69869 4.38574 10.5534C4.05384 12.3002 4.33323 14.1046 5.17109 15.6654L4.57075 17.7857C4.50499 18.013 4.50122 18.2538 4.55988 18.4831C4.61886 18.7137 4.73877 18.9242 4.90706 19.0925C5.07535 19.2607 5.2858 19.3807 5.51637 19.4396C5.74566 19.4983 5.98644 19.4945 6.21375 19.4288L8.33415 18.8284Z" />
                                      </svg>
                                      <span class="Text-sm">`+ el.commentCnt + `</span>
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
                        $(".list_wrap").append(allComment);

                        // 댓글 이벤트 세팅
                        importJs.event();

                    } else {
                        // ajax exception error
                        // toast.alert(res.message);
                    }
                },
                error: function (request, status, error) {
                    // filter error
                    toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
                }
            });
            return false;
        },
        // 대댓글 리스트
        allReplyList: function (item, commentIdx) {

            // params value
            let page = params.get("page");
            let recordSize = params.get("replyCnt");
            let sortType = params.get("sortType");

            $.ajax({
                url: '{ C.API_DOMAIN }/v1/contents/' + contentsIdx + '/comments/'+ commentIdx + '?page=' + page + '&recordSize=' + recordSize + '&sortType=' + sortType,
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

                        // 전체 대댓글 영역 set
                        let allReply = "";
                        if (res.data.contentReplyList.length > 0) {

                            // 대댓글 개수 set
                            let className = ".reple_" + commentIdx;
                            $(className).find("span").html(res.data.params.pagination.totalRecordCount);

                            // 대댓글 리스트 set
                            $.each(res.data.contentReplyList, function (index, el) {

                                // 본인이 작성한 대댓글이면 신고하기 -> 삭제하기 버튼으로 변경
                                let button = `<button class="report Text-sm" value="`+ el.idx +`">신고하기</button>`;
                                if (local.memberInfo().data.idx === el.memberIdx) {
                                    button = `<button class="delete Text-sm" value="`+ el.idx +`">삭제하기</button>`;
                                }

                                allReply += `
                                      <div class="reple_item">
                                        <div class="reple_top">
                                          <p class="left_wrap Text-sm">
                                            <span>`+ el.writerNick +`</span>
                                            <span>`+ el.regdate +`</span>
                                          </p>
                                          <div class="dot_wrap">
                                            <svg width="20" height="18" xmlns="http://www.w3.org/2000/svg" fill="none">
                                              <path fill="#999999"
                                                d="m16.5,4c0,0.6904 -0.5596,1.25 -1.25,1.25c-0.6904,0 -1.25,-0.5596 -1.25,-1.25c0,-0.69036 0.5596,-1.25 1.25,-1.25c0.6904,0 1.25,0.55964 1.25,1.25zm0,5c0,0.6904 -0.5596,1.25 -1.25,1.25c-0.6904,0 -1.25,-0.5596 -1.25,-1.25c0,-0.6904 0.5596,-1.25 1.25,-1.25c0.6904,0 1.25,0.5596 1.25,1.25zm-1.25,6.25c0.6904,0 1.25,-0.5596 1.25,-1.25c0,-0.6904 -0.5596,-1.25 -1.25,-1.25c-0.6904,0 -1.25,0.5596 -1.25,1.25c0,0.6904 0.5596,1.25 1.25,1.25z"
                                                clip-rule="evenodd" fill-rule="evenodd" />
                                            </svg>
                                            <div class="dot_select">`+ button +`</div>
                                          </div>
                                        </div>
                                        <p class="content_text Text-lg">`+ el.content +`</p>
                                      </div>
                                `;
                            });
                        }
                        // 답글 입력창 영역 set
                        let inputBox = `
                                        <div class="write_box">
                                            <textarea placeholder="댓글 입력" class="Text-md" cols="40" row="5" maxlength="200" wrap="hard"></textarea>
                                            <span>
                                              <b class="Text-xs">0</b>
                                              <b class="Text-xs">200</b>
                                            </span>
                                            <hr class="line">
                                            <div class="box_bottom">
                                              <p class="Text-xs">※ 이 댓글에 대한 법적 책임은 작성자에게 귀속됩니다.</p>
                                              <button id="submit" class="submit_reply Text-xs">등록</button>
                                            </div>
                                        </div>
                                        <button id="close_all" class="close_reply">
                                            <span class="Text-sm">답글 접기</span>
                                        </button>
                                    `;

                        // html set
                        $(item).html(allReply);
                        $(item).append(inputBox);

                        // 대댓글 이벤트 세팅
                        importJs.event();

                    } else {
                        // ajax exception error
                        // toast.alert(res.message);
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
                url: '{ C.API_DOMAIN }/v1/contents/' + contentsIdx + '/comments/' + commentIdx + '/like',
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
                        // toast.alert(res.message);
                    }
                },
                error: function (request, status, error) {
                    // filter error
                    toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
                }
            });
            return false;
        },
        // 댓글 OR 대댓글 신고하기
        report: function (commentIdx) {

            $.ajax({
                url: '{ C.API_DOMAIN }/v1/contents/' + contentsIdx + '/comments/' + commentIdx + '/report',
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
                        comment.bestCommentList();
                    } else {
                        // ajax exception error
                        // toast.alert(res.message);
                    }
                },
                error: function (request, status, error) {
                    // filter error
                    toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
                }
            });
            return false;
        },
        // 댓글 OR 대댓글 삭제하기
        delete: function (commentIdx) {

            $.ajax({
                url: '{ C.API_DOMAIN }/v1/contents/' + contentsIdx + '/comments/' + commentIdx,
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
                        comment.bestCommentList();
                    } else {
                        // ajax exception error
                        // toast.alert(res.message);
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
                url: '{ C.API_DOMAIN }/v1/contents/' + contentsIdx + '/comments',
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
                        comment.bestCommentList();
                    } else {
                        // ajax exception error
                        // toast.alert(res.message);
                    }
                },
                error: function (request, status, error) {
                    // filter error
                    toast.alert("code: " + request.status + "<br>" + "message: " + request.responseText + "<br>" + "error :" + error);
                }
            });
            return false;
        },
        // 대댓글 등록하기
        registerReply: function (item, commentIdx, content) {

            // send data set
            let obj = {content: content};
            let data = JSON.stringify(obj);

            $.ajax({
                url: '{ C.API_DOMAIN }/v1/contents/' + contentsIdx + '/comments/' + commentIdx,
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
                        // 대댓글 리스트 재호출
                        comment.allReplyList(item, commentIdx);
                    } else {
                        // ajax exception error
                        // toast.alert(res.message);
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

            /*댓글 정렬 메뉴 펼치기 OR 숨기기*/
            $("#filter").off().click(function () {

                let angle = "0deg";

                // 펼치기
                if ($(".filter_list").hasClass("active") == false) {
                    $(".filter_list").addClass("active");
                    angle = "180deg";

                    // 숨기기
                } else {
                    $(".filter_list").removeClass("active");
                }
                // 필터 화살표 180도 회전
                $(".pointer").animate({ rotate: angle }, 300);
            });

            /*댓글 베플순 정렬*/
            $(".filter_like").click(function () {

                // 베플순 버튼 활성화
                $(this).addClass("active");
                $(".filter_list").find('button').not($(this)).removeClass("active");

                // 베플순 텍스트 세팅
                let selectedText = $(this).html();
                $(".filter_list").parent().children("#filter").children("span").html(selectedText);

                // 필터 화살표 180도 회전
                $(".pointer").animate({ rotate: "0deg" }, 300);

                // 댓글 정렬 메뉴 닫기
                $(this).parent().removeClass("active");

                // 댓글 리스트 재호출
                commentParams.set(params, "sortType", 1);
                comment.bestCommentList();
            });

            /*댓글 인기순 정렬*/
            $(".filter_reply").click(function () {

                // 인기순 버튼 활성화
                $(this).addClass("active");
                $(".filter_list").find('button').not($(this)).removeClass("active");

                // 인기순 텍스트 세팅
                let selectedText = $(this).html();
                $(".filter_list").parent().children("#filter").children("span").html(selectedText);

                // 필터 화살표 180도 회전
                $(".pointer").animate({ rotate: "0deg" }, 300);

                // 댓글 정렬 메뉴 닫기
                $(this).parent().removeClass("active");

                // 댓글 리스트 재호출
                commentParams.set(params, "sortType", 3);
                comment.bestCommentList();
            });

            /*댓글 최신순 정렬*/
            $(".filter_new").click(function () {

                // 최신순 버튼 활성화
                $(this).addClass("active");
                $(".filter_list").find('button').not($(this)).removeClass("active");

                // 최신순 텍스트 세팅
                let selectedText = $(this).html();
                $(".filter_list").parent().children("#filter").children("span").html(selectedText);

                // 필터 화살표 180도 회전
                $(".pointer").animate({ rotate: "0deg" }, 300);

                // 댓글 정렬 메뉴 닫기
                $(this).parent().removeClass("active");

                // 댓글 리스트 재호출
                commentParams.set(params, "sortType", 2);
                comment.bestCommentList();
            });

            /*뒤로 가기*/
            $(".comment_back").click(function () {
                history.back();
            });
        },
        // 댓글 OR 대댓글 이벤트
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

            /*댓글 OR 대댓글 신고하기 버튼*/
            $(".dot_select .report").off().click(function () {

                // 신고한 댓글 숨기기
                $(this).parent().parent().parent().parent().hide();

                // 댓글 신고하기
                let commentIdx = $(this).attr('value');
                comment.report(commentIdx);
            });

            /*댓글 OR 대댓글 삭제하기 버튼*/
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

            /*대댓글 리스트 펼치기*/
            $("div[name=reple]").off().click(function () {

                // 페이지 세팅
                commentParams.set(params, "page", 1);

                // 선택한 댓글 idx
                let commentIdx = $(this).attr('value');

                // 대댓글 영역 찾기
                let item = $(this).parent().parent().children('.reple_list');

                // 대댓글 펼치기
                if ($(this).hasClass("active") == false) {

                    // 대댓글 버튼 활성화
                    $(this).addClass("active");

                    // 대댓글 리스트 호출하기
                    comment.allReplyList(item, commentIdx);
                    item.addClass("active");

                    // 대댓글 접기
                } else {

                    // 대댓글 버튼 비활성화
                    $(this).removeClass("active");

                    // 대댓글 리스트 숨기기
                    item.removeClass("active");
                }
            });

            /*답글 접기 버튼*/
            $(".close_reply").click(function () {

                // 대댓글 버튼 비활성화
                $(this).parent().parent().find(".bottom_wrap").find("div[name='reple']").removeClass("active");

                // 대댓글 접기
                $(this).parent().removeClass("active");
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

            /*대댓글 등록*/
            $(".submit_reply").click(function () {

                // 댓글 내용
                let content = $(this).parent().parent().find("textarea").val();

                // 등록할 댓글이 있는 경우
                if (content.length > 0) {
                    // 부모 댓글 idx
                    let commentIdx = $(this).parent().parent().parent().parent().children(".bottom_wrap").children("div[name='reple']").attr("value");
                    // 대댓글 영역
                    let item = $(this).parent().parent().parent();
                    // 대댓글 등록
                    comment.registerReply(item, commentIdx, content);
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