<?php
/**
 * Login form
 *
 * @author Michael
 */
namespace Application\Form;

use Zend\Form\Form;

class LoginForm extends Form
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
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Přihlásit',
                'class' => 'btn btn-info',
            ),
        ));
    }
}