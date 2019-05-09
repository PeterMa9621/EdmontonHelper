<?php


namespace User\Form;

use Zend\Form\Form;

class UserForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('user');

        $this->add([
           'name' => 'uid',
           'type' => 'text',
           'options' => [
               'label' => 'User Id',
           ],
        ]);

        $this->add([
            'name' => 'psw',
            'type' => 'text',
            'options' => [
                'label' => 'Password',
            ],
        ]);

        $this->add([
            'name' => 'email',
            'type' => 'text',
            'options' => [
                'label' => 'Email',
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
            ],
        ]);
    }
}