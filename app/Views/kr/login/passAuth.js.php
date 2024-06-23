<script>
    const res = "{_GET.res}";
    const msg = "{_GET.msg}";
    const txseq = "{_GET.txseq}";

    if (res === 'fail') {
        toast.alert(msg);
    }

    if (txseq) {
        window.opener.postMessage({ txseq, type: 'passAuth' }, window.location.origin);
    }

    window.close();
</script>
