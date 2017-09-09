<?php get_header(); ?>
<div id="container">
    <div id="content">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div class="post" id="post-<?php the_ID(); ?>">
	<h2 class="pagetitle"><?php the_title(); ?></h2>
		<div class="entrytext">
			<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
			<?php link_pages('<p>Pages: ', '</p>', 'number'); ?>
		</div>
	</div>
    <?php endwhile; ?>

    <?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>

    <?php else: ?>
      Sorry, that page could not be found.
    <?php endif; ?>
    </div><!-- content -->

    <?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>