<?php
// removing header - white space - blog name etc.
function clear_header() {
	remove_all_actions('thematic_header');
}
add_action('init', 'clear_header');

//the as we speak header instead
function aswespeak() {
   if (is_home() & !is_paged()) {
      echo ('<div class="aswespeak"><h2>[As we speak: '. get_bloginfo('description') .' ]<br /><br /></h2></div>');
   }
}

// welcome text that shows only on homepage 
function childtheme_welcome_blurb() {
if (is_home() & !is_paged()) {
   echo '
      <div class="welcome-blurb">
      Red Pyramids is<br />
      <span id="myname">Tal Stadler</span>&rsquo;s space for<br />
      design and words /<br />
      words and design<br />
      ________________<br />
      <br />
      Search different angle<br />
      <a href="">date</a>/<a href="">type of work</a><br />
      <br />
      <img src="/wp-content/themes/thematicthemechild/images/left menu.png" /><br />
      <a href="">@reach me</a>
      </div>
      ';
    } 
}
add_action('thematic_before','childtheme_welcome_blurb');


//making the WP loop show tumbnails instead of posts in homepage 
//Supporting thumbnails in WP:
if ( function_exists( 'add_theme_support' ) ) { 
  add_theme_support( 'post-thumbnails' ); 
}
set_post_thumbnail_size( 300, 250, true);

//removing the old loop - we dont want 2 loops
function remove_index_loop() {
	remove_action('thematic_indexloop', 'thematic_index_loop');
}
add_action('init', 'remove_index_loop');


//my new loop
//the post format
function childtheme_post() {
                           echo '<a href="'. get_permalink() .'">';
			   the_post_thumbnail();
                           echo '</a><div class="post-date">';
                           the_time('j/n/Y');
                           echo '</div>';
                           the_title('<div class="post-title"><a href="'. get_permalink() .'">','</a></div>');
                           echo '</div>';
}
//the loop
function childtheme_index_loop(){
      aswespeak(); //the as we speak part
        $isfirst = 1; //first post will be bigger - so we need to know if we are on the first.
	while ( have_posts() ) : the_post() ?>
			<?php if ($isfirst){
                           set_post_thumbnail_size( 350, 350, true  );
                           echo '<div class="first-post">';
                           childtheme_post();
                           set_post_thumbnail_size( 250, 250, true  );
                           $isfirst = 0;
			   } else {
			      echo '<div class="older-post">';
                              childtheme_post();
			   }		
			   endwhile;
}
add_action('thematic_indexloop', 'childtheme_index_loop');
?>