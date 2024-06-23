<script>
    // 팝업 닫기
    $("#lib_bottom_container .lib_bottom_wrap button.close").on('click', () => {
        $("#lib_bottom_container").animate({ bottom: -500 }, 'fast', function () {
            $("#lib_bottom_container").removeClass("active");
        });
    });

    var bottomSheet = {
        // 회차 이동
        episode: function () {
            var contentsIdx = $("#lib_bottom_container .lib_bottom_wrap a.continue").data('contents-idx');
            movePage.episode(contentsIdx);
        },
    }

    var purchaseButton = function (data) {
        let purchaseParams = {
            firstBtnTitle: '',          // 버튼 이름
            secondBtnTitle: '',         // 버튼 이름
            episodeUrl: '',             // link
            nextButton: ''
        }

        // 감상완료
        if (!data.isNextEpisode) {
            purchaseParams.nextButton = '<button class="Text-lg active" data-contents-idx="' + data.contentsIdx + '" data-episode-idx="' + data.episodeIdx + '">감상 완료</button>';
        }
        // 다음 회차 무료 보기
        else if (data.isNextEpFree) {
            let searchTypeCode = 'rent';
            if (data.sellType == 2) {
                searchTypeCode = 'have';
            }
            purchaseParams.nextButton = '<button class="Text-lg active" data-search-type-code="' + searchTypeCode + '" data-contents-idx="' + data.contentsIdx + '" data-episode-idx="' + data.nextEpisodeIdx + '">다음 회차 무료 보기</button>';
        }
        // 다음 회차 있을때
        else {
            // 소장만 가능
            if (data.sellType == 2) {
                // 다음 회차 소장 중
                if (data.isNextEpHave) {
                    purchaseParams.firstBtnTitle = '다음 회차 소장 중';
                }
                // 다음 회차 무료 보기
                else if (data.isNextEpHaveFree) {
                    purchaseParams.firstBtnTitle = '다음 회차 무료 보기';
                }
                // 다음 회차 소장
                else {
                    // 다음 회차 소장 버튼
                    purchaseParams.firstBtnTitle = '다음 회차 소장';
                }
                purchaseParams.nextButton = '<button class="Text-lg active" data-search-type-code="have" data-contents-idx="' + data.contentsIdx + '" data-episode-idx="' + data.nextEpisodeIdx + '">' + purchaseParams.firstBtnTitle + '</button>';
            }
            // 대여만 가능
            else if (data.sellType == 3) {
                // 다음 회차 대여 중
                if (data.isNextEpRent) {
                    purchaseParams.firstBtnTitle = '다음 회차 대여 중';
                }
                // 다음 회차 무료 보기
                else if (data.isNextEpRentFree) {
                    // 뷰어로 이동
                    purchaseParams.firstBtnTitle = '다음 회차 무료 보기';
                }
                // 다음 회차 대여
                else {
                    purchaseParams.firstBtnTitle = '다음 회차 대여';
                }
                purchaseParams.nextButton = '<button class="Text-lg active" data-search-type-code="rent" data-contents-idx="' + data.contentsIdx + '" data-episode-idx="' + data.nextEpisodeIdx + '">' + purchaseParams.firstBtnTitle + '</button>';
            }
            // 대여 + 소장
            else {
                // 다음 회차 대여 중
                if (data.isNextEpRent) {
                    purchaseParams.firstBtnTitle = '다음 회차 대여 중';
                }
                // 다음 회차 무료 보기
                else if (data.isNextEpRentFree) {
                    purchaseParams.firstBtnTitle = '다음 회차 무료 보기';
                }
                // 다음 회차 대여
                else {
                    purchaseParams.firstBtnTitle = '다음 회차 대여';
                }
                purchaseParams.nextButton += '<button class="Text-lg" data-search-type-code="rent" data-contents-idx="' + data.contentsIdx + '" data-episode-idx="' + data.nextEpisodeIdx + '">' + purchaseParams.firstBtnTitle + '</button>';

                // 다음 회차 소장 중
                if (data.isNextEpHave) {
                    purchaseParams.secondBtnTitle = '다음 회차 소장 중';
                }
                // 다음 회차 무료 보기
                else if (data.isNextEpHaveFree) {
                    purchaseParams.secondBtnTitle = '다음 회차 무료 보기';
                }
                // 다음 회차 소장
                else {
                    purchaseParams.secondBtnTitle = '다음 회차 소장';
                }
                purchaseParams.nextButton += '<button class="Text-lg active" data-search-type-code="have" data-contents-idx="' + data.contentsIdx + '" data-episode-idx="' + data.nextEpisodeIdx + '">' + purchaseParams.secondBtnTitle + '</button>';
            }
        }

        return purchaseParams;
    }

    // 최근 본 회차 보기, 다음 회차 대여, 소장
    $(document).on('click', '.lib_bottom_wrap .btn_wrap button, .lib_bottom_wrap .continue', function () {
        let contentsIdx = $(this).data('contents-idx');
        let episodeIdx = $(this).data('episode-idx');
        let searchType = ($(this).data('search-type-code')) ? $(this).data('search-type-code') : 'rent';

        episodeInfoCheck(contentsIdx, episodeIdx, searchType);
    })
</script>