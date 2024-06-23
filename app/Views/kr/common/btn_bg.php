<style>
  input[type="button"].btn_bg {
    display: block;
    width: 100%;
    border-radius: 8px;
    box-sizing: border-box;
    padding: 14px 1rem;
    text-align: center;
  }

  input[type="button"].btn_bg:disabled {
    opacity: 0.4;
  }

  input[type="button"].vertification {
    background-color: var(--info);
  }

  input[type="button"].defult {
    background-color: var(--primary);
  }

  input[type="button"].leave {
    background-color: var(--warning);
    color: var(--text-white);
  }

  input[type="button"].cancel {
    background-color: var(--info);
  }
</style>

<input type="button" class="btn_bg verification" value="본인인증" />

<input type="button" class="btn_bg defult" value="확인" />

<input type="button" class="btn_bg leave" value="탈퇴하기" />

<input type="button" class="btn_bg cancel" value="취소" />