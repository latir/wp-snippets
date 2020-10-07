/**
 * Plugin Name: WPShout Show Authorship this Month
 * Description: Show who's written what this month on WPShout
 * Version: 1.0
 * Author: WPShout
 * Author URI: https://wpshout.com
*/

add_shortcode( 'fbg_featured_grid', 'fbg_featured_grid' );
function fbg_featured_grid() {
		if( ! current_user_can( 'administrator' ) ) :
			return;
		endif;

		$args = array(
			'posts_per_page' => 5,
			'post_type' => 'any',
			'post_status' => 'publish',
			'cat' => 29,
			'orderby' => 'date',
			'order' => 'DESC',
		);

		$query = new WP_Query( $args );

		ob_start(); ?>
		<div class="fbg-featured-grid-container">
		  <style>
			.fbg-featured-grid-container {
			  display: flex;
			  height: 500px;
			}
			.fbg-fgc-first-container,
			.fbg-fgc-second-container {
			  flex: 1;
			}
			.fbg-fgc-item {
			  position: relative;
			  display: block;
			  height: 100%;
			}
			.fbg-fgc-second-container {
			  padding-left: 18px;
			  display: flex;
			  flex-direction: row;
			  flex-wrap: wrap;
			}
			.fbg-fgc-second-container .fbg-fgc-item {
			  width: calc(50% - 8px);
			  height: calc(50% - 8px);
			}
			.fbg-fgc-second-container .fbg-fgc-item:nth-of-type(-n+2) {
			  margin-bottom: 8px;
			}
			.fbg-fgc-second-container .fbg-fgc-item:nth-child(odd) {
			  margin-right: 8px;
			}
			.fbg-fgc-image {
			  height: 100%;
			  width: 100%;
			}
			.fbg-fgc-image img {
			  height: 100%;
			  width: 100%;
			  object-fit: cover;
			}
			.fbg-fgc-overlay {
			  bottom: 0;
			  position: absolute;
			  
			  color: white;
			  
			  background-color: rgb(0 0 0 / 0.40);
			  
			  width: 100%;
			  min-height: 104px;
			  
			  padding: 10px;
			  transition: min-height .5s, background-color .5s;
			}
			.fbg-fgc-item:hover .fbg-fgc-overlay {
			  min-height: 150px;
			  background-color: rgb(0 0 0 / 0.70);
			}
			.fbg-fgc-post-title {
			  font-weight: bold;
			}
			.fbg-fgc-categories {
			  position: absolute;
			  width: 100%;
			  display: flex;
			  flex-wrap;
			  padding: 10px 6px;
			}
			.fbg-fgc-categories .fgc-cat-item{
			  margin-left: 4px;
			  background-color: #cacaca;
			  padding: 4px 8px;
			  text-transform: uppercase;
			  color: black;
			  margin-bottom: 4px;
			  transition: background-color .5s, padding .5s;
			}
			.fbg-fgc-categories .fgc-cat-item:hover {
			  background-color: #f1c137;
			  padding: 4px 14px;
			}
		  </style>
		  <div class="fbg-fgc-first-container">
		<?php	
		while( $query->have_posts() ) :
			$query->the_post(); 
  		  	$idx = $query->current_post;
  			if($idx === 1):
		  ?>
		  </div>
		  <div class="fbg-fgc-second-container">
			<?php endif ?>
			<a class="fbg-fgc-item" href="<?php the_permalink(); ?>">
			  <div class="fbg-fgc-categories">
			  <?php
				foreach((get_the_category()) as $category) {
					echo '<div class="fgc-cat-item">' . $category->cat_name . '</div>';
				}
			  ?>
			  </div>
			  <div class="fbg-fgc-image">
				<img src="<?php echo the_post_thumbnail_url('full') ?>" />
			  </div>
			  <div class="fbg-fgc-overlay">
				<div class="fbg-fgc-post-title"><?php the_title(); ?></div>
				by <?php the_author(); ?>.
			  </div>
			</a>

		<?php endwhile ?>
		  </div>
		</div>
<?php
		wp_reset_postdata();

		return ob_get_clean();
}