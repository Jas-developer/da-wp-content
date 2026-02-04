
<?php 
    if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
    }
?>
<!-- #HEADER  -->
 <?php get_header(); ?>
<main class="container">
    <!--jobs-text-container -->
    <?php get_template_part('template-parts/job-opportunities/jobs-text-content'); ?>
    <!-- jobs-content-card-container -->
    <?php get_template_part('template-parts/job-opportunities/jobs-container'); ?>
 <?php ?>

</main>
<!-- FOOTER -->
 <?php get_footer(); ?>