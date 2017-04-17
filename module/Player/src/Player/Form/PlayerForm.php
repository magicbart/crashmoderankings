<?php

namespace Player\Form;

 use Zend\Form\Form;
 use Zend\Form\Element\Select;

 class PlayerForm extends Form
 {
     public function __construct($countries)
     {
         parent::__construct('player');
         $this->setAttribute('method', 'post');

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
         	'name' => 'country',
         	'type' => 'Select',
         	'options' => array(
                     'label' => 'Country',
                     'value_options' => $countries,
             )
         ));
         $this->add(array(
             'name' => 'notes',
             'type' => 'TextArea',
             'options' => array(
                 'label' => 'Notes',
             ),
         ));
         $this->add(array(
             'name' => 'wcr_channel',
             'type' => 'Text',
             'options' => array(
                 'label' => 'WCR Channel',
             ),
         ));
         $this->add(array(
             'name' => 'personnal_channel',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Personnal Channel',
             ),
         ));
         
         $this->add(array(
             'type' => 'Zend\Form\Element\Checkbox',
             'name' => 'xbl_total',
             'options' => array(
                     'label' => 'Total taken from XBL',
                     'use_hidden_element' => true,
                     'checked_value' => 1,
                     'unchecked_value' => 0
             )
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