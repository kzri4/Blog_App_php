<?php

require_once __DIR__ . '/../common/functions.php';

$id = filter_input(INPUT_GET, 'id');

class Post
{
    private const IMAGE_ROOT_PATH = '/images/posts/';
    private const NO_IMAGE = 'no_image.png';

    private $id;
    private $category_id;
    private $title;
    private $body;
    private $image;
    private $comments_count;
    private $created_at;
    private $updated_at;

    public function __construct($params)
    {
        $this->id = $params['id'];
        $this->category_id = $params['category_id'];
        $this->user_id = $params['user_id'];
        $this->titile = $params['title'];
        $this->image = $params['body'];
        $this->image = $params['image'];
        $this->comments_count = $params['comments_count'];
        $this->created_at = $params['created_at'];
        $this->updated_at = $params['updated_at'];
    }

    public function getTitle()
    {
        return $this->title;
    }
    
    public function getBody()
    {
        return $this->body;
    }

    public function getImagePath()
    {
        if (empty($this->image)) {
            return self::IMAGE_ROOT_PATH . self::NO_IMAGE;
        } else {
            return self::IMAGE_ROOT_PATH . $this->image;
        }
    }

    public function getCommnets_count()
    {
        return $this->comments_count;
    }

    public function getCreatedAt() 
    {
        return $this->created_at;
    }

    public static function findWithUser($id)
    {
        return self::findById($id);
    }

    public static function findById($id)
    {
        $instance = [];
        try {
            $dbh = connectDb();

            $sql = 'SELECT * FROM posts WHERE id = :id';
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $post = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($post) {
                $instance = new static($post);
            }
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }
        return $instance;
    }
}