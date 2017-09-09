<?php
/*
Template Name: Links
*/
?>

<?php get_header(); ?>
<div id="container">
    <div id="content">

    <h2 class="pagetitle">Links</h2>
    <ul>
      <?php get_links_list(); ?>
    </ul>
    </div><!-- content -->
	
    <?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
