<header id="writePost">
    <button>
        <svg class="back" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 8L12 16L20 24" stroke="#222" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </button>
    <p class="title">글쓰기</p>
</header>

<form id="write_container">
    <div class="top_wrap">
        <input class="Text-md" type="text" placeholder="작품명 검색" onclick="searchContent()" id="writeName">
        <input class="Text-md" type="text" placeholder="제목" id="writeTitle">
        <input type="checkbox" id="chkAdult">
        <label for="chkAdult">
            <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="0.5" y="1" width="19" height="19" rx="9.5" />
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M15.1696 7.1119C15.5346 7.45661 15.5511 8.03198 15.2064 8.39702L9.19713 14.7607C9.02539 14.9425 8.7863 15.0456 8.53616 15.0456C8.28602 15.0456 8.04693 14.9425 7.87519 14.7607L4.79354 11.4973C4.44883 11.1322 4.46531 10.5568 4.83035 10.2121C5.19539 9.86742 5.77076 9.8839 6.11547 10.2489L8.53616 12.8124L13.8844 7.14871C14.2292 6.78367 14.8045 6.76719 15.1696 7.1119Z" />
            </svg>
            <p class="Text-md">19세 이상 볼 수 있어요</p>
        </label>
    </div>
    <textarea id="editor"></textarea>
    <button type="button" class="btn-submit Text-lg" onclick="postWrite()">작성하기</button>
</form>


<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/translations/ko.js"></script>
<script>
    let editor;

    ClassicEditor
        .create(document.querySelector('#editor'), {
            language: 'ko'
        })
        .then(newEditor => {
            editor = newEditor;
        })
        .catch(error => {
            console.error(error);
        });

    function searchContent() {
        location.href = "/community/chooseContent"
    }

    /*뒤로 가기*/
    // $(".back").click(function () {
    //     // 쿠키에 저장한 이전 페이지 url로 이동
    //     window.location.href = $.cookie("prevPage");
    // })


    //! 게시물 등록
    function postWrite() {
        let dataBody = {
            title: $('#writeTitle').val(),
            content: editor.getData(),
            isAdult: $('#chkAdult').prop("checked")
        }

        // if (dataBody.title === '' || dataBody.content === '') {
        //     alert('제목과 내용은 필수 입력사항입니다. 입력 후 등록해 주세요') 
        //     return false
        // } 
        if (dataBody.title === '') {
            // alert('제목과 내용은 필수 입력사항입니다. 입력 후 등록해 주세요') 
            return false
        }
        if (dataBody.content === '') {
            return false
        }

        // $.ajax({
        //     url: '{ C.API_DOMAIN }/v1/community/contents',
        //     data: JSON.stringify(dataBody),
        //     type: 'POST',
        //     dataType: 'json',
        //     success: function (res) {
        //         if (res.result) {
        //             console.log(res.result)
        //         } else {
        //             console.log(res.code, res.message)
        //         }
        //     }
        // })

    }
</script>