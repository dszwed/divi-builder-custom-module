<?php

function wp360_get_categories() {
    $categoriesTerms = get_categories( array(
        'orderby' => 'name'
    ) );
    
    $categories = array(
        '' => 'All'
    );
 
    foreach ( $categoriesTerms as $term ) {
        
        $categories[$term->term_id] = $term->name;
    }
    
    return $categories;
}
