<style>
    .no_result_wrap {
        top: 0;
        left: 0;
        width: 100%;
        height: 200px;
        display: none;
        text-align: center;
        align-items:center;
        justify-content:center;
        grid-column: 1/5;
    }

    .no_result_wrap.active {
        display: flex;
    }

    .no_result {
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 12px;
        box-sizing: border-box;
        padding: 24px;
        padding-top: 0px;
        margin-bottom: 40px;
        text-align: center;
    }

    .no_result.active {
        display: flex;
        height: 200px;
    }

    .no_result>svg {
        display: block;
        width: 38px;
        height: 38px;
    }

    .no_result>p {
        display: flex;
        justify-content: center;
        align-items: center;
        color: var(--text-secondary);
        text-align: center;
    }

    .no_result>p>span {
        display: inline-block;
        width: fit-content;
    }

    #mySwiperContainer .no_result_wrap{
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        z-index: -1;
    }
</style>

<!-- 결과 없을 때 노출 -->
<div class="no_result_wrap">
    <div class="no_result">
        <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M11.6693 6.91916C11.0835 7.50495 11.0835 8.44776 11.0835 10.3334V10.6667H14.2502C15.3547 10.6667 16.2502 11.5621 16.2502 12.6667C16.2502 13.7713 15.3547 14.6667 14.2502 14.6667H11.0835V18.5834H14.2502C15.3547 18.5834 16.2502 19.4788 16.2502 20.5834C16.2502 21.6879 15.3547 22.5834 14.2502 22.5834H11.0835V26.5H14.2502C15.3547 26.5 16.2502 27.3955 16.2502 28.5C16.2502 29.6046 15.3547 30.5 14.2502 30.5H11.0927C11.1203 31.5861 11.2304 32.2254 11.6693 32.6643C12.2551 33.25 13.1979 33.25 15.0835 33.25H27.6668C29.5524 33.25 30.4953 33.25 31.081 32.6643C31.6668 32.0785 31.6668 31.1357 31.6668 29.25V10.3334C31.6668 8.44776 31.6668 7.50495 31.081 6.91916C30.4953 6.33337 29.5524 6.33337 27.6668 6.33337H15.0835C13.1979 6.33337 12.2551 6.33337 11.6693 6.91916ZM25.3334 16.8334C24.7811 16.8334 24.3334 16.3857 24.3334 15.8334V12.6667C24.3334 12.1144 24.7811 11.6667 25.3334 11.6667C25.8857 11.6667 26.3334 12.1144 26.3334 12.6667V15.8334C26.3334 16.3857 25.8857 16.8334 25.3334 16.8334ZM7.91675 11.6667C7.36446 11.6667 6.91675 12.1144 6.91675 12.6667C6.91675 13.219 7.36446 13.6667 7.91675 13.6667H14.2501C14.8024 13.6667 15.2501 13.219 15.2501 12.6667C15.2501 12.1144 14.8024 11.6667 14.2501 11.6667H7.91675ZM7.91675 19.5834C7.36446 19.5834 6.91675 20.0311 6.91675 20.5834C6.91675 21.1357 7.36446 21.5834 7.91675 21.5834H14.2501C14.8024 21.5834 15.2501 21.1357 15.2501 20.5834C15.2501 20.0311 14.8024 19.5834 14.2501 19.5834H7.91675ZM7.91675 27.5C7.36446 27.5 6.91675 27.9478 6.91675 28.5C6.91675 29.0523 7.36446 29.5 7.91675 29.5H14.2501C14.8024 29.5 15.2501 29.0523 15.2501 28.5C15.2501 27.9478 14.8024 27.5 14.2501 27.5H7.91675Z"
                fill="#E4E4E4" />
        </svg>
        <p class="Text-lg no_result_text"></p>
    </div>
</div>

<script>
    /* 결과 없음 세팅 */
    var noResult = {
        setting: function (type, text) {

            // 결과 없음 영역 노출
            if (type == "search_content") {
                $("." + type).children(".no_result_wrap").addClass("active");
                $("." + type).children(".no_result_wrap").children(".no_result").addClass("active");

            } else if (type == "todayGiftList" || type == "tomorrowGiftList") {
                $("#" + type).children(".no_result_wrap").addClass("active");
                $("#" + type).children(".no_result_wrap").children(".no_result").addClass("active");

            } else {
                $(".no_result_wrap").addClass("active");
                $(".no_result").addClass("active");
            }
            // 결과 없음 내용 세팅
            $(".no_result_text").html(text);
        }
    }
</script>