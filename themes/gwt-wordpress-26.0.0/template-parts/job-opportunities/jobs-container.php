<div class="d-flex flex-column">
    <div class="d-flex flex-row justify-content-between align-items-center">

    <?php
     $per_page = isset($_GET['per_page']) ? intval($_GET['per_page']) : 5;
     ?>

        <h2 class="text-success ">DETAILED LIST OF VACANT POSITIONS</h2>
        
         <div class="d-flex flex-row justify-content-center align-items-center gap-2">
            <span>SHOW</span>
            <form method="GET" id="posts-per-page-form" >
              <select name="per_page" onchange="this.form.submit()">
             <option value="5" <?php selected($per_page, 5); ?> >5</option>
              <option value="10" <?php selected($per_page, 10); ?>>10</option>
               <option value="20" <?php selected($per_page, 20); ?>>20</option>
              </select>
            </form>
            <span>ENTRIES</span>
         </div>
    </div>
    <!-- jobs-container -->
     <div class="d-flex flex-column">

    <?php
     $args = array(
        'post_type' => 'job-opportunities',
        'posts_per_page' => $per_page,
     );
    
    $job = new Wp_Query($args);
    ?>
    


      <table>
        <thead style="border-bottom: 2px solid green;" class=" text-success ">
            <tr >
                <th>POSITION TITLE</th>
                <th>SG</th>
                <th>ASSIGNMENT</th>
                <th>EDUCATION</th>
                <th>EXPERIENCE & TRAINING</th>
                <th>ELIGIBILITY</th>
            </tr>
        </thead>

        <tbody>
           <?php 
           if($job->have_posts()){
             while($job->have_posts()){ $job->the_post(); ?>
            <tr class="jobs-row">
                <!-- TITLE -->
                <td>
                    <?php echo esc_html(get_the_title()); ?>
                </td>
                <!-- SG -->
                <td>
                <?php 
                   $sg_field = get_field('sg'); 
                   $sg = $sg_field ? $sg_field : "To be Determined";
                   echo esc_html($sg);
                  ?>
                </td>
                <!-- ASSIGNMENT -->
                <td>
                 <?php 
                   $assignment_field = get_field('assignment');
                   $assignment = $assignment_field ? $assignment_field : 'To be Determined';
                   echo esc_html($assignment);
                 ?>

                </td>
                <!-- EDUCATION -->
                <td>
                 <?php
                  
                  $eductcation_field = get_field('education');
                  $education = $eductcation_field ? $eductcation_field : "To be Determined";
                  echo esc_html($education);
                 
                 ?>

                </td>
                <!-- EXPERIENCE & TRAINING -->
                <td>
                <?php
                   
                 $expt_field =  get_field('experience_and_training');
                 $expt = $expt_field ? $expt_field : "To be Determined";
                 echo esc_html($expt); 
                 ?>
                </td>
                <!-- ELIGIBILITY -->
                <td>
                    <?php 
                    
                    $eligibility_field = get_field('eligibility');
                    $eligibility = $eligibility_field ? $eligibility_field : "To be Determined";
                    echo $eligibility;

                    
                    ?>
                </td>
               </tr>
           
           <?php }
           }
           
           ?>
        </tbody>
      </table>
     </div>
</div>