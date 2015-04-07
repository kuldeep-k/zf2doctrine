<?php

namespace Student\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Student\Form\SubjectForm;
use Student\Entity\Subject;


class SubjectController extends AbstractActionController
{
    protected $_objectManager;
    public function indexAction()
    {
        $subjects = $this->getEntityManager()->getRepository('Student\Entity\Subject')->findAll();
        return new ViewModel(array('subjects' => $subjects));
    }
    public function addAction()
    {
        //$students = $this->getEntityManager()->getRepository('Application\Entity\Student')->findAll();
        $subject  = new Subject();
        $form = new SubjectForm($this->getEntityManager());
        
        $form->bind($subject);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                
                $this->getEntityManager()->persist($subject);
                $this->getEntityManager()->flush(); 
                $this->FlashMessenger()->setNamespace(\Zend\Mvc\Controller\Plugin\FlashMessenger::NAMESPACE_INFO)
                        ->addMessage("Added");
                return $this->redirect()->toRoute('subject');
            } else {
                print_r($form->getInputFilter()->getMessages());
            }     
        }
        return new ViewModel(array('form' => $form));
    }
    public function editAction()
    {
        $id = (int) $this->params('id', null);
        $subject = $this->getEntityManager()->find('Student\Entity\Subject', $id);;
        
        //$student  = new Student();
        $form = new SubjectForm($this->getEntityManager());
        
        $form->bind($subject);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            
            print_r($request->getPost());
            if ($form->isValid()) {
                //print_r($student);die;
                $this->getEntityManager()->persist($subject);
                $this->getEntityManager()->flush(); 
                $this->FlashMessenger()->setNamespace(\Zend\Mvc\Controller\Plugin\FlashMessenger::NAMESPACE_INFO)
                        ->addMessage("Added");
                return $this->redirect()->toRoute('subject');
            } else {
                echo 'ddd';
                print_r($form->getInputFilter()->getMessages());die;
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