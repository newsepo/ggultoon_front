<style>
  header#find {
    width: 100%;
    display: flex;
    justify-content: flex-start;
    align-items: center;
    gap: 0.25rem;
    box-sizing: border-box;
    padding: 12px 0.5rem;
    position: sticky;
    top: 0px;
    left: 0px;
    z-index: 1001;
    background-color: var(--theme-day-bg);
  }

  header#find>a {
    display: block;
    width: 32px;
    height: 32px;
    text-decoration: none;
  }

  header#find>a>svg>path {
    stroke: var(--text-able);
  }

  header#find>.title {
    display: block;
    width: calc(100% - 36px - 1rem);
    text-align: center;
    font-family: 'NanumSquareNeo';
    font-size: 1rem;
    line-height: 120%;
    font-weight: 800;
    letter-spacing: -0.5px;
    color: var(--text-able);
  }
</style>

<header id="find">
  <a href="/">
    <svg class="back" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M20 8L12 16L20 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
    </svg>
  </a>
  <p class="title">아이디 <b class="point">·</b> 비밀번호 찾기</p>
</header>