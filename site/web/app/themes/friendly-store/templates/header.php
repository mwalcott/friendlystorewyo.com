<?php above_header(); ?>
<header id="myAffix" class="banner">
  <div class="container">
    <a class="visible-xs pull-left" href="#nav-mobile"><span class="glyphicon glyphicon-option-vertical"></span></a>
    <a class="visible-xs pull-right" href="tel:<?php the_field( 'phone_number', 'option' ); ?>"><span class="glyphicon glyphicon-earphone"></span></a>
    <a class="brand" href="<?= esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
    <nav class="nav-primary hidden-xs">
      <?php
      if (has_nav_menu('primary_navigation')) :
        wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']);
      endif;
      ?>
    </nav>
  </div>
</header>
