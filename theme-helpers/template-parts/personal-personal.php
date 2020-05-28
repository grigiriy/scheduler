<?php $user_id = get_current_user_id(); ?>


<div class="card mx-0 mb-3 px-5 pb-5 pt-3 bg-white bottom_rounded shadow-lg" id="data">
    <div class="row">
        <div class="col-12">
            <p class="h2">Profile settings</p>
        </div>
        <div class="col-3 mt-3" id="config_ava">
            <img id="ava_img" class="ava mw-100" src="<?= carbon_get_user_meta($user_id,'avatar'); ?>" alt="">
            <div class="mt-3 text-center">
                <label class="text-primary edit smaller" for="_file" id="_label">
                    <svg viewBox="0 0 492.49284 492" width="0.8em" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#007bff"
                            d="m304.140625 82.472656-270.976563 270.996094c-1.363281 1.367188-2.347656 3.09375-2.816406 4.949219l-30.035156 120.554687c-.898438 3.628906.167969 7.488282 2.816406 10.136719 2.003906 2.003906 4.734375 3.113281 7.527344 3.113281.855469 0 1.730469-.105468 2.582031-.320312l120.554688-30.039063c1.878906-.46875 3.585937-1.449219 4.949219-2.8125l271-270.976562zm0 0">
                        </path>
                        <path fill="#007bff"
                            d="m476.875 45.523438-30.164062-30.164063c-20.160157-20.160156-55.296876-20.140625-75.433594 0l-36.949219 36.949219 105.597656 105.597656 36.949219-36.949219c10.070312-10.066406 15.617188-23.464843 15.617188-37.714843s-5.546876-27.648438-15.617188-37.71875zm0 0">
                        </path>
                        <!-- Icons made by Pixel perfect (https://www.flaticon.com/authors/pixel-perfect) for Flaticon (https://www.flaticon.com/) -->
                    </svg>
                    Edit</label>
                <span style="display:none" class="edit btn btn-link border-0" id="_save"
                    data-hash="<?= wp_create_nonce('uplfile') ?>">save</span>

                <input name="my_file_upload" type="file" id="_file" value=""">
            </div>
        </div>
        <div class="col-9 mt-3" id="configs">
            <p class="mb-3 name_field">
                <span>
                    <?= get_userdata($user_id)->first_name; ?>
                </span>
                <span class="ml-3 text-primary edit smaller" data-type="first_name">
                    <svg viewBox="0 0 492.49284 492" width="0.8em" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#007bff"
                            d="m304.140625 82.472656-270.976563 270.996094c-1.363281 1.367188-2.347656 3.09375-2.816406 4.949219l-30.035156 120.554687c-.898438 3.628906.167969 7.488282 2.816406 10.136719 2.003906 2.003906 4.734375 3.113281 7.527344 3.113281.855469 0 1.730469-.105468 2.582031-.320312l120.554688-30.039063c1.878906-.46875 3.585937-1.449219 4.949219-2.8125l271-270.976562zm0 0">
                        </path>
                        <path fill="#007bff"
                            d="m476.875 45.523438-30.164062-30.164063c-20.160157-20.160156-55.296876-20.140625-75.433594 0l-36.949219 36.949219 105.597656 105.597656 36.949219-36.949219c10.070312-10.066406 15.617188-23.464843 15.617188-37.714843s-5.546876-27.648438-15.617188-37.71875zm0 0">
                        </path>
                        <!-- Icons made by Pixel perfect (https://www.flaticon.com/authors/pixel-perfect) for Flaticon (https://www.flaticon.com/) -->
                    </svg>
                    Edit</span>
                <div class="invalid-feedback">
                    Your name can't be empty
                </div>
            </p>

            <?php if( carbon_get_theme_option( 'teacher' ) ) {?>
            <div class="row mt-3 _not_set"
                style="<?= carbon_get_user_meta( $user_id, 'phone') ? 'display:none' :'' ?>">
                <div class="col-2">
                    <div class="add_icon border-primary border text-primary py-2 text-center" data-type="phone"
                        data-new="true">+</div>
                </div>
                <div class="col-10 smaller pl-0">
                    <p class="mb-1">Add your phone number:</p>
                </div>
            </div>

            <p class="my-2 _set" style="<?= !carbon_get_user_meta( $user_id, 'phone') ? 'display:none' :'' ?>">
                Phone:
                <span><?= carbon_get_user_meta( $user_id, 'phone' ) ?></span>
                <span class="ml-3 text-primary edit" data-type="phone">
                    <svg viewBox="0 0 492.49284 492" width="0.8em" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#007bff"
                            d="m304.140625 82.472656-270.976563 270.996094c-1.363281 1.367188-2.347656 3.09375-2.816406 4.949219l-30.035156 120.554687c-.898438 3.628906.167969 7.488282 2.816406 10.136719 2.003906 2.003906 4.734375 3.113281 7.527344 3.113281.855469 0 1.730469-.105468 2.582031-.320312l120.554688-30.039063c1.878906-.46875 3.585937-1.449219 4.949219-2.8125l271-270.976562zm0 0">
                        </path>
                        <path fill="#007bff"
                            d="m476.875 45.523438-30.164062-30.164063c-20.160157-20.160156-55.296876-20.140625-75.433594 0l-36.949219 36.949219 105.597656 105.597656 36.949219-36.949219c10.070312-10.066406 15.617188-23.464843 15.617188-37.714843s-5.546876-27.648438-15.617188-37.71875zm0 0">
                        </path>
                        <!-- Icons made by Pixel perfect (https://www.flaticon.com/authors/pixel-perfect) for Flaticon (https://www.flaticon.com/) -->
                    </svg>
                    Edit</span>
                <div class="invalid-feedback">
                    Please write valid phone
                </div>
            </p>
            <?php } ?>

            <div class="row mt-3 _not_set"
                style="<?= carbon_get_user_meta( $user_id, 'notify_email') ? 'display:none' :'' ?>">
                <div class="col-2">
                    <div class="add_icon border-primary border text-primary py-2 text-center"
                        data-type="notify_email" data-new="true">+
                    </div>
                </div>
                <div class="col-10 smaller pl-0">
                    <p class="mb-1">Add your email:</p>
                    <p class="text-muted mb-1">Email for notofications</p>
                </div>
            </div>
            <p class="my-2 _set"
                style="<?= !carbon_get_user_meta( $user_id, 'notify_email') ? 'display:none' :'' ?>">
                E-mail:
                <span><?= carbon_get_user_meta( $user_id, 'notify_email' ) ?></span>
                <span class="ml-3 text-primary edit" data-type="notify_email">
                    <svg viewBox="0 0 492.49284 492" width="0.8em" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#007bff"
                            d="m304.140625 82.472656-270.976563 270.996094c-1.363281 1.367188-2.347656 3.09375-2.816406 4.949219l-30.035156 120.554687c-.898438 3.628906.167969 7.488282 2.816406 10.136719 2.003906 2.003906 4.734375 3.113281 7.527344 3.113281.855469 0 1.730469-.105468 2.582031-.320312l120.554688-30.039063c1.878906-.46875 3.585937-1.449219 4.949219-2.8125l271-270.976562zm0 0">
                        </path>
                        <path fill="#007bff"
                            d="m476.875 45.523438-30.164062-30.164063c-20.160157-20.160156-55.296876-20.140625-75.433594 0l-36.949219 36.949219 105.597656 105.597656 36.949219-36.949219c10.070312-10.066406 15.617188-23.464843 15.617188-37.714843s-5.546876-27.648438-15.617188-37.71875zm0 0">
                        </path>
                        <!-- Icons made by Pixel perfect (https://www.flaticon.com/authors/pixel-perfect) for Flaticon (https://www.flaticon.com/) -->
                    </svg>
                    Edit</span>
                <div class="invalid-feedback">
                    Please write valid email
                </div>
            </p>

            <?php if( carbon_get_theme_option( 'teacher' ) ) {?>
            <div class="row mt-3 _not_set"
                style="<?= carbon_get_user_meta( $user_id, 'skype') ? 'display:none' :'' ?>">
                <div class="col-2">
                    <div class="add_icon border-primary border text-primary py-2 text-center" data-type="skype"
                        data-new="true">+</div>
                </div>
                <div class="col-10 smaller pl-0">
                    <p class="mb-1">Add your Skype account:</p>
                    <p class="text-muted mb-1">What is your skype for online lessons?</p>
                </div>
            </div>
            <p class="my-2 _set" style="<?= !carbon_get_user_meta( $user_id, 'skype') ? 'display:none' :'' ?>">
                Skype:
                <span><?= carbon_get_user_meta( $user_id, 'skype' ) ?></span>
                <span class="ml-3 text-primary edit" data-type="skype">
                    <svg viewBox="0 0 492.49284 492" width="0.8em" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#007bff"
                            d="m304.140625 82.472656-270.976563 270.996094c-1.363281 1.367188-2.347656 3.09375-2.816406 4.949219l-30.035156 120.554687c-.898438 3.628906.167969 7.488282 2.816406 10.136719 2.003906 2.003906 4.734375 3.113281 7.527344 3.113281.855469 0 1.730469-.105468 2.582031-.320312l120.554688-30.039063c1.878906-.46875 3.585937-1.449219 4.949219-2.8125l271-270.976562zm0 0">
                        </path>
                        <path fill="#007bff"
                            d="m476.875 45.523438-30.164062-30.164063c-20.160157-20.160156-55.296876-20.140625-75.433594 0l-36.949219 36.949219 105.597656 105.597656 36.949219-36.949219c10.070312-10.066406 15.617188-23.464843 15.617188-37.714843s-5.546876-27.648438-15.617188-37.71875zm0 0">
                        </path>
                        <!-- Icons made by Pixel perfect (https://www.flaticon.com/authors/pixel-perfect) for Flaticon (https://www.flaticon.com/) -->
                    </svg>
                    Edit</span>
                <div class="invalid-feedback">
                    Your skype username can't be empty
                </div>
            </p>
            <?php } ?>


            <div class="row mt-3">
                <div class="col-2">
                    <a href="/training-settings/">
                        <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" class="text-primary">
                            <!-- Icons made by Freepik( https://www.flaticon.com/authors/freepik) from Flaticon (https://www.flaticon.com/) -->
                            <path fill="currentColor"
                                d="m499.953125 197.703125-39.351563-8.554687c-3.421874-10.476563-7.660156-20.695313-12.664062-30.539063l21.785156-33.886719c3.890625-6.054687 3.035156-14.003906-2.050781-19.089844l-61.304687-61.304687c-5.085938-5.085937-13.035157-5.941406-19.089844-2.050781l-33.886719 21.785156c-9.84375-5.003906-20.0625-9.242188-30.539063-12.664062l-8.554687-39.351563c-1.527344-7.03125-7.753906-12.046875-14.949219-12.046875h-86.695312c-7.195313 0-13.421875 5.015625-14.949219 12.046875l-8.554687 39.351563c-10.476563 3.421874-20.695313 7.660156-30.539063 12.664062l-33.886719-21.785156c-6.054687-3.890625-14.003906-3.035156-19.089844 2.050781l-61.304687 61.304687c-5.085937 5.085938-5.941406 13.035157-2.050781 19.089844l21.785156 33.886719c-5.003906 9.84375-9.242188 20.0625-12.664062 30.539063l-39.351563 8.554687c-7.03125 1.53125-12.046875 7.753906-12.046875 14.949219v86.695312c0 7.195313 5.015625 13.417969 12.046875 14.949219l39.351563 8.554687c3.421874 10.476563 7.660156 20.695313 12.664062 30.539063l-21.785156 33.886719c-3.890625 6.054687-3.035156 14.003906 2.050781 19.089844l61.304687 61.304687c5.085938 5.085937 13.035157 5.941406 19.089844 2.050781l33.886719-21.785156c9.84375 5.003906 20.0625 9.242188 30.539063 12.664062l8.554687 39.351563c1.527344 7.03125 7.753906 12.046875 14.949219 12.046875h86.695312c7.195313 0 13.421875-5.015625 14.949219-12.046875l8.554687-39.351563c10.476563-3.421874 20.695313-7.660156 30.539063-12.664062l33.886719 21.785156c6.054687 3.890625 14.003906 3.039063 19.089844-2.050781l61.304687-61.304687c5.085937-5.085938 5.941406-13.035157 2.050781-19.089844l-21.785156-33.886719c5.003906-9.84375 9.242188-20.0625 12.664062-30.539063l39.351563-8.554687c7.03125-1.53125 12.046875-7.753906 12.046875-14.949219v-86.695312c0-7.195313-5.015625-13.417969-12.046875-14.949219zm-152.160156 58.296875c0 50.613281-41.179688 91.792969-91.792969 91.792969s-91.792969-41.179688-91.792969-91.792969 41.179688-91.792969 91.792969-91.792969 91.792969 41.179688 91.792969 91.792969zm0 0" />
                        </svg>
                    </a>
                </div>
                <div class="col-10 smaller pl-0 d-flex">
                    <a class="mb-1 align-self-center" href="/training-settings/">Trainig and notification
                        settings</a>
                </div>
            </div>

        </div>
    </div>
</div>