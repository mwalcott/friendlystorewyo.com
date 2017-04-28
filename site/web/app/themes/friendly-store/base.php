<?php

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;

?>

<!doctype html>
<html <?php language_attributes(); ?>>
  <?php get_template_part('templates/head'); ?>
  <body <?php body_class(); ?>>
    <!--[if IE]>
      <div class="alert alert-warning">
        <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
      </div>
    <![endif]-->

    <nav class="hidden-sm hidden-md hidden-lg" id="nav-mobile">
      <?php
      if (has_nav_menu('primary_navigation')) :
        wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'mobile-nav']);
      endif;
      ?>
    </nav>

    
		<!-- Start Div for mmenu -->
    <div class="mmenu-wrap">
    
    <?php
      do_action('get_header');
      get_template_part('templates/header');
    ?>
    <div class="wrap container" role="document">
      <div class="content row">
        <main class="main">
          <?php include Wrapper\template_path(); ?>
        </main><!-- /.main -->
        <?php if (Setup\display_sidebar()) : ?>
          <aside class="sidebar">
            <?php include Wrapper\sidebar_path(); ?>
          </aside><!-- /.sidebar -->
        <?php endif; ?>
      </div><!-- /.content -->
    </div><!-- /.wrap -->
    
    <!-- Content Builder Hook -->
    <?php content_builder(); ?>

<?php 

$location = get_field('google_map', 'option');

if( !empty($location) ):
?>
<div class="container">
<!-- 	<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d2195.576724282958!2d-106.1398324470116!3d41.29766734960727!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x908cf11313e9026c!2sFriendly+Store+%26+Motel!5e0!3m2!1sen!2sus!4v1463435027442" width="100%" height="500" frameborder="0" style="border:0" allowfullscreen></iframe> -->
	<div class="acf-map">
		<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
	</div>
</div>
<?php endif; ?>
    
    <?php
      do_action('get_footer');
      get_template_part('templates/footer');
      wp_footer();
    ?>
    
    </div>
    <!-- End Div for mmenu -->
    
  </body>
</html>
