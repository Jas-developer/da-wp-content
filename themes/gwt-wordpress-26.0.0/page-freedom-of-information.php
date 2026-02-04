
<?php 
    if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
    }
    get_header();
?>

<main class="container mt-4 d-flex flex-column gap-2">
    <!-- HEADING CONTAINER -->
     <div style="background-color: #E79D11;" class="text-white p-3">
       <h2>DA Freedom of Information (FOI) Manual</h2>
     </div>
    <!-- PDF FILE -->
    <div class="w-100 ">
        <embed style="height:70vh;" class="w-100 " src="https://www.da.gov.ph/wp-content/uploads/2024/01/2024-DA-FOI-Manual.pdf" type="application/pdf">
    </div>
    <!-- FORM IMAGE -->
    <div class="w-100">
        <img src="https://calabarzon.da.gov.ph/wp-content/uploads/2025/01/foiform.jpg" alt="" class="w-100">
    </div>
     <p>
        Download the Department of Agriculture <b class="text-success">
            <a href="https://calabarzon.da.gov.ph/wp-content/uploads/2024/02/2024-DA-FOI-MANUAL.pdf" class="text-decoration-none">Freedom of Information (FOI)  Manual </a></b> 
       and <b class="text-success"><a href="https://calabarzon.da.gov.ph/wp-content/uploads/2024/02/2024-DA-FOI-MANUAL.pdf">Request Form</a></b>
     </p>
</main>

<?php  get_footer(); ?>