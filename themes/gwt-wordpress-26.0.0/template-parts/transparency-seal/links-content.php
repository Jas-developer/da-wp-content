


<?php
$args = array(
    'post_type' => 'transparency',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'ASC'
);
$query = new WP_Query($args); ?>
  <div class="container d-flex flex-column gap-3  mb-4 " id="seal-content-wrapper">
    <!-- heading -->
     <div class="w-100">
        <h2 class="text-black fw-semibold">DA Compliance with Sec. 103 (Transparency Seal) R.A. No. 11975 (General Appropriations Act 2024)</h2>
     </div>

     <div id="seal-section-wrapper" class="d-flex flex-column seal-section-wrapper gap-2">
<?php 
if($query->have_posts()){ 
  $categories = [];
 while($query->have_posts()){ $query->the_post();
   $category = get_field('category');
    
   ?>
    
     <!-- main content -->
  
    <!-- title -->
  <?php if(!in_array($category,$categories)){ 
    $categories[] = $category;   
    $exploded_category =  explode('.', $category); ?>
     
      <h4  style="background-color:#EDECE3;" class="fw-semibold li-category shadow-sm p-2 text-success"  data-id="<?php echo $exploded_category[0]; ?>">
        <span role="button" data-id="<?php echo $exploded_category[0]; ?>" class="dashicons text-warning fs-5 dashicons-plus-alt2"></span> 
        <?php 

        /* 
          #remove the roman numerals and the dot
          - check if there is a roman numerals or a dot 
          - if there is substract/remove str before dot & retain the str after dot
        */

          $pos = strpos($category, ".");
          $category_result = ($pos !== false) ? substr($category,$pos+1) :  $category;
        
      echo   esc_html($category_result); ?>
      </h4>
    <?php }  ?>
     <!-- sub title -->
  <div id="<?php echo $exploded_category[0]; ?>" <?php if($category){ ?> data-id="<?php echo $exploded_category[0]; ?>" <?php  } ?> class="w-100 seal-list-wrapper d-none">
        <?php if(get_the_title()) { ?><span class="fw-semibold" style="color:rgb(122, 122, 122)"><?php echo esc_html(get_the_title()); ?></span> <?php } ?>
      <!-- list content -->
       <ul class=" px-5">
         <!-- EXTRACT THE LINK AND THE TITLE -->
          <?php
           //convert into array | use newline as seperator with explode function 

           $field = get_field('links');
           $links = preg_split("/\r\n|\r|\n/",$field); // return an array 


           foreach($links as $link){
            $link = trim($link);
            // skip empty lines 
             if(empty($link)) continue;
              $part = array_map('trim', explode("|",$link)); // seperate url and title 
              $title = $part[0] ??  ""; 
              $url = $part[1] ??  "#";

            ?>
            <li><a class="link-success" href="<?php echo esc_url($url); ?>"><?php echo esc_html($title); ?></a></li>
          <?php }
          
          
           ?>
      </ul>
  </div>
 

   <?php }
 ?>  </div> <?php 
  
   }

?> 
</div>  
