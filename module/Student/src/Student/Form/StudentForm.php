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
use Student\Entity\Student;
use Student\Validate\NoObjectExists;

class StudentForm extends Form implements InputFilterAwareInterface, ObjectManagerAwareInterface
{
	protected $inputFilter;
	protected $objectManager;
    public function setObjectManager(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }
    
    public function getObjectManager()
    {
        return $this->objectManager;
    }
    
	public function __construct($objectManager)
	{
		parent::__construct();
		$this->setObjectManager($objectManager);
		$this->setInputFilter($this->getInputFilter());
		$this->setHydrator(new DoctrineHydrator($objectManager, 'Student\Entity\Student'));
		//$this->setHydrator(new DoctrineHydrator($objectManager))->setObject(new Student());;
		
		$this->setAttribute('method', 'post');
		$this->add(array(
			'name' => 'id',
			'attributes' => array(
				'type'  => 'hidden',
			),
		));

        $this->add(array(
			'name' => 'studentId',
			'attributes' => array(
				'type'  => 'text',
			),
			'options' => array(
				'label'  => 'Student Id',
			),
		));

		$this->add(array(
			'name' => 'firstName',
			'attributes' => array(
				'type'  => 'text',
			),
			'options' => array(
				'label'  => 'First name',
			),
		));


		$this->add(array(
			'name' => 'lastName',
			'attributes' => array(
				'type'  => 'text',
			),
			'options' => array(
				'label'  => 'Last name',
			),
		));

		$this->add(array(
		    'type' => 'DoctrineModule\Form\Element\ObjectSelect',  
			'name' => 'class',
			'options' => array (
			    'label' => 'Class',
			    'object_manager' => $objectManager,
                'target_class'   => 'Student\Entity\SchoolClass',
                'property'       => 'name'
			),
			'attributes' => array(
                'required' => '*'
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
                'name' => 'studentId',
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
                            'max' => 20,
                        ),
                    ),
                    array(
                        //'name' => 'DoctrineModule\Validator\NoObjectExists',
                        'name' => 'Student\Validate\NoObjectExists',
                        'otherField' => 'class',
                        //'name' => new NoObjectExists(array('object_repository' => $this->getObjectManager(), 'fields' => array('studentId', 'class'))),
                        'options' => array(
                            'object_repository' => $this->getObjectManager()->getRepository('Student\Entity\Student'),
                            'fields' => array('studentId', 'class'),
                            //'fields' => 'name', <--- with one field it works fine
                            'messages' => array(
                                //'objectFound' => 'Custom text'
                            ),
                        )
                    )
                ),
                
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'firstName',
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
                'name' => 'lastName',
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
