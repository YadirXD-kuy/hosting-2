<?php

include "db.php";

$id = $_GET['id'];

$sql = "DELETE FROM pegawai WHERE id_pegawai = $id";


if($conn->query($sql) === TRUE){
    echo "Data pegawai berhasil dihapus.";
    header("Location: create_pegawai.php");
}else{
    echo "Error:" . $conn->error;
}

?>