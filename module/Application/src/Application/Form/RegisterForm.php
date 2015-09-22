<?php
/**
 * Login form
 *
 * @author Michael
 */
namespace Application\Form;

use Zend\Form\Form;

class RegisterForm extends Form
{
    public function __construct( )
    {
        parent::__construct('login');

        $this->add(array(
            'name' => 'nick',
            'type' => 'Text',
        ));

        $this->add(array(
            'name' => 'heslo',
            'type' => 'Password',
        ));
        
        $this->add(array(
            'name' => 'heslo_repeat',
            'type' => 'Password',
        ));
        
        $this->add(array(
            'name' => 'email',
            'type' => 'Text',
        ));
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Registrovat',
                'class' => 'btn btn-info',
            ),
        ));
    }
}