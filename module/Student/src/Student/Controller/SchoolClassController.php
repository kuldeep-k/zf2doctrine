<?php

namespace Student\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Student\Form\SchoolClassForm;
use Student\Entity\SchoolClass;


class SchoolClassController extends AbstractActionController
{
    protected $_objectManager;
    public function indexAction()
    {
        $classes = $this->getEntityManager()->getRepository('Student\Entity\SchoolClass')->findAll();
        return new ViewModel(array('classes' => $classes));
    }
    public function addAction()
    {
        //$students = $this->getEntityManager()->getRepository('Application\Entity\Student')->findAll();
        $class  = new SchoolClass();
        $form = new SchoolClassForm($this->getEntityManager());
        
        $form->bind($class);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            
            //print_r($request->getPost());
            if ($form->isValid()) {
                
                //print_r($student);die;
                $this->getEntityManager()->persist($class);
                $this->getEntityManager()->flush(); 
                $this->FlashMessenger()->setNamespace(\Zend\Mvc\Controller\Plugin\FlashMessenger::NAMESPACE_INFO)
                        ->addMessage("Added");
                return $this->redirect()->toRoute('schoolclass');
            } else {
                //echo 'ddd';
                print_r($form->getInputFilter()->getMessages());
            }     
        }
        return new ViewModel(array('form' => $form));
    }
    public function editAction()
    {
        $id = (int) $this->params('id', null);
        $class = $this->getEntityManager()->find('Student\Entity\SchoolClass', $id);;
        
        //$student  = new Student();
        $form = new SchoolClassForm($this->getEntityManager());
        
        $form->bind($class);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            
            //print_r($request->getPost());
            if ($form->isValid()) {
                //print_r($student);die;
                $this->getEntityManager()->persist($class);
                $this->getEntityManager()->flush(); 
                $this->FlashMessenger()->setNamespace(\Zend\Mvc\Controller\Plugin\FlashMessenger::NAMESPACE_INFO)
                        ->addMessage("Added");
                return $this->redirect()->toRoute('schoolclass');
            } else {
                echo 'ddd';die;
                print_r($form->getInputFilter()->getMessages());
            }     
        }
        return new ViewModel(array('id' => $id, 'form' => $form));
    }
    protected function getEntityManager()
    {
        if (!$this->_objectManager) {
            $this->_objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }

        return $this->_objectManager;
    }
}    