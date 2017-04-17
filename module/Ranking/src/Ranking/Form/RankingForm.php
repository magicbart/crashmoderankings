<?php

namespace Ranking\Form;

 use Zend\Form\Form;
 use Zend\Form\Element\Select;

 class RankingForm extends Form
 {
     public function __construct()
     {
         parent::__construct('rankings');

         $limits = array(
         	'10' => '10',
         	'25' => '25',
         	'50' => '50',
         	/*'100' => '100',
         	'150' => '150',
         	'1000' => 'All',*/
         );
         
         $this->add(array(
             'name' => 'limit',
             'type' => 'Select',
             'options' => array(
                 'label' => 'Display Until',
         		 'value_options' => $limits,
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