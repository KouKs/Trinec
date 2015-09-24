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
            'attributes' => array(
                'id' => 'cat',
                'style' => 'display: none;'
            ),
            'options' => array(
                'empty_option' => array(
                    'label' => 'Vyberte umístění kategorie',
                        'attributes' => array(
                            'selected' => 'selected',
                            'disabled' => 'disabled',
                        ),
                ),
                'value_options' => $kategorie
            ),
        ));
        $this->add(array(
            'name' => 'typ',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'id' => 'typ',
            ),
            'options' => array(
                'empty_option' => array(
                    'label' => 'Vyberte typ kategorie',
                        'attributes' => array(
                            'selected' => 'selected',
                            'disabled' => 'disabled',
                        ),
                ),
                'value_options' => array(
                    array(
                        'value' => 'firmy',
                        'label' => 'Firmy'
                    ),
                    array(
                        'value' => 'inzeraty',
                        'label' => 'Inzeráty'
                    ),
                ),
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Přidat',
                'class' => 'btn btn-info',
            ),
        ));
    }
}