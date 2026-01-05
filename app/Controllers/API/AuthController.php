<?php

namespace App\Controllers\Api;
use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // REGISTER
    public function register()
    {
        $data = $this->request->getJSON(true);

        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        try {
            $this->userModel->insert($data);
            return $this->response->setJSON(['message' => 'Register berhasil']);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)
                                   ->setJSON(['message' => $e->getMessage()]);
        }
    }

    // LOGIN
    public function login()
    {
        $data = $this->request->getJSON(true);
        $user = $this->userModel->where('username', $data['username'])->first();

        if (!$user || !password_verify($data['password'], $user['password'])) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED)
                                   ->setJSON(['message' => 'Username atau password salah']);
        }

        return $this->response->setJSON([
            'message' => 'Login berhasil',
            'user' => [
                'id_user' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role']
            ]
        ]);
    }
}
