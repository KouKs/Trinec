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

class User implements InputFilterAwareInterface {
    
    public $id;
    public $nick;
    public $email;
    public $heslo;
    public $jmeno;
    public $prijmeni;
    public $telefon;
    public $ip;
    public $adresa;
    public $zarizeni;
    public $lastlogin;
    public $registrovan;
    public $admin;
    public $display;
    
    public $inputs;
    
    protected $inputFilter;

    public function exchangeArray( $data )
    {
        $this->id     = @$data['id'];
        $this->nick  = @$data['nick'];
        $this->email  = @$data['email'];
        $this->heslo  = sha1( @$data['heslo'] );
        $this->jmeno  = @$data['jmeno'];
        $this->prijmeni  = @$data['prijmeni'];
        $this->telefon  = @$data['telefon'];
        $this->ip  = @$data['ip'];
        $this->adresa  = @$data['adresa'];
        $this->zarizeni  = @$data['zarizeni'];
        $this->lastlogin  = @$data['lastlogin'];
        $this->registrovan  = @$data['registrovan'];
        $this->admin  = @$data['admin'];
        $this->display  = @$data['display'];
    }
    
    public function setInputs( $inputs ) {
        $this->inputs = $inputs;
        return $this;
    }
    
    public function setInputFilter( InputFilterInterface $inputFilter )
    {
        throw new \Exception("Not used");
    }
    
    public function getInputFilter( )
    {
        $inputs = $this->inputs;
        if( !$this->inputFilter ) {
            $inputFilter = new InputFilter();

            if( in_array( 'nick', $inputs ) ) $inputFilter->add( array(
                'name'     => 'nick',
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
                            'max'      => 50,
                        ),
                    ),
                ),
            ));
            
            if( in_array( 'email', $inputs ) ) $inputFilter->add( array(
                'name'     => 'email',
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
                            'max'      => 50,
                        ),
                    ),
                    new \Zend\Validator\EmailAddress()
                ),
            ));
            
            if( in_array( 'heslo', $inputs ) ) $inputFilter->add( array(
                'name'     => 'heslo',
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
