<?php
/**
 * CLI 라우터
 */
$routes->cli('/', 'Home\Main::index');
// 텔레그램
$routes->cli('tg/send_cli/(:any)', 'Tg::send_cli/$1');


/**
 * 웹 라우터
 */
// 메인
$routes->get('/', 'Home\Main::index');

// 검색봇 설정
//$routes->get('robots.txt', 'Home\Main::bot');

// 웹툰
$routes->get('webtoon', 'Category\Webtoon::index');

// 만화
$routes->get('comic', 'Category\Comic::index');

// 소설
$routes->get('novel', 'Category\Novel::index');

// 마이페이지(비로그인)
$routes->get('guest', 'My\Guest::index');

// 마이페이지(로그인)
$routes->get('member', 'My\Member::index');

// 검색 결과 미리보기
$routes->get('search/main', 'Search\Main::index');

// 작품 검색 결과 페이지 더보기
$routes->get('search/content', 'Search\Content::index');
// 작가 검색 결과 페이지 더보기
$routes->get('search/author', 'Search\Author::index');
// 태그 검색 결과 페이지 더보기
$routes->get('search/tag', 'Search\Tag::index');


// 작품 그룹
$routes->group('contents', static function ($routes) {
    // 회차 리스트
    $routes->get('(:num)/episode', 'Contents\Episode::index/$1');
    // 작품 댓글 리스트
    $routes->get('(:num)/comments', 'Contents\ContentComment::index/$1');
    // 작품 뷰어
    $routes->get('(:num)/episode/(:num)', 'Contents\Viewer::index/$1/$2');
    // 회차 댓글 리스트
    $routes->get('(:num)/episode/(:num)/comments', 'Contents\EpisodeComment::index/$1/$2');
});

// 회원가입
$routes->get('join', 'Login\Join::index');

// 로그인
$routes->get('login', 'Login\Login::index');

// 네이버 인증
$routes->get('auth/naver', 'Login\Join::authSocial');

// 본인인증 완료
$routes->get('passAuth', 'Login\Join::passAuth');

// 아이디/비밀번호 찾기
$routes->get('findInfo', 'FindInfo\FindInfo::index');

// 아이디 찾기 본인인증
$routes->get('findInfoAuthId', 'FindInfo\FindInfo::findInfoAuthId');

// 비밀번호 찾기 본인인증
$routes->get('findInfoAuthPw', 'FindInfo\FindInfo::findInfoAuthPw');

// 아이디/비밀번호 찾기 결과
$routes->get('findResult', 'FindInfo\FindResult::index');

// 탈퇴
$routes->get('leave', 'Leave\Leave::index');

// 내정보
$routes->get('my/info', 'MyInfo\MyInfo::index');

// 이용내역
$routes->get('my/history/charged', 'History\Charged::index');
$routes->get('my/history/used', 'History\Charged::index');
$routes->get('my/history/expired', 'History\Charged::index');

// 내서재
$routes->get('my/lib', 'MyLib\MyLib::index');
$routes->get('my/lib/view', 'MyLib\MyLib::view');
$routes->get('my/lib/rent', 'MyLib\MyLib::rent');
$routes->get('my/lib/have', 'MyLib\MyLib::have');
$routes->get('my/lib/favorite', 'MyLib\MyLib::favorite');
$routes->get('my/lib/bottomSheet', 'MyLib\MyLib::bottomSheet');


// 커뮤니티 메인
$routes->get('community', 'Community\Community::index');
// 커뮤니티 글쓰기
$routes->get('community/write', 'Community\Write::index');
// 커뮤니티 작품 선택
$routes->get('community/chooseContent', 'Community\ChooseContent::index');
// 커뮤니티 게시글 디테일
$routes->get('community/post', 'Community\Post::index');



// 알림
$routes->get('my/notify', 'Notification\Notification::index');

// 환경설정
$routes->get('my/setting', 'Setting\Setting::index');

// 결제 그룹
$routes->group('charging', static function ($routes) {
    // 충전소
    $routes->get('', 'Charging\Charging::index');
    // 결제완료
    $routes->post('complete', 'Charging\Charging::complete');
    // 결제취소
    $routes->post('cancel', 'Charging\Charging::cancel');
});

// 카드 포인트 전환
$routes->get('point/card', 'Point\Card::index');

// 이용약관
$routes->get('policy/service', 'Policy\TermsOfUse::index');
// 개인정보처리방침
$routes->get('policy/privacy', 'Policy\Privacy::index');
// 청소년보호정책
$routes->get('policy/youth', 'Policy\Youth::index');

// 이용약관 모달
$routes->get('policy/service/popup', 'Policy\TermsOfUse::servicePopup');
// 개인정보처리방침 모달
$routes->get('policy/privacy/popup', 'Policy\Privacy::privacyPopup');
// 마케팅 약관 모달
$routes->get('policy/marketing', 'Policy\Marketing::index');

// 고객센터
$routes->get('help/notice', 'Help\Notice::index');

// 실시간 문의
$routes->get('help/counseling', 'Help\Counseling::index');

// 채널톡 memberHash 생성
$routes->get('help/enc/(:num)', 'Help\Counseling::memberHash/$1');

// 제휴연재문의
$routes->get('suggestion', 'Suggest\Suggest::index');

// 이벤트
// $routes->get('event', 'Event\Event::index');
// 무협 이벤트
$routes->get('event/contentEvent', 'Event\Hero::index');
// 여름 이벤트
$routes->get('event/summer', 'Event\Summer::index');
// 제휴사 쿠폰 이벤트
$routes->get('event/ottcoupon', 'Event\Ottcoupon::index');
// 마일리지 이벤트
$routes->get('event/mileage', 'Event\Mileage::index');
// 첫결제 마일리지 이벤트
$routes->get('event/firstCharge', 'Event\FirstCharge::index');
// 등급별 리워드 이벤트
$routes->get('event/levelReward', 'Event\LevelReward::index');



// modal test
$routes->get('modal', 'Modal\Modal::index');

// 선물함
$routes->get('gift', 'Gift\Gift::index');

// 테스트
$routes->get('help/info', 'Help\Counseling::info');
