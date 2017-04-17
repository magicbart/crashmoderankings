<?php

namespace Score\Form;

 use Zend\Form\Form;
 use Zend\Form\Element\Select;
 use Zend\InputFilter\InputFilterProviderInterface;

 class ScoreSearchForm extends Form implements InputFilterProviderInterface
 {
     public function __construct(array $players, array $zones)
     {
         parent::__construct('scores');

         $this->add(array(
             'name' => 'player',
             'type' => 'Select',
         'allowEmpty' => true,
             'options' => array(
                 'label' => 'Player',
         		 'empty_option' => 'All',
         		 'value_options' => $players,
             ),
         ));
         $this->add(array(
             'name' => 'zone',
             'type' => 'Select',
         'allowEmpty' => true,
             'options' => array(
                 'label' => 'Zone',
         		 'empty_option' => 'All',
         		 'value_options' => $zones,
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
     
 public function getInputFilterSpecification() {
return array(
'player' => array(
'required' => false,
),
'zone' => array(
'required' => false,
)
);
}
 }