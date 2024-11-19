<?php
class AYS_Gall_Helper{
	public static function ays_redirect($url){
		wp_safe_redirect(admin_url($url));
	}
}
?>

