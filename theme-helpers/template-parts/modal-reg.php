<div class="modal fade" id="regModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog me-modal">
        <div class="modal-content bottom_rounded top_rounded">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0">
                <div class="h4 text-center text-warning pb-3">Create an account</div>
                <div class="px-5">
                    <!-- <form class="px-5 form-group" name="loginform" action="/wp-login.php?action=register" method="post"> -->
                    <!-- <p>
                        <input class="form-control" type="text" name="user_login" placeholder="Login" value="" />
                    </p>
                    <p>
                        <input class="form-control" type="email" name="user_email" placeholder="Email" value="" />
                    </p> -->
                    <?php
                    // if( carbon_get_theme_option( 'teacher' ) ) {
                        ?>
                    <!-- <p>
                        <input class="form-control" type="text" name="phone" placeholder="Phone" value="" />
                    </p> -->
                    <?php
                    // }
                    
                    
                        echo do_shortcode('[ultimatemember form_id="311"]');

                    ?>
                    <!-- <p>
                        <input class="form-control" type="email" name="user_password" placeholder="Email" value="" />
                    </p>
                    <p>
                        <input class="form-control" type="email" name="user_email" placeholder="Email" value="" />
                    </p> -->
                    <!-- <input type="hidden" name="redirect_to" value="/reg-intro/" />
                    <p class="text-center my-4">
                        <input type="submit" name="wp-submit" class="btn btn-primary btn-round px-4 py-2"
                            value="Sign in" tabindex="100" />
                    </p>
                </form> -->
                    <p class="text-center">Already have an account?<span class="arrow_symbol mx-3">⟶</span>
                        <a href="javascript:void(0)" onclick="changeModals(this)">Log in.</a></p>
                </div>
            </div>
        </div>
    </div>
</div>