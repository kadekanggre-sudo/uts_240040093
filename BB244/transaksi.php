<?php

include 'database.php';

class Transaksi extends Database {

    public function beli($id,$jumlah){

        $ambil = $this->conn->query("SELECT * FROM produk WHERE id='$id'");

        $data = $ambil->fetch_assoc();

        if($jumlah > $data['stok']){
            echo "Stok tidak cukup";
            return;
        }

        $sisa = $data['stok'] - $jumlah;

        $this->conn->query("UPDATE produk SET stok='$sisa' WHERE id='$id'");

        $this->conn->query("INSERT INTO transaksi VALUES(
            '',
            '$id',
            '$jumlah',
            NOW()
        )");
    }

    public function tampilTransaksi(){

        $data = $this->conn->query("
            SELECT * FROM transaksi
            JOIN produk ON transaksi.produk_id = produk.id
        ");

        while($d = $data->fetch_assoc()){

            echo "<tr>";

            echo "<td>".$d['nama_produk']."</td>";
            echo "<td>".$d['jumlah']."</td>";
            echo "<td>".$d['tanggal']."</td>";

            echo "</tr>";
        }
    }
}

?>