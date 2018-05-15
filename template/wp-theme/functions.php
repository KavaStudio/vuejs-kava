<?php
add_theme_support( 'post-thumbnails' );

function rest_theme_scripts() {
	$base_url  = esc_url_raw( home_url() );
  $base_path = rtrim( parse_url( $base_url, PHP_URL_PATH ), '/' );

  wp_deregister_script('jquery');
  wp_deregister_script( 'wp-embed' );

}
add_action( 'wp_enqueue_scripts', 'rest_theme_scripts' );

// Disable use XML-RPC
add_filter( 'xmlrpc_enabled', '__return_false' );

// Disable X-Pingback to header
add_filter( 'wp_headers', 'disable_x_pingback' );
function disable_x_pingback( $headers ) {
    unset( $headers['X-Pingback'] );

return $headers;
}

remove_action( 'wp_head', 'wlwmanifest_link');
remove_action ('wp_head', 'rsd_link');

function disable_emojicons_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
    return array();
  }
}

function disable_wp_emojicons() {

  // all actions related to emojis
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

  // filter to remove TinyMCE emojis
  add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
}
add_action( 'init', 'disable_wp_emojicons' );
/* 
function create_post_type() {  
  register_post_type( 'zdjecia',
    array(
      'labels' => array(
        'name' => __( 'Zdjęcie' ),
        'singular_name' => __( 'Zdjęcie' )
      ),
      'public' => true,
      'has_archive' => false,
      'supports' => array( 'title', 'thumbnail' ),
      'show_in_rest' => true,
  		'rest_base' => 'gallery',
    )
  );

  register_taxonomy(
		'gallery-type',
		'zdjecia',
		array(
      'label' => __( 'Galeria' ),
      'hierarchical' => true,
      'show_in_rest' => true
		)
  );
}

add_action( 'init', 'create_post_type' );

function retrieveTerms( $data ) {
  $terms = get_terms( array(
    'taxonomy' => $data['name'],
    'hide_empty' => true,
    'order' => 'asc'
  ) );
 
  if ( empty( $terms ) ) {
    return null;
  }
 
  return $terms;
}

add_action( 'rest_api_init', function () {
  register_rest_route( 'tax/v1', '/terms/(?P<name>[a-zA-Z0-9-]+)', array(
    'methods' => 'GET',
    'callback' => 'retrieveTerms'
  ) );
} );

function getPostsWithThumb($posts_per_page=-1, $post_type='', $taxonomy, $term) {
 
  $args = array( 
    'posts_per_page' => $posts_per_page,
    'orderby'          => 'post_date',
    'order'            => 'DESC',
    'post_type'        => $post_type,
    'post_status'      => 'publish',               
    'meta_query' => array(
      array(
        'key'     => '_thumbnail_id',
        'value'   => '',
        'compare' => '!=',
      )
    ),
    'tax_query' => array(
      array(
      'taxonomy' => $taxonomy,
      'field' => 'term_id',
      'terms' => $term
      )
    )
  );

  $posts_with_photos =  new WP_Query( $args );  
  foreach ($posts_with_photos->posts as $p) {
    $aTemp = new stdClass();
    $thumb_id = (int)get_post_thumbnail_id($p->ID);
    $aTemp->post_id = $p->ID;
    // $aTemp->author = $p->post_author;
    // $aTemp->post_date = $p->post_date;
    $aTemp->title = $p->post_title;
    // $aTemp->comment_count = $p->comment_count;
    $aTemp->thumbnail = wp_get_attachment_image_src( $thumb_id, 'thumbnail');
    $aTemp->full = wp_get_attachment_image_src( $thumb_id, 'full');
    // $aTemp->content = $p->post_content;
    $oReturn->posts[] = $aTemp;
  }
  return $oReturn;
}

function retrieveTermsWithPosts( $data ) {
  $terms = get_terms( array(
    'taxonomy' => $data['name'],
    'hide_empty' => true,
    'order' => 'asc'
  ) );

  $itemsWithPosts = array();

  foreach($terms as $term) {
    $posts = getPostsWithThumb(-1, $data['post_type'], $data['name'], $term->term_id);

    if($term->name != null) {
      $termsWPosts = new \stdClass();
      $termsWPosts->title = $term->name;
      $termsWPosts->items = $posts;

      array_push($itemsWithPosts, $termsWPosts);
    }
  }
 
  if ( empty( $itemsWithPosts ) ) {
    return null;
  }
 
  return $itemsWithPosts;
}

add_action( 'rest_api_init', function () {
  register_rest_route( 'tax/v1', '/terms/(?P<post_type>[a-zA-Z0-9-]+)/(?P<name>[a-zA-Z0-9-]+)', array(
    'methods' => 'GET',
    'callback' => 'retrieveTermsWithPosts'
  ) );
} );

function rest_theme_routes() {
	$routes = array();
	$query = new WP_Query( array(
		'post_type'      => 'any',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
	) );
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$routes[] = array(
				'id'   => get_the_ID(),
				'type' => get_post_type(),
				'slug' => basename( get_permalink() ),
			);
		}
	}
	wp_reset_postdata();
	return $routes;
}

*/
?>