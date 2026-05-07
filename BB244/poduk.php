<?php

include 'database.php';

class Produk extends Database {

    public function tambahProduk($nama,$kategori,$stok,$harga){

        if($stok < 0){
            echo "Stok tidak valid";
            return;
        }

        $this->conn->query("INSERT INTO produk VALUES(
            '',
            '$nama',
            '$kategori',
            '$stok',
            '$harga'
        )");
    }

    public function tampilProduk(){

        $data = $this->conn->query("SELECT * FROM produk");

        while($d = $data->fetch_assoc()){

            echo "<tr>";

            echo "<td>".$d['id']."</td>";
            echo "<td>".$d['nama_produk']."</td>";
            echo "<td>".$d['kategori']."</td>";
            echo "<td>".$d['stok']."</td>";
            echo "<td>".$d['harga']."</td>";

            if($d['stok'] < 5){
                echo "<td>Stok Menipis</td>";
            }else{
                echo "<td>Aman</td>";
            }

            echo "</tr>";
        }
    }
}

?>