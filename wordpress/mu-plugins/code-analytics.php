<?php
/*
Plugin Name: Google Analytics
Author: Julia Galindo
Author URI: https://objectifseo.fr
Description: ajout du code Google analytics
Version: 1.0
*/
//Change all occurence of YOUR-GA-CODE with the adequat code
function ju_google_analytics() { ?>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=YOUR-GA-CODE"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'YOUR-GA-CODE');
	</script>
<?php
}
add_action( 'wp_head', 'ju_google_analytics' );