<style>
  button {
    border-style: none;
    background-color: transparent;
    padding: 0px;
  }

  header#episode_header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    height: 56px;
    box-sizing: border-box;
    padding: 12px 0.5rem;
    background: linear-gradient(to bottom, rgba(0, 0, 0, 0.5) 0%, rgba(0, 0, 0, 0) 100%);
    position: sticky;
    top: 0px;
    left: 0px;
    z-index: 1001;
  }

  header#episode_header>button {
    width: 32px;
    height: 32px;
    border-style: none;
    background-color: transparent;
    padding: 0px;
  }

  header#episode_header>button>svg {
    stroke: #fff;
  }

  header#episode_header.active>button>svg {
    stroke: #fff;
  }


  header#episode_header .right_menu {
    position: relative;

  }

  header#episode_header .right_menu svg circle {
    fill: #fff;
  }

  header#episode_header .dot_wrap {
    display: none;
  }

  header#episode_header .dot_wrap.active {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    width: 89px;
    box-sizing: border-box;
    padding: 1rem 0px;
    border: 1px solid var(--border-e0);
    background-color: var(--theme-day-bg);
    border-radius: 0.5rem;
    position: absolute;
    top: 34px;
    right: 0px;
    z-index: 1000;
  }

  header#episode_header .dot_wrap>button {
    width: 100%;
    text-align: center;
    color: var(--text-secondary);
    padding: 0.5rem 0px;
    border-style: none;
    background-color: var(--theme-day-bg);
  }

  header#episode_header .dot_wrap>button:active,
  header#episode_header .dot_wrap>button.active,
  header#episode_header .dot_wrap>button:hover {
    color: var(--secondary);
  }


  /* !기본 헤더에서 타이틀 hide */
  header#episode_header p.title {
    display: none;
  }





  header#episode_header.active,
  header#episode_header.type_novel {
    background: var(--theme-day-bg)
  }

  header#episode_header.active button>svg,
  header#episode_header.type_novel button>svg {
    stroke: var(--text-able);
  }

  header#episode_header.type_novel p.title {
    display: none;
  }

  header#episode_header.active p.title,
  header#episode_header.active.type_novel p.title {
    display: block;
    width: calc(100% - 72px);
    text-align: center;
    font-family: 'NanumSquareNeo';
    font-weight: 800;
    line-height: 140%;
    color: var(--text-able);
    margin-bottom: 0px;
  }

  header#episode_header.active .right_menu button>svg circle,
  header#episode_header.type_novel .right_menu button>svg circle {
    fill: var(--text-able);
  }

  header#episode_header.active .right_menu button>svg>defs,
  header#episode_header.type_novel .right_menu button>svg>defs {
    display: none;
    visibility: hidden;
  }
</style>

<header id="episode_header" class="active">
  <button class="episode_back">
    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M20 8L12 16L20 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
    </svg>
  </button>
  <p class="title"></p>
  <div class="right_menu">
    <button>
      <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g filter="url(#filter0_d_5900_14823)">
          <circle cx="16.5" cy="9.5" r="1.5" />
          <circle cx="16.5" cy="16.5" r="1.5" />
          <circle cx="16.5" cy="23.5" r="1.5" />
        </g>
        <defs>
          <filter class="filter-test" id="filter0_d_5900_14823" x="12" y="5" width="9" height="23"
            filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
            <feFlood flood-opacity="0" result="BackgroundImageFix" />
            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
              result="hardAlpha" />
            <feOffset />
            <feGaussianBlur stdDeviation="1.5" />
            <feComposite in2="hardAlpha" operator="out" />
            <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.2 0" />
            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_5900_14823" />
            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_5900_14823" result="shape" />
          </filter>
        </defs>
      </svg>
    </button>
    <div class="dot_wrap">
      <button id="right_menu_like" class="Text-sm">찜하기</button>
      <button id="right_menu_report" class="Text-sm">신고하기</button>
    </div>
  </div>
</header>

<script>
  $(document).ready(function () {
    let filterTest = document.querySelector('.filter-test');

    let episodeHeader = document.querySelector('#episode_header');

    if (episodeHeader.classList.contains('active')) {
      filterTest.id = '';
    } else if (episodeHeader.classList.contains('type_novel')) {
      filterTest.id = '';
    } else {
      filterTest.id = 'filter0_d_5900_14823';
    }
  })
</script>