<footer class="content-info" style="background-image: url(<?php the_field( 'footer_background_image', 'option' ); ?>);">
  <div class="container text-center">

		<?php footer_top(); ?>

    <?php dynamic_sidebar('sidebar-footer'); ?>
        
    &copy; <?php echo date( 'Y' ); ?> <?php bloginfo('name'); ?>. All Rights reserved
    
  </div>
</footer>