<?php


namespace User\Instagram\models;


use User\Instagram\lib\Database;
use User\Instagram\lib\Model;
use PDO;
use PDOException;

class User extends Model {

    private int $id;
    private array $posts;
    private string $profile;

    public function __construct(
        private string $username,
        private string $password
    )
    {
        parent::__construct();
        $this->posts = [];
        $this->profile = "";
        $this->id = -1;
    }

    public function save()
    {
        try {

            // ! TODO: validar si existe el usuario primero

            $hash = $this->getHashedPassword($this->password);
            $query = $this->prepare('INSERT INTO instagram.users (username, password, profile) VALUES (:username, :password, :profile)');
            $query->execute(
                [
                    'username' => $this->username,
                    'password' => $hash,
                    'profile'  => $this->profile
                ]
            );
            return true;
        } catch (PDOException $e){
            error_log($e->getMessage());
            return false;
        }
    }

    private function getHashedPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT, ['cost' => 10]);
    }

    public static function exists($username)
    {
        try {
            $db = new Database();
            $query = $db->connect()->prepare('SELECT username FROM instagram.users WHERE username = :username');
            $query->execute(['username'=>$username]);
            if ($query->rowCount()>0){
                return true;
            }else{
                return false;
            }
        }catch (PDOException $e){
            error_log($e->getMessage());
            return false;
        }
    }

    public static function getUser($username): ?user
    {
        try {
            $db = new Database();
            $query = $db->connect()->prepare('SELECT * FROM instagram.users WHERE username = :username');
            $query->execute(['username'=>$username]);

            $data = $query->fetch(PDO::FETCH_ASSOC);

            $user = new User($data['username'], $data['password']);
            $user->setId($data['user_id']);
            $user->setProfile($data['profile']);

            return $user;

        }catch (PDOException $e){
            error_log($e->getMessage());
            return null;
        }
    }

    public static function getById(string $user_id)
    {
        try {
            $db = new Database();
            $query = $db->connect()->prepare('SELECT * FROM instagram.users WHERE user_id = :user_id');
            $query->execute(['user_id'=>$user_id]);

            $data = $query->fetch(PDO::FETCH_ASSOC);

            $user = new User($data['username'], $data['password']);
            $user->setId($data['user_id']);
            $user->setProfile($data['profile']);

            return $user;

        }catch (PDOException $e){
            error_log($e->getMessage());
            return null;
        }
    }

    public function comparePassword(string $password):bool
    {
        return password_verify($password, $this->password);
    }

    public function publish(PostImage $post): bool
    {
        try {
            $query = $this->prepare("INSERT INTO instagram.posts (user_id, title, media) VALUES (:user_id, :title, :media)");
            $query->execute([
                'user_id' => $this->id,
                'title' => $post->getTitle(),
                'media' => $post->getImage()
            ]);
            return true;
        }catch (PDOException $e){
            return false;
        }
    }

    public function fetchPosts()
    {
        $this->posts = PostImage::getAll($this->id);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->id = $value;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($value)
    {
        return $this->username = $value;
    }

    public function getProfile()
    {
        return $this->profile;
    }

    public function setProfile($value)
    {
        $this->profile = $value;
    }

    public function getPosts()
    {
        return $this->posts;
    }

    public function setPosts($value)
    {
        $this->posts = $value;
    }
}