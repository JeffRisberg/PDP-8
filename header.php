<?php
$pdp8_Mode = get_settings('pdp8_Mode');
if (!$pdp8_Mode) {
  $pdp8_Mode = 'PDP8';
  update_option('pdp8_Mode', $pdp8_Mode);
}

$pdp8_Sidebar = get_settings('pdp8_Sidebar');
if (!$pdp8_Sidebar) {
  $pdp8_Sidebar = 'Left';
  update_option('pdp8_Sidebar', $pdp8_Sidebar);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head profile="http://gmpg.org/xfn/11">
 <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
 <meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->

 <title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?></title>

 <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
 <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/<?php echo get_settings( 'pdp8_Mode' ) . ".css"; ?>" type="text/css" media="screen" />
<?php if ($pdp8_Sidebar == "Left") { ?>
 <style type="text/css" media="screen">
   #content { float: right; }
   #sidebar { float: left; 
     padding-right: 12px;
     border-right: 3px solid black;
     margin-right: 3px;
   }
 </style>
 <?php } else { ?>
 <style type="text/css" media="screen">
   #content { float: left; }
   #sidebar { float: right; 
     padding-left: 10px;
     border-left: 3px solid black; 
     margin-left: 3px;
   }
 </style>
<?php } ?>

 <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
 <link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
 <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

 <?php wp_get_archives('type=monthly&format=link'); ?>

 <?php wp_head(); ?>
</head>
<body>

<div id="page">
<div id="header">
  <div id="headerimg">
    <h1><a href="<?php echo get_settings('home'); ?>"><?php bloginfo('name'); ?></a></h1>
    <div class="description"><?php bloginfo('description'); ?></div>
  </div>
</div>
<div id="navbar">
  <ul class="level1">
    <li><a href="<?php bloginfo('url'); ?>/">Home</a></li>
    <?php
     if (function_exists("pdp8_pages_nav")) {
      pdp8_pages_nav("sort_column=menu_order&list_tag=0&show_all_parents=1&show_root=1");
     }
    else {
      echo("</ul>");
    }
    ?>
</div>
