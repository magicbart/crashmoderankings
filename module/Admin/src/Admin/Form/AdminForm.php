<?php

namespace Admin\Form;

 use Zend\Form\Form;

 class AdminForm extends Form
 {
     public function __construct()
     {
         parent::__construct('admin');
         $this->setAttribute('method', 'post');
        $this->add(array(
             'name' => 'nickname',
             'type' => 'Text',
        	'options' => array(
        		'label' => 'Nickname',
        	),
         ));
         $this->add(array(
             'name' => 'password',
             'type' => 'password',
         	'options' => array(
        		'label' => 'Password',
        	),
	     ));
	     
	     
         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Go',
                 'id' => 'submitbutton',
             ),
         ));
     }
 }