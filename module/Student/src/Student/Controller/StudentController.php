<?php

namespace Student\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Student\Form\StudentForm;
use Student\Form\StudentMarksForm;
use Student\Entity\Student;


class StudentController extends AbstractActionController
{
    protected $_objectManager;
    public function indexAction()
    {
        $students = $this->getEntityManager()->getRepository('Student\Entity\Student')->findAll();
        return new ViewModel(array('students' => $students));
    }
    public function addAction()
    {
        //$students = $this->getEntityManager()->getRepository('Application\Entity\Student')->findAll();
        $student  = new Student();
        $form = new StudentForm($this->getEntityManager());
        
        $form->bind($student);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            
            //print_r($request->getPost());
            if ($form->isValid()) {
                
                //print_r($student);die;
                $this->getEntityManager()->persist($student);
                $this->getEntityManager()->flush(); 
                $this->FlashMessenger()->setNamespace(\Zend\Mvc\Controller\Plugin\FlashMessenger::NAMESPACE_INFO)
                        ->addMessage("Added");
                return $this->redirect()->toRoute('student');
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
        $student = $this->getEntityManager()->find('Student\Entity\Student', $id);;
        
        //$student  = new Student();
        $form = new StudentForm($this->getEntityManager());
        
        $form->bind($student);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            
            //print_r($request->getPost());
            if ($form->isValid()) {
                //print_r($student);die;
                $this->getEntityManager()->persist($student);
                $this->getEntityManager()->flush(); 
                $this->FlashMessenger()->setNamespace(\Zend\Mvc\Controller\Plugin\FlashMessenger::NAMESPACE_INFO)
                        ->addMessage("Added");
                return $this->redirect()->toRoute('student');
            } else {
                echo 'ddd';die;
                print_r($form->getInputFilter()->getMessages());
            }     
        }
        return new ViewModel(array('id' => $id, 'form' => $form));
    }
    public function marksAction()
    {
        //$form = new StudentMarksForm($this->getEntityManager());
        try
        {
            $form = $this->getServiceLocator()->get('FormElementManager')->get('Student\Form\StudentMarksForm');
            
        }
        catch(\Exception $e)
        {
            throw new \Exception($e);
        }    
        //$form = $this->getServiceLocator()->get('FormElementManager')->get('Student\Form\MarksFieldset');
        //var_dump(get_class($form));die;
        
        //$students = $this->getEntityManager()->getRepository('Student\Entity\Student')->findAll();
        return new ViewModel(array('form' => $form));
    }
    protected function getEntityManager()
    {
        if (!$this->_objectManager) {
            $this->_objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }

        return $this->_objectManager;
    }
}    