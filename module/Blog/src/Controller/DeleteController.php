<?php


namespace Blog\Controller;


use Blog\Model\PostCommandInterface;
use Blog\Model\PostRepositoryInterface;
use InvalidArgumentException;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class DeleteController extends AbstractActionController
{
    private $repository;
    private $command;

    public function __construct(PostRepositoryInterface $repository, PostCommandInterface $command){
        $this->repository = $repository;
        $this->command = $command;
    }

    public function deleteAction(){
        $id = $this->params()->fromRoute('id', null);

        if(! $id){
            return $this->redirect()->toRoute('blog');
        }

        try{
            $post = $this->repository->findPost($id);
        } catch (InvalidArgumentException $e){
            return $this->redirect()->toRoute('blog');
        }

        $request = $this->getRequest();

        if(! $request->isPost()){
            return new ViewModel(['post' => $post]);
        }

        // Usage: getPost(       X,         Y   )
        //                     index     default
        // $request->getPost('confirm', 'Cancel')
        if($id != $request->getPost('id') || 'Delete' !== $request->getPost('confirm', 'Cancel')){
            return $this->redirect()->toRoute('blog');
        }

        $post = $this->command->deletePost($post);
        return $this->redirect()->toRoute('blog');
    }
}