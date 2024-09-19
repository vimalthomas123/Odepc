<?php

function timeSwitch($time) {
  $today = getdate();
  $week = date( 'W' );
  $year = date( 'Y' );
  switch ($time) {
    case $time == 'lastHour':
        return array(
          'column' => 'post_date_gmt',
          'after' => '1 hour ago',
        );
        break;
    case $time == 'last24hours':
        return array(
          'column' => 'post_date_gmt',
          'after' => '24 hour ago',
        );
        break;
    case $time == 'last7days':
        return array(
          'column' => 'post_date_gmt',
          'after' => '7 days ago',
        );
        break;
    case $time == 'last14days':
        return array(
          'column' => 'post_date_gmt',
          'after' => '14 days ago',
        );
        break;
    case $time == 'last30days':
        return array(
          'column' => 'post_date_gmt',
          'after' => '30 days ago',
        );
        break;
    default:
        echo "";
  }
}

add_action('wp_ajax_job_result','job_result');
add_action('wp_ajax_nopriv_job_result','job_result');
function job_result(){

  header("Content-Type: application/json"); 

  $data = $_POST;

  $keywordSearch = sanitize_text_field( $data['keywordSearch'] );
  $countryState = sanitize_text_field( $data['countryState'] );
  $recordsPerPage = sanitize_text_field( $data['recordsPerPage'] );
  $sortBy = sanitize_text_field( $data['sortBy'] );

  $jobType = sanitize_text_field( $data['jobType'] );
  $industry = sanitize_text_field( $data['industry'] );
  $gender = sanitize_text_field( $data['gender'] );

  $country = sanitize_text_field( $data['country'] );
  $state = sanitize_text_field( $data['state'] );
  
  $datePosted = sanitize_text_field( $data['datePosted'] );

  $page = sanitize_text_field( $data['page'] );
  $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
  $meta_query = array('relation' => 'AND');
  $tax_query = array('relation' => 'AND');
  $date_query = array();
  
  
  if($jobType){
    $tax_query[] = array(
      'taxonomy'  => 'types',
      'field'     => 'id',
      'terms'     => $jobType,
    );
  }

  if($industry){
    $tax_query[] = array(
      'taxonomy'  => 'industries',
      'field'     => 'id',
      'terms'     => $industry,
    );
  }

  if($gender && $gender != 'none') {
    $meta_query[] = array(
      'key'     => 'gender_preference',
      'value'   => $gender,
      'compare' => '=',
    );
  }

  if($datePosted != 'all') {
    $date_query[] = timeSwitch($datePosted);
  }



    if($country)
    {

      $tax_query[] = array(
        'taxonomy'  => 'locations',
        'field'     => 'id',
        'terms'     => array($country, $state),
        'operator' => 'IN'
      );
    }
    else if($countryState)
    {
      $tax_query[] = array(
        'taxonomy' => 'locations',
        'field'    => 'name',
        'terms'    => $countryState,
        'operator' => 'IN'
    );
    }

  $joinSearch = $keywordSearch;
if($sortBy == 'title')
{
  $ordr = 'ASC';
}
else{
  $ordr = 'DESC';
}
  $args = array(
    's' => $joinSearch,
    'post_type' => 	'jobs',
    'status'  => 'published',
    'posts_per_page'  => 	($recordsPerPage) ? $recordsPerPage : 8,
    'orderby' => $sortBy,
    'order' => $ordr,
    'paged' => $page,
    'meta_query' => $meta_query,
    'tax_query' => $tax_query,
    'date_query' => $date_query
    //'page' => $page
  );

  $response	= array();
  
  ob_start();
    $the_query = new WP_Query($args);
    if ( $the_query->have_posts() ) {
      while ( $the_query->have_posts() ) : $the_query->the_post();

      global $post;
      $img_url = get_the_post_thumbnail_url(get_the_ID(),'full');
      $title = get_the_title();
      $closing_date = get_field('closing_date');
      $publish_date = $post->post_date;
      $locations = get_the_term_list( $post->ID, 'locations', '', ', ' );
      $industries = get_the_term_list( $post->ID, 'industries', '', ', ' );
      $types = get_the_terms( $post->ID , array( 'types' ) );
      ?>

      <div class="card-list">
        <a href="<?php echo get_the_permalink(); ?>">
          <h4 class="card-list-title"><?php echo $title; ?></h4>
        </a>
        <div class="card-list-body">
          <div class="card-list-content">
            <ul>
              <?php if($closing_date): ?> <li>Closing Date: <span class="danger"> <?php echo date("d F, Y", strtotime($closing_date)); ?></span></li> <?php endif; ?>
              <?php if($publish_date): ?> <li><i class="flaticon flaticon-calendar-5"></i>Published <?php echo timeago($publish_date); ?></li> <?php endif; ?>
              <?php if($locations): ?> <li> <i class="flaticon flaticon-placeholder-3"></i> <?php echo $locations; ?> </li> <?php endif; ?>
              <?php if($industries): ?> <li> <i class="flaticon flaticon-funnel"></i> <?php echo $industries; ?> </li> <?php endif; ?>
            </ul>
          </div>
          <?php if($types): ?>
            <?php 
            $i = 1;
            foreach ( $types as $term ) {
              $term_link = get_term_link( $term, array( 'types') );
              if( is_wp_error( $term_link ) )
              continue;
              echo '<a class="badge ' .$term->slug . ' ' .getBadgeClass($term->slug). '" href="' . $term_link . '">' . strtoupper($term->name) . '</a>';
              echo ($i < count($types))? ", " : "";
              $i++;
            }
            ?>
          <?php else: ?>
          <span class="badge badge-secondary">OTHERS</span>
          <?php endif; ?>
        </div>
      </div>

      <?php
      endwhile; 
    } else {
      echo "<div class='no-result'>Sorry, No Records Found...</div>";
    };
  $html_content = ob_get_clean();

  ob_start();
  echo pagination_bar($the_query);
  $pagination = ob_get_clean();

  ob_start();
    ?>
    <h2><?php echo $the_query->found_posts.' Records Found'; ?></h2>
    <h4>Displayed Here : <?php echo ($recordsPerPage) ? $recordsPerPage : 1; ?> - <?php echo $the_query->found_posts; ?> Jobs</h4>
    <?php
  $result_status = ob_get_clean();
  
  $response['html_content']	= $html_content;
  $response['result_status']	= $result_status;
  $response['pagination']	= $pagination;
  $response['args']	= $args;
  
  echo json_encode($response);

  wp_reset_postdata();
  die();

}