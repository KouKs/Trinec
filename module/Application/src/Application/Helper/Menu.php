<?php
/**
 * Description of Menu
 *
 * @author Pavel
 */

namespace Application\Helper;

use Zend\View\Helper\AbstractHelper;

class Menu extends AbstractHelper
{
    protected $html;
    
    public function __invoke( $path , $pages , $selected )
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
            $this->html .= str_replace( "//" , "/" , "<a class='animate leave' href='" . $path . "/" . $page . "'>" . $name . "</a>" );
        }

        $this->html .= "</nav>";
        
        echo $this->html;
    }
}
