<?php

namespace App\Controllers;
use App\Models\UserModel;
use App\Models\ProfileMenuModel;
use App\Models\MenuModel;
use App\Models\OrderDetailModel;
use App\Models\ProductInModel;

class UserController extends BaseController
{
    public function index()  {
        return view('layout/login');        
    }

    public function register()  {
        return view('layout/register');
    }

    public function profile()  {
        $data['pageTitle'] = 'Profile';
        $data['menu'] = '';
        $session = session();
        if (!$session->has('dataUser')) {
            $data['dataUser'] = null;
        } else {
            $data['dataUser'] = array_values(session('dataUser'));
        }
        return view('view_menu/view_profile', $data);
    }

    public function doLogin() {
        helper(['form']);
        $rules = [
            "username" => [
                "label" => "Username", 
                "rules" => "required|min_length[3]|max_length[20]"
            ],
            "password" => [
                "label" => "Password", 
                "rules" => "required|min_length[3]|max_length[20]"
            ]
        ];

        if ($this->validate($rules)) {  
            $session = session();
            $userModel = new UserModel();

            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');
            
            try {
                $array = array('username' => $username);
                $dataUser = $userModel->where($array)->first();
                if ( $dataUser ) {
                    // if ( password_verify($password, $dataUser['password']) ) {
                        $profileMenu = new ProfileMenuModel();
                        $menuModel = new MenuModel();

                        $dataProfile = $profileMenu->where( array( 'id' => $dataUser['profile_id'] ) )->first();
                        $arrMenuID = explode(",",$dataProfile['menu_id']);
                        $profileMenu = [];
                        for ($i = 0; $i < count($arrMenuID); $i++) {
                            $tempMenu = $menuModel->where( array( 'id' => $arrMenuID[$i] ) )->first();
                            array_push($profileMenu, [
                                'menu_id' => $arrMenuID[$i],
                                'menu' => $tempMenu['menu'],
                                'url' => $tempMenu['url']
                            ]);
                        }
                        $ses_data = array ( [
                            'id' => $dataUser['id'],
                            'username' => $dataUser['username'],
                            'email' => $dataUser['email'],
                            'role' => $dataProfile['profile']
                        ] ) ;
                        $session->set('dataUser', $ses_data);
                        $session->set('profileMenu', $profileMenu);
                        if ( $dataProfile['profile'] == 'customer' ) {
                            return redirect()->to('/orderProduct');
                        } else if ( $dataProfile['profile'] == 'suplier' ) {
                            $orderDetailModel = new OrderDetailModel();
                            $order = $orderDetailModel->getTotalIncome();
                            $userModel = new UserModel();
                            $user = $userModel->getCountCustomer();
                            $productInModel = new ProductInModel();
                            $product = $productInModel->getCountProductIn();
                            $dashboard = array ( [
                                'income' => $order[0]->total_price,
                                'stockOut' => $order[0]->quantity,
                                'customer' => $user[0]->customer,
                                'stockIn' => $product[0]->product_in
                            ] ) ;
                            $session->set('dashboard', $dashboard);
                            return redirect()->to('/transactionSuplier');
                        } else if ( $dataProfile['profile'] == 'courier' ) {
                            return redirect()->to('/pickUpOrder');
                        }
                    // } else {
                    //     $session->setFlashdata('message', 'Invalid username / password');
                    //     return redirect()->to('/login');
                    // }
                } else {
                    $session->setFlashdata('message', 'User Not Found');
                    return redirect()->to('/login');
                }
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        } else {
            $data['validation'] = $this->validator;
            return view('layout/login');
        }
       
    }

    public function logout() {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }

    public function doRegister() {
        helper(['form']);
        $rules = [
            "email" => [
                "label" => "Email", 
                "rules" => "required|min_length[3]|max_length[20]|valid_email"
            ],
            "password" => [
                "label" => "Password", 
                "rules" => "required|min_length[3]|max_length[20]"
            ]
        ];

        if ($this->validate($rules)) {  
            $session = session();
            $userModel = new UserModel();
            $email = $this->request->getVar("email");
            $password = $this->request->getVar("password");
            $username = substr($email, 0, strpos($email, '@'));
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $data = [
                "username" => $username,
                "password" => $passwordHash,
                "email" => $email,
                "balance" => 100000
            ];
            try {
                $array = array(
                    'username' => $username
                );
                $dataUser = $userModel->where($array)->first();
                if ( $dataUser == null ) {
                    if ( $userModel->saveUser($data) ) {
                        $session->setFlashdata('message', 'Registration Success');
                        $session->setFlashdata('status', 'success');
                    } else {
                        $session->setFlashdata('message', 'Registration Failed');
                        $session->setFlashdata('status', 'failed');
                    }
                } else {
                    $session->setFlashdata('message', 'User already registerd');
                    $session->setFlashdata('status', 'failed');
                }
                return redirect()->to('/register');
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
          
        } else {
            $data['validation'] = $this->validator;
            return view('layout/register');
        }
    }

    public function updateProfile() {
        $email = $this->request->getVar('inp-profile-email');
        $oldPassword = $this->request->getVar('inp-profile-oldPassword');
        $newPassword = $this->request->getVar('inp-profile-newPassword');
        $dataUser = array_values(session("dataUser"));
        $session = session();

        if ( $oldPassword != $newPassword ) {
            $session->setFlashdata('message', 'Update profile failed. Password is not match');
            $session->setFlashdata('flag', 'danger');
            $session->setFlashdata('status', 'Failed!');
            return redirect()->to('/profile');
        }

        try {

            $userModel = new UserModel();
            $userModel->updateProfile($dataUser[0]["id"], $email, password_hash($newPassword, PASSWORD_DEFAULT));

            $session->setFlashdata('message', 'Update profile success.');
            $session->setFlashdata('flag', 'success');
            $session->setFlashdata('status', 'Success!');
            return redirect()->to('/profile');
            
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getUser() {
        $username = $this->request->getPost("username");
        $array = array( 'username' => $username );
        $userModel = new UserModel();
        return $this->response->setJSON([
            "object" => $userModel->where($array)->first()
        ]);
    }

}
