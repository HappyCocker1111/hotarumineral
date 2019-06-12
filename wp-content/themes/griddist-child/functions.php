<?php
//子テーマとしての利用宣言
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );//親テーマのCSS
    wp_enqueue_style( 'custom-style', get_stylesheet_directory_uri() . '/custom-style.css', array('parent-style')); // 子テーマのcss
}

//カスタム投稿の表示件数設定
function change_posts_per_page($query) {
    if ( is_admin() || ! $query->is_main_query() ) {
      return;
    }
    if ( $query->is_tax( 'goods' ) ) {//ここでタクソノミー名を設定
      $query->set( 'posts_per_page', '6' );//ここで表示件数を設定
    }elseif($query->is_tax( 'blog' )){
        $query->set( 'posts_per_page', '6' );
    }
  }
  add_action( 'pre_get_posts', 'change_posts_per_page' );

//ウィジェットでショートコードを使う
add_filter('widget_text','do_shortcode');