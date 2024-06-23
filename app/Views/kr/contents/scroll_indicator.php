<style>
  .indicator_wrap{
    display: none;
    position: fixed;
    top: 50%;
    width: 570px;
    max-width: 100%;
    z-index: 999;
    transform: translateY(-50%);
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
  }
  .indicator_wrap>div {
    box-sizing: border-box;
    padding: 1rem;
    border-radius: 0.5rem;
    background-color: rgba(34, 34, 34, 0.8);
    color: var(--theme-day-bg);
    position: absolute;
    top: 50%;
    left: 50%;
    opacity: 0;
    z-index: 10000;
    transform: translate(-50%,-50%);
    -webkit-transform: translate(-50%,-50%);
    -moz-transform: translate(-50%,-50%);
    -ms-transform: translate(-50%,-50%);
    -o-transform: translate(-50%,-50%);
  }

  .indicator_wrap>div>svg {
    display: block;
    width: 32px;
    height: 32px;
    margin: 0 auto;
  }

  .indicator_wrap>div>p {
    display: block;
    font-family: "NanumSquareNeo";
    font-size: 12px;
    font-weight: 800;
    line-height: 140%;
    letter-spacing: -0.5px;
    text-align: center;
    margin-top: 0.25rem;
    margin-bottom: 0px;
    color: var(--theme-day-bg);
  }

  .indicator_wrap.active{
    display: block;
  }
  .indicator_wrap#vertical.active > div.vertical{
    animation: fade_out 2s linear;
  }

  .indicator_wrap#horizontal.active > div.horizontal{
    animation: fade_out 2s linear;
  }

  @keyframes fade_out {
    0% {
      opacity: 0;
    }

    50% {
      opacity: 1;
    }

    80%{
      opacity: 1;
    }
    100% {
      opacity: 0;
    }
  }
</style>



<div class="indicator_wrap">
  <div class="vertical">
    <svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M23 24L23 8" stroke="white" stroke-width="2" stroke-linecap="round" />
      <path d="M24.5 9.5L23 8L21.5 9.5" stroke="white" stroke-width="2" stroke-linecap="round"
        stroke-linejoin="round" />
      <path d="M24.5 22.5L23 24L21.5 22.5" stroke="white" stroke-width="2" stroke-linecap="round"
        stroke-linejoin="round" />
      <rect x="8.5" y="24" width="16" height="8" rx="1.5" transform="rotate(-90 8.5 24)" stroke="white" stroke-width="2"
        stroke-linejoin="round" />
    </svg>
    <p>위아래로 넘겨서 보세요</p>
  </div>
  <div class="horizontal">
    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path fill-rule="evenodd" clip-rule="evenodd"
        d="M7 22.5C7 21.9477 7.44772 21.5 8 21.5H24C24.5523 21.5 25 21.9477 25 22.5C25 23.0523 24.5523 23.5 24 23.5H8C7.44772 23.5 7 23.0523 7 22.5Z"
        fill="#FBFBFB" />
      <path fill-rule="evenodd" clip-rule="evenodd"
        d="M21.7929 20.2929C22.1834 19.9024 22.8166 19.9024 23.2071 20.2929L24.7071 21.7929C25.0976 22.1834 25.0976 22.8166 24.7071 23.2071L23.2071 24.7071C22.8166 25.0976 22.1834 25.0976 21.7929 24.7071C21.4024 24.3166 21.4024 23.6834 21.7929 23.2929L22.5858 22.5L21.7929 21.7071C21.4024 21.3166 21.4024 20.6834 21.7929 20.2929Z"
        fill="#FBFBFB" />
      <path fill-rule="evenodd" clip-rule="evenodd"
        d="M10.2071 20.2929C10.5976 20.6834 10.5976 21.3166 10.2071 21.7071L9.41421 22.5L10.2071 23.2929C10.5976 23.6834 10.5976 24.3166 10.2071 24.7071C9.81658 25.0976 9.18342 25.0976 8.79289 24.7071L7.29289 23.2071C6.90237 22.8166 6.90237 22.1834 7.29289 21.7929L8.79289 20.2929C9.18342 19.9024 9.81658 19.9024 10.2071 20.2929Z"
        fill="#FBFBFB" />
      <path fill-rule="evenodd" clip-rule="evenodd"
        d="M7 9.5C7 8.11929 8.11929 7 9.5 7H22.5C23.8807 7 25 8.11929 25 9.5V14.5C25 15.8807 23.8807 17 22.5 17H9.5C8.11929 17 7 15.8807 7 14.5V9.5ZM9.5 9C9.22386 9 9 9.22386 9 9.5V14.5C9 14.7761 9.22386 15 9.5 15H22.5C22.7761 15 23 14.7761 23 14.5V9.5C23 9.22386 22.7761 9 22.5 9H9.5Z"
        fill="#FBFBFB" />
    </svg>
    <p>좌우로 넘겨서 보세요</p>
  </div>
</div>