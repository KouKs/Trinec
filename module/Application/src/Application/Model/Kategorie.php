<?php
/**
 * model tabulky kategorie
 *
 * @author Pavel
 */
namespace Application\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Kategorie implements InputFilterAwareInterface {
    
    public $id;
    public $nazev;
    public $level;
    public $typ;
    public $parent;
    public $aktivni;
    
    protected $inputFilter;

    public function exchangeArray( $data )
    {
        $this->id     = @$data['id'];
        $this->nazev  = @$data['nazev'];
        $this->level  = @$data['level'];
        $this->typ    = @$data['typ'];
        $this->parent = @$data['parent'];
        $this->aktivni= @$data['aktivni'];
    }
    
    public function setInputFilter( InputFilterInterface $inputFilter )
    {
        throw new \Exception("Not used");
    }
    
    public function getInputFilter()
    {
        if( !$this->inputFilter ) {
            $inputFilter = new InputFilter();

            $inputFilter->add( array(
                'name'     => 'nazev',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 2,
                            'max'      => 100,
                        ),
                    ),
                ),
            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}
