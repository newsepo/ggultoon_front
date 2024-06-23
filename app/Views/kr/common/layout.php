<!DOCTYPE html>
<html lang="ko" data-env="{C.ENVIRONMENT}" oncontextmenu="return false;" style="overflow-y:scroll;">

<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-7KGBEY9663"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());

        gtag('config', 'G-7KGBEY9663');
    </script>
    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || []; w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            }); var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-MWQVFXH');</script>
    <!-- End Google Tag Manager -->
    {# head}
    {# js}
    <style>
        #toonWrap.hide #sideSection {
            display: none;
        }

        #toonWrap.hide #mainSection {
            max-width: 768px;
        }

        @media screen and (max-width: 1294px) {
            #toonWrap.hide #mainSection {
                width: 768px;
            }
        }
    </style>
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MWQVFXH" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <section id="toonWrap">
        <div id="sideSection">
            {# sideSection}
        </div>
        <div id="mainSection">
            {# main_header}
            {# menu}
            <div id="layoutSidenav">
                <div class="toast-wrap active"></div>
                {# body}
                {# modal}
                {# login}
            </div>
            <!-- 확대,축소 btn -->
            <button id="zoom_in_out">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_3142_71659)">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M2 8.5C2 4.91015 4.91015 2 8.5 2C12.0899 2 15 4.91015 15 8.5C15 12.0899 12.0899 15 8.5 15C4.91015 15 2 12.0899 2 8.5ZM8.5 0C3.80558 0 0 3.80558 0 8.5C0 13.1944 3.80558 17 8.5 17C10.4869 17 12.3145 16.3183 13.7618 15.176L18.2929 19.7071C18.6834 20.0976 19.3166 20.0976 19.7071 19.7071C20.0976 19.3166 20.0976 18.6834 19.7071 18.2929L15.176 13.7618C16.3183 12.3145 17 10.4869 17 8.5C17 3.80558 13.1944 0 8.5 0Z"
                            fill="#222222" />
                        <rect x="5" y="7.5" width="7" height="2" rx="1" fill="#222222" />
                        <rect x="9.5" y="5" width="7" height="2" rx="1" transform="rotate(90 9.5 5)" fill="#222222" />
                    </g>
                    <defs>
                        <clipPath id="clip0_3142_71659">
                            <rect width="20" height="20" fill="white" />
                        </clipPath>
                    </defs>
                </svg>
            </button>

            {# foot}
            {# layer}
            {# import_js}
        </div>
    </section>
</body>
<script>

    $(document).ready(function () {

        const btnZoom = document.querySelector('#zoom_in_out');
        const toonWrap = document.querySelector('#toonWrap');

        function btnZoomPostion() {
            let mainSection = document.querySelector('#mainSection');
            let mainPosition = mainSection.offsetLeft;
            let mainWidth = mainSection.clientWidth;

            btnZoom.style.left = mainPosition + mainWidth + 'px'
        }
        btnZoomPostion();

        let checkHide;
        local.chkWrapWide() == null ? localStorage.setItem('chkWrapWide', false) : checkHide = local.chkWrapWide();

        checkHide = (checkHide === "true") ? true : false;
        if (checkHide) {
            toonWrap.classList.add('hide');
            btnZoomPostion();
        } else {
            toonWrap.classList.remove('hide');
            btnZoomPostion();
        }

        btnZoom.addEventListener('click', function () {
            toonWrap.classList.toggle('hide');
            btnZoomPostion();

            if (toonWrap.classList.contains('hide')) {
                checkHide = true;
            } else {
                checkHide = false;
            }
            localStorage.setItem('chkWrapWide', checkHide);
        })

        $(window).resize(function () {
            btnZoomPostion();
        });
    });
</script>

</html>