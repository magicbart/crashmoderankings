<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Form\AdminForm;
use Zend\Session\Container;

 class AdminController extends AbstractActionController	{
	 
	 public function indexAction()	{
	 	$userContainer = new Container('user');
	 	if($userContainer->offsetExists('admin')&&$userContainer->offsetGet('admin'))
	 		return new ViewModel();
	 	return $this->redirect()->toRoute('homeadmin', array('action' => 'login'));
	 }
	 

     public function loginAction()	{
         $form  = new AdminForm();
         $form->get('submit')->setValue('Login');
         $request = $this->getRequest();
         if ($request->isPost()) {
             $form->setData($request->getPost());
             if ($form->isValid()) {
             	if (md5($form->get('password')->getValue())=='ec5b16728ffe9ac20c79df06930cd532')	{
             		$userContainer = new Container('user');
             		$userContainer->admin = true;
              		return $this->redirect()->toRoute('homeadmin');
             	}
             }
         }
         return array(
             'form' => $form,
         );
     }
 }