<?php

namespace App\Models;
use CodeIgniter\Model;

class KostModel extends Model
{
    protected $table = 'kost';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'jarak', 'harga', 'foto', 'deskripsi', 'alamat', 'nohp', 'keamanan', 'fasilitas'];
    protected $createdField = "createdAt";
}
