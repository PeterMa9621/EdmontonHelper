<?php


namespace Blog\Model;


use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Sql;

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
        // TODO: Implement updatePost() method.
    }

    /**
     * Delete a post from the system.
     *
     * @param Post $post The post to delete.
     * @return bool
     */
    public function deletePost(Post $post)
    {
        // TODO: Implement deletePost() method.
    }
}