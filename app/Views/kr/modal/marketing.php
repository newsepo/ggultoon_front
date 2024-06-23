<style>
  header#marketing {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    gap: 0.25rem;
    width: 100%;
    box-sizing: border-box;
    padding: 12px 0.5rem;
    position: sticky;
    top: 0px;
    left: 0px;
    z-index: 1000;
    background-color: var(--theme-day-bg);
  }

  header#marketing button {
    border-style: none;
    width: 32px;
    height: 32px;
    box-sizing: border-box;
    padding: 0px;
    background-color: transparent;
  }


  header#marketing>p {
    margin-bottom: 0px;
    font-family: 'NanumSquareNeo';
    font-weight: 800;
    font-size: 1rem;
    line-height: 120%;
    letter-spacing: -0.5px;
    color: var(--text-able);
    width: calc(100% - 36px - 1rem);
    text-align: center;
  }

  .marketing_container {
    box-sizing: border-box;
    width: 100%;
    display: grid;
    padding: 4px 1rem;
    padding-bottom: 4rem;
    gap: 24px;
  }

  .marketing_container h3,
  .marketing_container h4 {
    font-family: 'NanumSquareNeo';
    font-weight: 800;
    display: block;
    width: 100%;
  }

  .marketing_container h3,
  .marketing_container h4,
  .marketing_container p {
    color: var(--text-333);
  }


  .marketing_container table>thead {
    background-color: #ededed;
  }

  .marketing_container table>thead>tr>th:last-of-type {
    width: 40%;
  }
</style>




<header id="marketing">
  <p class="title">마케팅 광고 약관</p>
  <button class="btn-modal-close">
    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"
      class="cursor-pointer">
      <path fill-rule="evenodd" clip-rule="evenodd"
        d="M8.29289 22.2929C7.90237 22.6834 7.90237 23.3166 8.29289 23.7071C8.68342 24.0976 9.31658 24.0976 9.70711 23.7071L16 17.4142L22.2929 23.7071C22.6834 24.0976 23.3166 24.0976 23.7071 23.7071C24.0976 23.3166 24.0976 22.6834 23.7071 22.2929L17.4142 16L23.7071 9.70711C24.0976 9.31658 24.0976 8.68342 23.7071 8.29289C23.3166 7.90237 22.6834 7.90237 22.2929 8.29289L16 14.5858L9.70711 8.29289C9.31658 7.90237 8.68342 7.90237 8.29289 8.29289C7.90237 8.68342 7.90237 9.31658 8.29289 9.70711L14.5858 16L8.29289 22.2929Z"
        fill="#222222"></path>
    </svg>
  </button>
</header>

<div class="Text-md marketing_container ">
  <div class="Text-md">
    <h4 class="Title-sm">1. 광고성 정보의 이용목적</h4>
    <p>
      주식회사 유엑스플러스스튜디오 가 제공하는 이용자 맞춤형 서비스 및 상품 추천, 각종 경품 행사,이벤트 등의
      광고성 정보를 전자우편이나 인터넷 광고, 서신우편, 문자(SMS 또는 카카오 알림톡), 푸시, 전화 등을 통해
      이용자에게 제공합니다. (보유기간 : 회원탈퇴 또는 위탁계약 종료시까지)
    </p>
  </div>

  <div class="Text-md">
    <h4 class="Title-sm">2.미동의 시 불이익 사항</h4>
    <p>
      개인정보보호법 제22조 제5항에 의해 선택정보 사항에 대해서는 동의 거부하시더라도 서비스 이용에 제한되지
      않습니다.
      <br /> 단, 할인, 이벤트 및 이용자 맞춤형 추천 등의 마케팅 정보 안내 서비스가 제한됩니다.
    </p>
  </div>
</div>


<script>
  // X(닫기) 버튼
  $(document).on('click', '#marketing .btn-modal-close', function () {
    $(this).closest('.modal#terms').css('display', 'none');
    $(this).closest('.modal#terms .modal-body').empty();
  })
</script>