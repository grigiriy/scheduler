<?php
    if (get_the_title($post_id) === 'Already passed') {
          $word = 'finished ';
      } else if (get_the_title($post_id) === 'Favorite') {
          $word = 'favorite ';
      } else {
          $word = '';
      }
?>
<div class="mx-auto text-center mb-5 d-flex flex-column">
    <p class="h3 mb-0">You do not have any <?= $word; ?>lessons yet </p>
    <img class="w-50 mx-auto" src="/wp-content/themes/scheduler_mvp/img/all_done.png" alt="">
    <p class="h4 mt-3">Choose the most interesting video here and dive into learning languages with pleasure!</p>
</div>