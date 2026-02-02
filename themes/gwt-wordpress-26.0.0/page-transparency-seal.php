<?php get_header();

//the text-content
// the title and sub title 
// i will create tempplate part for each
?> 
<main class="container-fluid ">
<?php 
   get_template_part('template-parts/transparency-seal/text-content'); ?> 
   <!-- links - content 
     ##template parts
     ##links content 
   -->
   <?php get_template_part('template-parts/transparency-seal/links-content'); ?>
</main>
<?php 




get_footer();
?>