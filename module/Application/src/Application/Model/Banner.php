<?php
/**
 * model tabulky bannerů
 *
 * @author Pavel
 */
namespace Application\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Banner implements InputFilterAwareInterface {
    
    public $id;
    public $autor_id;
    public $url;
    public $img;
    public $doba; /* týdny */
    public $pozice;
    public $vlozeno;
    public $potvrzeno;
    public $cas;
    public $aktivni;
    
    protected $inputFilter;
    
    public function __construct( $data ) {
        $this->exchangeArray($data);
    }
    
    public function exchangeArray( $data )
    {
        $this->id           = @$data['id'];
        $this->autor_id     = @$data['autor_id'];
        $this->url          = @$data['url'];
        $this->img          = @$data['img'];
        $this->doba         = @$data['doba'];
        $this->pozice       = @$data['pozice'];
        $this->vlozeno      = @$data['vlozeno'];
        $this->potvrzeno    = @$data['potvrzeno'];
        $this->cas          = @$data['cas'];
        $this->aktivni      = @$data['aktivni'];
    }
    
    public function setInputFilter( InputFilterInterface $inputFilter )
    {
        throw new \Exception("Not used");
    }
    
    public function getInputFilter()
    {
        /*
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
        */
        return new InputFilter();
    }
}
