<?php
/**
 * Template Name: Payment Page
 */
get_header();

if( !is_user_logged_in() ) {
?>
<script>
document.location.href = '/';
</script>

<?php
} else {
    while ( have_posts() ) :
        the_post();

global $now_incTZ;
$user_id = get_current_user_id();
// $frequency = get_user_meta($user_id)['frequency'][0];
$paid = carbon_get_user_meta( $user_id, 'paid_till' );
$offers = carbon_get_post_meta($post->ID, 'prices');

$default_price = carbon_get_post_meta($post->ID, 'default_price');
set_query_var('default_price',$default_price);
?>

<div class="col-4">
    <img src="/wp-content/themes/scheduler_mvp/img/coffee.png" class="pl-5 w-75" alt="">
</div>
<div class="col-8">
    <p class="h3">Lessons paid by
        <span class="text-danger">
            <?= getdate($paid)['mday'] .' '. getdate($paid)['month'] .' '.getdate($paid)['year'] ?>
        </span>
    </p>
    <?= the_content(); ?>
</div>

<div class="col-12 my-5">
    <div class="row">
        <?php


    foreach ($offers as $key=>$offer){
        set_query_var('offer',$offer);
        set_query_var('key',$key);
        get_template_part('theme-helpers/template-parts/payment','offer');
    }

    ?>
    </div>
</div>

<?php
endwhile;
}
?>