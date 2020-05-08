<?php
$yt_code = get_post_custom($_post->ID)['yt_code'][0];
preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $yt_code, $matches);
$yt_code = $matches[0];

$in_fav = in_array($_post->ID,$selected_posts);

$args = $_post->ID.','.$user_id;

$course_level = get_the_terms($_post->ID,'course_level');
$course_duration = get_the_terms($_post->ID,'course_duration');

?>
<div class="card mb-3 shadow-lg p-0">
    <div class="card-head">
        <img class="" style="width:100%" src="https://i.ytimg.com/vi/<?=$yt_code; ?>/maxresdefault.jpg">
    </div>
    <div class="card-body">
        <p class="text-muted d-flex">
            <span>
                <svg class="bi bi-flag-fill mr-1 mb-1" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M3.5 1a.5.5 0 01.5.5v13a.5.5 0 01-1 0v-13a.5.5 0 01.5-.5z"
                        clip-rule="evenodd" />
                    <path fill-rule="evenodd"
                        d="M3.762 2.558C4.735 1.909 5.348 1.5 6.5 1.5c.653 0 1.139.325 1.495.562l.032.022c.391.26.646.416.973.416.168 0 .356-.042.587-.126a8.89 8.89 0 00.593-.25c.058-.027.117-.053.18-.08.57-.255 1.278-.544 2.14-.544a.5.5 0 01.5.5v6a.5.5 0 01-.5.5c-.638 0-1.18.21-1.734.457l-.159.07c-.22.1-.453.205-.678.287A2.719 2.719 0 019 9.5c-.653 0-1.139-.325-1.495-.562l-.032-.022c-.391-.26-.646-.416-.973-.416-.833 0-1.218.246-2.223.916A.5.5 0 013.5 9V3a.5.5 0 01.223-.416l.04-.026z"
                        clip-rule="evenodd" />
                </svg>
                <?= $course_level[0]->name ?>
            </span>
            <span class="ml-4">
                <svg class="bi bi-clock-history mr-1 mb-1" width="1em" height="1em" viewBox="0 0 16 16"
                    fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M8.515 1.019A7 7 0 008 1V0a8 8 0 01.589.022l-.074.997zm2.004.45a7.003 7.003 0 00-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 00-.439-.27l.493-.87a8.025 8.025 0 01.979.654l-.615.789a6.996 6.996 0 00-.418-.302zm1.834 1.79a6.99 6.99 0 00-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 00-.214-.468l.893-.45a7.976 7.976 0 01.45 1.088l-.95.313a7.023 7.023 0 00-.179-.483zm.53 2.507a6.991 6.991 0 00-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 01-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 01-.401.432l-.707-.707z"
                        clip-rule="evenodd" />
                    <path fill-rule="evenodd" d="M8 1a7 7 0 104.95 11.95l.707.707A8.001 8.001 0 118 0v1z"
                        clip-rule="evenodd" />
                    <path fill-rule="evenodd"
                        d="M7.5 3a.5.5 0 01.5.5v5.21l3.248 1.856a.5.5 0 01-.496.868l-3.5-2A.5.5 0 017 9V3.5a.5.5 0 01.5-.5z"
                        clip-rule="evenodd" />
                </svg>
                <?= $course_duration[0]->name ?>
            </span>
        </p>
        <p class="h4"><?= get_the_title($_post->ID); ?></p>
        <p class="text-muted"><?= $_post->post_excerpt ?></p>
        <div class="d-flex mt-4 mb-3">
            <a href="<?= get_the_permalink($_post->ID); ?>" class="btn btn-primary btn-round px-4 py-3">Start
                learning <span class="arrow_symbol"> ⟶</span></a>
            <span class="favorite_btn ml-auto my-2 <?= $in_fav === true ? 'active' : '' ?>"
                onclick="to_favorite_before(<?=$args?>,this)"></span>
        </div>
    </div>
</div>