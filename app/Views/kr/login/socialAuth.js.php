<script>
    // 네이버 인증 완료
    let accessToken;
    if (location.hash) {
        accessToken = location.hash.split('=')[1].split('&')[0];
        opener.parent.naver.auth(accessToken,'login');
    }
    window.close();
</script>
