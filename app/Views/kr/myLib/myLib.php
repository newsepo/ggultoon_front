<header id="myLib">
    <button>
        <svg class="myInfo back" width="32" height="32" viewBox="0 0 32 32" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path d="M20 8L12 16L20 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </button>
    <p class="myInfo title">내 꿀단지</p>
</header>

<div class="lib_container">
    <div class="lib_top">
        <label for="lib_search">
            <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="11.7812" cy="11.7812" r="6.09375" stroke="#999999" stroke-width="2" />
                <path d="M20.3125 20.3125L16.25 16.25" stroke="#999999" stroke-width="2" stroke-linecap="round" />
            </svg>
            <input type="search" name="librarySearch" class="Text-md" placeholder="작품 검색" />
        </label>
    </div>
    <div class="lib_content">
        <div class="lib_tab_top">
            <div class="tab_wrap">
                <button class="tab_item recent {? HTML.TYPE == 'view'}active{/}">최근</button>
                <button class="tab_item rent {? HTML.TYPE == 'rent'}active{/}">대여</button>
                <button class="tab_item have {? HTML.TYPE == 'have'}active{/}">소장</button>
                <button class="tab_item like {? HTML.TYPE == 'favorite'}active{/}">관심</button>
            </div>
            <button id="edit" class="Text-sm active">편집</button>
            <button id="complete" class="Text-sm">완료</button>
        </div>
        <!-- 편집모드시에 active 되는 편집모드 상단 전체선택 및 삭제  -->
        <div class="edit_top">
            <input type="checkbox" id="select_all">
            <label for="select_all">
                <svg class="" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 9.75L8.16327 14L16 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="Text-md">전체선택</span>
            </label>
            <button id="delete" class="Text-sm" onclick="library.removeTarget();">삭제</button>
        </div>

        <div class="lib_tab_content">
            <div class="tab_content recent active"></div>
            <div id="search_container" class="search_content">
                <!-- 결과 없음 -->
                { #noResult }
            </div>
        </div>
    </div>

    <!-- 큐레이션 -->
    { #curation }

    <!-- bottom popup -->
    <div id="myLibBottomSheet">
    </div>
</div>