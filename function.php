<?php
session_start();
//koneksi ke database
$conn = mysqli_connect("localhost","root", "", "inventory");


//menambah barang baru
if (isset($_POST['addnewbarang'])) {
    $kdbarang = $_POST['kodebarang'];
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];

    //soal gambar
    $allowed_extension = array('png', 'jpg');
    $nama = $_FILES['file']['name']; //ngambil nama gambar
    $dot = explode('.', $nama);
    $ekstensi = strtolower(end($dot)); //ngambil ekstensinya
    $ukuran = $_FILES['file']['size']; //ngambil size filenya
    $file_tmp = $_FILES['file']['tmp_name']; //ngambil lokasi filenya

    //penamaan file -> enkripsi
    $image = md5(uniqid($nama, true) . time()) . '.' . $ekstensi; //menggabungkan nama file yg dienkripsi dgn ekstensinya


    //validasi udah ada atau belum
    $cek = mysqli_query($conn, "SELECT * FROM stock WHERE namabarang='$namabarang'");
    $hitung = mysqli_num_rows($cek);

    if ($hitung < 1) {
        //jika belum ada

        //proses upload gambar
        if (in_array($ekstensi, $allowed_extension) == true) {
            //validasi ukuran filenya
            if ($ukuran < 15000000) {
                move_uploaded_file($file_tmp, 'images/' . $image);

                $addtotable = mysqli_query($conn, "insert into stock (kodebarang, namabarang, deskripsi, stock, image) values('$kdbarang', '$namabarang','$deskripsi','$stock','$image')");
                if ($addtotable) {
                    header('location:index.php');
                } else {
                    echo 'Gagal Tambah Barang';
                    header('location:index.php');
                }
            } else {
                //kalau filenya lebih dari 15mb
                echo '
                <script>
                    alert("Ukuran File Terlalu Besar !");
                    window.location.href="index.php";
                </script>
                ';
            }
        } else {
            //kalau filenya tidak png / jpg
            echo '
            <script>
                alert("File Harus png/jpg !");
                window.location.href="index.php";
            </script>
            ';
        }
    } else {
        //jika sudah ada
        echo '
        <script>
            alert("Nama barang sudah terdaftar !");
            window.location.href="index.php";
        </script>
        ';
    }
}


//menambah barang masuk
if (isset($_POST['barangmasuk'])) {
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang + $qty;

    $addtomasuk = mysqli_query($conn, "INSERT INTO masuk (idbarang, keterangan, qty) VALUES ('$barangnya','$penerima','$qty')");
    $updatestockmasuk = mysqli_query($conn, "UPDATE stock SET stock='$tambahkanstocksekarangdenganquantity' WHERE idbarang='$barangnya'");
    if ($addtomasuk && $updatestockmasuk) {
        header('location:masuk.php');
    } else {
        echo 'Gagal Tambah Barang Masuk';
        header('location:masuk.php');
    }
}

//menambah barang keluar
if (isset($_POST['addbarangkeluar'])) {
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];

    if ($stocksekarang >= $qty) {
        //kalau barangnya cukup
        $tambahkanstocksekarangdenganquantity = $stocksekarang - $qty;

        $addtokeluar = mysqli_query($conn, "INSERT INTO keluar (idbarang, penerima, qty) VALUES ('$barangnya','$penerima','$qty')");
        $updatestockmasuk = mysqli_query($conn, "UPDATE stock SET stock='$tambahkanstocksekarangdenganquantity' WHERE idbarang='$barangnya'");
        if ($addtokeluar && $updatestockmasuk) {
            header('location:keluar.php');
        } else {
            echo 'Gagal Tambah Barang Masuk';
            header('location:keluar.php');
        }
    } else {
        //kalau barangnya tidak cukup
        echo '
        <script>
            alert("Stock saat ini tidak mencukupi");
            window.location.href="keluar.php";
        </script>
        ';
    }
}


//update info barang
if (isset($_POST['updatebarang'])) {
    $idb = $_POST['idb'];
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];

    //soal gambar
    $allowed_extension = array('png', 'jpg');
    $nama = $_FILES['file']['name']; //ngambil nama gambar
    $dot = explode('.', $nama);
    $ekstensi = strtolower(end($dot)); //ngambil ekstensinya
    $ukuran = $_FILES['file']['size']; //ngambil size filenya
    $file_tmp = $_FILES['file']['tmp_name']; //ngambil lokasi filenya

    //penamaan file -> enkripsi
    $image = md5(uniqid($nama, true) . time()) . '.' . $ekstensi; //menggabungkan nama file yg dienkripsi dgn ekstensinya

    if ($ukuran == 0) {
        //jika tidak ingin upload
        $update = mysqli_query($conn, "UPDATE stock SET namabarang='$namabarang', deskripsi='$deskripsi' WHERE idbarang='$idb'");
        if ($update) {
            header('location:index.php');
        } else {
            echo 'Gagal Update Barang';
            header('location:index.php');
        }
    } else {
        //jika ingin
        move_uploaded_file($file_tmp, 'images/' . $image);
        $update = mysqli_query($conn, "UPDATE stock SET namabarang='$namabarang', deskripsi='$deskripsi', image='$image' WHERE idbarang='$idb'");
        if ($update) {
            header('location:index.php');
        } else {
            echo 'Gagal Update Barang';
            header('location:index.php');
        }
    }
}


//menghapus barang dari stock
if (isset($_POST['hapusbarang'])) {
    $idb = $_POST['idb']; //idbarang

    $gambar = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    $get = mysqli_fetch_array($gambar);
    $img = 'images/' . $get['image'];
    unlink($img);

    $hapus = mysqli_query($conn, "DELETE FROM stock WHERE idbarang='$idb'");
    if ($hapus) {
        header('location:index.php');
    } else {
        echo 'Gagal Update Barang';
        header('location:index.php');
    }
}


//mengubah data barang masuk
if (isset($_POST['updatebarangmasuk'])) {
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $deskripsi = $_POST['keterangan'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn, "SELECT * FROM stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrng = $stocknya['stock'];

    $qtyskrng = mysqli_query($conn, "SELECT * FROM masuk WHERE idmasuk='$idm'");
    $qtynya = mysqli_fetch_array($qtyskrng);
    $qtyskrng = $qtynya['qty'];

    if ($qty > $qtyskrng) {
        $selisih = $qty - $qtyskrng;
        $kurangin = $stockskrng + $selisih;
        $kurangistock = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE idbarang='$idb'");
        $updatenya = mysqli_query($conn, "UPDATE masuk SET qty='$qty', keterangan='$deskripsi' WHERE idmasuk='$idm'");
        if ($kurangistock && $updatenya) {
            header('location:masuk.php');
        } else {
            echo 'Gagal Mengubah';
            header('location:masuk.php');
        }
    } else {
        $selisih = $qtyskrng - $qty;
        $kurangin = $stockskrng - $selisih;
        $kurangistock = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE idbarang='$idb'");
        $updatenya = mysqli_query($conn, "UPDATE masuk SET qty='$qty', keterangan='$deskripsi' WHERE idmasuk='$idm'");
        if ($kurangistock && $updatenya) {
            header('location:masuk.php');
        } else {
            echo 'Gagal Mengubah';
            header('location:masuk.php');
        }
    }
}


//menghapus barang masuk
if (isset($_POST['hapusbarangmasuk'])) {
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idm = $_POST['idm'];

    $getdatastock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];

    $selisih = $stok - $qty;

    $update = mysqli_query($conn, "UPDATE stock SET stock='$selisih' WHERE idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "DELETE FROM masuk WHERE idmasuk='$idm'");

    if ($update && $hapusdata) {
        header('location:masuk.php');
    } else {
        header('location:masuk.php');
    }
}


//mengubah data barang keluar
if (isset($_POST['updatebarangkeluar'])) {
    $idb = $_POST['idb'];
    $idk = $_POST['idk'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn, "SELECT * FROM stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrng = $stocknya['stock'];

    $qtyskrng = mysqli_query($conn, "SELECT * FROM keluar WHERE idkeluar='$idk'");
    $qtynya = mysqli_fetch_array($qtyskrng);
    $qtyskrng = $qtynya['qty'];

    if ($qty > $qtyskrng) {
        $selisih = $qty - $qtyskrng;
        $kurangin = $stockskrng - $selisih;
        $kurangistock = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE idbarang='$idb'");
        $updatenya = mysqli_query($conn, "UPDATE keluar SET qty='$qty', penerima='$penerima' WHERE idkeluar='$idk'");
        if ($kurangistock && $updatenya) {
            header('location:keluar.php');
        } else {
            echo 'Gagal Mengubah';
            header('location:keluar.php');
        }
    } else {
        $selisih = $qtyskrng - $qty;
        $kurangin = $stockskrng + $selisih;
        $kurangistock = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE idbarang='$idb'");
        $updatenya = mysqli_query($conn, "UPDATE keluar SET qty='$qty', penerima='$penerima' WHERE idkeluar='$idk'");
        if ($kurangistock && $updatenya) {
            header('location:keluar.php');
        } else {
            echo 'Gagal Mengubah';
            header('location:keluar.php');
        }
    }
}


//menghapus barang keluar
if (isset($_POST['hapusbarangkeluar'])) {
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idk = $_POST['idk'];

    $getdatastock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];

    $selisih = $stok + $qty;

    $update = mysqli_query($conn, "UPDATE stock SET stock='$selisih' WHERE idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "DELETE FROM keluar WHERE idkeluar='$idk'");

    if ($update && $hapusdata) {
        header('location:keluar.php');
    } else {
        header('location:keluar.php');
    }
}


//menambah admin baru
if (isset($_POST['addadmin'])) {
    $iduser = $_POST['iduser'];
    $nama = $_POST['nama'];
    $em = $_POST['email'];
    $password = $_POST['password'];

    //foto
    $allowed_extension = array('png', 'jpg');
    $namafoto = $_FILES['file']['name'];
    $dot = explode('.', $namafoto);
    $ekstensi = strtolower(end($dot));
    $ukuran = $_FILES['file']['size'];
    $file_tmp = $_FILES['file']['tmp_name'];

    $image = md5(uniqid($namafoto, true) . time()) . '.' . $ekstensi;

    //validasi udah ada atau belum
    $cekuser = mysqli_query($conn, "SELECT * FROM login WHERE nama='$nama'");
    $itung = mysqli_num_rows($cekuser);

    if ($itung < 1) {
        //jika belum ada

        // proses upload gambar
        if (in_array($ekstensi, $allowed_extension) == true) {
            //validasi ukuran filenya
            if ($ukuran < 15000000) {
                move_uploaded_file($file_tmp, 'fotouser/' . $image);

                $addtologin = mysqli_query($conn, "INSERT INTO login (nama, email, password, foto) VALUES ('$nama', '$em', '$password', '$image')");
                if ($addtologin) {
                    header('location: admin.php');
                } else {
                    echo 'Gagal Tambah User';
                    header('location: admin.php');
                }
            } else {
                //kalau filenya lebih dari 15mb
                echo '
                <script>
                    alert("Ukuran File Terlalu Besar !");
                    window.location.href="admin.php";
                </script>
                ';
            }
        } else {
            //kalau filenya tidak png / jpg
            echo '
            <script>
                alert("File Harus png/jpg !");
                window.location.href="admin.php";
            </script>
            ';
        }
    } else {
        //jika sudah ada
        echo '
        <script>
            alert("Nama sudah terdaftar !");
            window.location.href="admin.php";
        </script>
        ';
    }
}

//edit data admin
if (isset($_POST['updateadmin'])) {
    $emailbaru = $_POST['emailadmin'];
    $passwordbaru = $_POST['passwordbaru'];
    $namabaru = $_POST['namaadmin'];
    $idnya = $_POST['id'];

    //soal gambar
    $allowed_extension = array('png', 'jpg');
    $nama = $_FILES['file']['name']; //ngambil nama gambar
    $dot = explode('.', $nama);
    $ekstensi = strtolower(end($dot)); //ngambil ekstensinya
    $ukuran = $_FILES['file']['size']; //ngambil size filenya
    $file_tmp = $_FILES['file']['tmp_name']; //ngambil lokasi filenya

    //penamaan file -> enkripsi
    $image = md5(uniqid($nama, true) . time()) . '.' . $ekstensi;

    if ($ukuran == 0) {
        //jika tidak ingin upload
        $updateadmin = mysqli_query($conn, "UPDATE login SET email='$emailbaru', password='$passwordbaru', username='$namabaru' WHERE idauser='$idnya'");
        if ($updateadmin) {
            header('location:admin.php');
        } else {
            //jika ingin ganti foto
            move_uploaded_file($file_tmp, 'fotouser/' . $image);
            $updateadmin = mysqli_query($conn, "UPDATE login SET email='$emailbaru', password='$passwordbaru', username='$namabaru', foto='$image' WHERE idauser='$idnya'");
            if ($updateadmin) {
                header('location:admin.php');
            } else {
                echo 'Gagal Ubah Admin';
                header('location:admin.php');
            }
        }
    }
}

//hapus admin
if (isset($_POST['hapusadmin'])) {
    $id = $_POST['iduser'];

    $querydelete = mysqli_query($conn, "DELETE FROM login WHERE iduser='$id'");

    if ($querydelete) {
        header('location:admin.php');
    } else {
        header('location:admin.php');
    }
}
