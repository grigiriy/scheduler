<div class="modal fade" id="authModal" tabindex="-1" role="dialog" aria-hidden="true">
    aria-hidden="true">
    <div class="modal-dialog me-modal">
        <div class="modal-content bottom_rounded top_rounded">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0">
                <div class="h4 text-center text-warning pb-3">Log in</div>
                <form class="px-5 form-group" name="loginform" action="/wp-login.php" method="post">
                    <p>
                        <input class="form-control" type="text" name="log" placeholder="Email" value="" size="20"
                            tabindex="10" />
                    </p>
                    <p>

                        <input class="form-control" type="password" name="pwd" placeholder="Password" value="" size="20"
                            tabindex="20" />
                    </p>
                    <p class="text-center my-4">
                        <input type="submit" name="wp-submit" class="btn btn-primary btn-round px-4 py-2" value="Log in"
                            tabindex="100" />
                    </p>
                    <input type="hidden" name="redirect_to" value="/account/" />
                </form>
                <p class="text-center">New to magicEnglish?<span class="arrow_symbol mx-3">⟶</span><a
                        href="javascript:void(0)" onclick="changeModals(this)">Create
                        an account.</a></p>
            </div>
        </div>
    </div>
</div>