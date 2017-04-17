<?php

namespace Country\Form;

 use Zend\Form\Form;
 use Zend\Form\Element\Select;

 class CountryForm extends Form
 {
     public function __construct()
     {
         parent::__construct('country');

         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
         $this->add(array(
             'name' => 'name',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Name',
             ),
         ));
         
         $this->add(array(
         	'name' => 'abr',
         	'type' => 'Text',
         	'options' => array(
                     'label' => 'Olympics norm (3 letters)',
             )
         ));
         
         $this->add(array(
             'name' => 'iso',
             'type' => 'Text',
             'options' => array(
                 'label' => 'ISO norm (2 letters)',
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