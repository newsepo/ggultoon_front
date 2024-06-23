# CodeIgniter 4 Framework.

## 서버 요구 사항

다음 확장이 설치된 PHP 버전 7.4 이상이 필요합니다.

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

또한 PHP에서 다음 확장이 활성화되어 있는지 확인하십시오.

- json(기본적으로 활성화됨 - 끄지 마십시오)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) MySQL을 사용하려는 경우
- [libcurl](http://php.net/manual/en/curl.requirements.php) HTTP\CURLRequest 라이브러리를 사용하려는 경우

## 기본 설정 사항

* 초기 변경 사항

   ```sh
   └─Document Root
      │
      ├─/app
      │  │
      │  ├─/Config
      │  │  │
      │  │  ├─/development (추가: 라우터 설정)
      │  │  │  │
      │  │  │  └─Routes.php (추가: 라우터 설정)
      │  │  │
      │  │  ├─/production (추가: 라우터 설정)
      │  │  │  │
      │  │  │  └─Routes.php (추가: 라우터 설정)
      │  │  │
      │  │  ├─App.php ('수정: 각 설정 - 기존값은 주석처리')
      │  │  │
      │  │  ├─Constants.php ('수정: ConstantsExt.php 파일 포함하도록')
      │  │  │
      │  │  ├─ConstantsExt.php (추가: 사용자 상수 선언)
      │  │  │
      │  │  ├─Database.php ('수정: 디비 커넥션 관리')
      │  │  │
      │  │  ├─Session.php ('수정: 세션 디비 커넥션 관리')
      │  │  │
      │  │  └─Paths.php ('수정: /system에서 변경된 폴더 바라보도록')
      │  │
      │  ├─/Controllers
      │  │  │
      │  │  ├─BaseController.php ('수정: 컨트롤러의 컨트롤러')
      │  │  │
      │  │  ├─Main.php ('수정: 테스트 소스')
      │  │  │
      │  │  └─Tg.php (추가: 텔레그램 푸시용 파일)
      │  │
      │  ├─/Filters
      │  │  │
      │  │  ├─AuthFilter.php (추가: 로그인 체크 필터)
      │  │  │
      │  │  └─UserFilter.php (추가: 로그인 체크 필터)
      │  │
      │  ├─/Helpers
      │  │  │
      │  │  └─common_helper.php (추가: 뷰단에서 사용할 함수 선언)
      │  │
      │  ├─/Language
      │  │  │
      │  │  └─/kr (추가: 언어 설정)
      │  │     │
      │  │     └─Validation.php (추가: 언어 설정)
      │  │
      │  ├─/Libraries
      │  │  │
      │  │  ├─/tpl_plugin (추가: 템플릿언더바 라이브러리)
      │  │  │
      │  │  ├─DatabaseDriver.php (추가: 쿼리 라이브러리)
      │  │  │
      │  │  ├─Protect.php (추가: 암호화 라이브러리)
      │  │  │
      │  │  ├─Template_.compiler.php (추가: 템플릿언더바 라이브러리)
      │  │  │
      │  │  └─Template_.php (추가: 템플릿언더바 라이브러리)
      │  │
      │  ├─/Model
      │  │  │
      │  │  ├─BaseModel.php (추가: 전체 모델 관리용)
      │  │  │
      │  │  └─UserModel.php (추가: 세션관리용)
      │  │
      │  └─/Views
      │     │
      │     └─/common (추가: 공통 HTML 레이아웃)
      │
      ├─/public
      │  │
      │  └─/assets (추가: js/css/editor/images/vendor 업로드용 폴더)
      │
      ├─/system_4.3.4  ('변경: /system에서 버전정보 포함하도록')
      │
      ├─/tests
      │
      ├─/writable
      │  │
      │  └─/cache (추가: 템플릿언더바 사용위해)
      │     │
      │     └─/template (추가: 템플릿언더바 사용위해)
      │          │
      │          └─/_compile (추가: 템플릿언더바 사용위해)
      │
      ├─.gitignore (추가: git 배포시 불필요한 파일 거르기 위해)
      │
      ├─composer.json
      │
      ├─env
      │
      ├─LICENSE
      │
      ├─phpunit.xml
      │
      ├─preload.php
      │
      ├─README.md ('변경: 기본 설명 작성')
      │
      └─spark
   ```


## 1. 테이블 셋팅

1. 테스트 테이블

   ```
   CREATE TABLE `tbl_admin` (
    `idx` bigint unsigned NOT NULL AUTO_INCREMENT,
    `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '아이디',
    `pw` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '패스워드',
    `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '이름',
    PRIMARY KEY (`idx`)
    ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
   ```

    - 테스트 아이디 : test / 123456 / 홍길동   

2. 세션 테이블

   ```
   CREATE TABLE `ci_sessions` (
    `id` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
    `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `data` blob NOT NULL,
    KEY `ci_sessions_timestamp` (`timestamp`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
   ```
   
3. 트랜잭션 테스트 테이블

    ```
    CREATE TABLE `tbl_test` (
      `idx` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `title` VARCHAR(100) COLLATE utf8mb4_unicode_ci NOT NULL,
      PRIMARY KEY (`idx`)
    ) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    
    CREATE TABLE `tbl_test_sub` (
      `idx` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `title` VARCHAR(100) COLLATE utf8mb4_unicode_ci NOT NULL,
      PRIMARY KEY (`idx`)
    ) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ```

4. Exception 응답은 http status 사용 : FE/어플과 응닶값은 맞춰야 함
