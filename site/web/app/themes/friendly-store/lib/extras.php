<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;

/**
 * Add <body> classes
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  // Add class if sidebar is active
  if (Setup\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');


// Custom Options Page
if( function_exists('acf_add_options_page') ) {
 
	$option_page = acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title' 	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability' 	=> 'edit_posts',
		'redirect' 	=> false
	));
 
}

// Begin Header Extras

// Main Banner
function main_banner() { ?>

	<?php if( is_front_page() ) { ?>
		<div class="container-fluid text-center jumbotron" style="background-image: url(<?php the_field('background_image'); ?>);">
			
			<div class="container">	
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<div class="row above-banner-title">
							<div class="col-xs-6 col-sm-6 text-left">
								- Est <?php the_field('established_year', 'option'); ?>
							</div>
							<div class="col-xs-6 col-sm-6 text-right">
								<?php echo get_bloginfo ('description'); ?> -
							</div>
						</div>
						<h2><?php bloginfo('name'); ?></h2>

				      <?php
				      if (has_nav_menu('primary_navigation')) :
				        wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'services hidden-xs']);
				      endif;
				      ?>
						
					</div>
				</div>
			
			</div>	
			
		</div>
	<?php }

}
add_action('above_header', __NAMESPACE__ . '\\main_banner');

// Content Builder ACF
function content_acf() { ?>

<?php

	// check if the flexible content field has rows of data
	if( have_rows('sections') ):
	
		// loop through the rows of data
		while ( have_rows('sections') ) : the_row();
		
			if( get_row_layout() == 'content_block' ):
				
				$background = '';
				$backgroundClass = '';
				
				$backgroundColor = get_sub_field('cb_background_color');
				$backgroundImage = get_sub_field('cb_background_image');
					
				if( $backgroundColor == '' ) {
					$backgroundClass = '';
				}	
				elseif( $backgroundColor && $backgroundImage ) {
					$background = 'background-image: url('. $backgroundImage .')';
					$backgroundClass = 'background background-image';
				}
				elseif( $backgroundColor ) {
					$background = 'background-color: '. $backgroundColor;
					$backgroundClass = 'background background-color';					
				}
				else {
					
				}
										
				echo '<div class="container-fluid '. $backgroundClass .'" style="'. $background .'">';
					echo '<div class="container">';
						echo '<div class="row content-block">';
							echo '<div class="col-sm-12 text-center">';
								echo '<h2>'. get_sub_field('cb_title') .'</h2>';
								the_sub_field('cb_content');
							echo '</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			
			elseif( get_row_layout() == 'columns' ): 
				
				$colWrapperClass = get_sub_field('column_wrapper_class');


				$rows = get_sub_field('column');
				
				if( $rows ) {
					$count = count($rows);
					$colClass = '';
					
					if( $count == 4 ) {
						$colClass = 'col-sm-3';
					}
					elseif( $count == 3 ) {
						$colClass = 'col-sm-4';
					}
					elseif( $count == 2 ) {
						$colClass = 'col-sm-6';
					}
					else {
						$colClass = 'col-sm-12';
					}
					
					echo '<div class="container">';
						echo '<div class="row text-center">';
						
						foreach( $rows as $row ) {
						
							echo '<div class="'. $colClass .' columns '. $colWrapperClass .'">';	
								echo '<div>';	
								
								if( $row['col_icon'] ) {
									echo '<i class="'. $row['col_icon'] .'" aria-hidden="true"></i>';
								}
								
								if( $row['col_title'] ) {
									echo '<h3>'. $row['col_title'] .'</h3>';
								}

								if( $row['col_image'] ) {
									echo '<img src="'. $row['col_image'] .'" class="img-responsive"/>';
								}
								
								if( $row['col_description'] ) {
									echo $row['col_description'];
								}
								
								if($row['col_page_link']) {
									echo '<a class="btn btn-primary" href="'. $row['col_page_link'] .'">'. $row['col_title'] .'</a>';
								}
								
								echo '</div>';
							echo '</div>';
							
						}
						
						echo '</div>';
					echo '</div>';
					
				}
			
			endif;
		
		endwhile;
	
	else :
	
		// no layouts found
	
endif;

?>

<?php }
add_action('content_builder', __NAMESPACE__ . '\\content_acf');

function footer_contact() { ?>

	<div class="row contact">
	  <div class="col-sm-4">
		  <a href="/contact">
			  <i class="fa fa-map-marker" aria-hidden="true"></i><br />
			  2758 Highway Wy-130<br />
			  Centennial, Wyoming 82055
		  </a>
	  </div>
	  <div class="col-sm-4">
		  <a href="mailto:friendlystorewyo@gmail.com">
			  <i class="fa fa-envelope-o" aria-hidden="true"></i><br />
			  friendlystorewyo@gmail.com
		  </a>
	  </div>
	  <div class="col-sm-4">
		  <a href="tel:<?php the_field( 'phone_number', 'option' ); ?>">
			  <i class="fa fa-mobile" aria-hidden="true"></i><br />
			  <?php the_field( 'phone_number', 'option' ); ?>
		  </a>
	  </div>
	</div>

<?php }
add_action('footer_top', __NAMESPACE__ . '\\footer_contact', 1);

function footer_social() { ?>

<?php

// check if the repeater field has rows of data
if( have_rows('accounts', 'option') ):
	

	echo '<ul class="social clearfix">';
 	// loop through the rows of data
    while ( have_rows('accounts', 'option') ) : the_row();

			$field = get_field_object('account_provider', 'option');
			$value = get_field('account_provider', 'option');
			$label = $field['choices'][ $value ];

			$icon = '';
			$url = get_sub_field('account_url', 'option');
			$provider = get_sub_field('account_provider', 'option');
			$linkbuilder = '';
			
			
			if( $provider == 'Facebook' ) {
				$icon = 'facebook';
			}
			elseif( $provider == 'Twitter' ) {
				$icon = 'twitter';
			}		
			elseif( $provider == 'LinkedIn' ) {
				$icon = 'linkedin';
			}		
			elseif( $provider == 'Google+' ) {
				$icon = 'google-plus';
			}		
			elseif( $provider == 'YouTube' ) {
				$icon = 'youtube-play';
			}		
			elseif( $provider == 'Instagram' ) {
				$icon = 'instagram';
			}		
			else {
				$icon = '';
			}	
			
			$linkbuilder .= '<li>';	
				$linkbuilder .= '<a href="'. $url .'" target="_blank" rel="nofollow">';	
					$linkbuilder .= '<i class="fa fa-'. $icon .'" aria-hidden="true"></i><br />';	
					//$linkbuilder .= $provider;	
				$linkbuilder .= '</a>';	
			$linkbuilder .= '</li>';	
			
			echo $linkbuilder;
			
    endwhile;
	echo '</ul>';
else :

    // no rows found

endif;

}

add_action('footer_top', __NAMESPACE__ . '\\footer_social', 10);