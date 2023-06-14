<?php
require 'function.php';
require 'cek.php';

//get data
//ambil data login
$get1 = mysqli_query($conn, "SELECT * FROM login");
$count1 = mysqli_num_rows($get1);

//ambil jumlah stock
$get2 = mysqli_query($conn, "SELECT * FROM stock");
$totalstock = 0;
while ($tampil = $get2->fetch_array()) {
    $totalstock += $tampil['stock'];
}

//ambil jumlah masuk
$get3 = mysqli_query($conn, "SELECT * FROM masuk");
$qtymasuk = 0;
while ($tampil = $get3->fetch_array()) {
    $qtymasuk += $tampil['qty'];
}

//ambil jumlah keluar
$get4 = mysqli_query($conn, "SELECT * FROM keluar");
$qtykeluar = 0;
while ($tampil = $get4->fetch_array()) {
    $qtykeluar += $tampil['qty'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Beranda</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        .zoomable {
            width: 100px;
        }

        .zoomable:hover {
            transform: scale(2.0);
            transition: 0.3 ease;
        }

        a {
            text-decoration: none;
            color: black;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ml-4" href="index.php">
            <b class="logo-icon">
                <!--Logo Sepatu-->
                <img src="./assets/img/PersediaanSepatau.png" height="75" width="140" alt="homepage" class="dark-logo">
            </b>
            <span class="logo-text ml-3">
                <button class="btn btn-dark btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            </span>
        </a>
        <!-- Sidebar Toggle-->
        <ul class="navbar-nav d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i>
                    <?php echo $_SESSION['username']; ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>



        <!-- Sidebar Toggle-->

    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fa fa-archive"></i></div>
                            Beranda
                        </a>
                        <hr width="100%">
                        <div class="sb-sidenav-menu-heading">Manajemen Barang</div>
                        <a class="nav-link" href="stok.php">
                            <div class="sb-nav-link-icon"><i class="fa fa-archive"></i></div>
                            Stok Sepatu
                        </a>
                        <a class="nav-link" href="masuk.php">
                            <div class="sb-nav-link-icon"><i class="fa fa-cloud-download"></i></div>
                            Barang masuk
                        </a>
                        <a class="nav-link" href="keluar.php">
                            <div class="sb-nav-link-icon"><i class="fa fa-cloud-upload"></i></div>
                            Barang Keluar
                        </a>
                        <hr width="100%">
                        <div class="sb-sidenav-menu-heading">Manajemen Staff</div>
                        <a class="nav-link" href="admin.php">
                            <div class="sb-nav-link-icon"><i class="fa fa-user-circle"></i></div>
                            Staff
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Beranda</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Selamat Datang, <?php echo $_SESSION['username']; ?></li>
                    </ol>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card text-dark mb-4">
                                <div class="card-body">
                                    <h2><i class="fas fa-user"></i> User : <?= $count1 ?></h2>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-dark stretched-link" href="admin.php">Lihat Detail</a>
                                    <div class="small text-dark"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-light text-dark mb-4">
                                <div class="card-body">
                                    <h2><i class="fas fa-cloud-download-alt"></i> Masuk : <?= $qtymasuk ?></h2>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-dark stretched-link" href="masuk.php">Lihat Detail</a>
                                    <div class="small text-dark"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-light text-dark mb-4">
                                <div class="card-body">
                                    <h2><i class="fas fa-cloud-upload-alt"></i> Keluar : <?= $qtykeluar ?></h2>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-dark stretched-link" href="keluar.php">Lihat Detail</a>
                                    <div class="small text-dark"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-light text-dark mb-4">
                                <div class="card-body">
                                    <h2><i class="fas fa-archive"></i> Stok : <?= $totalstock ?></h2>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-dark stretched-link" href="stok.php">Lihat Detail</a>
                                    <div class="small text-dark"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <h4 class="card-title">Aktivitas Terakhir Pemasukan Barang</h4>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table no-wrap v-middle mb-0">
                                            <thead>
                                                <tr class="border-0">
                                                    <th class="border-0 font-14 font-weight-medium text-muted px-2">Kode Barang</th>
                                                    <th class="border-0 font-14 font-weight-medium text-muted px-2">Nama Penerima</th>
                                                    <th class="border-0 font-14 font-weight-medium text-muted px-2">Jumlah</th>
                                                    <th class="border-0 font-14 font-weight-medium text-muted px-2 text-center">Waktu Pemasukan</th>
                                                    <th class="border-0 font-14 font-weight-medium text-muted"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $ambildatamasuk = mysqli_query($conn, "SELECT * FROM masuk m, stock s WHERE s.idbarang= m.idbarang");
                                                while ($fetch = mysqli_fetch_array($ambildatamasuk)) {
                                                    $tanggal = $fetch['tanggal'];
                                                    $kode = $fetch['kodebarang'];
                                                    $keterangan = $fetch['keterangan'];
                                                    $jumlah = $fetch['qty'];
                                                    $idb = $fetch['idbarang'];
                                                ?>
                                                    <tr>
                                                        <td class="border-top-0 px-2 py-4 font-weight-medium"><?= $kode; ?></td>
                                                        <td class="border-top-0 text-muted px-2 py-4 font-14"><?= $keterangan ?></td>
                                                        <td class="border-top-0 text-muted px-2 py-4 font-14"><?= $jumlah ?></td>
                                                        <td class="border-top-0 text-muted px-2 py-4 font-14 text-center"><?= date('d-m-Y H:i:s', strtotime($tanggal)) ?></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <h4 class="card-title">Aktivitas Terakhir Pengeluaran Barang</h4>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table no-wrap v-middle mb-0">
                                            <thead>
                                                <tr class="border-0">
                                                    <th class="border-0 font-14 font-weight-medium text-muted px-2">Kode Barang</th>
                                                    <th class="border-0 font-14 font-weight-medium text-muted px-2">Nama Pembeli</th>
                                                    <th class="border-0 font-14 font-weight-medium text-muted px-2">Jumlah</th>
                                                    <th class="border-0 font-14 font-weight-medium text-muted px-2 text-center">Waktu Keluaran</th>
                                                    <th class="border-0 font-14 font-weight-medium text-muted"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <?php
                                                    $ambildatamasuk = mysqli_query($conn, "SELECT * FROM keluar k, stock s WHERE s.idbarang= k.idbarang");
                                                    while ($fetch = mysqli_fetch_array($ambildatamasuk)) {
                                                        $tanggal = $fetch['tanggal'];
                                                        $kode = $fetch['kodebarang'];
                                                        $penerima = $fetch['penerima'];
                                                        $jumlah = $fetch['qty'];
                                                        $idb = $fetch['idbarang'];
                                                    ?>
                                                <tr>
                                                    <td class="border-top-0 px-2 py-4 font-weight-medium"><?= $kode; ?></td>
                                                    <td class="border-top-0 text-muted px-2 py-4 font-14"><?= $penerima ?></td>
                                                    <td class="border-top-0 text-muted px-2 py-4 font-14"><?= $jumlah ?></td>
                                                    <td class="border-top-0 text-muted px-2 py-4 font-14 text-center"><?= date('d-m-Y H:i:s', strtotime($tanggal)) ?></td>
                                                </tr>
                                            <?php
                                                    }
                                            ?>

                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-cart-plus" aria-hidden="true"></i> Tambah Barang</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <?php
            $ambil = mysqli_query($conn, "SELECT max(kodebarang) as max_code FROM stock");
            $data = mysqli_fetch_array($ambil);
            $kode = $data['max_code'];
            $urutan = (int)substr($kode, 2, 3);
            $urutan++;
            $huruf = "KB";
            $kdbar = $huruf . sprintf("%03s", $urutan);
            ?>


            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">

                    <input type="text" name="kodebarang" value="<?= $kdbar; ?>" placeholder="Kode Barang" class="form-control" readonly>
                    <input type="text" name="namabarang" placeholder="Nama Sepatu" class="form-control mt-2" required>
                    <input type="text" name="deskripsi" placeholder="Deskripsi" class="form-control mt-2" required>
                    <input type="number" name="stock" placeholder="Stock" class="form-control mt-2" required>
                    <input type="file" name="file" class="form-control mt-2">
                    <button type="submit" class="btn btn-secondary mt-2" name="addnewbarang"><i class="fa fa-plus-circle" aria-hidden="true"></i> Submit</button>
                </div>
            </form>



        </div>
    </div>
</div>

</html>