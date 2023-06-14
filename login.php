<?php
require 'function.php';


//cek login, terdaftar apa engga
if (isset($_POST['login'])) {
    $em = $_POST['email'];
    $password = $_POST['password'];

    //cocokin dengan database, cari... ada atau engga datanya
    $cekdatabase = mysqli_query($conn, "SELECT * FROM login where email='$em' AND password='$password'");
    //hitung jumlah data
    $hitung = mysqli_num_rows($cekdatabase);

    if ($hitung > 0) {
        while ($data = mysqli_fetch_array($cekdatabase)) {
            $_SESSION['log'] = 'True';
            $_SESSION['username'] = $data['username'];
            $_SESSION['email'] = $em;
            echo "<script>alert('Login Berhasil !');</script>";
            echo "<script>location='index.php';</script>";
        }
    } else {
        echo "<script>alert('Email atau Password Tidak Dikenali');</script>";
        echo "<script>location='login.php';</script>";
    };
};

if (!isset($_SESSION['log'])) {
} else {
    echo "<script>alert('Login Terlebih Dahulu');</script>";
    echo "<script>location='login.php';</script>";
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
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4"><i class="fa fa-user-circle" aria-hidden="true"></i> Login</h3>
                                </div>
                                <div class="card-body">
                                    <form method="post">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" name="email" id="inputEmail" type="email" placeholder="Email" />
                                            <label for="inputEmail"><i class="fa fa-envelope" aria-hidden="true"></i> Email</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" name="password" id="inputPassword" type="password" placeholder="Password" />
                                            <label for="inputPassword"><i class="fa fa-key" aria-hidden="true"></i> Password</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-2">
                                            <button class="btn btn-secondary" href="index.php" name="login"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>