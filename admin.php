<?php
require 'function.php';
require 'cek.php'

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Kelola Staff</title>
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
            color: white;
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
                    <h1 class="mt-4"><i class="fa fa-user-circle"></i> Kelola Staff</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-user-plus" aria-hidden="true"></i>
                                Tambah Staff
                            </button>
                        </div>

                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Foto</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $ambilsemuadataadmin = mysqli_query($conn, "SELECT * FROM login");
                                    $i = 1;
                                    while ($data = mysqli_fetch_array($ambilsemuadataadmin)) {
                                        $iduser = $data['iduser'];
                                        $nama = $data['username'];
                                        $em = $data['email'];
                                        $pw = $data['password'];

                                        //cek ada gambar atau tidak
                                        $foto = $data['foto']; //ambil gambar
                                        if ($foto == null) {
                                            //jika tidak ada gambar
                                            $gambar = 'No Photo';
                                        } else {
                                            //jika ada gambar
                                            $gambar = '<img src="fotouser/' . $foto . '" class="zoomable">';
                                        }

                                    ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $gambar; ?></td>
                                            <td><?= $nama; ?></td>
                                            <td><?= $em; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?= $iduser ?>">
                                                    <i class="fa fa-wrench" aria-hidden="true"></i>
                                                    Edit
                                                </button>
                                                <input type="hidden" name="idadminygmaudihapus" value="<?= $iduser; ?>">
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $iduser; ?>">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="edit<?= $iduser; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Edit Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"><i class="fa fa-wrench" aria-hidden="true"></i> Edit Admin</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Edit body -->
                                                    <form method="post" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <input type="text" name="namaadmin" value="<?= $nama; ?>" class="form-control" placeholder="Isi Nama" required>
                                                            <input type="email" name="emailadmin" value="<?= $em; ?>" class="form-control mt-2" placeholder="Isi Email" required>
                                                            <input type="password" name="passwordbaru" class="form-control mt-2" value="<?= $pw; ?>" placeholder="Isi Password">
                                                            <input type="file" name="file" class="form-control mt-2">
                                                            <input type="hidden" name="id" value="<?= $iduser; ?>">
                                                            <button type="submit" class="btn btn-secondary mt-2" name="updateadmin"><i class="fa fa-wrench" aria-hidden="true"></i> Update</button>
                                                        </div>
                                                    </form>



                                                </div>
                                            </div>
                                        </div>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="delete<?= $iduser; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- delete Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"><i class="fa fa-trash" aria-hidden="true"></i> Hapus Admin</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Delete body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            Apakah anda yakin ingin menghapus <strong><?= $nama; ?></strong> ?
                                                            <input type="hidden" name="iduser" value="<?= $iduser; ?>">
                                                            <br>
                                                            <br>
                                                            <button type="submit" class="btn btn-secondary" name="hapusadmin"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
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
                <h4 class="modal-title"><i class="fa fa-user-plus" aria-hidden="true"></i> Tambah Staff</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="text" name="nama" placeholder="Nama Lengkap" class="form-control" required>
                    <input type="email" name="email" placeholder="Email" class="form-control mt-2" required>
                    <input type="password" name="password" placeholder="Password" class="form-control mt-2" required>
                    <input type="file" name="file" class="form-control mt-2" required>
                    <button type="submit" class="btn btn-secondary mt-2" name="addadmin"><i class="fa fa-plus-circle" aria-hidden="true"></i> Submit</button>
                </div>
            </form>



        </div>
    </div>
</div>

</html>