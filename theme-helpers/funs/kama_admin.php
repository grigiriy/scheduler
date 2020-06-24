<?php
function restrict_admin()
{
	if ( ! current_user_can( 'manage_options' ) && '/wp-admin/admin-ajax.php' != $_SERVER['PHP_SELF'] ) {
      wp_redirect( site_url() );
	}
}
add_action( 'admin_init', 'restrict_admin', 1 );
// Оставляет пользователя на той же странице при вводе неверного логина/пароля в форме авторизации wp_login_form() //wp-kama
add_action( 'wp_login_failed', 'my_front_end_login_fail' );
function my_front_end_login_fail( $username ) {
	$referrer = $_SERVER['HTTP_REFERER'];  // откуда пришел запрос

	// Если есть referrer и это не страница wp-login.php
	if( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
		wp_redirect( $referrer.'#login' );
		exit;
	}
}
?>