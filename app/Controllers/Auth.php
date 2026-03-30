<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {
        return view('login');
    }

    public function login()
    {
        $session = session();
        $db = \Config\Database::connect();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $db->table('users')->where('username', $username)->get()->getRow();

        if ($user && password_verify($password, $user->password)) {
            $session->set([
                'user_id' => $user->id,
                'username' => $user->username,
                'role' => $user->role,
                'company_id' => $user->company_id,
                'isLoggedIn' => true
            ]);
            return redirect()->to('/dashboard');
        }
        return redirect()->back()->with('error', 'Login Gagal!');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}