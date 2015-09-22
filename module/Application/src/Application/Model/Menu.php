<?php

/**
 *
 *
 * @author Pavel
 */
namespace Application\Model;

class Menu {
    
    private $html;
    
    public function __construct( $path , $pages , $selected = null )
    {
        $this->html = "<nav class='shadow'>";
        
        foreach( $pages as $page )
        {
            if( $page == $selected )
            {
                $this->html .= "<a class='selected' href='#'>" . $page . "</a>";
                continue;
            }
            $this->html .= "<a class='animate leave' href='" . $path . "/" . $page . "'>" . $page . "</a>";
        }

        $this->html .= "</nav>";

    }
    
    public function __toString( ) 
    {
        return $this->html;
    }
    
}
