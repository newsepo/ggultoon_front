<?php

/**
 * 타임존 : https://en.wikipedia.org/wiki/List_of_tz_database_time_zones
 *
 * 기본 셋팅된 폴더 사용시
 * langs('파일명.key');
 *
 * 다른 언어 폴더 사용시
 * langs('파일명.key', [], 'en');
 * ex: langs('Validation.테스트', [], 'en');
 */
return [
    '잘못된파라미터입니다' => 'Invalid parameter.',
    '아이디를입력해주세요' => 'Please enter your ID.',
    '패스워드를입력해주세요' => 'Please enter your password.',
    '패스워드를다시입력해주세요' => 'Please enter your password again.',
    '이름을입력해주세요' => 'Input your name, please.',
    '아이디는_자이상_자이하입력해주세요' => 'Please enter your ID between {0, number} and {1, number} characters.',
    '패스워드는_자이상_자이하입력해주세요' => 'Please enter at least {0, number} characters and no more than {1, number} characters for your password.',
    '입력하신패스워드가일치하지않습니다' => 'The passwords you entered do not match.',
    '이름은_자이상_자이하입력해주세요' => 'Please enter your name with at least {0, number} characters and no more than {1, number} characters.',
];
