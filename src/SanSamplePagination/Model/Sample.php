<?php

namespace SanSamplePagination\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Sample implements InputFilterAwareInterface
{
    public $id;
    public $name;
    public $gender;
    public $hobby;
    public $email;
    public $birth;
    public $address;
    public $direction;
    
    protected $inputFilter;

    public function exchangeArray($data)
    {
        $this->id        = (isset($data['id'])) ? $data['id'] : null;
        $this->name      = (isset($data['name'])) ? $data['name'] : null;
        $this->gender    = (isset($data['gender'])) ? $data['gender'] : null;
        $this->hobby    = (isset($data['hobby'])) ? $data['hobby'] : null;     
        $this->email     = (isset($data['email'])) ? $data['email'] : null;
        $this->birth     = (isset($data['birth'])) ? $data['birth'] : null;
        $this->address   = (isset($data['address'])) ? $data['address'] : null;
        $this->direction = (isset($data['direction'])) ? $data['direction'] : null;
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    } 
    
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'name',
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
                            'min'      => 5,
                            'max'      => 255,
                        ),
                    ),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'gender',
                'validators' => array(
                    array(
                        'name'    => 'InArray',
                        'options' => array(
                            'haystack' => array(2,3),
                            'messages' => array(
                                'notInArray' => 'Please select your gender !'  
                            ),
                        ),
                    ),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'hobby',
                'required' => true
            )));
            
            $translator =  new \Zend\I18n\Translator\Translator();
            $translator->addTranslationFile('phparray', './module/SanSamplePagination/language/indonesia.php');
        
            $inputFilter->add($factory->createInput(array(
                'name'     => 'email',
                'validators' => array(
                    array(
                        'name'    => 'EmailAddress',
                        'options' => array(
                            'translator' => $translator
                        )
                    ),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'birth',
                'validators' => array(
                    array(
                        'name'    => 'Between',
                        'options' => array(
                            'min' => '1970-01-01',
                            'max' => date('Y-m-d')
                        ),
                    ),
                ),
            ))); 
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'address',
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
                            'min'      => 5,
                            'max'      => 255,
                        ),
                    ),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'direction',
                'required' => true  
            )));
             

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}