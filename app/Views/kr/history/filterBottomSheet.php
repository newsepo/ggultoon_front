<style>
  #layoutSidenav {
    height: 100%;
  }



  #toonWrap .bottom_sheet {
    position: fixed;
    bottom: 0px;
    z-index: 1004;
    width: 100%;
    max-width: 570px;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    align-items: flex-start;
  }



  .bottom_sheet .sheet_wrap {
    display: none;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    gap: 1rem;
    width: 100%;
    box-sizing: border-box;
    padding: 24px;
    padding-bottom: 40px;
    background-color: var(--theme-day-bg);
    border-radius: 20px 20px 0px 0px;
    border-top: 1px solid var(--border-e0);
  }

  .bottom_sheet .sheet_wrap.active {
    display: flex;
  }

  .bottom_sheet .sheet_wrap .sheet_top {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    width: 100%;
    box-sizing: border-box;
    padding: 6px 0px;
  }

  .bottom_sheet .sheet_wrap .sheet_top>button {
    display: block;
    width: fit-content;
    color: var(--text-primary);
    font-size: 13px;
    letter-spacing: -0.5px;
    text-align: right;
    border-style: none;
    box-sizing: border-box;
    background-color: transparent;
    padding: 0px;
  }

  .bottom_sheet .sheet_wrap .type_wrap {
    margin-bottom: 1rem;
  }

  .bottom_sheet .sheet_wrap .type_wrap,
  .bottom_sheet .sheet_wrap .genre_wrap {
    width: 100%;
  }

  .bottom_sheet .sheet_wrap .type_wrap h5,
  .bottom_sheet .sheet_wrap .genre_wrap h5 {
    display: block;
    width: 100%;
    text-align: left;
    margin-bottom: 0.5rem;
    color: var(--text-able);
  }

  .bottom_sheet .sheet_wrap .type_wrap .wrap,
  .bottom_sheet .sheet_wrap .genre_wrap .wrap {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 6px;
    width: 100%;
  }

  .bottom_sheet .sheet_wrap .type_wrap .wrap>label,
  .bottom_sheet .sheet_wrap .genre_wrap .wrap>label,
  .bottom_sheet .sheet_wrap .type_wrap .wrap>button,
  .bottom_sheet .sheet_wrap .genre_wrap .wrap>button {
    display: block;
    width: 100%;
    box-sizing: border-box;
    font-family: 'Pretendard';
    font-weight: 500;
    font-size: 14px;
    line-height: 150%;
    letter-spacing: -0.5px;
    color: var(--text-able);
    text-align: center;
    border-radius: 0.5rem;
    background-color: var(--border-f0);
    border-style: none;
    padding: 11px 0px;
  }

  .bottom_sheet .sheet_wrap .type_wrap input[type='radio']:checked+label,
  .bottom_sheet .sheet_wrap .genre_wrap input[type='radio']:checked+label,
  .bottom_sheet .sheet_wrap .type_wrap .wrap>button.active,
  .bottom_sheet .sheet_wrap .genre_wrap .wrap>button.active {
    background-color: var(--primary);
  }

  .bottom_sheet .sheet_wrap .type_wrap input[type='radio'],
  .bottom_sheet .sheet_wrap .genre_wrap input[type='radio'] {
    display: none;
  }


  #toonWrap.hide #mainSection .bottom_sheet {
    max-width: 768px;
  }
</style>

<div class="bottom_sheet">
  <div class="charge sheet_wrap">
    <div class="type_wrap">
      <div class="sheet_top">
        <button class="Text-sm">확인</button>
      </div>
      <h5 class="Text-sm">유형</h5>
      <div class="wrap">
        <input id="type_rent" type="radio" name="type" value="rent" checked>
        <label for="type_rent">대여</label>
        <input id="type_have" type="radio" name="type" value="have">
        <label for="type_have">소장</label>
      </div>
    </div>
    <div class="genre_wrap">
      <h5 class="Text-sm">장르</h5>
      <div class="wrap">
        <input id="genre_all" type="radio" name="genre" value="0" checked>
        <label for="genre_all" class="genre_all active">전체</label>
        <input id="genre_webtoon" type="radio" name="genre" value="1">
        <label for="genre_webtoon" class="genre_webtoon">웹툰</label>
        <input id="genre_comic" type="radio" name="genre" value="2">
        <label for="genre_comic" class="genre_comic">만화</label>
        <input id="genre_novel" type="radio" name="genre" value="3">
        <label for="genre_novel" class="genre_novel">소설</label>
      </div>
    </div>
  </div>
</div>

<script>
  // 외부영역 클릭 시 팝업 닫기
  $(document).mouseup(function (e) {
    var LayerPopup = $(".bottom_sheet .charge");

    if (LayerPopup.has(e.target).length === 0) {
      $(".bottom_sheet .charge").slideUp(400);
    }
  });
  // 필터 버튼 클릭
  $(".filter_btn").click(function () {
    if (!$(".bottom_sheet .charge").is(':animated')) {
      $(".bottom_sheet .charge").slideDown(400);
    }

  });
  // 확인 버튼
  $(".sheet_top button").click(function () {
    if (!$(".bottom_sheet .charge").is(':animated')) {
      $(".bottom_sheet .charge").slideUp(400);
    }

  });
</script>