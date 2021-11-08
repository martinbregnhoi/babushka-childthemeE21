<?php
add_action( 'wp_enqueue_scripts', 'enqueue_important_files' );
function enqueue_important_files() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
wp_enqueue_script( 'script', get_stylesheet_directory_uri() . '/js/script.js', 1.1, true);
}
?>