<div id="commu_container">
    <div class="commu_top">
        <label for="">
            <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="11.7812" cy="11.7812" r="6.09375" stroke="#999999" stroke-width="2"></circle>
                <path d="M20.3125 20.3125L16.25 16.25" stroke="#999999" stroke-width="2" stroke-linecap="round"></path>
            </svg>
            <input class="Text-md" type="text" placeholder="제목, 닉네임을 검색해보세요">
        </label>
    </div>
    <!-- 커뮤니티 상단 검색바  -->

    <div class="list_container">
        <div class="filter_wrap">
            <div class="left select_wrap">
                <button class="">
                    <span class="Text-sm">전체</span>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 8L10 12L6 8" stroke="#999999" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </svg>
                </button>
                <div class="sort_list">
                    <button class="Text-sm">전체</button>
                    <button class="Text-sm">유머</button>
                    <button class="Text-sm">웹툰</button>
                    <button class="Text-sm">만화</button>
                    <button class="Text-sm">소설</button>
                </div>
            </div>
            <div class="right select_wrap">
                <button>
                    <span class="Text-sm">최신순</span>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 8L10 12L6 8" stroke="#999999" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </svg>
                </button>
                <div class="sort_list">
                    <button class="Text-sm">최신순</button>
                    <button class="Text-sm">인기순</button>
                    <button class="Text-sm">추천순</button>
                </div>
            </div>
        </div>
        <ul>

        </ul>

        <!-- 
            커뮤니티 리스트 아이템 
            기본형(이미지 없이 텍스트만 있는 게시물) = .commu_item ,
            이미지포함 = .commu_item과 .img_post 클래스 함께 사용
        -->

        <div class="no_result">
            <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M11.6692 6.9191C11.0834 7.50489 11.0834 8.44769 11.0834 10.3333V10.6666H14.2501C15.3546 10.6666 16.2501 11.5621 16.2501 12.6666C16.2501 13.7712 15.3546 14.6666 14.2501 14.6666H11.0834V18.5833H14.2501C15.3546 18.5833 16.2501 19.4787 16.2501 20.5833C16.2501 21.6879 15.3546 22.5833 14.2501 22.5833H11.0834V26.5H14.2501C15.3546 26.5 16.2501 27.3954 16.2501 28.5C16.2501 29.6045 15.3546 30.5 14.2501 30.5H11.0926C11.1202 31.586 11.2303 32.2253 11.6692 32.6642C12.255 33.25 13.1978 33.25 15.0834 33.25H27.6667C29.5524 33.25 30.4952 33.25 31.0809 32.6642C31.6667 32.0784 31.6667 31.1356 31.6667 29.25V10.3333C31.6667 8.4477 31.6667 7.50489 31.0809 6.9191C30.4952 6.33331 29.5524 6.33331 27.6667 6.33331H15.0834C13.1978 6.33331 12.255 6.33331 11.6692 6.9191ZM25.3333 16.8333C24.781 16.8333 24.3333 16.3856 24.3333 15.8333V12.6666C24.3333 12.1144 24.781 11.6666 25.3333 11.6666C25.8856 11.6666 26.3333 12.1144 26.3333 12.6666V15.8333C26.3333 16.3856 25.8856 16.8333 25.3333 16.8333ZM7.91666 11.6666C7.36437 11.6666 6.91666 12.1144 6.91666 12.6666C6.91666 13.2189 7.36437 13.6666 7.91666 13.6666H14.25C14.8023 13.6666 15.25 13.2189 15.25 12.6666C15.25 12.1144 14.8023 11.6666 14.25 11.6666H7.91666ZM7.91666 19.5833C7.36437 19.5833 6.91666 20.031 6.91666 20.5833C6.91666 21.1356 7.36437 21.5833 7.91666 21.5833H14.25C14.8023 21.5833 15.25 21.1356 15.25 20.5833C15.25 20.031 14.8023 19.5833 14.25 19.5833H7.91666ZM7.91666 27.5C7.36437 27.5 6.91666 27.9477 6.91666 28.5C6.91666 29.0523 7.36437 29.5 7.91666 29.5H14.25C14.8023 29.5 15.25 29.0523 15.25 28.5C15.25 27.9477 14.8023 27.5 14.25 27.5H7.91666Z"
                    fill="#E4E4E4" />
            </svg>
            <p>
                '<span class="Text-lg">검색어</span>'
                <span class="Text-lg">에 대한 결과가 없어요</span>
            </p>
        </div>

        <!-- 페이징 -->
        <ol class="pagination">
            <li class="pre disable">
                <button>
                    <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="17" cy="17" r="16.25" stroke="#E0E0E0" stroke-width="1.5" />
                        <path d="M19 12L14 17L19 22" stroke="#E0E0E0" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>

                </button>
            </li>
            <li class="active"><a href="" class="Text-sm">1</a></li>
            <li><a href="" class="Text-sm">2</a></li>
            <li><a href="" class="Text-sm">3</a></li>
            <li><a href="" class="Text-sm">4</a></li>
            <li><a href="" class="Text-sm">5</a></li>
            <li class="next">
                <button>
                    <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="17" cy="17" r="16.25" stroke="#222222" stroke-width="1.5" />
                        <path d="M15 12L20 17L15 22" stroke="#222222" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>

                </button>
            </li>
        </ol>
    </div>
</div>
<button id="write_post" onclick="writePost()">
    <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="25" cy="25" r="25" fill="#FFE143" />
        <path
            d="M15.5 27L15 31.5L19.5 31L30.0858 20.4142C30.8668 19.6332 30.8668 18.3668 30.0858 17.5858L28.9142 16.4142C28.1332 15.6332 26.8668 15.6332 26.0858 16.4142L15.5 27Z"
            stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        <path d="M24.5 18L28.5 22" stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        <path d="M23.5 32H31.5" stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
    </svg>
</button>

<script>
    $('.select_wrap.left>button').click(function () {
        $(this).toggleClass('active');
        $('.select_wrap.left').children('.sort_list').toggleClass('active');
    })

    $('.select_wrap.right>button').click(function () {
        $(this).toggleClass('active');
        $('.select_wrap.right').children('.sort_list').toggleClass('active');
    })

    function writePost() {

        // 회원 정보 조회
        let memberInfo = local.memberInfo();
        
        // 비로그인
        if (memberInfo == null) {
            toast.alert("로그인 후 이용해주세요");
            movePage.login();
            
            // 로그인
        } else {
            // 닉네임 체크
            if (memberInfo.data.nick == "") { // 닉네임 없음
                if (show == false) {
                    $("#nickname_sheet_container").animate({ bottom: 0 }, 'fast');
                    show = true;
                    $("#reple_wrap").prop("checked", true);
                } else {
                    $("#nickname_sheet_container").animate({ bottom: -300 }, 'fast');
                    show = false;
                    $("#reple_wrap").prop("checked", false);
                }
            } else { // 닉네임 있음
                location.href = "/community/write";
            }
        }
    }

    /* 전역 변수 */
    let params = new Map();
    let data = new Map();
    params.set("page", 1);
    $(document).ready(function () {
        // notice.tab();
        // notice.list();
    });


    // api 대신
    let COMMU_API = {
        "result": true,
        "code": "1000",
        "data": {
            "params": {
                "pagination": {
                    "limitStart": 0,
                    "startPage": 1,
                    "totalPageCount": 1,
                    "existNextPage": false,
                    "endPage": 1,
                    "existPrevPage": false,
                    "totalRecordCount": 4
                },
                "offset": 0,
                "sortType": 1,
                "categoryIdx": 0,
                "limit": 10,
                "pageSize": 5,
                "searchWord": "",
                "page": 1,
                "adult": 1,
                "recordSize": 10
            },
            "contentList": [
                {
                    "nick": "mjey",
                    "likeCnt": 4,
                    "viewCnt": 0,
                    "regdate": "5월 17일",
                    "title": "이미지 테스트3",
                    "category": "작품 홍보",
                    "idx": 4,
                    "adult": 1,
                    "commentCnt": 6,
                    "imageList": [
                        {
                            "width": 328,
                            "sort": 1,
                            "url": "https://tb.devlabs.co.kr/2Y8MuHvaOlpD7QXJQi6KrPdmUoI=/328x446/https://webtoon-imgs.devlabs.co.kr/community/contents/4/6234e1d2-2815-4cd1-b277-8bd625345421.png",
                            "height": 446
                        }
                    ],
                    "isMemberLike": false,
                    "content": "이미지 테스트3"
                },
                {
                    "nick": "mjey",
                    "likeCnt": 3,
                    "viewCnt": 0,
                    "regdate": "5월 17일",
                    "title": "이미지 테스트2",
                    "category": "작품 홍보",
                    "idx": 3,
                    "adult": 0,
                    "commentCnt": 7,
                    "imageList": [
                        {
                            "width": 328,
                            "sort": 1,
                            "url": "https://tb.devlabs.co.kr/3q-X1liJhjtBqTH9qYZtbxqu0Vc=/328x328/https://webtoon-imgs.devlabs.co.kr/community/contents/3/20b31ee7-6220-4e76-9b68-8a4511386008.png",
                            "height": 328
                        }
                    ],
                    "isMemberLike": true,
                    "content": "이미지 테스트2"
                },
                {
                    "nick": "mjey",
                    "likeCnt": 2,
                    "viewCnt": 0,
                    "regdate": "5월 17일",
                    "title": "이미지 테스트1 ",
                    "category": "작품 홍보",
                    "idx": 2,
                    "adult": 0,
                    "commentCnt": 8,
                    "imageList": [
                        {
                            "width": 328,
                            "sort": 1,
                            "url": "https://tb.devlabs.co.kr/B54matFXE4ziu4LvP6-4WDmyAFA=/328x328/https://webtoon-imgs.devlabs.co.kr/community/contents/2/11176b32-b627-4853-8651-7d0ff1ccb96c.jpg",
                            "height": 328
                        }
                    ],
                    "isMemberLike": true,
                    "content": "이미지 테스트1"
                },
                {
                    "nick": "mjey",
                    "likeCnt": 1,
                    "viewCnt": 10,
                    "regdate": "5월 11일",
                    "title": "테스트",
                    "category": "일반",
                    "idx": 1,
                    "adult": 0,
                    "commentCnt": 9,
                    "imageList": [],
                    "isMemberLike": true,
                    "content": "테스트"
                }
            ]
        },
        "message": "조회를 완료하였습니다."
    }


    console.log(COMMU_API.data.contentList);
    // console.log(COMMU_API.data.contentList.commentCnt);

    let listBody = "";
    if (COMMU_API.data.contentList.length > 0) {
        $.each(COMMU_API.data.contentList, function (index, item) {

            // console.log(item.imageList[0].url);
            listBody += `
            
                <li>
                    <div class="commu_item">
                    <div class="item_wrap">
                            <p class="Text-lg post_title">`+ item.title + `</p>
                            <span class="nickname Text-xs">`+ item.nick + `</span>
                            <div class="info_wrap">
                                <div class="info_item">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M2.23183 7.38924C3.0431 6.08042 4.89277 3.83331 8.00001 3.83331C11.1072 3.83331 12.9569 6.08042 13.7682 7.38924C14.0086 7.77713 14.0279 7.83312 14.0231 7.96207C14.0183 8.08961 13.9928 8.14831 13.7126 8.5328C13.2401 9.18135 12.4755 10.0996 11.487 10.8518C10.498 11.6043 9.31729 12.1666 8.00001 12.1666C6.68273 12.1666 5.50199 11.6043 4.51303 10.8518C3.52452 10.0996 2.75988 9.18135 2.28738 8.5328C2.00727 8.14831 1.98172 8.08961 1.97695 7.96207C1.97213 7.83312 1.9914 7.77713 2.23183 7.38924ZM8.00001 2.83331C4.35646 2.83331 2.24554 5.46904 1.38187 6.86239L1.35323 6.9085C1.14957 7.236 0.960476 7.54008 0.977649 7.99943C0.99483 8.45901 1.21134 8.75521 1.44454 9.07426L1.47913 9.12164C1.98332 9.81369 2.81354 10.8152 3.90749 11.6476C5.00098 12.4796 6.39027 13.1666 8.00001 13.1666C9.60975 13.1666 10.999 12.4796 12.0925 11.6476C13.1865 10.8152 14.0167 9.81369 14.5209 9.12164L14.5555 9.07426C14.7887 8.75521 15.0052 8.45901 15.0224 7.99943C15.0395 7.54008 14.8504 7.236 14.6468 6.9085L14.6182 6.86239C13.7545 5.46904 11.6436 2.83331 8.00001 2.83331ZM6.49997 8C6.49997 7.17157 7.17154 6.5 7.99997 6.5C8.8284 6.5 9.49997 7.17157 9.49997 8C9.49997 8.82843 8.8284 9.5 7.99997 9.5C7.17154 9.5 6.49997 8.82843 6.49997 8ZM7.99997 5.5C6.61926 5.5 5.49997 6.61929 5.49997 8C5.49997 9.38071 6.61926 10.5 7.99997 10.5C9.38068 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38068 5.5 7.99997 5.5Z"
                                            fill="#999999"></path>
                                    </svg>
                                    <span class="Text-xs">`+ item.viewCnt + `</span>
                                </div>
                                <div class="info_item">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M12.6898 4.18798C11.633 2.82581 9.51159 3.05426 8.76898 4.6102C8.46031 5.25695 7.53971 5.25695 7.23104 4.61021C6.48842 3.05426 4.36704 2.82581 3.31018 4.18798L3.10821 4.4483C2.19217 5.62897 2.32444 7.31267 3.4136 8.33582L7.95277 12.5999C7.97017 12.6162 7.98576 12.6309 8.00001 12.6442C8.01425 12.6309 8.02985 12.6162 8.04725 12.5999L12.5864 8.33582C13.6756 7.31267 13.8078 5.62897 12.8918 4.4483L12.6898 4.18798ZM8.00001 3.92699C9.16478 1.92976 12.026 1.70101 13.4799 3.57498L13.6819 3.8353C14.9141 5.4235 14.7362 7.68836 13.2711 9.06467L8.72036 13.3396C8.65247 13.4034 8.57779 13.4736 8.50726 13.5279C8.426 13.5905 8.31182 13.6634 8.15916 13.6934C8.05406 13.714 7.94596 13.714 7.84086 13.6934C7.6882 13.6634 7.57401 13.5905 7.49276 13.5279C7.42223 13.4736 7.34757 13.4034 7.27968 13.3396L2.72892 9.06467C1.26382 7.68836 1.0859 5.4235 2.31813 3.8353L2.5201 3.57498C3.97404 1.70102 6.83523 1.92976 8.00001 3.92699Z"
                                            fill="#999999"></path>
                                    </svg>
                                    <span class="Text-xs">`+ item.likeCnt + `</span>
                                </div>
                                <div class="info_item">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M11.89 4.11002C10.94 3.16002 9.67999 2.59002 8.33999 2.51002C7.00999 2.42002 5.68999 2.83002 4.62999 3.65002C3.56999 4.47002 2.84999 5.65002 2.59999 6.97002C2.35999 8.21002 2.55999 9.50002 3.15999 10.61L2.72999 12.14C2.67999 12.29 2.67999 12.46 2.71999 12.62C2.75999 12.78 2.83999 12.92 2.95999 13.04C3.06999 13.15 3.21999 13.23 3.37999 13.28C3.53999 13.32 3.69999 13.31 3.85999 13.27L5.38999 12.83C6.49999 13.43 7.77999 13.64 9.02999 13.4C10.34 13.15 11.52 12.43 12.34 11.37C13.17 10.31 13.57 8.99002 13.49 7.65002C13.41 6.31002 12.84 5.05002 11.89 4.11002ZM11.55 10.76C10.88 11.62 9.91999 12.21 8.83999 12.42C8.55999 12.47 8.27999 12.5 7.99999 12.5C7.19999 12.5 6.40999 12.29 5.70999 11.87C5.58999 11.8 5.44999 11.78 5.30999 11.82L3.72999 12.26L4.17999 10.68C4.21999 10.55 4.19999 10.41 4.12999 10.29C3.56999 9.35002 3.36999 8.23002 3.57999 7.16002C3.77999 6.08002 4.36999 5.11002 5.23999 4.44002C6.10999 3.77002 7.18999 3.44002 8.27999 3.50002C9.37999 3.57002 10.41 4.04002 11.18 4.81002C11.95 5.58002 12.42 6.62002 12.49 7.71002C12.56 8.81002 12.23 9.89002 11.55 10.76Z"
                                            fill="#999999" />
                                    </svg>
                                    <span class="Text-xs">`+ item.commentCnt + `</span>
                                </div>
                                <span class="date Text-xs">`+ item.regdate + `</span>
                            </div>
                        </div>
                    </div>
                </li>
            `;
        })
    }
    $(".list_container>ul").html(listBody);



    let item = COMMU_API.data.contentList
    let test = document.querySelectorAll('.commu_item');
    let itemImg = "";


    for (let i = 0; i < test.length; i++) {

        if (item[i].imageList[0].url !== '') {
            // test[i].prepend(itemImg);
            console.log(item[i].imageList[0].url);
        } else {
            console.log('');
        }
    }


    // itemImg += `
                // <div class="img_wrap">
                    // <img src="`+ item[i].imageList[0].url + `" alt="" />
                // </div>
            // `;





    // $(document).ready(function () {
    //     console.log('aaa');
    //     $.ajax({
    //         url: '{C.API_DOMAIN}/v1/community/contents?categoryIdx=' + 0 + '&sortType=' + 1 + '&page=' + 1 + '&recordSize=' + 10,
    //         cache: true,
    //         method: 'GET',
    //         dataType: 'json',
    //         processData: false,
    //         contentType: false,
    //         xhrFields: {
    //             withCredentials: true
    //         },
    //         success: function (res) {
    //             if (res.result) {
    //                 console.log(res);
    //             } else {
    //                 console.log(res.code);
    //             }
    //         }
    //     })
    // })


</script>