<?php
include "../includes/config.php";

$id = $_GET['id'];

mysqli_query($mysqli, "DELETE FROM buku WHERE id_buku='$id'");

header("Location: ../index.php?hal=buku");
exit;