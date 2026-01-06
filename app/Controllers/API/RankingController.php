<?php

namespace App\Controllers\Api;
use App\Controllers\BaseController;
use App\Models\RankingModel;
use CodeIgniter\HTTP\ResponseInterface;

class RankingController extends BaseController
{
    protected $rankingModel;

    public function __construct()
    {
        $this->rankingModel = new RankingModel();
    }

    // GET /ranking
    public function index()
    {
        return $this->response->setJSON($this->rankingModel->findAll());
    }

    // GET /ranking/{id}
    public function show($id = null)
    {
        $data = $this->rankingModel->where('id', $id)->first();
        if (!$data) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                                   ->setJSON(['message' => 'Ranking tidak ditemukan']);
        }
        return $this->response->setJSON($data);
    }

    // POST /ranking
    public function create()
    {
        $data = $this->request->getJSON(true);
        $this->rankingModel->insert($data);
        return $this->response->setJSON(['message' => 'Ranking berhasil ditambahkan']);
    }

    // PUT /ranking/{id}
    public function update($id = null)
    {
        $data = $this->request->getJSON(true);
        $this->rankingModel->update($id, $data);
        return $this->response->setJSON(['message' => 'Riwayat berhasil diperbarui']);
    }

    // DELETE /ranking/{id}
    public function delete($id = null)
    {
        $this->rankingModel->where('id', $id)->delete();
        return $this->response->setJSON(['message' => 'Ranking berhasil dihapus']);
    }
}
