(function(){var w=window;if(w.ChannelIO){return w.console.error("ChannelIO script included twice.");}var ch=function(){ch.c(arguments);};ch.q=[];ch.c=function(args){ch.q.push(args);};w.ChannelIO=ch;function l(){if(w.ChannelIOInitialized){return;}w.ChannelIOInitialized=true;var s=document.createElement("script");s.type="text/javascript";s.async=true;s.src="https://cdn.channel.io/plugin/ch-plugin-web.js";var x=document.getElementsByTagName("script")[0];if(x.parentNode){x.parentNode.insertBefore(s,x);}}if(document.readyState==="complete"){l();}else{w.addEventListener("DOMContentLoaded",l);w.addEventListener("load",l);}})();

let help ={
    enc:function (idx) {
        let enc ='';
        $.ajax({
            url: '/help/enc/'+idx,
            cache: true,
            method: 'GET',
            async:false,
            success: function (res) {
                enc = res;

            }
        })
        return enc;
    }
}
// 채널톡 옵셥 설정
const options = {
    pluginKey:  "4803137b-e885-4e62-847e-bdd0b99e35f9",
    customLauncherSelector: ".btn-channel",
    hideChannelButtonOnBoot: true,
};
// 로그인 회원의 회원 정보 전송
if (local.memberInfo() != null) {
    options.memberId = local.memberInfo().data.idx;
    options.memberHash = help.enc(options.memberId);
}
// 채널톡 실행
ChannelIO('boot', options);



