<?php

namespace User\Instagram\models;

use PDO;
use PDOException;
use User\Instagram\lib\Database;
use User\Instagram\lib\Model;

class Post extends Model
{

    private int $id;
    private array $likes;
    private User $user;

    protected function __construct(private string $title)
    {
        parent::__construct();
        $this->likes = [];
    }

    public function getId():string
    {
        return $this->id;
    }

    public function setId(string $id)
    {
        $this->id = $id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getLikes()
    {
        return count($this->likes);
    }

    public function fetchLikes(){
        $items = [];

        try {
            $query = $this->prepare("SELECT * FROM instagram.likes WHERE post_id = :post_id");
            $query->execute(['post_id' => $this->id]);

            while ($p = $query->fetch(PDO::FETCH_ASSOC)){
                $item = new Like($p['post_id'], $p['user_id']);
                $item->setId($p['id']);

                array_push($items, $item);
            }
            $this->likes = $items;
//            return $items;
        }catch (PDOException $e){
            echo $e;
        }
    }

    public function addLike(User $user)
    {
        // TODO: CHECK FIRST IF USER HAS SET LIKE BEFORE, IF SO, DELETE LIKE GIVEN.

        $like = new Like($this->id, $user->getId());
        $like->save();
        array_push($this->likes, $like);
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }
}