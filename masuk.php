<?php
require 'function.php';
require 'cek.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Barang Masuk</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
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
                    <h1 class="mt-4"><i class="fa fa-cloud-download" aria-hidden="true"></i> Barang Masuk</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-cloud-download" aria-hidden="true"></i>
                                Tambah Barang
                            </button>
                            <a href="exportmasuk.php" class="btn btn-dark"><i class="fa fa-print" aria-hidden="true"></i> Export Data Masuk</a>
                            <br>
                            <div class="row mt-4">
                                <div class="col">
                                    <form method="post" class="form-inline">
                                        <input type="date" name="tgl_mulai" class="form-control">
                                        <input type="date" name="tgl_selesai" class="form-control ml-3">
                                        <button type="submit" name="filter_tgl" class="btn btn-secondary ml-3"><i class="fa fa-search" aria-hidden="true"></i> Filter</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Foto</th>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                        <th>Penerima Barang</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                    if (isset($_POST['filter_tgl'])) {
                                        $mulai = $_POST['tgl_mulai'];
                                        $selesai = $_POST['tgl_selesai'];

                                        if ($mulai != null || $selesai != null) {

                                            $ambilsemuadatastock = mysqli_query($conn, "SELECT * FROM masuk m, stock s where s.idbarang = m.idbarang and tanggal BETWEEN '$mulai' and DATE_ADD('$selesai',INTERVAL 1 DAY)");
                                        } else {
                                            $ambilsemuadatastock = mysqli_query($conn, "SELECT * FROM masuk m, stock s where s.idbarang = m.idbarang");
                                        }
                                    } else {
                                        $ambilsemuadatastock = mysqli_query($conn, "SELECT * FROM masuk m, stock s where s.idbarang = m.idbarang");
                                    }



                                    while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                                        $idb = $data['idbarang'];
                                        $idm = $data['idmasuk'];
                                        $tanggal = $data['tanggal'];
                                        $kdbarang = $data['kodebarang'];
                                        $namabarang = $data['namabarang'];
                                        $qty = $data['qty'];
                                        $keterangan = $data['keterangan'];

                                        //cek ada gambar atau tidak
                                        $gambar = $data['image']; //ambil gambar
                                        if ($gambar == null) {
                                            //jika tidak ada gambar
                                            $img = 'No Photo';
                                        } else {
                                            //jika ada gambar
                                            $img = '<img src="images/' . $gambar . '" class="zoomable">';
                                        }
                                    ?>
                                        <tr>
                                            <td><?= $tanggal; ?></td>
                                            <td><?= $img; ?></td>
                                            <td><?= $kdbarang; ?></td>
                                            <td><?= $namabarang; ?></td>
                                            <td><?= $qty; ?></td>
                                            <td><?= $keterangan; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?= $idm; ?>">
                                                    <i class="fa fa-wrench" aria-hidden="true"></i>
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $idm; ?>">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Edit Masuk Modal -->
                                        <div class="modal fade" id="edit<?= $idm; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Edit Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"><i class="fa fa-wrench" aria-hidden="true"></i> Edit Barang</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Edit body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            <input type="text" name="keterangan" value="<?= $keterangan; ?>" class="form-control" required>
                                                            <br>
                                                            <input type="number" name="qty" value="<?= $qty; ?>" class="form-control" required>
                                                            <br>
                                                            <input type="hidden" name="idb" value="<?= $idb; ?>">
                                                            <input type="hidden" name="idm" value="<?= $idm; ?>">
                                                            <button type="submit" class="btn btn-secondary" name="updatebarangmasuk"><i class="fa fa-wrench" aria-hidden="true"></i> Update</button>
                                                        </div>
                                                    </form>



                                                </div>
                                            </div>
                                        </div>

                                        <!-- Delete Masuk Modal -->
                                        <div class="modal fade" id="delete<?= $idm; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- delete Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"><i class="fa fa-trash" aria-hidden="true"></i> Hapus Barang ?</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Delete body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            Apakah anda yakin ingin menghapus <strong><?= $namabarang; ?></strong> ?
                                                            <input type="hidden" name="idb" value="<?= $idb; ?>">
                                                            <input type="hidden" name="kty" value="<?= $qty; ?>">
                                                            <input type="hidden" name="idm" value="<?= $idm; ?>">
                                                            <br>
                                                            <br>
                                                            <button type="submit" class="btn btn-secondary" name="hapusbarangmasuk"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                                        </div>
                                                    </form>



                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    };
                                    ?>

                                </tbody>
                            </table>
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
                <h4 class="modal-title"><i class="fa fa-cloud-download" aria-hidden="true"></i> Tambah Barang Masuk</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <form method="post">
                <div class="modal-body">
                    <select name="barangnya" class="form-control">
                        <?php
                        $ambilsemuadatanya = mysqli_query($conn, "SELECT * FROM stock");
                        while ($fetcharray = mysqli_fetch_array($ambilsemuadatanya)) {
                            $namabarangnya = $fetcharray['namabarang'];
                            $idbarangnya = $fetcharray['idbarang'];
                        ?>

                            <option value="<?= $idbarangnya; ?>"><?= $namabarangnya; ?></option>

                        <?php
                        }
                        ?>
                    </select>
                    <input type="number" name="qty" placeholder="Quantity" class="form-control mt-2" required>
                    <input type="text" name="penerima" placeholder="Penerima" class="form-control mt-2" required>
                    <button type="submit" class="btn btn-secondary mt-2" name="barangmasuk"><i class="fa fa-plus-circle" aria-hidden="true"></i> Submit</button>
                </div>
            </form>



        </div>
    </div>
</div>

</html>