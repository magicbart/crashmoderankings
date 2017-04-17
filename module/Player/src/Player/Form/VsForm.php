<?php

namespace Player\Form;

 use Zend\Form\Form;
 use Zend\Form\Element\Select;

 class VsForm extends Form
 {
     public function __construct(array $players)
     {
         parent::__construct('players');

         $this->add(array(
             'name' => 'player_1',
             'type' => 'Select',
             'options' => array(
         		 'value_options' => $players,
             ),
         ));
         $this->add(array(
             'name' => 'player_2',
             'type' => 'Select',
             'options' => array(
         		 'value_options' => $players,
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