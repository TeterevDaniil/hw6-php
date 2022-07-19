<?php

namespace APP\Controller;

use App\Model\Eloquent\Message;
use App\Model\Eloquent\User;
use Base\AbstractController;
use Base\Helper;
use Base\View;

class Admin extends AbstractController
{
    public function deleteMessageAction()
    {
        $this->view->setRenderType(View::RENDER_TYPE_NATIVE);
        if (!$this->user && !$this->user->isAdmin()) {
            $this->redirect('/user/blog');
        }
        $messageId = $_GET['id'];
        Message::deleteMessage($messageId);
        $this->redirect('/blog');
    }

    public function indexAction()
    { 
        $this->view->setRenderType(View::RENDER_TYPE_NATIVE);
        return $this->view->render(
            'admin/users.phtml',
            [
                'users' => User::getList(),
                'user' => $this->user
            ]
        );
    }

    public function saveUserAction()
    {
        $success = true;
        $id = trim($_POST['id']);
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $helper = new Helper();
        $password = trim($_POST['password']);

        $userCheck = User::getById($id);
        if (!$userCheck) {
            return $this->response(['error' => 'no user']);
        }
        if ($password && mb_strlen($password) <= 4) {
            return $this->response(['error' => 'too short password']);
            $success = false;
        }

        $password = $helper->hashPassword($password);
        if (!$name) {
            return $this->response(['error' => 'no name']);
            $success = false;
        }

        if (!$email) {
            return $this->response(['error' => 'no email']);
            $success = false;
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return $this->response(['error' => 'not a email']);
            $success = false;
        }

        if ($email) {
            $userEmail =  User::getByEmail($email);
            if ($userEmail && $userEmail->id != $id) {
                return $this->response(['error' => 'email busy']);
            }
        }

         if ($success == true) {
            $userCheck->name = $name;
            $userCheck->email = $email;
            if ($password) {
                $userCheck->password = $password;
            }
            $userCheck->save();
            return $this->response(['result' => 'Ok']);
        }
    }

    public function deleteUserAction()
    {
        $success = true;
        $id = trim($_POST['id']);
        $userCheck = User::getById($id);
        if (!$userCheck) {
            return $this->response(['error' => 'no user']);
        }
        $userCheck->delete();
        return $this->response(['result' => 'Ok']);
    }


    public function addUserAction()
    {
        $success = true;

        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $helper = new Helper();
        $password = trim($_POST['password']);


        if (!$password || mb_strlen($password) <= 4) {
            return $this->response(['error' => 'too short password']);
            $success = false;
        }

        $password = $helper->hashPassword($password);
        if (!$name) {
            return $this->response(['error' => 'no name']);
            $success = false;
        }

        if (!$email) {
            return $this->response(['error' => 'no email']);
            $success = false;
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return $this->response(['error' => 'not a email']);
            $success = false;
        }
        if ($email) {
            $userEmail = User::getByEmail($email);
            if ($userEmail) {
                return $this->response(['error' => 'email busy']);
                $success = false;
            }
        }

        if ($success == true) {
            $userData = [
                'name' => $name,
                'password' => $password,
                'email' => $email,
            ];
            $user = new User($userData);
            $user->save();
            return $this->response(['result' => 'Ok']);
        }
    }


    public function response(array $data)
    {
        header('Content-type: application/json');
        return json_encode($data);
    }
}
