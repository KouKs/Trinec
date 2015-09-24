<?php
/**
 * Description of Menu
 *
 * @author Pavel
 */

namespace Application\Helper;

use Zend\View\Helper\AbstractHelper;

class Messenger extends AbstractHelper
{
    protected $html;

    public function __invoke( $success , $notice , $error )
    {
        $this->html = "";
        
        if( isset( $success ) )
        {
            $this->html .= '<div class="shadow message success">';
                $this->html .= $success; 
            $this->html .= '</div>';
        }
        
        if( isset( $notice ) )
        {
            $this->html .= '<div class="shadow message notice">';
                $this->html .= $notice; 
            $this->html .= '</div>';
        }
        
        if( isset( $error ) )
        {
            $this->html .= '<div class="shadow message error">';
                $this->html .= $error; 
            $this->html .= '</div>';
        }
        
        echo $this->html;
    }
}