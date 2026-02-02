<?php
/**
 * gwt_wp functions and definitions
 *
 * @package gwt_wp
 */

/**
 * 1. THEME SETUP & INCLUDES
 */
require get_template_directory() . '/inc/function-initialize.php';
require get_template_directory() . '/inc/function-widget.php';
require get_template_directory() . '/inc/function-breadcrumbs.php';
require get_template_directory() . '/inc/function-excerpt.php';
require get_template_directory() . '/inc/function-enqueue_scripts.php';
require get_template_directory() . '/inc/function-disable_comments.php';
require get_template_directory() . '/inc/govph-widget.php';
require get_template_directory() . '/inc/sidebar.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/extras.php';
require get_template_directory() . '/inc/function-options.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/vendors/envato-flex-slider/envato-flex-slider.php';
require get_template_directory() . '/inc/function-disable_api.php';

/**
 * Enable classic widgets and posts (Disables Gutenberg)
 */
require get_template_directory() . '/inc/function-enable-classic-widgets.php';
require get_template_directory() . '/inc/function-enable-classic-posts.php';

/**
 * GWT Back-compatibility
 */
if ( version_compare( $GLOBALS['wp_version'], '4.4-alpha', '<' ) ) {
    require get_template_directory() . '/inc/back-compat.php';
}

/**
 * Security: Block Frames
 */
function block_frames() {
    header( 'X-FRAME-OPTIONS: SAMEORIGIN' );
}
add_action( 'send_headers', 'block_frames', 10 );


/* -----------------------------------------------------------
 * CUSTOM ADDITION: JOB VACANCIES TABLE SHORTCODE
 * Usage: [da_jobs_table]
 * ----------------------------------------------------------- */
function da_render_jobs_table() {
    global $wpdb;

    // 1. FETCH DATA
    // We use the database prefix (usually 'wp_') + 'da_job_vacancies'
    $table_name = $wpdb->prefix . 'da_job_vacancies'; 
    
    // Safety Check: We check if the table actually exists in the database
    // We use a specific SQL query to check existence to avoid crashes
    $check_table = $wpdb->get_var("SHOW TABLES LIKE '$table_name'");

    if($check_table != $table_name) {
        // If table is missing, only show error to Admin
        if (current_user_can('administrator')) {
            return "<div style='background:#fee; color:red; padding:15px; border:1px solid red; margin:20px 0;'>
                <strong>Configuration Error:</strong><br>
                The database table <code>$table_name</code> was not found.<br>
                Please check your database via phpMyAdmin.
            </div>";
        }
        return "";
    }

    // SQL Query to get your data
    $query = "
        SELECT 
            title, 
            sg, 
            assignment AS place, 
            education AS educ, 
            experience AS exp, 
            eligibility AS elig 
        FROM $table_name 
        ORDER BY id DESC
    ";
    
    $results = $wpdb->get_results($query);
    
    // Fix for empty results to prevent JSON errors
    if (empty($results)) {
        $jobs_json = '[]';
    } else {
        $jobs_json = json_encode($results);
    }

    ob_start(); 
    ?>

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        /* Scoped Variables */
        .da-job-board-wrapper {
            --da-green: #006837;
            --bg-stripe: #f5f5f5;
            --border-color: #ddd;
            --text-color: #333;
            font-family: 'Open Sans', sans-serif;
            background-color: #fff;
            padding: 20px;
            color: var(--text-color);
        }

        .da-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* --- HEADER & CONTROLS --- */
        .da-header-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .da-table-title {
            color: var(--da-green);
            margin: 0;
            font-weight: 700;
            font-size: 1.5rem;
            text-transform: uppercase;
        }

        .da-controls-wrapper {
            font-size: 0.9rem;
            color: #555;
        }

        .da-rows-select {
            padding: 6px 10px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            color: #333;
            background: white;
            cursor: pointer;
            margin: 0 5px;
            width: auto;
            display: inline-block;
        }

        /* --- TABLE STYLES --- */
        .da-table-wrapper {
            width: 100%;
            overflow-x: auto;
            border: 1px solid #eee;
            margin-bottom: 20px;
        }

        table.da-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
            min-width: 1000px;
        }

        table.da-table th {
            text-align: left;
            padding: 15px;
            background-color: white;
            color: var(--da-green);
            font-weight: 700;
            border-bottom: 2px solid var(--da-green);
            text-transform: uppercase;
            white-space: nowrap;
        }

        table.da-table td {
            padding: 14px 15px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
            line-height: 1.5;
        }

        /* Column Widths */
        .col-title { font-weight: 700; color: var(--da-green); width: 20%; }
        .col-sg { font-weight: 600; text-align: center; width: 5%; }
        .col-place { font-style: italic; color: #555; width: 15%; }
        .col-educ { width: 20%; }
        .col-exp { width: 20%; }
        .col-elig { width: 20%; }

        /* Striped Rows */
        table.da-table tbody tr:nth-child(even) { background-color: var(--bg-stripe); }
        table.da-table tbody tr:hover { background-color: #e8f5e9; }

        /* --- PAGINATION --- */
        .da-pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 10px;
        }

        .da-pagination-btns { display: flex; gap: 4px; }

        .da-page-btn {
            background: white;
            border: 1px solid #ddd;
            color: #555;
            padding: 8px 12px;
            font-size: 0.9rem;
            cursor: pointer;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            transition: all 0.2s;
        }

        .da-page-btn:hover:not(:disabled) { background-color: #f0f0f0; border-color: #ccc; }
        .da-page-btn.active { background-color: var(--da-green); color: white; border-color: var(--da-green); }
        .da-page-btn:disabled { color: #ccc; cursor: default; border-color: #eee; }

        .da-page-info { font-size: 0.9rem; color: #333; }

        @media (max-width: 768px) {
            .da-pagination-container { flex-direction: column; gap: 15px; }
            .da-header-wrapper { flex-direction: column; align-items: flex-start; }
        }
    </style>

    <div class="da-job-board-wrapper">
        <div class="da-container">
            <div class="da-header-wrapper">
                <h2 class="da-table-title">Detailed List of Vacant Positions</h2>
                <div class="da-controls-wrapper">
                    <label>Show 
                        <select class="da-rows-select" id="daRowsPerPage" onchange="daChangeRowsPerPage()">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                        </select> 
                    entries</label>
                </div>
            </div>

            <div class="da-table-wrapper">
                <table class="da-table">
                    <thead>
                        <tr>
                            <th>Position Title</th>
                            <th style="text-align:center;">SG</th>
                            <th>Assignment</th>
                            <th>Education</th>
                            <th>Experience & Training</th>
                            <th>Eligibility</th>
                        </tr>
                    </thead>
                    <tbody id="da-table-body"></tbody>
                </table>
            </div>

            <div class="da-pagination-container">
                <div class="da-pagination-btns" id="da-pagination-btns"></div>
                <div class="da-page-info" id="da-page-info"></div>
            </div>
        </div>
    </div>

    <script>
        const jobs = <?php echo $jobs_json; ?>;
        let daCurrentPage = 1;
        let daRowsPerPage = 5;

        function daRenderTable() {
            const tableBody = document.getElementById('da-table-body');
            const paginationBtns = document.getElementById('da-pagination-btns');
            const pageInfo = document.getElementById('da-page-info');

            tableBody.innerHTML = "";
            paginationBtns.innerHTML = "";

            if (!jobs || jobs.length === 0) {
                tableBody.innerHTML = "<tr><td colspan='6' style='text-align:center; padding:20px;'>No job vacancies found in database.</td></tr>";
                pageInfo.innerText = "Showing 0 entries";
                return;
            }

            const start = (daCurrentPage - 1) * daRowsPerPage;
            const end = start + daRowsPerPage;
            const paginatedItems = jobs.slice(start, end);
            const totalPages = Math.ceil(jobs.length / daRowsPerPage);

            paginatedItems.forEach(job => {
                const row = `
                    <tr>
                        <td class="col-title">${job.title}</td>
                        <td class="col-sg">${job.sg}</td>
                        <td class="col-place">${job.place}</td>
                        <td class="col-educ">${job.educ}</td>
                        <td class="col-exp">${job.exp}</td>
                        <td class="col-elig">${job.elig}</td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });

            paginationBtns.innerHTML += `<button class="da-page-btn" onclick="daGoToPage(1)" ${daCurrentPage === 1 ? 'disabled' : ''}><i class="fas fa-angles-left"></i></button>`;
            paginationBtns.innerHTML += `<button class="da-page-btn" onclick="daGoToPage(${daCurrentPage - 1})" ${daCurrentPage === 1 ? 'disabled' : ''}><i class="fas fa-angle-left"></i></button>`;
            
            for (let i = 1; i <= totalPages; i++) {
                const activeClass = daCurrentPage === i ? "active" : "";
                paginationBtns.innerHTML += `<button class="da-page-btn ${activeClass}" onclick="daGoToPage(${i})">${i}</button>`;
            }
            
            paginationBtns.innerHTML += `<button class="da-page-btn" onclick="daGoToPage(${daCurrentPage + 1})" ${daCurrentPage === totalPages ? 'disabled' : ''}><i class="fas fa-angle-right"></i></button>`;
            paginationBtns.innerHTML += `<button class="da-page-btn" onclick="daGoToPage(${totalPages})" ${daCurrentPage === totalPages ? 'disabled' : ''}><i class="fas fa-angles-right"></i></button>`;

            const endDisplay = Math.min(end, jobs.length);
            const startDisplay = jobs.length === 0 ? 0 : start + 1;
            pageInfo.innerText = `Showing ${startDisplay} to ${endDisplay} of ${jobs.length} entries`;
        }

        function daGoToPage(page) {
            const totalPages = Math.ceil(jobs.length / daRowsPerPage);
            if (page < 1 || page > totalPages) return;
            daCurrentPage = page;
            daRenderTable();
        }

        function daChangeRowsPerPage() {
            daRowsPerPage = parseInt(document.getElementById('daRowsPerPage').value);
            daCurrentPage = 1;
            daRenderTable();
        }

        document.addEventListener("DOMContentLoaded", daRenderTable);
    </script>

    <?php
    return ob_get_clean();
}
add_shortcode('da_jobs_table', 'da_render_jobs_table');