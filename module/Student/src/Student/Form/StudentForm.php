<?php 

namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\Factory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;

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
    
	public function __construct($name=null)
	{
		parent::__construct('user');
		$this->setAttribute('method', 'post');
		$this->add(array(
			'name' => 'id',
			'attributes' => array(
				'type'  => 'hidden',
			),
		));


		$this->add(array(
			'name' => 'first_name',
			'attributes' => array(
				'type'  => 'text',
			),
			'options' => array(
				'label'  => 'First name',
			),
		));


		$this->add(array(
			'name' => 'last_name',
			'attributes' => array(
				'type'  => 'text',
			),
			'options' => array(
				'label'  => 'Last name',
			),
		));

		/*$this->add(array(
		    'type' => 'DoctrineModule\Form\Element\ObjectMultiCheckbox',  
			'name' => 'groups',
			'option' => array (
			     'label' => 'Groups',
			     'object_manager' => $this->getObjectManager(),
                'target_class'   => 'Application\Entity\Group',
                'property'       => 'name'
			),
			'attributes' => array(
				'type'  => 'submit',
				'value'  => 'Save',
				'id'  => 'submit',
			),
		));
		*/
		$this->add(array(
			'name' => 'submit',
			'attributes' => array(
				'type'  => 'submit',
				'value'  => 'Save',
				'id'  => 'submit',
			),
		));
	}

}
