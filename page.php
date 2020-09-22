<?php get_header(); ?>

<div class="container">
<?php while( have_posts() ):  the_post(); ?>
	
	<h2><?php the_title(); ?></h2>

	<?php 
		if(has_post_thumbnail()):
			the_post_thumbnail();
		endif;
	?>

	<?php the_content(); ?>

<?php endwhile; ?>
</div>
<?php get_footer(); ?>