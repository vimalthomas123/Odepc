<?php

function pagination_bar( $the_query ) {

    $total_pages = $the_query->max_num_pages;
    $the_query->query_vars['paged'] > 1 ? $current = $the_query->query_vars['paged'] : $current = 1;
    if ($total_pages > 1){
      $big = 999999999; // need an unlikely integer
      $pages = paginate_links( array(
        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format' => '?paged=%#%',
        'current' => $current,
        'total' => $total_pages,
        'type' => 'array',
        'prev_next' => false,
        'type'  => 'array'
      ));

      if( is_array( $pages ) ) {
        $paginateLinks = '<nav id="pagination" class="top-margin-md"><ul class="pagination align-right">';
        foreach ( $pages as $page ) {
          $isActive = '';
          if ( strpos( $page, 'current' ) !== false ) {
            $isActive = 'active';
          }
          $pageLink = str_replace('page-numbers','page-link',$page);
          $paginateLinks.= "<li class='page-item ".  $isActive ."'>". $pageLink. "</li>";
        }
        $paginateLinks .= '</ul></nav>';
      }
    }

    return $paginateLinks;

}