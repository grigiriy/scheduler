<?php

$user_id = get_current_user_id();

?>


<div class="row mx-0 mb-3 p-3" id="tutor">
    <div class="col-12">
        <p class="h2">Your tutor</p>
    </div>
    <div class="col-4 mt-3">
        <img class="ava mw-100" src="<?= carbon_get_user_meta($user_id,'avatar'); ?>" alt="">
    </div>
    <div class="col-8 mt-3">
        <p class="h5 mb-3">
            <?= get_userdata($user_id)->first_name . ' ' . get_userdata($user_id)->last_name; ?>
        </p>
        <p class="smaller my-1">Phone: <span><?= carbon_get_user_meta( $user_id, 'phone' ) ?></span></p>
        <p class="smaller my-1">Skype: <span><?= carbon_get_user_meta( $user_id, 'skype' ) ?></span></p>
        <a class="smaller my-1" href="/">Подробнее<span class="arrow_symbol ml-3">⟶</span></a>
    </div>
</div>