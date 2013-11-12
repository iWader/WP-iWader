<?php
    
    function iwader_excerpt_length()
    {
        return 100;
    }
    
    add_filter('excerpt_length', 'iwader_excerpt_length', 999);
    
    function iwader_excerpt_more($more)
    {
        return ' ...';
    }
    
    add_filter('excerpt_more', 'iwader_excerpt_more')
    
?>
