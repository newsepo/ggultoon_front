<header id="charging">
  <a href="/">
    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M20 8L12 16L20 24" stroke="#222222" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
    </svg>
  </a>
  <p>꿀충전</p>
</header>

<div class="charging_container">

    <div class="banner_wrap">
        <!-- 메인 배너-->
        {# mainBanner }
    </div>

  <!-- 충전 리스트 -->
  <div class="charging_content">
    <div>
      <h4 id="charging_title"></h4>
      <ul id="charging_list"></ul>
    </div>

    <div class="grade_section">
        {# grade // 회원등급}
        <p class="grade_notice Text-md" style="display: none;">></p>
    </div>

    <div id="select_product" style="display: none;">
      <hr class="line">
      <br>
      <h4>선택 상품</h4>
      <div class="charging_info">
        <p>
          <span class="Text-sm">코인 수</span>
          <span class="Text-lg" id="select_product_coin">300</span>
        </p>
        <p>
          <span class="Text-sm">추가 혜택</span>
          <span class="Text-lg" id="select_product_mileage">800</span>
        </p>
        <p>
          <span class="Text-sm">최종 결제 금액</span>
          <span class="Text-lg" id="select_product_price">29,900</span>
        </p>
      </div>
      <hr class="line">
    </div>

    <div class="simple_pay" style="display: none;">
      <h4>간편 결제</h4>
      <div id="simple_pay">
      </div>
    </div>
    <div class="normal_pay" style="display: none;">
      <h4>일반 결제</h4>
      <div id="normal_pay">
      </div>
      <br>
    </div>

    <hr class="line">

    <div class="notice">
      <p class="Text-md">알려드립니다!</p>
      <p class="Text-sm">
        <span><b>·</b><b>모든 상품은 부가가치세가 별도로 부과됩니다.</b></span>
        <span><b>·</b><b>구입하신 꿀은 모든 디바이스에서 자유롭게 사용 가능합니다.</b></span>
        <span><b>·</b><b>결제가 완료되기 전, 결제창을 닫으면 결제가 완료되지 않을 수 있습니다.</b></span>
        <span><b>·</b><b>꿀은 충전일로부터 7일 이내, 사용하지 않은 상품만 환불이 가능합니다.</b></span>
        <span><b>·</b><b>당월 결제 시 당월 취소, 익월 환불 시 결제자 본인계좌로만 환불가능 합니다.</b></span>
        <span><b>·</b><b>휴대폰 결제의 경우 당월 결제 취소만 가능, 익월 이후 요청 시 휴대폰 요금 납부 확인 후 결제자 본인 계좌로만 환불가능 합니다.</b></span>
        <span><b>·</b><b>결제 혜택 및 이벤트는 내부 사정에 따라 사전 예고없이 변경 및 종료 될 수 있습니다.</b></span>
        <span><b>·</b><b>모든 작품은 꿀 및 마일리지를 사용하여 감상할 수 있습니다.</b></span>
        <span><b>·</b><b>충전일을 기준으로 유료꿀의 경우 5년, 보너스꿀 및 마일리지의 경우 30일 동안 이용하지 않을 경우 각 기간 종료일다음날 소멸합니다.</b></span>
        <span><b>·</b><b>결제내역은 마이페이지 이용내역 메뉴에서 확인 가능합니다.</b></span>
        <span><b>·</b><b>결제에 대한 자세한 문의는 꿀툰 고객센터 실시간 문의로 문의하시길 바랍니다.</b></span>
      </p>
    </div>
  </div>
</div>