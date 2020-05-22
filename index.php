<?php
/**
 * Template Name: Main
 */
 get_header(); 


if( is_user_logged_in() ) {?>
<script>
document.location.href = '/account/';
</script>

<?php
}
get_footer(); ?>