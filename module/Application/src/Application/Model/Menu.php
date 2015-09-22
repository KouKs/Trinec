<?php

/**
 * generace custom menu
 *
 * @author Pavel
 */
namespace Application\Model;

class Menu {
    
    private $html;
    
    public function __construct( $path , $pages , $selected = null )
    {
        $this->html = "<nav class='shadow'>";
        
        foreach( $pages as $page => $name )
        {
            if( is_numeric($page) ) {
                $page = $name;
            }
            
            if( $page === $selected )
            {
                $this->html .= "<a class='selected' href='#'>" . $name . "</a>";
                continue;
            }
            $this->html .= "<a class='animate leave' href='" . $path . $page . "/'>" . $name . "</a>";
        }

        $this->html .= "</nav>";

    }
    
    public function __toString( ) 
    {
        return $this->html;
    }
    
}
