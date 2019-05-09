<?php


namespace User\Model;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;

class User implements InputFilterAwareInterface
{
    public $uid;
    public $psw;
    public $email;

    public $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->uid     = !empty($data['uid']) ? $data['uid'] : null;
        $this->psw = !empty($data['psw']) ? $data['psw'] : null;
        $this->email  = !empty($data['email']) ? $data['email'] : null;
    }

    public function getArrayCopy(){
        return [
            'uid' => $this->uid,
            'psw' => $this->psw,
            'email' => $this->email,
        ];
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        // TODO: Implement setInputFilter() method.
        throw new DomainException(sprintf('%s does not allow injection of an alternate input filter'), __CLASS__);
    }

    public function getInputFilter()
    {
        // TODO: Implement getInputFilter() method.
        if($this->inputFilter){
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'uid',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'psw',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 6,
                        'max' => 30,
                    ],
                ],
            ],
        ]);


        $inputFilter->add([
            'name' => 'email',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 6,
                        'max' => 30,
                    ],
                ],
            ],
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}