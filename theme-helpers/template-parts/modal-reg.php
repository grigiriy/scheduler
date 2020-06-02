<div class="modal fade" id="signin" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog me-modal">
        <div class="modal-content bottom_rounded top_rounded">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0">
                <div class="h4 text-center text-warning pb-3">Create an account</div>
                <div class="px-sm-5 px-1">
                    <?= do_shortcode('[ultimatemember form_id="311"]'); ?>
                    <p class="text-center">Already have an account?<span class="arrow_symbol mx-3">⟶</span>
                        <a href="javascript:void(0)" data-modalto="login" onclick="changeModals(this)">Log in.</a></p>
                </div>
            </div>
        </div>
    </div>
</div>