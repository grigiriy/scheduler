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
                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    xmlns:xlink="http://www.w3.org/1999/xlink" class="mr-1 mb-1" width="1em" height="1em" x="0px"
                    y="0px" viewBox="0 0 280.001 280.001" style="enable-background:new 0 0 280.001 280.001;"
                    xml:space="preserve">
                    <!-- Icons made by Freepik (https://www.flaticon.com/authors/freepik) from Flaticon (https://www.flaticon.com/)  -->
                    <g id="XMLID_348_">
                        <path id="XMLID_350_" d="M140.001,60.083c-8.284,0-15,6.716-15,15v49.981H75.02c-8.284,0-15,6.716-15,15c0,8.284,6.716,15,15,15
		                h64.981c8.284,0,15-6.716,15-15V75.083C155.001,66.799,148.285,60.083,140.001,60.083z" />
                        <path id="XMLID_351_" d="M140.001,0C62.804,0,0,62.804,0,140.001c0,77.196,62.804,140,140,140c77.196,0,140-62.804,140-140
                        C280.001,62.804,217.197,0,140.001,0z M140.001,250.001c-60.654,0-110-49.346-110-110C30,79.346,79.346,30,140.001,30
                        s110,49.346,110,110.001C250.001,200.655,200.655,250.001,140.001,250.001z" />
                    </g>
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