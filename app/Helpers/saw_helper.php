<?php

function sawRanking(array $data): array
{
    $weights = [
        'jarak'     => 0.25,
        'harga'     => 0.25,
        'keamanan'  => 0.25,
        'fasilitas' => 0.25,
    ];
    
    $jarak     = array_map('floatval', array_column($data, 'jarak'));
    $harga     = array_map('floatval', array_column($data, 'harga'));
    $keamanan  = array_map('floatval', array_column($data, 'keamanan'));
    $fasilitas = array_map('floatval', array_column($data, 'fasilitas'));

    
    $minJarak     = min($jarak);
    $minHarga     = min($harga);
    $maxKeamanan  = max($keamanan);
    $maxFasilitas = max($fasilitas);
    
    foreach ($data as &$row) {
        $row['saw_score'] =
            (($minJarak / floatval($row['jarak'])) * $weights['jarak']) +
            (($minHarga / floatval($row['harga'])) * $weights['harga']) +
            ((floatval($row['keamanan']) / $maxKeamanan) * $weights['keamanan']) +
            ((floatval($row['fasilitas']) / $maxFasilitas) * $weights['fasilitas']);
    
        $row['saw_score'] = round($row['saw_score'], 4);
    }
    unset($row);
    
    usort($data, fn($a, $b) => $b['saw_score'] <=> $a['saw_score']);
    
    return $data;
}
