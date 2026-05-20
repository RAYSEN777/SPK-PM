<?php
include 'koneksi.php';

if (isset($_GET['type']) && isset($_GET['id'])) {
    $type = $_GET['type'];
    $id = $_GET['id'];

    if ($type == 'kriteria') {
        mysqli_query($conn, "DELETE FROM kriteria WHERE id_kriteria = '$id'");
        header("Location: kriteria.php");
    } elseif ($type == 'alternatif') {
        mysqli_query($conn, "DELETE FROM alternatif WHERE id_alternatif = '$id'");
        header("Location: alternatif.php");
    }
}
?>