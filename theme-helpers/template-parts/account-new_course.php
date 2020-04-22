<?php
$role = wp_get_current_user()->roles[0];
if(
    // $role === 'administrator' ||
    $role === 'author' ||
    $role === 'editor' 
){ ?>
<div class="card-header">
    <p class="bg-light h3">
        <a href="/add_post/">Add new Lesson</a>
    </p>
</div>
<?php } ?>