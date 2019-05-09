<?php


namespace User\Controller;

use User\Form\UserForm;
use User\Model\User;
use User\Model\UserTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController
{
    private $table;

    public function __construct(UserTable $table){
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel([
            'users' => $this->table->fetchAll(),
        ]);
    }

    public function addAction(){
        $form = new UserForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if(!$request->isPost()){
            return ['form' => $form];
        }

        $user = new User();
        $form->setInputFilter($user->getInputFilter());
        $form->setData($request->getPost());

        if(! $form->isValid()){
            return ['form' => $form];
        }

        $user->exchangeArray($form->getData());
        $this->table->saveUser($user);

        return $this->redirect()->toRoute('user');
    }

    public function editAction(){
        $uid = $this->params()->fromRoute('uid', "");

        if($uid==""){
            return $this->redirect()->toRoute('user', ['action' => 'add']);
        }

        try{
            $user = $this->table->getUser($uid);
        } catch (\RuntimeException $e){
            return $this->redirect()->toRoute('user', ['action' => 'index']);
        }

        $form = new UserForm();
        $form->bind($user);
        $form->get('submit')->setValue('Edit');

        $request = $this->getRequest();

        if(!$request->isPost()){
            return ['uid' => $uid, 'form' => $form];
        }

        $form->setInputFilter($user->getInputFilter());
        $form->setData($request->getPost());

        if(!$form->isValid()){
            return ['uid' => $uid, 'form' => $form];
        }

        $this->table->saveUser($user);

        return $this->redirect()->toRoute('user');
    }

    public function deleteAction(){
        $uid = $this->params()->fromRoute('uid', "");

        if($uid==""){
            return $this->redirect()->toRoute('user');
        }

        $request = $this->getRequest();
        if(!$request->isPost()){
            return ['uid' => $uid, 'user' => $this->table->getUser($uid)];
        }

        $delete = $request->getPost('delete', 'No');
        if($delete=='Yes'){
            $uid = $request->getPost('uid');
            $this->table->deleteUser($uid);
        }

        return $this->redirect()->toRoute('user');
    }
}