<?php


namespace Blog\Model;

use RuntimeException;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Sql\Delete;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;

class ZendDbSqlCommand implements PostCommandInterface
{
    private $db;

    public function __construct(AdapterInterface $db){
        $this->db = $db;
    }

    /**
     * Persist a new post in the system.
     *
     * @param Post $post The post to insert; may or may not have an identifier.
     * @return Post The inserted post, with identifier.
     */
    public function insertPost(Post $post)
    {
        $title = $post->getTitle();
        $text = $post->getText();
        $insert = new Insert('posts');
        $insert->values([
            'title' => $title,
            'text' => $text,
        ]);

        $sql = new Sql($this->db);
        $statement = $sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();

        if(! $result instanceof ResultInterface){
            throw new RuntimeException(
                'Database error occurred during blog post insert operation'
            );
        }

        $id = $result->getGeneratedValue();
        return new Post($title, $text, $id);
    }

    /**
     * Update an existing post in the system.
     *
     * @param Post $post The post to update; must have an identifier.
     * @return Post The updated post.
     */
    public function updatePost(Post $post)
    {
        $id = $post->getId();
        if(! $id){
            throw new RuntimeException(
                'Cannot update post; missing identifier'
            );
        }
        $title = $post->getTitle();
        $text = $post->getText();

        $update = new Update('posts');
        $update->set([
            'title' => $title,
            'text' => $text,
        ]);
        $update->where(['id = ?' => $id]);

        $sql = new Sql($this->db);
        $statement = $sql->prepareStatementForSqlObject($update);
        $result = $statement->execute();

        if(! $result instanceof ResultInterface){
            throw new RuntimeException('
                Database error occurred during blog post update operation'
            );
        };

        return $post;
    }

    /**
     * Delete a post from the system.
     *
     * @param Post $post The post to delete.
     * @return bool
     */
    public function deletePost(Post $post)
    {
        $id = $post->getId();
        if(! $id){
            throw new RuntimeException(
                'Cannot delete post; missing identifier'
            );
        }

        $delete = new Delete('posts');
        $delete->where(['id = ?' => $id]);

        $sql = new Sql($this->db);
        $statement = $sql->prepareStatementForSqlObject($delete);
        $result = $statement->execute();

        if(! $result instanceof ResultInterface){
            return false;
        };

        return true;
    }
}