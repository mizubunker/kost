<?php

namespace App\Models;
use CodeIgniter\Model;

class RankingModel extends Model
{
    protected $table = 'hasil_ranking';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_user', 'id_kost', 'skor_akhir'];
    protected $createdField = "createdAt";
}
