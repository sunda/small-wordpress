
  function disable_emojis() {

    remove_action('wp_head',             'print_emoji_detection_script', 7);
    remove_action('admin_print_styles',  'print_emoji_styles' );
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles',     'print_emoji_styles');
    remove_filter('the_content_feed',    'wp_staticize_emoji');
    remove_filter('comment_text_rss',    'wp_staticize_emoji');
    remove_filter('wp_mail',             'wp_staticize_emoji_for_email');
    add_filter( 'emoji_svg_url',         '__return_false' );

    add_filter('tiny_mce_plugins',  'disable_emojis_tinymce');
    add_filter('wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2);

  }


  function disable_emojis_tinymce($plugins) {
    if(is_array($plugins)) {
      return array_diff($plugins, array('wpemoji'));
    }
    return array();
  }


  function disable_emojis_remove_dns_prefetch($urls, $relation_type) {
    if('dns-prefetch' == $relation_type){
      $emoji_svg_url_bit = 'https://s.w.org/images/core/emoji/';
      foreach($urls as $key => $url) {
        if(false !== strpos($url, $emoji_svg_url_bit)) {
          unset($urls[$key]);
        }
      }
    }
    return $urls;
  }


  add_action('init', 'disable_emojis');


