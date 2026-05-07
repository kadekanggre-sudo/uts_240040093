<?php
include 'database.php';

class Barang extends Database {

    public function tambah($nama,$jenis,$stok,$harga){

        if($stok < 0){
            echo "Stok tidak valid";
            return;
        }

        mysqli_query($this->conn,"INSERT INTO produk VALUES(
            '',
            '$nama',
            '$jenis',
            '$stok',
            '$harga'
        )");
    }

    public function beli($id,$jumlah){

        $ambil = mysqli_query($this->conn,"SELECT * FROM produk WHERE id='$id'");
        $data = mysqli_fetch_array($ambil);

        if($jumlah > $data['stok']){
            echo "Stok habis";
            return;
        }

        $sisa = $data['stok'] - $jumlah;

        mysqli_query($this->conn,"UPDATE produk SET stok='$sisa' WHERE id='$id'");

        mysqli_query($this->conn,"INSERT INTO transaksi VALUES(
            '',
            '$id',
            '$jumlah',
            NOW()
        )");
    }

    public function tampil(){

        $data = mysqli_query($this->conn,"SELECT * FROM produk");

        while($d = mysqli_fetch_array($data)){

            echo "<tr>";

            echo "<td>$d[id]</td>";
            echo "<td>$d[nama_produk]</td>";
            echo "<td>$d[kategori]</td>";
            echo "<td>$d[stok]</td>";
            echo "<td>$d[harga]</td>";

            if($d['stok'] < 5){
                echo "<td>Stok Menipis</td>";
            }else{
                echo "<td>Aman</td>";
            }

            echo "</tr>";
        }
    }

    public function transaksi(){

        $trx = mysqli_query($this->conn,"
            SELECT * FROM transaksi
            JOIN produk ON transaksi.produk_id = produk.id
        ");

        while($t = mysqli_fetch_array($trx)){

            echo "<tr>";

            echo "<td>$t[nama_produk]</td>";
            echo "<td>$t[jumlah]</td>";
            echo "<td>$t[tanggal]</td>";

            echo "</tr>";
        }
    }
}

$obj = new Barang();

if(isset($_POST['simpan'])){

    $obj->tambah(
        $_POST['nama'],
        $_POST['jenis'],
        $_POST['stok'],
        $_POST['harga']
    );
}

if(isset($_POST['beli'])){

    $obj->beli(
        $_POST['id'],
        $_POST['jumlah']
    );
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Inventaris Toko</title>
</head>
<body>

<h2>Input Produk</h2>

<form method="POST">

    <input type="text" name="nama" placeholder="Nama Produk" required>

    <select name="jenis">
        <option>Laptop</option>
        <option>Smartphone</option>
    </select>

    <input type="number" name="stok" placeholder="Stok" required>

    <input type="number" name="harga" placeholder="Harga" required>

    <button type="submit" name="simpan">Simpan</button>

</form>

<h2>Transaksi</h2>

<form method="POST">

    <input type="number" name="id" placeholder="ID Produk" required>

    <input type="number" name="jumlah" placeholder="Jumlah" required>

    <button type="submit" name="beli">Proses</button>

</form>

<h2>Data Barang</h2>

<table border="1">

<tr>
    <th>ID</th>
    <th>Nama</th>
    <th>Kategori</th>
    <th>Stok</th>
    <th>Harga</th>
    <th>Status</th>
</tr>

<?php
$obj->tampil();
?>

</table>

<h2>Rekap Transaksi</h2>

<table border="1">

<tr>
    <th>Produk</th>
    <th>Jumlah</th>
    <th>Tanggal</th>
</tr>

<?php
$obj->transaksi();
?>

</table>

</body>
</html>