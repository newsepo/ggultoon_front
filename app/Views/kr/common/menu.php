<style>
  * {
    box-sizing: border-box;
  }

  a {
    text-decoration: none !important;
  }

  #fixed_nav {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    /* height: 65px; */
    background-color: #fff;
    border: 1px solid #e0e0e0;
    box-sizing: border-box;
    border-radius: 16px 16px 0px 0px;
    padding: 8.5px 24px;
    /* position: sticky;
    top: calc(100vh - 69px);
    left: 0px; */
    position: fixed;
    width: 100%;
    max-width: 570px;
    bottom: 0px;
    z-index: 1000;
  }

  #toonWrap.hide #mainSection #fixed_nav {
    max-width: 768px;
  }

  #fixed_nav>div {
    display: block;
    width: fit-content;
    text-align: center;
  }

  #fixed_nav>div>input[type="radio"] {
    display: none;
  }

  #fixed_nav div>label svg {
    display: block;
    width: 32px;
    height: 32px;
    margin: 0 auto;
  }

  #fixed_nav div>label span {
    font-family: !important'NanumSquareNeo';
    text-transform: uppercase;
    font-weight: 700;
    font-size: 11px;
    color: #999;
  }

  #fixed_nav div>input[type="radio"]:checked~label>a>span {
    color: var(--secondary);
  }

  #fixed_nav div>label svg>path.nav_svg_icon {
    fill: #e0e0e0;
  }

  #fixed_nav div>input[type="radio"]:checked~label svg>path.nav_svg_icon {
    fill: var(--secondary);
  }
</style>


<nav id="fixed_nav">
  <div>
    <input type="radio" name="nav_icon" id="home">
    <label for="home">
      <a href="javascript:void(0);">
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path class="nav_svg_icon"
            d="M6.39209 12.4491C6 13.1928 6 14.0388 6 15.7308V21.0152C6 23.3651 6 24.54 6.83684 25.27C7.67368 26 9.02055 26 11.7143 26H12V19.3333C12 18.1464 12.8885 17 14.2 17H17.8C19.1115 17 20 18.1464 20 19.3333V26H20.2857C22.9795 26 24.3263 26 25.1632 25.27C26 24.54 26 23.3651 26 21.0152V15.7308C26 14.0388 26 13.1928 25.6079 12.4491C25.2158 11.7054 24.4795 11.1549 23.0068 10.0537L21.5782 8.98552C18.9163 6.99517 17.5854 6 16 6C14.4146 6 13.0837 6.99517 10.4218 8.98551L8.99322 10.0537C7.52052 11.1549 6.78418 11.7054 6.39209 12.4491Z" />
          <path class="nav_svg_icon"
            d="M18 26V19.3333C18 19.2083 17.9546 19.1143 17.9052 19.0595C17.8574 19.0064 17.8189 19 17.8 19H14.2C14.1811 19 14.1426 19.0064 14.0948 19.0595C14.0454 19.1143 14 19.2083 14 19.3333V26H18Z" />
        </svg>
        <span>홈</span>
      </a>
    </label>
  </div>

  <div>
    <input type="radio" name="nav_icon" id="webtoon">
    <label for="webtoon">
      <a href="javascript:void(0);">
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path class="nav_svg_icon" d="M9 6C7.34315 6 6 7.34315 6 9V17.359L26 12V9C26 7.34315 24.6569 6 23 6H9Z" />
          <path class="nav_svg_icon"
            d="M26 14.0706L6 19.4295V23C6 24.6569 7.34315 26 9 26H23C24.6569 26 26 24.6569 26 23V14.0706Z" />
        </svg>
        <span>웹툰</span>
      </a>
    </label>
  </div>

  <div>
    <input type="radio" name="nav_icon" id="comic">
    <label for="comic">
      <a href="javascript:void(0);">
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path class="nav_svg_icon" d="M6 9C6 7.34315 7.34315 6 9 6H14V26H9C7.34315 26 6 24.6569 6 23V9Z" />
          <path class="nav_svg_icon" d="M16 15.1607V6H23C24.6569 6 26 7.34315 26 9V12.4812L16 15.1607Z" />
          <path class="nav_svg_icon" d="M16 17.2312V26H23C24.6569 26 26 24.6569 26 23V14.5517L16 17.2312Z" />
        </svg>
        <span>만화</span>
      </a>
    </label>
  </div>

  <div>
    <input type="radio" name="nav_icon" id="novel">
    <label for="novel">
      <a href="javascript:void(0);">
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path class="nav_svg_icon" fill-rule="evenodd" clip-rule="evenodd"
            d="M9 6C7.34315 6 6 7.34315 6 9V23C6 24.6569 7.34315 26 9 26H23C24.6569 26 26 24.6569 26 23V9C26 7.34315 24.6569 6 23 6H9ZM10 10C9.44772 10 9 10.4477 9 11C9 11.5523 9.44772 12 10 12H22C22.5523 12 23 11.5523 23 11C23 10.4477 22.5523 10 22 10H10ZM9 16C9 15.4477 9.44772 15 10 15H20C20.5523 15 21 15.4477 21 16C21 16.5523 20.5523 17 20 17H10C9.44772 17 9 16.5523 9 16ZM10 20C9.44772 20 9 20.4477 9 21C9 21.5523 9.44772 22 10 22H20C20.5523 22 21 21.5523 21 21C21 20.4477 20.5523 20 20 20H10Z" />
        </svg>
        <span>소설</span>
      </a>
    </label>
  </div>

  <div>
    <input type="radio" name="nav_icon" id="my">
    <label for="my">
      <a href="javascript:void(0);">
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path class="nav_svg_icon"
            d="M6 9C6 8.44772 6.44772 8 7 8H25C25.5523 8 26 8.44772 26 9C26 9.55228 25.5523 10 25 10H7C6.44772 10 6 9.55228 6 9Z">
          </path>
          <path class="nav_svg_icon"
            d="M6 16C6 15.4477 6.44772 15 7 15H25C25.5523 15 26 15.4477 26 16C26 16.5523 25.5523 17 25 17H7C6.44772 17 6 16.5523 6 16Z">
          </path>
          <path class="nav_svg_icon"
            d="M6 23C6 22.4477 6.44772 22 7 22H25C25.5523 22 26 22.4477 26 23C26 23.5523 25.5523 24 25 24H7C6.44772 24 6 23.5523 6 23Z">
          </path>
        </svg>
        <span>my</span>
      </a>
    </label>
  </div>
</nav>

<script>
  $(document).ready(function () {
    /* 페이지 이동 url 세팅 */
    $("label[for='home']").find('a').attr('href', '/');
    $("label[for='webtoon']").find('a').attr('href', '/webtoon');
    $("label[for='comic']").find('a').attr('href', '/comic');
    $("label[for='novel']").find('a').attr('href', '/novel');

    // 회원 정보 조회
    let memberInfo = local.memberInfo();
    if (memberInfo == null) { // 비로그인
      $("label[for='my']").find('a').attr('href', '/guest');

    } else { // 로그인
      $("label[for='my']").find('a').attr('href', '/member');
    }

    /* 선택한 메뉴 버튼 활성화 */
    let path = $(location).attr('pathname'); // 현재 url path

    if (path == "/") { // 메인 페이지
      $("input:radio[name=nav_icon][id='home']").prop("checked", true);

    } else if (path == "/webtoon") { // 웹툰 카테고리 페이지
      $("input:radio[name=nav_icon][id='webtoon']").prop("checked", true);

    } else if (path == "/comic") { // 만화 카테고리 페이지
      $("input:radio[name=nav_icon][id='comic']").prop("checked", true);

    } else if (path == "/novel") { // 소설 카테고리 페이지
      $("input:radio[name=nav_icon][id='novel']").prop("checked", true);

    } else if (path == "/guest" || path == "/member") { // 마이 페이지
      $("input:radio[name=nav_icon][id='my']").prop("checked", true);
    }

  });
</script>