<?php use Roots\Sage\Titles; ?>

<div class="page-header">
  <h1><?= Titles\title(); ?></h1>
  
  <?php if( get_field('icon_class') ) { ?>
  	<span class="divider">
  		<span class="white-bg"><i class="<?php the_field( 'icon_class' ); ?>" aria-hidden="true"></i></span>
  	</span>
  <?php } ?>
  
</div>
