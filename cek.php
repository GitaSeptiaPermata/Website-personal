<?php
//jika belum login

if (isset($_SESSION['log'])) {
} else {
    echo "<script>alert('login terlebih dahulu');</script>";
    echo "<script>location='login.php';</script>";
}