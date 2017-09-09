<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>
<div id="container">
    <div id="content">

    <h2 class="pagetitle">Archives</h2>
    <?php include (TEMPLATEPATH . '/searchform.php'); ?>

    <h3>Archives by Month:</h3>
    <ul>
      <?php wp_get_archives('type=monthly'); ?>
    </ul>

    <h3>Archives by Subject:</h3>
    <ul>
     <?php wp_list_cats(); ?>
    </ul>
    </div><!-- content -->	
    
    <?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
