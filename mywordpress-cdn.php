<?php
/*
Plugin Name: Mywordpress CDN
Description: 使用七牛云存储实现CDN加速
Plugin URI: http://mywordpress.cn/
Author: 57620133@qq.com
Author URI: http://mywordpress.cn/
Version: 0.1
*/

/**
css,js在做cdn时缓存更新比较麻烦，七牛文档上说可以使用版本号解决更新问题，但在测试时并没有刷新，
TODO: 要是能指定几个不走cdn的js,css那就比较好了
*/

define('MYWORDPRESS_CDN_PLUGIN_URL', plugins_url( '', __FILE__ ) );
define('MYWORDPRESS_CDN_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . dirname( plugin_basename( __FILE__ ) ) );

define('LOCAL_HOST', untrailingslashit(home_url()));

// 可以直接指定自己的加速CDN
// define('CDN_HOST', 'http://cdn.mywordpress.cn');

// 本地开发时不用CDN
define('CDN_HOST', untrailingslashit( guess_cdn_host()));

// 默认CDN域名前缀为cdn. 比如你的域名是mysite.com, 加速CDN就是cdn.mysite.com
// define('CDN_HOST', untrailingslashit( guess_cdn_host( 'cdn' )));

add_action('wp_loaded', 'mywordpress_cdn_ob_cache');

function guess_cdn_host( $subdomain = '' ) {
	$url = home_url();
	if ( empty( $subdomain ) ) {
		return $url;
	}
	$domain = parse_url( $url, PHP_URL_HOST );
	$domain_cdn = $subdomain . '.'. str_ireplace( 'www.', '', $domain );
	$url_cdn = str_ireplace( $domain, $domain_cdn, $url );
	return apply_filters( 'guess_cdn_host', $url_cdn );
}

function mywordpress_cdn_ob_cache() {
	ob_start('mywordpress_cdn_cdn_replace');
}

function mywordpress_cdn_cdn_replace( $html ) {
	if ( is_admin() ) {
		return $html;
	}

	if ( LOCAL_HOST === CDN_HOST ) {
		return $html;
	}

	//$cdn_exts	= get_option( 'exts', 'js|css|png|jpg|jpeg|gif|ico');
	$cdn_exts	= get_option( 'exts', 'png|jpg|jpeg|gif|ico');
	$cdn_dirs	= str_replace( '-', '\-', get_option( 'dirs', 'wp-content|wp-includes') );

	if ( $cdn_dirs ){
		$regex	=  '/'.str_replace('/','\/',LOCAL_HOST).'\/(('.$cdn_dirs.')\/[^\s\?\\\'\"\;\>\<]{1,}.('.$cdn_exts.'))([\"\\\'\s\?]{1})/';
		$html =  preg_replace($regex, CDN_HOST.'/$1$4', $html);
	} else {
		$regex	= '/'.str_replace('/','\/',LOCAL_HOST).'\/([^\s\?\\\'\"\;\>\<]{1,}.('.$cdn_exts.'))([\"\\\'\s\?]{1})/';
		$html =  preg_replace($regex, CDN_HOST.'/$1$3', $html);
	}

	return $html;
}
