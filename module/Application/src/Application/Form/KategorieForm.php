<?php
/**
 * Adding a catgegory
 *
 * @author Pavel
 */
namespace Application\Form;

use Zend\Form\Form;

class KategorieForm extends Form
{
    public function __construct($name = null,$kategorie = null)
    {
        parent::__construct('kategorie');

        $this->add(array(
            'name' => 'nazev',
            'type' => 'Text',
            'options' => array(
                'label' => 'Název kategorie',
            ),
        ));
        $this->add(array(
            'name' => 'kategorie',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Kategorie',
                'empty_option' => 'Hlavní kategorie',
                'value_options' => array(
                    'test' => 'Test',
                )
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Přidat',
            ),
        ));
    }
}
/*
$form = new Form('my-form');
   $form->add(array(
       'type' => 'Zend\Form\Element\MultiCheckbox',
       'name' => 'multi-checkbox',
       'options' => array(
           'label' => 'What do you like ?',
           'value_options' => array(
               array(
                   'value' => '0',
                   'label' => 'Apple',
                   'selected' => false,
                   'disabled' => false,
                   'attributes' => array(
                       'id' => 'apple_option',
                       'data-fruit' => 'apple',
                   ),
                   'label_attributes' => array(
                       'id' => 'apple_label',
                   ),
               ),
               array(
                   'value' => '1',
                   'label' => 'Orange',
                   'selected' => true,
               ),
               array(
                   'value' => '2',
                   'label' => 'Lemon',
               ),
           ),
       ),
   ));*/