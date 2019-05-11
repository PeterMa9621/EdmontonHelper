<?php


namespace User\Model;


use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class UserTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway){
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll(){
        return $this->tableGateway->select();
    }

    public function getUser($uid){
        $rowset = $this->tableGateway->select(['uid' => $uid]);
        $row = $rowset->current();
        if(!$row){
            throw new RuntimeException(sprintf('Could not find the user with id %d', $uid));
        }
        return $row;
    }

    public function saveUser(User $user){
        $data = [
            'uid' => $user->uid,
            'psw' => $user->psw,
            'email' => $user->email,
        ];

        $uid = $user->uid;

        if($user->uid==""){
            throw new RuntimeException(sprintf('Uid cannot be empty!'));
        }

        // Try to get the user first, if no such user, then insert this user
        try{
            $this->getUser($uid);
        } catch (RuntimeException $e){
            $this->tableGateway->insert($data);
            return;
        }

        // Remove the value based on key 'id'
        unset($data['id']);
        $this->tableGateway->update($data, ['uid' => $uid]);
    }

    public function deleteUser($uid){
        $this->tableGateway->delete(['uid' => $uid]);
    }
}