<?php

namespace App\Controllers\Api;
use App\Controllers\BaseController;
use App\Models\KostModel;
use CodeIgniter\HTTP\ResponseInterface;

class KostController extends BaseController
{
    protected $kostModel;

    public function __construct()
    {
        $this->kostModel = new KostModel();
    }

    // GET /kost
    public function index()
    {
        return $this->response->setJSON($this->kostModel->findAll());
    }

    // GET /kost/{id}
    public function show($id = null)
    {
        $data = $this->kostModel->where('id', $id)->first();
        if (!$data) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                                   ->setJSON(['message' => 'Kost tidak ditemukan']);
        }
        return $this->response->setJSON($data);
    }

    // POST /kost
    public function create()
    {
        $data = $this->request->getJSON(true);
        $this->kostModel->insert($data);
        return $this->response->setJSON(['message' => 'Kost berhasil ditambahkan']);
    }

    // PUT /kost/{id}
    public function update($id = null)
    {
        $data = $this->request->getJSON(true);
        $this->kostModel->update($id, $data);
        return $this->response->setJSON(['message' => 'Riwayat berhasil diperbarui']);
    }

    // DELETE /kost/{id}
    public function delete($id = null)
    {
        $this->kostModel->where('id', $id)->delete();
        return $this->response->setJSON(['message' => 'Kost berhasil dihapus']);
    }

    public function saw($sortBy = null) {

        helper('saw_helper');

        $data = $this->kostModel->findAll();

        $data = \sawRanking($data);

        $allowedSort = ['jarak', 'harga', 'keamanan', 'fasilitas'];

        if ($sortBy && in_array($sortBy, $allowedSort)) {
            if (in_array($sortBy, ['jarak', 'harga'])) {
                usort($data, fn($a, $b) => floatval($a[$sortBy]) <=> floatval($b[$sortBy]));
            } else {
                usort($data, fn($a, $b) => floatval($b[$sortBy]) <=> floatval($a[$sortBy]));
            }
        } else {
            usort($data, fn($a, $b) => floatval($b['saw_score']) <=> floatval($a['saw_score']));
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $data
        ]);
    }
}
