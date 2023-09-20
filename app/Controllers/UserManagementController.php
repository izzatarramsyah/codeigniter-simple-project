<?php

namespace App\Controllers;
use App\Models\UserModel;

class UserManagementController extends BaseController  {

    public function index()  {
        $data['pageTitle'] = 'User Management';
        $data['menu'] = 'userManagement';
        $session = session();
        if ($session->has('dataUser')) {
            $data['dataUser'] = array_values(session('dataUser'));
            $data["profileMenu"] = array_values(session("profileMenu"));
            $data["dashboard"] = array_values(session("dashboard"));
            return view('view_menu/view_user_management', $data);
        }
    }

    public function getListUser() {
        $userModel = new UserModel();
        return $this->response->setJSON([
            "object" => $userModel->getListUser()
        ]);
    }

    public function addUser(){
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $username = substr($email, 0, strpos($email, '@'));
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $role = $this->request->getPost('role');

        $userModel = new UserModel();
        $param = array(
            'username' => $username,
            'password' => $passwordHash,
            'email' => $email,
            'status' => 'ACTIVE',
            'profile_id' => $role
        );
        if ( $userModel->saveUser($param) ) {
            return $this->response->setJSON([
                'message' => 'Success Add New User'
            ]);
        } else {
            return $this->response->setJSON([
                'message' => 'Failed Add New User'
            ]);
        }
    }

    public function updateUser(){
        $id = $this->request->getPost('id');
        $email = $this->request->getPost('email');
        $username = substr($email, 0, strpos($email, '@'));
        $userModel = new UserModel();
        if ( $userModel->updateUser($id, $username, $email) ) {
            return $this->response->setJSON([
                'message' => 'Success Update Status User'
            ]);
        } else {
            return $this->response->setJSON([
                'message' => 'Failed Update Status User'
            ]);
        }
    }

    public function updateStatusUser(){
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');
        $userModel = new UserModel();
        if ( $userModel->updateStatusUser($id, $status) ) {
            return $this->response->setJSON([
                'message' => 'Success Update Status User to '. $status
            ]);
        } else {
            return $this->response->setJSON([
                'message' => 'Failed Update Status User'
            ]);
        }
    }

    public function deleteUser()  {
        $id = $this->request->getPost('id');
        try {
            $userModel = new UserModel();
            if ( $userModel->deleteUser($id) ) {
                return $this->response->setJSON([
                    'message' => 'Success Delete User'
                ]);
            } else {
                return $this->response->setJSON([
                    'message' => 'Failed Delete User'
                ]);
            }
        }catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

}