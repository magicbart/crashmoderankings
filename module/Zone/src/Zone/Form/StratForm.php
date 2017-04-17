<?php

namespace Zone\Form;

 use Zend\Form\Form;

 class StratForm extends Form
 {
     public function __construct(array $zones, array $cars, $name = null)
     {
         // we want to ignore the name passed
         parent::__construct('strat');
         
         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
         
         $this->add(array(
             'name' => 'zone',
             'type' => 'Select',
             'options' => array(
                 'label' => 'Zone',
         		 'value_options' => $zones,
             ),
         ));
	     
         $this->add(array(
             'name' => 'name',
             'type' => 'Text',
         	 'options' => array(
	                 'label' => 'Name',
	         ),
         ));
	     
         $this->add(array(
             'name' => 'description',
             'type' => 'TextArea',
         	 'options' => array(
	                 'label' => 'Description',
	         ),
	         'attributes' => array(
             	 		'class' => 'form-group form-control',
         			),
         ));
         
         $this->add(array(
             'type' => 'Zend\Form\Element\Checkbox',
             'name' => 'hz50',
             'options' => array(
                     'label' => '50Hz',
                     'use_hidden_element' => true,
                     'checked_value' => 1,
                     'unchecked_value' => 0
             )
	     ));
         
         $this->add(array(
             'type' => 'Zend\Form\Element\Checkbox',
             'name' => 'hz60',
             'options' => array(
                     'label' => '60Hz',
                     'use_hidden_element' => true,
                     'checked_value' => 1,
                     'unchecked_value' => 0
             )
	     ));
         
         $this->add(array(
             'type' => 'Zend\Form\Element\Checkbox',
             'name' => 'gc',
             'options' => array(
                     'label' => 'GC',
                     'use_hidden_element' => true,
                     'checked_value' => 1,
                     'unchecked_value' => 0
             )
	     ));
         
         $this->add(array(
             'type' => 'Zend\Form\Element\Checkbox',
             'name' => 'xbox',
             'options' => array(
                     'label' => 'Xbox',
                     'use_hidden_element' => true,
                     'checked_value' => 1,
                     'unchecked_value' => 0
             )
	     ));
         
         $this->add(array(
             'type' => 'Zend\Form\Element\Checkbox',
             'name' => 'ps2',
             'options' => array(
                     'label' => 'PS2',
                     'use_hidden_element' => true,
                     'checked_value' => 1,
                     'unchecked_value' => 0
             )
	     ));
	     
		$this->add(array(
	             'name' => 'best_damage',
	             'type' => 'Text',
	             'options' => array(
	                 'label' => 'Best Damage',
	             ),
	         ));
		$this->add(array(
	             'name' => 'best_multi',
	             'type' => 'Text',
	             'options' => array(
	                 'label' => 'Best Multi',
	             ),
	         ));
		$this->add(array(
	             'name' => 'best_total',
	             'type' => 'Text',
	             'options' => array(
	                 'label' => 'Best Total',
	             ),
         ));
		 
         $this->add(array(
             'type' => 'Zend\Form\Element\MultiCheckbox',
             'name' => 'cars',
             'options' => array(
                     'label' => 'Cars',
                     'value_options' => $cars,
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