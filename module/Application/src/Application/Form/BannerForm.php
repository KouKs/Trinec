<?php
/**
 * Login form
 *
 * @author Michael
 */
namespace Application\Form;

use Zend\Form\Form;

class BannerForm extends Form
{
    public function __construct( )
    {
        parent::__construct('banner');

        $this->add(array(
            'name' => 'banner',
            'type' => 'Hidden',
            'attributes' => array(
                'id' => 'edit_id'
            ),
        ));
        
        $this->add(array(
            'name' => 'url',
            'type' => 'Text',
        ));

        $this->add(array(
            'name' => 'soubor',
            'type' => 'File',
        ));
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Upravit',
                'class' => 'btn btn-info',
            ),
        ));
    }
}