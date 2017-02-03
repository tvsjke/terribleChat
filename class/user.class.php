<?php

class USER
{
    private $model;

    function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function register($name, $email, $pass)
    {
        $this->model->userAdd($name, $email, $pass);
    }

    public function login($name, $pass)
    {
        if($user_id = $this->model->userLogin($name, $pass)) {
            $_SESSION['user_session'] = $user_id;
            return true;
        }
        return false;
    }

    public function is_logged()
    {
        if(isset($_SESSION['user_session']))
        {
            return true;
        }
    }

    public function redirect($url)
    {
        header("Location: $url");
    }

    public function logout()
    {
        session_destroy();
        unset($_SESSION['user_session']);
        return true;
    }
}
?>