<?php
    if (get_the_title($post_id) === 'Already passed') {
          $before = 'You have no completed videos yet.';
          $after = '<p class="h5">Maybe you have not done enough reviews?</p>
          <ul>
          <li>According to the curve of forgetting all new information should be repeated for
          several times in 4 days after 1 familiarization. You can read more about our
          method <a href="/help/">here</a>.</li>
          <li>To finish the lesson and memorize the content better review the lesson for 4
          times each.</li>
          </ul>
          <p class="h5 mt-4">Did you start your studies?</p>
          <p>Pick the most engaging video for you from the <a href="/catalog/">Catolog</a> or your <a href="/account/wishlist/">Wishlist</a> and
          press “Choose this lesson” button to start learning English with native speakers
          now!</p>';
        } else if (get_the_title($post_id) === 'Favorite') {
            $before = 'Wishlist is your collection of videos that you would like to learn next.';
            $after = 'Press ❤️ on the videos in the <a href="/catalog/">Catalog</a> to add fun and useful materials in your collection.<br><br>Choose the most interesting video and dive into learning English with native speakers!';
        } else if(get_the_title($post_id) === 'Current lessons') {
            $before = 'You have no videos to learn for now.';
            $after = 'Pick the most engaging video from the <a href="/catalog/">Catolog</a> or your <a href="/account/wishlist/">Wishlist</a> and press “Choose this
            lesson” button to start learning English with native speakers now!';
        } else {
            $before = 'No courses yet...';
            $after = 'Please, try again later';
      }
?>
<div class="mx-auto text-center mb-5 d-inline-block w-100">
    <p class="h3 my-2"><?= $before; ?></p>
    <img class="w-50 mx-auto" src="/wp-content/themes/scheduler_mvp/img/all_done.png" alt="">
    <p class="h5 my-2"><?= $after; ?></p>
</div>