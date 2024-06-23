<script>
    const id = "{=urlencode(_GET.id)}";
    const ci = "{=urlencode(_GET.ci)}";
    const di = "{=urlencode(_GET.di)}";
    const msg = "{=urlencode(_GET.msg)}";

    if (ci === "" || di === "") {
        toast.alert(msg);
    }
    if (ci !== "" && di !== "") {
        window.opener.postMessage({ id: decodeURIComponent(id), ci: decodeURIComponent(ci), di: decodeURIComponent(di), type: 'findInfoAuthPw' }, window.location.origin);
    }
    window.close();
</script>
