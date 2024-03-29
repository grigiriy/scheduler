<p class="h3">Notification settings</p>
<p class="h6 pb-3">What type of reminders do you want to use?</p>
<p class="text-muted">Enable reminders to be in time with your schedule.</p>
<div id="configs">
    <p>Get on e-mail: <span><?= carbon_get_user_meta( $user_id, 'notify_email' ) ?></span>
        <span class="ml-3 text-primary edit" data-type="notify_email">
            <svg viewBox="0 0 492.49284 492" width="0.8em" xmlns="http://www.w3.org/2000/svg">
                <path fill="#007bff"
                    d="m304.140625 82.472656-270.976563 270.996094c-1.363281 1.367188-2.347656 3.09375-2.816406 4.949219l-30.035156 120.554687c-.898438 3.628906.167969 7.488282 2.816406 10.136719 2.003906 2.003906 4.734375 3.113281 7.527344 3.113281.855469 0 1.730469-.105468 2.582031-.320312l120.554688-30.039063c1.878906-.46875 3.585937-1.449219 4.949219-2.8125l271-270.976562zm0 0" />
                <path fill="#007bff"
                    d="m476.875 45.523438-30.164062-30.164063c-20.160157-20.160156-55.296876-20.140625-75.433594 0l-36.949219 36.949219 105.597656 105.597656 36.949219-36.949219c10.070312-10.066406 15.617188-23.464843 15.617188-37.714843s-5.546876-27.648438-15.617188-37.71875zm0 0" />
                <!-- Icons made by Pixel perfect (https://www.flaticon.com/authors/pixel-perfect) for Flaticon (https://www.flaticon.com/) -->
            </svg>
            &#160;Edit</span>
        <div class="invalid-feedback">
            Please write valid email
        </div>
    </p>
    <p
    class="d-none d-sm-flex pseudocheckbox"
    onclick="os_toggle()"
    data-placement="top"
    title="Make sure you enable notifications" tabindex="0" data-trigger="focus" data-html="true" data-html="true" data-content="<img style='max-width:250px' src='/wp-content/themes/scheduler_mvp/img/notify.jpg'/><p>At the address bar you can find the lock icon. Click it :)</p>">
        <span class="d-block mr-2"></span> Get notifications in browser.
    </p>
</div>