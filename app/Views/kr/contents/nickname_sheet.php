<style>
  #nickname_sheet_container {
    display: none;
    width: 100%;
    max-width: 570px;
    box-sizing: border-box;
    padding: 24px;
    padding-bottom: 40px;
    background-color: var(--theme-day-bg);
    border-radius: 20px 20px 0px 0px;
    border-top: 1px solid var(--border-e0);
    position: fixed;
    bottom: -300px;
    z-index: 1005;
  }

  #nickname_sheet_container.active {
    display: block;
  }

  #nickname_sheet_container .nickname_wrap {
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
  }

  #nickname_sheet_container .nickname_wrap>h4 {
    display: block;
    width: 100%;
    font-family: "NanumSqureNeo";
    font-size: 1rem;
    line-height: 120%;
    letter-spacing: -0.5px;
    font-weight: 800;
    text-align: left;
    margin-bottom: 12px;
    color: var(--text-333);
  }

  #nickname_sheet_container .nickname_wrap input {
    display: block;
    width: 100%;
    box-sizing: border-box;
    background-color: var(--theme-day-bg);
    border: 1px solid var(--border-e0);
    padding: 14px 1rem;
    color: var(--text-able);
    outline: none;
    border-radius: 0.5rem;
    margin-bottom: 0.5rem;
  }

  #nickname_sheet_container .nickname_wrap input::placeholder {
    color: var(--text-primary);
  }

  #nickname_sheet_container .nickname_wrap .notice {
    display: block;
    width: 100%;
    margin-bottom: 1rem;
  }

  #nickname_sheet_container .nickname_wrap .notice>span {
    display: none;
    width: 100%;
    letter-spacing: -0.5px;
  }

  #nickname_sheet_container .nickname_wrap .notice>span.active {
    display: block;
  }

  #nickname_sheet_container .nickname_wrap .notice>.success {
    color: var(--success);
  }

  #nickname_sheet_container .nickname_wrap .notice>.fail {
    color: var(--warning);
  }



  #nickname_sheet_container .nickname_wrap button {
    display: block;
    width: 100%;
    text-align: center;
    box-sizing: border-box;
    padding: 13.5px 1rem;
    color: var(--text-able);
    background-color: var(--primary);
    border-radius: 0.5rem;
  }

  #nickname_sheet_container .nickname_wrap button:disabled {
    opacity: 0.4;
  }

  #toonWrap.hide #nickname_sheet_container {
    max-width: 768px;
  }
</style>



<div id="nickname_sheet_container" class="active">
  <div class="nickname_wrap">
    <h4>닉네임 설정</h4>
    <input type="text" class="Text-md" placeholder="2 ~ 12자의 한글, 영문, 숫자">
    <p class="notice">
      <span class="Text-xs success"></span>
      <span class="Text-xs fail"></span>
    </p>
    <button id="submit" disabled>저장하기</button>
  </div>
</div>