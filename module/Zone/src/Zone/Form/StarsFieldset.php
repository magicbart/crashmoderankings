<?php
namespace Zone\Form;

 use Zend\Form\Fieldset;
 use Zend\InputFilter\InputFilterProviderInterface;

 class StarsFieldset extends Fieldset implements InputFilterProviderInterface
 {
 	protected $stars;
     public function __construct($stars = array())
     {
         parent::__construct('stars');
         $this->stars = $stars;

         foreach ($stars as $nbstars => $score) {
         	$this->add(array(
             'name' => (string)$nbstars,
             'type' => 'Text',
             'options' => array(
                 'label' => (string)$nbstars,
             ),
         ));
         }
         $this->setLabel('Stars');
     }

     /**
      * @return array
      */
     public function getInputFilterSpecification()
     {
     	$filt = array(
             'name' => array(
                 'required' => true,
             ),
         );
         
         foreach ($this->stars as $nbstars => $score)	{
         	$filt[$nbstars] = array(
         		'required' => true,
				'validators'  => array(
					array('name' => 'Int'),
				),
         	);
         }
         return $filt;
     }
 }