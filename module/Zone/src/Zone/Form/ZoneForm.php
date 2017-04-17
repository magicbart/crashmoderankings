<?php

namespace Zone\Form;

 use Zend\Form\Form;

 class ZoneForm extends Form
 {
     public function __construct(array $stars, $name = null)
     {
         // we want to ignore the name passed
         parent::__construct('zone');

         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
         $this->add(array(
             'name' => 'name',
             'type' => 'Hidden',
         ));
         $this->add(array(
             'name' => 'ps2',
             'type' => 'Hidden',
	     ));
		$this->add(array(
	             'name' => 'description',
	             'type' => 'Hidden',
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
             'type' => 'Zend\Form\Element\Checkbox',
             'name' => 'dmg_wr_known',
             'options' => array(
                     'label' => 'WR damage known',
                     'use_hidden_element' => true,
                     'checked_value' => 1,
                     'unchecked_value' => 0
             )
	     ));
		 $this->add(array(
        'name' => 'glitch',
        'type' => 'Zend\Form\Element\Radio',
        'options' => array(
            'label' => 'Glitch Type',
            'value_options' => array(
                'None' => 'None',
                'Glitch' => 'Glitch',
				'Sink' => 'Sink',
            ),
        ),
    ));
	$this->add(array(
             'name' => 'top25_channel',
             'type' => 'Text',
             'options' => array(
                 'label' => 'WCR Top25 Channel',
             ),
         ));
	$this->add(array(
             'name' => 'bestvids_channel',
             'type' => 'Text',
             'options' => array(
                 'label' => '10 Best Vids Channel',
             ),
         ));
	$this->add(array(
             'name' => 'forum',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Forum',
             ),
         ));

         $this->add(new StarsFieldset($stars));
         
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