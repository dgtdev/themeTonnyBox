<!DOCTYPE html>
<html <?php language_attributes(); ?> >
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>

</head>
<body <?php body_class(); ?> >
	
<header class="site-header">
	<div class="contenedor">
		<div class="barra-navegacion">
			<div class="logo">

				<?php
					if ( has_custom_logo() ) {
						the_custom_logo();

					} else {

						?>
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="LogoSitio">

				<?php } ?>
				
			</div>
			
			
			
			<div>
				
				<?php
					$args = array(
						'theme_location' => 'menu-principal',
						'container' => 'nav',
						'container_id' => 'cssmenu',
						'walker' => new CSS_Menu_Walker()
					);
					wp_nav_menu( $args );
				?>
			</div>

			<?php echo do_shortcode('[wcas-search-form]'); ?>
			
			<div class="lupa">			
				<img src="<?php echo get_template_directory_uri(); ?>/assets/images/lupa.png" alt="search">
			</div>
		</div>
	</div>
</header>