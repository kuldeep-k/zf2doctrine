<?php

namespace Student;

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'student' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/student[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Student\Controller\Student',
                        'action'     => 'index',
                    ),
                ),
            ),
            'schoolclass' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/schoolclass[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Student\Controller\SchoolClass',
                        'action'     => 'index',
                    ),
                ),
            ),
            'subject' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/subject[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Student\Controller\Subject',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
    
    ),
    'form_elements' => array(
        'factories' => array(
            'Student\Form\MarksFieldset' => function($sm) {
                
                $form = new Form\MarksFieldset();//$sm->getServiceLocator()->get('Doctrine\ORM\EntityManager'));
               
                $form->setObjectManager($sm->getServiceLocator()->get('Doctrine\ORM\EntityManager'));
                
               //$form->setInputFilter(new Form\PropertyFilter($sm->get('Doctrine\ORM\EntityManager')));
               //$form->setHydrator(new DoctrineHydrator($sm->get('Doctrine\ORM\EntityManager'), 'Property\Entity\Property'));
               return $form;
             },
             'Student\Form\StudentMarksForm' => function($sm) {
                 
                $form = new Form\StudentMarksForm();
                $form->setObjectManager($sm->getServiceLocator()->get('Doctrine\ORM\EntityManager'));
                $form->setServiceLocator($sm);
                //$form->setInputFilter(new Form\PropertyFilter($sm->get('Doctrine\ORM\EntityManager')));
                //$form->setHydrator(new DoctrineHydrator($sm->get('Doctrine\ORM\EntityManager'), 'Property\Entity\Property'));
                return $form;
             },
         ),
    ),
    
    'controllers' => array(
        'invokables' => array(
            'Student\Controller\Student' => 'Student\Controller\StudentController',
            'Student\Controller\Subject' => 'Student\Controller\SubjectController',
            'Student\Controller\SchoolClass' => 'Student\Controller\SchoolClassController',
            
        ),
    ),
     
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            //'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/student/index/index.phtml',
            //'error/404'               => __DIR__ . '/../view/error/404.phtml',
            //'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
	// Doctrine config
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    )
);
