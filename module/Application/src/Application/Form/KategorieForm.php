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
        ));
        $this->add(array(
            'name' => 'kategorie',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'value_options' => $kategorie
            ),
        ));
        $this->add(array(
            'name' => 'typ',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'value_options' => array(
                    'firmy' => 'Firmy',
                    'inzeraty' => 'Inzeráty',
                ),
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Přidat',
                'class' => 'btn btn-info leave',
            ),
        ));
    }
}