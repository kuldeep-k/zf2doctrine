<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractActionController
{
    protected $failedLoginMessage = 'Problem Problem';
    public function indexAction()
    {
        return new ViewModel();
    }
    
    public function authAction()
    {
        $request = $this->getRequest();
		    
        //$form    = $this->getLoginForm();
        $data = $request->getPost();
        //$form->setData($request->getPost());
        
        $this->getRequest()->getPost()->set('identity', $data['identity']);
        $this->getRequest()->getPost()->set('credential', $data['credential']);

    
        $this->zfcUserAuthentication()->getAuthAdapter()->resetAdapters();
        $this->zfcUserAuthentication()->getAuthService()->clearIdentity();

        $adapter = $this->zfcUserAuthentication()->getAuthAdapter();
        //$adapter->setIdentity($data['username'])->setCredential($data['password']);
        $adapter->prepareForAuthentication($this->getRequest());
        //$this->getRequest()->getPost()->set('identity',$data['identity']);
        //$this->getRequest()->getPost()->set('credential',$data['credential']);
        $auth = $this->zfcUserAuthentication()->getAuthService()->authenticate($adapter);

        if (!$auth->isValid()) {
            //$this->flashMessenger()->setNamespace('zfcuser-login-form')->addMessage($this->failedLoginMessage);
            $adapter->resetAdapters();
            /*return new JsonModel(array(
                'data' => $this->failedLoginMessage.'jirrr',
            ));*/
            $response_data = array(
                'status' => $this->failedLoginMessage.'jirrr'
            ) ;
        }
        
        $response_data = array(
                'status' => 'OK'
            ) ;

        $response = $this->getResponse();
        $response->setStatusCode(200);
        $response->setContent(json_encode($response_data));
        return $response;

        /*$this->setTerminal(true);
        return new JsonModel(array(
            'data' => 'OK',
        ));*/
    }
}
