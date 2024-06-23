<style>
  input[type="radio"] {
    display: none;
  }

  .bottom_sheet {
    position: fixed;
    /* left: calc(100% - this.width); */
    bottom: -500px;
    z-index: 1001;
    width: 100%;
    max-width: 570px;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    align-items: center;
  }

  #toonWrap.hide .bottom_sheet {
    max-width: 768px;
  }

  .bottom_sheet .sheet_wrap {
    position: absolute;
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

  .bottom_sheet .sheet_wrap .wrap {
    width: 100%;
  }

  .bottom_sheet .sheet_wrap .wrap h5 {
    display: block;
    width: 100%;
    text-align: left;
    margin-bottom: 0.5rem;
    color: var(--text-able);
  }

  .bottom_sheet .sheet_wrap .wrap .wrap {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 6px;
    width: 100%;
  }

  .bottom_sheet .sheet_wrap .genre.wrap .wrap {
    justify-content: flex-start;
    align-items: flex-start;
    flex-wrap: wrap;
  }

  .bottom_sheet .sheet_wrap .wrap .wrap>button,
  .bottom_sheet .sheet_wrap .wrap .wrap>label {
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

  .bottom_sheet .sheet_wrap .genre.wrap .wrap>label,
  .bottom_sheet .sheet_wrap .genre.wrap .wrap>button {
    width: fit-content;
    padding: 11px 1rem;
  }

  .bottom_sheet .sheet_wrap .wrap .wrap>input[type="radio"]:checked+label,
  .bottom_sheet .sheet_wrap .wrap .wrap>button.active {
    background-color: var(--primary);
  }
</style>

<div class="bottom_sheet">
  <div class="sheet_wrap active">
    <div class="genre wrap">
      <div class="sheet_top">
        <button class="Text-sm">확인</button>
      </div>
      <h5 class="Text-sm">장르</h5>
      <div class="wrap">
      </div>
    </div>
    <div class="type wrap">
      <h5 class="Text-sm">유형</h5>
      <div class="wrap">
        <button class="paperback">단행본</button>
        <button class="completed">완결작</button>
      </div>
    </div>
    <div class="term wrap">
      <h5 class="Text-sm">조회기간</h5>
      <div class="wrap">
        <input type="radio" name="filter_date" id="daily" value="1" checked>
        <label for="daily" class=" active">일간</label>
        <input type="radio" name="filter_date" id="weekly" value="2">
        <label for="weekly" class="">주간</label>
        <input type="radio" name="filter_date" id="monthly" value="3">
        <label for="monthly" class="">월간</label>
      </div>
    </div>
  </div>
</div>