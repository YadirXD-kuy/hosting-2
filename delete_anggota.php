<?php

include "db.php";

$id = $_GET['id'];

$sql = "DELETE FROM anggota WHERE id_anggota = $id";


if($conn->query($sql) === TRUE){
    echo "Data anggota berhasil dihapus.";
    header("Location: create_anggota.php");
}else{
    echo "Error:" . $conn->error;
}

?>