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

class SchoolClassForm extends Form implements InputFilterAwareInterface, ObjectManagerAwareInterface
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
		//echo 'd'; 
        $this->setInputFilter($this->getInputFilter());
				
		$this->setHydrator(new DoctrineHydrator($objectManager, 'Student\Entity\SchoolClass'));
		//$this->setHydrator(new DoctrineHydrator($objectManager))->setObject(new Student());;
		
		$this->setAttribute('method', 'post');
		$this->add(array(
			'name' => 'id',
			'attributes' => array(
				'type'  => 'hidden',
			),
		));


		$this->add(array(
			'name' => 'name',
			'attributes' => array(
				'type'  => 'text',
			),
			'options' => array(
				'label'  => 'Name',
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
                    array(
                        'name' => 'DoctrineModule\Validator\NoObjectExists',
                        'options' => array(
                            'object_repository' => $this->objectManager->getRepository('Student\Entity\SchoolClass'),
                            'fields' => 'name',
                            'message' => 'duplicate class name'
                        ),
                    )
                ),
            )));
    
            $this->inputFilter = $inputFilter;
        }
    
        return $this->inputFilter;
    }

}
