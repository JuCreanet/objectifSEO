<?php
/*
Plugin Name: Otpimisation WordPress
Author: Julia Galindo
Author URI: https://objectifseo.fr
Description: fonctions pour améliorer la sécurité et les performances de WordPress
Version: 1.0
*/

// retire les informations sensibles du head
function ju_clean_head(){
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'wp_shortlink_wp_head');
	remove_action('wp_head', 'rest_output_link_wp_head');
	remove_action('wp_head', 'wp_oembed_add_discovery_links');
	remove_action('template_redirect', 'rest_output_link_header', 11, 0 );
	remove_action('wp_head', 'feed_links', 2);
	remove_action('wp_head', 'feed_links_extra', 3);
}
add_action('after_setup_theme', 'ju_clean_head');

//Masquer la version de WordPress des scripts et style
function ju_remove_wp_version_strings( $src ) {
global $wp_version;
parse_str(parse_url($src, PHP_URL_QUERY), $query);
if ( !empty($query['ver']) && $query['ver'] === $wp_version ) {
$src = remove_query_arg('ver', $src);
}
return $src;
}
add_filter( 'script_loader_src', 'ju_remove_wp_version_strings' );
add_filter( 'style_loader_src', 'ju_remove_wp_version_strings' );

//retire la classe qui fait apparaître le login dans les commentaires
function ju_no_com_author_class($classes){
	foreach($classes as $key => $class){  
		if(strstr($class,"comment-author-")){
			unset($classes[$key]);
		}
	}return $classes;
}
add_filter('comment_class','ju_no_com_author_class');

//Modifie le message d'erreur d'authentification pour qu'il soit moins explicite
function ju_no_login_errors($error){
	return "Erreur d’authentification!";
}
add_filter('login_errors', 'ju_no_login_errors');

//désactive les émojis
function ju_disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    add_filter( 'tiny_mce_plugins', 'ju_disable_emojis_tinymce' );
    add_filter( 'wp_resource_hints', 'ju_disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'ju_disable_emojis' );

function ju_disable_emojis_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
        return array_diff( $plugins, array( 'wpemoji' ) );
    } else {
        return array();
    }
}

function ju_disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
	if ( 'dns-prefetch' != $relation_type ) {
		return $urls;
	}
	$emoji_svg_url_bit = 'https://s.w.org/images/core/emoji/';
	foreach ( $urls as $key => $url ) {
		if ( strpos( $url, $emoji_svg_url_bit ) !== false ) {
			unset( $urls[ $key ] );
		}
	}
	return $urls;
}

//désactive les liens du flux RSS
function ju_disable_feed(){
	add_filter( 'feed_links_show_posts_feed', '__return_false' );
	add_filter( 'feed_links_show_comments_feed', '__return_false' );
}
add_action( 'init', 'ju_disable_feed' );

//supprime lien d'auteur des commentaires
function ju_remove_comment_author_link( $return, $author, $comment_ID ) {
            return $author;
}
add_filter( 'get_comment_author_link', 'ju_remove_comment_author_link', 10, 3 );

function ju_remove_comment_author_url() {
    return false;
}
add_filter( 'get_comment_author_url', 'ju_remove_comment_author_url');

//supprime complètement le champs de saisie de l'url lors du dépot de commentaire (si pas modifié par le thème)
function ju_remove_website_field($fields) {
   unset($fields['url']);
   return $fields;
}
add_filter('comment_form_default_fields', 'ju_remove_website_field');
