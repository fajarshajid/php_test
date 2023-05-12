<?php
mysql_connect("localhost", "root", "");
mysql_select_db("db_test");

$nama_gambar = $_FILES['user_foto']['name'];
$ukuran_gambar = $_FILES['user_foto']['size'];
$fileinfo = @getimagesize($_FILES["user_foto"]["tmp_name"]);
$width = $fileinfo[0];
$height = $fileinfo[1];
$file_gambar = addslashes(file_get_contents($_FILES['user_foto']['tmp_name']));

//LOGIC
if ($ukuran_gambar > 119200) {
    echo 'Ukuran gambar melebihi 1 Mb';
} else {
    $email = $_POST['user_email'];
    $cek_email = mysql_query("SELECT * FROM tbl_user WHERE user_email = '$email'");
    if (mysql_num_rows($cek_email) > 0) {
        echo "Email sudah terdaftar di database, ganti dengan email yang lain";
    } else {
        $sql = mysql_query("INSERT INTO tbl_user(user_nama,user_email,user_foto) VALUES('" . $_POST['user_nama'] . "', '" . $_POST['user_email'] . "','" . $file_gambar . "')");
        if ($sql) {
            echo 'Simpan data berhasil';
        } else {
            echo 'Simpan data gagal';
        }
    }
}
