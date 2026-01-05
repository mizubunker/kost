<?php

namespace App\Controllers\Api;
use App\Controllers\BaseController;
use App\Models\VoteModel;
use CodeIgniter\HTTP\ResponseInterface;

class VoteController extends BaseController
{
    protected $voteModel;

    public function __construct()
    {
        $this->voteModel = new VoteModel();
    }

    // GET /vote
    public function index()
    {
        return $this->response->setJSON($this->voteModel->findAll());
    }

    // GET /vote/{id}
    public function show($id = null)
    {
        $data = $this->voteModel->where('id_kost', $id)->first();
        if (!$data) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                                   ->setJSON(['message' => 'Vote tidak ditemukan']);
        }
        return $this->response->setJSON($data);
    }

    // POST /vote
    public function create()
    {
        $data = $this->request->getJSON(true);
        $this->voteModel->insert($data);
        return $this->response->setJSON(['message' => 'Vote berhasil ditambahkan']);
    }

    // PUT /vote/{id}
    public function update($id = null)
    {
        $data = $this->request->getJSON(true);
        $this->voteModel->update($id, $data);
        return $this->response->setJSON(['message' => 'Riwayat berhasil diperbarui']);
    }

    // DELETE /vote/{id}
    public function delete($id = null)
    {
        $this->voteModel->where('id_kost', $id)->delete();
        return $this->response->setJSON(['message' => 'Vote berhasil dihapus']);
    }

    // GET /vote/user/{id}
    public function getByUser($id = null)
    {
        if (!$id) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)->setJSON(['message' => 'ID user harus diberikan']);
        }
        $data = $this->voteModel->where('id', $id)->findAll();
        return $this->response->setJSON($data);
    }

    // GET /vote/check/{id_kost}/{id}
    public function check($id_kost, $id)
    {
        $data = $this->voteModel
            ->where('id_kost', $id_kost)
            ->where('id', $id)
            ->first();
    
        if ($data) {
            return $this->response->setJSON($data);
        }
    
        return $this->response->setStatusCode(404)->setJSON(['message' => 'not voted']);
    }
    
    // DELETE /vote/{id_kost}/{id}
    public function unvote($id_kost, $id)
    {
        $this->voteModel
            ->where('id_kost', $id_kost)
            ->where('id', $id)
            ->delete();
    
        return $this->response->setJSON(['message' => 'unvoted']);
    }

}
