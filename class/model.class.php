<?php
/**
 * Одна модель на всё
 */

class Model {

    private $db;

    public function __construct(Mysqldb $dbh){
        $this->db = $dbh;
    }

    public function getUser($id) {
        $this->db->query('SELECT * FROM users WHERE id=:id');
        $this->db->bind(':id', $id);
        $this->db->execute();

        return $this->db->single();
    }

    public function getPosts($start, $limit) {
        $this->db->query("SELECT * FROM posts ORDER BY id DESC LIMIT :start, :limit");
        $this->db->bind(':limit', (int)$limit);
        $this->db->bind(':start', (int)$start);
        $this->db->execute();

        $posts = $this->db->resultset();

        $res = [];

        foreach($posts as $post) {
            $this->db->query("SELECT * FROM users WHERE id = :id");
            $this->db->bind(':id', $post['id_user']);
            $this->db->execute();

            $user = $this->db->single();

            $post_temp = $post;
            $post_temp['author_name'] = $user['name'];

            if(isset($_SESSION['user_session'])) {
                $post_temp['is_own'] = $_SESSION['user_session'] == $post['id_user'] ? true:false;
            }

            $res[] = $post_temp;
        }

        return $res;
    }

    public function getPostsCount() {
        $this->db->query("SELECT * FROM posts");
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function userAdd($name, $email, $pass) {
        $new_password = password_hash($pass, PASSWORD_DEFAULT);

        $this->db->query("INSERT INTO users(name, email, pass, ip, browser) VALUES(:name, :mail, :pass, :ip, :browser)");

        $this->db->bind(":name", $name);
        $this->db->bind(":mail", $email);
        $this->db->bind(":pass", $new_password);
        $this->db->bind(":ip", $_SERVER['REMOTE_ADDR']);
        $this->db->bind(":browser", $_SERVER['HTTP_USER_AGENT']);
        $this->db->execute();
    }

    public function userLogin($name, $pass) {

        $this->db->query("SELECT * FROM users WHERE name=:name LIMIT 1");

        $this->db->bind(":name", $name);
        $this->db->execute();

        $user = $this->db->single();

        if($user) {
            if(password_verify($pass, $user['pass'])) {
                return $user['id'];
            }
        }

        return false;
    }

    public function userCheckIfNameAndEmailExist($name, $email) {
        $this->db->query("SELECT name, email FROM users WHERE name=:name or email=:mail");

        $this->db->bind(":name", $name);
        $this->db->bind(":mail", $email);
        $this->db->execute();

        return $this->db->single();
    }

    public function postAdd($msg, $homepage) {
        $this->db->query("INSERT INTO posts(homepage, post_text, id_user) VALUES(:homepage, :post_text, :id_user)");

        $this->db->bind(":homepage", $homepage);
        $this->db->bind(":post_text", $msg);
        $this->db->bind(":id_user", $_SESSION['user_session']);
        $this->db->execute();
    }

    public function postDelete($id) {
        $this->db->query("DELETE FROM posts WHERE id = :id");

        $this->db->bind(":id", $id);
        $this->db->execute();
    }

    public function postEdit($id, $msg, $homepage) {
        $this->db->query('UPDATE posts SET homepage = :homepage, post_text = :post_text WHERE id = :id');

        $this->db->bind(':homepage', $homepage);
        $this->db->bind(':post_text', $msg);
        $this->db->bind(':id', $id);
        $this->db->execute();
    }
}