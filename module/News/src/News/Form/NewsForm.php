<?php

namespace News\Form;

 use Zend\Form\Form;

 class NewsForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('news');

         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
         $this->add(array(
             'name' => 'content',
             'type' => 'TextArea',
             'options' => array(
                 'label' => 'Content',
             ),
             'attributes' => array(
             	 'class' => 'form-group form-control',
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