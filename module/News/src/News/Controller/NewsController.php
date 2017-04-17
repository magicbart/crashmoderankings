<?php

namespace News\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use News\Model\News;
 use News\Form\NewsForm;

 class NewsController extends AbstractActionController
 {
 protected $newsTable;
	 
     public function indexAction()
     {
     	$paginator = $this->getNewsTable()->fetchAll(true);
     	$paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
     	$paginator->setItemCountPerPage(15);
		return new ViewModel(array(
             'news' => $paginator,
         ));
     }
	 
	 	public function getNewsTable()
     {
         if (!$this->newsTable) {
             $sm = $this->getServiceLocator();
             $this->newsTable = $sm->get('News\Model\NewsTable');
         }
         return $this->newsTable;
     }
 }