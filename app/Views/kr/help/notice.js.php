<script>
    /* 전역 변수 */
    let params = new Map();
    let data = new Map();
    params.set("page",1);
    $(document).ready(function(){
        notice.tab();
        notice.list();
    });

    let notice = {
        list:function () {
            $.ajax({
                url: '{ C.API_DOMAIN }/v1/board/notices?page='+params.get("page")+'&recordSize=30',
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
                        if (res.data.noticeList.length > 0) {
                            $.each(res.data.noticeList,function (i,el) {
                                listTbody += `<li>
                                                <div class="notice-list-tit">
                                                    <p class="title-txt">
                                                        ${el.badgeList.length > 0 ?
                                    `<svg xmlns="http://www.w3.org/2000/svg" width="27" height="19" fill="none"><rect width="27" height="19" fill="#FC324B" rx="4"></rect><path fill="#fff" d="M10.99 4.23h1.56v4.66h-1.56V4.23Zm-.44 4.27c-.72.113-1.49.2-2.31.26-.82.053-1.6.08-2.34.08H4.49l-.07-1.31h.91V5.85h-.77V4.53h5.66v1.32h-.77v1.47l.94-.12.16 1.3Zm-2.6-2.65H6.84v1.67c.52-.027.89-.05 1.11-.07v-1.6Zm-.38 6.17v.47h5.23v1.18H6.01V10.9h4.98v-.43H5.96V9.33h6.59v2.69H7.57Zm10.932-4.15v.66h3.66v1.32h-8.88V8.53h3.66v-.66h-2.59V4.38h6.64v1.24h-5.07v1.01h5.17v1.24h-2.59Zm1.12 3.98h-5.36v-1.38h6.92v3.25h-1.56v-1.87Z"></path></svg>`:``
                                }
                                                        ${el.title.toString()}
                                                    </p>
                                                    <span class="date"> ${el.regdate.toString()}</span>
                                                    <svg class="ico-arrow" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" onclick="showTerms(this);">
                                                        <path d="M14 8L10 12L6 8" stroke="#999999" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </div>
                                                <div class="list-content">
                                                    <p class="Text-md">
                                                    ${el.content.toString()}
                                                    </p>
                                                </div>
                                          </li>`;
                            });
                        } else {
                            // 결과 없음 노출
                            $(".notice-list").hide();
                            let text = `<span class="Text-lg">공지사항</span>이 없어요`;
                            noResult.setting("notice", text);
                        }
                        $(".notice-list").append(listTbody);
                        notice.setting();
                    }
                }
            });
        },setting:function () {
            // 공지사항 .notice-list .list-content
            let listContent = document.querySelectorAll('.notice-list-tit');
            for(let i=0;i<listContent.length; i++){
                listContent[i].addEventListener('click',function(){
                    listContent[i].classList.toggle('active');
                })
            }
        },tab:function () {
            // tab list
            let tabList = document.querySelectorAll('.tab-list li');
            let tabContent = document.querySelectorAll('.tab-content');

            for(let i=0; i<tabList.length; i++){
                tabList[i].addEventListener('click',function(){
                    for(let j=0;j<tabContent.length; j++){
                        tabContent[j].classList.value = 'tab-content';
                        tabList[j].classList.value = '';
                    }
                    this.classList.add('active');
                    tabContent[i].classList.add('active');
                })
            }
        }
    }
</script>