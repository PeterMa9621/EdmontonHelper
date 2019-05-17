<?php


namespace Blog\Controller;


use Blog\Form\PostForm;
use Blog\Model\Post;
use Blog\Model\PostCommandInterface;
use Blog\Model\PostRepositoryInterface;
use InvalidArgumentException;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class WriteController extends AbstractActionController
{
    private $command;
    private $form;
    private $repository;

    public function __construct(PostCommandInterface $command, PostForm $form, PostRepositoryInterface $repository){
        $this->command = $command;
        $this->form = $form;
        $this->repository = $repository;
    }

    public function addAction(){
        $request = $this->getRequest();
        $viewModel = new ViewModel(['form' => $this->form]);

        if(! $request->isPost()){
            return $viewModel;
        }

        $data = $request->getPost();
        $this->form->setData($data);

        if(!$this->form->isValid()){
            return $viewModel;
        }

        $post = $this->form->getData();

        try{
            $post = $this->command->insertPost($post);
        } catch (\Exception $e){
            throw $e;
        }

        return $this->redirect()->toRoute('blog/detail', ['id' => $post->getId()]);
    }

    public function editAction(){
        $id = $this->params()->fromRoute('id', null);

        if(!$id){
            return $this->redirect()->toRoute('blog');
        }

        try{
            $post = $this->repository->findPost($id);
        } catch (InvalidArgumentException $e){
            return $this->redirect()->toRoute('blog');
        }

        $this->form->bind($post);
        $viewModel = new ViewModel(['form' => $this->form]);

        $request = $this->getRequest();
        if(! $request->isPost()){
            return $viewModel;
        }

        $data = $request->getPost();
        $this->form->setData($data);

        if($this->form->isValid()){
            $post = $this->form->getData();
            $this->command->updatePost($post);
            return $this->redirect()->toRoute('blog/detail', ['id' => $post->getId()]);
        }

        return $viewModel;
    }
}