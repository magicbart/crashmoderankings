<?php

namespace Score\Form;

 use Zend\Form\Form;
 use Zend\Form\Element\Select;

 class ScoreForm extends Form
 {
     public function __construct(array $players, array $cars, array $strats)
     {
         parent::__construct('score');

         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
         
         $this->add(array(
         	'name' => 'zone',
         	'type' => 'Hidden',
         ));
         
         $this->add(array(
             'name' => 'player',
             'type' => 'Select',
             'options' => array(
                 'label' => 'Player',
         		 'value_options' => $players,
             ),
         ));
         $this->add(array(
         	'name' => 'score',
         	'type' => 'Text',
         	'options' => array(
                     'label' => 'Score',
             )
         ));
         $this->add(array(
         	'name' => 'damage',
         	'type' => 'Text',
         	'options' => array(
                     'label' => 'Damage',
             )
         ));
         $this->add(array(
         	'name' => 'multi',
         	'type' => 'Text',
         	'options' => array(
                     'label' => 'Multi',
             )
         ));
         $this->add(array(
             'name' => 'strat',
             'type' => 'Select',
             'options' => array(
                 'label' => 'Strat',
         		 'empty_option' => 'Unknown',
         		 'value_options' => $strats,
             ),
         ));
         $this->add(array(
             'name' => 'car',
             'type' => 'Select',
             'options' => array(
                 'label' => 'Car',
         		 'value_options' => $cars,
             ),
         ));
         
         $this->add(array(
             'type' => 'Zend\Form\Element\Checkbox',
             'name' => 'emulator',
             'options' => array(
                     'label' => 'Emulator',
                     'use_hidden_element' => true,
                     'checked_value' => 1,
                     'unchecked_value' => 0
             )
	     ));
         
         $this->add(array(
             'type' => 'Zend\Form\Element\Checkbox',
             'name' => 'former_wr',
             'options' => array(
                     'label' => 'Former WR',
                     'use_hidden_element' => true,
                     'checked_value' => 1,
                     'unchecked_value' => 0
             )
	     ));
	     
	     $this->add(array(
	        'name' => 'proof_type',
	        'type' => 'Select',
	        'options' => array(
	            'label' => 'Proof Type',
	     		'empty_option' => 'None',
	            'value_options' => array(
					'Replay' => 'Replay',
	                'Pic' => 'Pic',
	                'XBL' => 'XBL',
					'Live' => 'Live',
					'Freeze' => 'Freeze',
	            ),
	        ),
	    ));
         $this->add(array(
             'name' => 'proof_link',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Proof Link',
             ),
         ));
         
	     $this->add(array(
	        'name' => 'platform',
	        'type' => 'Select',
	        'options' => array(
	            'label' => 'Platform',
	     		'empty_option' => 'Unknown',
	            'value_options' => array(
					'GC' => 'GC',
	                'Xbox' => 'Xbox',
	                'PS2' => 'PS2',
	            ),
	        ),
	    ));
         
	     $this->add(array(
	        'name' => 'version',
	        'type' => 'Select',
	        'options' => array(
	            'label' => 'Version',
	     		'empty_option' => 'Unknown',
	            'value_options' => array(
					'PAL' => 'PAL',
	                'NTSC' => 'NTSC',
	            ),
	        ),
	    ));
         
	     $this->add(array(
	        'name' => 'freq',
	        'type' => 'Select',
	        'options' => array(
	            'label' => 'Freq',
	     		'empty_option' => 'Unknown',
	            'value_options' => array(
					'50Hz' => '50Hz',
	                '60Hz' => '60Hz',
	            ),
	        ),
	    ));
         
	     $this->add(array(
	        'name' => 'glitch',
	        'type' => 'Select',
	        'options' => array(
	            'label' => 'Glitch Type',
	     		'empty_option' => 'Unknown',
	            'value_options' => array(
					'None' => 'None',
	                'Glitch' => 'Glitch',
	                'Sink' => 'Sink',
	                'Freeze' => 'Freeze',
	            ),
	        ),
	    ));
	    
		 $this->add(array(
		     'type' => 'Zend\Form\Element\Date',
		     'name' => 'realisation',
		     'options' => array(
		             'label' => 'Realisation Date (last day possible if inaccurate)',
		             'format' => 'Y-m-d'
		     ),
		     'attributes' => array(
		             'min' => '2002-01-01',
		             'step' => '1', // days; default step interval is 1 day
		     )
		 ));
		 
         $this->add(array(
             'name' => 'inaccurate',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Inaccurate date (text to be displayed if date not accurate, let empty if irrelevant)',
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