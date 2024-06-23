<style>
  footer {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    gap: 1rem;
    width: 100%;
    box-sizing: border-box;
    padding: 2rem 1rem;
    background-color: var(--footer-bg);
    padding-bottom: calc(65px + 3rem);
  }

  footer>.footer_menu {
    display: flex;
    justify-content: flex-start;
    flex-wrap: wrap;
    width: 100%;
    gap: 1rem;
    row-gap: 0.5rem;
  }

  footer>.footer_menu a {
    display: block;
    width: fit-content;
    color: var(--text-333);
  }

  input[type="checkbox"]#footer_toggle {
    display: none;
  }

  label[for="footer_toggle"] {
    display: inline-block;
    margin-bottom: 0.25rem;
    cursor: pointer;
  }

  label[for="footer_toggle"],
  .footer_toggle_content {
    color: var(--text-primary);
  }

  label[for="footer_toggle"]>svg {
    display: inline-block;
    width: 14px;
    rotate: 360deg;
  }

  input[type="checkbox"]#footer_toggle:checked+label>svg>path {
    transform: rotate(180deg);
    transform-origin: 50% 50%;
  }

  .footer_toggle_content {
    max-width: 350px;
    justify-content: flex-start;
    align-items: flex-start;
    flex-wrap: wrap;
    column-gap: 0.5rem;
    row-gap: 0.25rem;
    transition-duration: 0.2s;
    transition-timing-function: ease-in-out;
  }

  .footer_toggle_content span,
  .footer_toggle_content span>a {
    font-weight: 500;
    color: var(--text-primary);
  }

  input[type="checkbox"]#footer_toggle~.footer_toggle_content {
    display: none;
  }

  input[type="checkbox"]#footer_toggle:checked~.footer_toggle_content {
    display: flex;
  }

  footer p.comment {
    color: var(--text-secondary);
  }
  footer .btn-f-check{
    position: relative;
    display: inline-block;
    color: var(--text-primary);
    background: none;
  }
</style>


<footer>
  <p class="footer_menu Text-sm">
    <a href="/policy/service">이용약관</a>
    <a href="/policy/privacy">개인정보처리방침</a>
    <a href="/policy/youth">청소년보호정책</a>
    <a href="/suggestion">제휴/연재문의</a>
    <a href="/help/notice">고객센터</a>
  </p>

  <div>
    <input type="checkbox" id="footer_toggle">
    <label for="footer_toggle" class="Text-xs">
      주식회사 유엑스플러스스튜디오
      <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="7" cy="7.5" r="6.5" fill="white" stroke="#E0E0E0" />
        <path d="M4 8.5L7 5.5L10 8.5" stroke="#999999" stroke-width="1.5" stroke-linecap="round"
          stroke-linejoin="round" />
      </svg>

    </label>
    <div class="footer_toggle_content Text-xs">
      <span>대표이사 최영묵</span>
      <span>사업자 번호 : 598-87-02563</span>
      <span>통신판매업 신고번호 : 제 2023-서울마포-1311호 </span>
      <button class="btn-f-check" onclick="onopen()">[사업자 정보 확인]</button>
      <span>주소 : 서울특별시 마포구 와우산로29길 42, 1층(서교동)</span>
      <span>E-mail : help@ggultoons.com</span>
      <span>고객센터: 1533-1436</span>
    </div>
  </div>
  <p class="comment Text-xs">꿀툰에 게시된 모든 콘텐츠들은 저작권법에 의거 보호받고 있습니다.</p>
</footer>

<script>
  function onopen() {
    window.open('http://www.ftc.go.kr/bizCommPop.do?wrkr_no=5988702563', 'bizCommPop', 'width=750, height=700;');
  }
</script>