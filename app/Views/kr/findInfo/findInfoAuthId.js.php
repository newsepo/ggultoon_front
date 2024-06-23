<script>
    const mdl_tkn = "{_GET.mdl_tkn}";
    const msg = "{_GET.msg}";

    if (mdl_tkn === 'fail') {
        toast.alert(msg);
    }
    if (mdl_tkn) {
        window.opener.postMessage({ mdl_tkn, type: 'findInfoAuthId' }, window.location.origin);
    }
    window.close();
</script>
