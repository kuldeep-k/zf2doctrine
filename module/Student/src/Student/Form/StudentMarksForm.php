<?php 

namespace Student\Form;

use Zend\Form\Form;
use Zend\InputFilter\Factory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Factory as InputFactory;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Student\Entity\Subject;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class StudentMarksForm extends Form implements InputFilterAwareInterface, ObjectManagerAwareInterface
{
	protected $inputFilter;
	protected $objectManager;
	protected $service_manager;

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->service_manager = $serviceLocator;
    }

    public function getServiceLocator()
    {
        return $this->service_manager;
    }
    public function setObjectManager(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }
    
    public function getObjectManager()
    {
        return $this->objectManager;
    }
    
	public function init()
	{
		//parent::__construct();
		$this->setInputFilter($this->getInputFilter());
		$this->setHydrator(new DoctrineHydrator($this->getObjectManager(), 'Student\Entity\Subject'));
		//$this->setHydrator(new DoctrineHydrator($objectManager))->setObject(new Student());;
		
		$this->setAttribute('method', 'post');
		//echo get_class($this->getServiceLocator()->get('Student\Form\MarksFieldset'));die;
//		echo get_class($this->getServiceLocator()->get('Student\Form\MarksFieldset'));die;
		
		$this->add(array(
             'type' => 'Zend\Form\Element\Collection',
             'name' => 'marks',
             'options' => array(
                 'label' => 'Please choose marks for this subjects',
                 'count' => 5,
                 'should_create_template' => true,
                 'allow_add' => true,
                 'target_element' => array(
                     //'type' => $this->getServiceLocator()->get('FormElementManager')->get('Student\Form\MarksFieldset'),
                     //'type' => $this->getServiceLocator()->get('Student\Form\MarksFieldset'),
                     'type' => 'Student\Form\MarksFieldset',
                 ),
             ),
         ));
		$this->add(array(
			'name' => 'submit',
			'attributes' => array(
				'type'  => 'submit',
				'value'  => 'Save',
				'id'  => 'submit',
			),
		));
	}
	
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
    
            $factory = new InputFactory();
    
            $inputFilter->add($factory->createInput(array(
                'name' => 'name',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 2,
                            'max' => 255,
                        ),
                    ),
                ),
            )));
            $inputFilter->add($factory->createInput(array(
                'name' => 'description',
                'required' => false,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 2,
                            'max' => 255,
                        ),
                    ),
                ),
            )));
            $inputFilter->add($factory->createInput(array(
                'name' => 'class',
                'required' => true,
                /*'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 2,
                            'max' => 255,
                        ),
                    ),
                ),*/
            )));    
    
    
            $this->inputFilter = $inputFilter;
        }
    
        return $this->inputFilter;
    }

}
