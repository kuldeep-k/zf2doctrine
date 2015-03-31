<?php

namespace Student\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class StudentController extends AbstractActionController
{
    protected $_objectManager;
    public function indexAction()
    {
        $students = $this->getObjectManager()->getRepository('Student\Entity\Student')->findAll();
        return new ViewModel(array('students' => $students));
    }
    public function addAction()
    {
        //$students = $this->getObjectManager()->getRepository('Application\Entity\Student')->findAll();
        return new ViewModel();
    }
    protected function getObjectManager()
    {
        if (!$this->_objectManager) {
            $this->_objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }

        return $this->_objectManager;
    }
}    