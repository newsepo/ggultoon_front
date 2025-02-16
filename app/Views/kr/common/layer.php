<!-- toast -->
<input type="hidden" id="error_toast" value="{ERROR.message}">
<div id="box_toast" class="position-fixed bottom-0 end-0 p-3" style="z-index: 11"></div>

<!-- layer_dialog -->
<div class="modal fade" id="layer_dialog">
    <div class="modal-dialog" id="section_dialog"></div>
</div>

<!-- layer_dialog_large_size -->
<div class="modal fade" id="layer_dialog_lg">
    <div class="modal-dialog modal-lg" id="section_dialog_lg"></div>
</div>

<script>
    // 종료시 내용 비우기
    let layer_dialog_lg = document.getElementById('layer_dialog_lg')
    layer_dialog_lg.addEventListener('hidden.bs.modal', function (event) {
        $('#section_dialog_lg').empty();
    })
    let layer_dialog = document.getElementById('layer_dialog')
    layer_dialog.addEventListener('hidden.bs.modal', function (event) {
        $('#section_dialog').empty();
    })
</script>