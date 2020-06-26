<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog me-modal">
        <div class="modal-content bottom_rounded top_rounded">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0 px-sm-5 px-3">
                <div class="h4 text-center text-warning pb-3">Log in</div>
                <?= do_shortcode('[ultimatemember form_id="312"]');?>
                <p class="text-center"><a href="javascript:void(0)" class="text-muted" data-modalto="reset" onclick="changeModals(this)">Forgot your password?</a></p>
                <p class="text-center">New to magicEnglish?<span class="d-sm-inline d-none arrow_symbol mx-3">⟶</span><a
                href="javascript:void(0)" data-modalto="signup" class="d-sm-inline d-block" onclick="changeModals(this)">Create
                an account.</a></p>
            </div>
        </div>
    </div>
</div>