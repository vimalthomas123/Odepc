<?php  get_header(); ?>

<section id="job-listing" class="top-padding-md">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="side-bar">
                    <div class="sidebar-head">
                        <h4><i class="flaticon flaticon-search-1"></i>Refine your Search</h4>
                    </div>
                    <div class="sidebar-body">
                        <div class="sidebar-items">
                            <h5>Filter By</h5>
                            <div class="form-group">
                              <select class="selectpicker hide-search" name="jobType" id="jobType">
                                <option value="" disabled selected>Job Type</option>
                                <?php 
                                  $terms = get_terms( array( 'post_types' => 'jobs', 'taxonomy' => 'types' ) );
                                  if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
                                  foreach ( $terms as $term ) {
                                      echo '<option value="'.$term->term_id.'">'.$term->name.'</option>';
                                  }
                                  }
                                ?>
                              </select>
                            </div>
                            <div class="form-group">
                                <select class="selectpicker" name="industry" id="industry">
                                  <option value="" disabled selected>Industry</option>
                                  <?php 
                                    $terms = get_terms( array( 'post_types' => 'jobs', 'taxonomy' => 'industries' ) );
                                    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
                                    foreach ( $terms as $term ) {
                                        echo '<option value="'.$term->term_id.'">'.$term->name.'</option>';
                                    }
                                    }
                                  ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="selectpicker hide-search" name="gender" id="gender">
                                  <option value="" disabled selected>Gender</option>
                                  <option value="male">Male</option>
                                  <option value="female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="sidebar-items">
                            <h5>Locations</h5>
                            <div class="form-group">
                                <select class="selectpicker" name="country" id="country"></select>
                            </div>
                            <div class="form-group">
                                <select class="selectpicker" name="state" id="state"></select>
                            </div>
                        </div>
                        <div class="sidebar-items">
                            <h5>Date Posted</h5>
                            <div class="checkbox-group">
                                <input type="radio" name="datePosted" id="lastHour">
                                <label for="lastHour">Last Hour</label>
                            </div>
                            <div class="checkbox-group">
                                <input type="radio" name="datePosted" id="last24hours">
                                <label for="last24hours">Last 24 hours</label>
                            </div>
                            <div class="checkbox-group">
                                <input type="radio" name="datePosted" id="last7days">
                                <label for="last7days">Last 7 days</label>
                            </div>
                            <div class="checkbox-group">
                                <input type="radio" name="datePosted" id="last14days">
                                <label for="last14days">Last 14 days</label>
                            </div>
                            <div class="checkbox-group">
                                <input type="radio" name="datePosted" id="last30days">
                                <label for="last30days">Last 30 days</label>
                            </div>
                            <div class="checkbox-group">
                                <input type="radio" name="datePosted" id="all" checked>
                                <label for="all">All</label>
                            </div>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-danger btn-lg" id="filterJobs">Find Jobs</button>
                            <button type="button" class="btn btn-light btn-lg" id="resetJobs">Reset</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row rl-sort">
                    <div class="col-md-6">
                      <div class="rl-title" id="resultStatus"></div>
                    </div>
                    <div class="col-md-6">
                        <form action="#" class="rl-search-wrap">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group selectpicker-xs">
                                        <select class="selectpicker hide-search" name="sortBy" id="sortBy">
                                          <option value="" disabled selected>Sort By</option>
                                          <option value="post_date">Most Recent</option>
                                          <option value="title">Job Title</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group selectpicker-xs">
                                        <select class="selectpicker hide-search" name="recordsPerPage" id="recordsPerPage">
                                          <option value="" disabled selected>Records Per Page</option>
                                          <option value="8">8</option>
                                          <option value="16">16</option>
                                          <option value="24">24</option>
                                          <option value="32">32</option>
                                          <option value="40">40</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div id="jobData"></div>
                <div id="jobPagination"></div>

            </div>
        </div>
        <hr class="top-margin-lg">
    </div>
</section>
 
<?php get_footer(); ?>