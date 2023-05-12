<?php
mysql_connect("localhost", "root", "");
mysql_select_db("db_test");

if (isset($_POST["user_cari"])) {
    $search = $_POST["user_cari"];
    $query = mysql_query("SELECT * FROM tbl_user WHERE user_nama LIKE '%" . $search . "%' OR user_email LIKE '%" . $search . "%'");
} else {
    $query = mysql_query("SELECT * FROM tbl_user ORDER BY user_id ASC");
}

$output = '';

if (mysql_num_rows($query) > 0) {
    $output .= '<div class="table-responsive">
                    <table border="1">
                        <tr>
                        <th>ID</th>
                        <th>NAMA</th>
                        <th>EMAIL</th>
                        <th>FOTO</th>
                        <th>STATUS</th>
                        </tr>';
    while ($row = mysql_fetch_array($query)) {
        if ($row["user_status"] == "0") {
            $user_status = "Aktif";
        } else {
            $user_status = "Tidak Aktif";
        }
        $output .= '<tr>
                        <td>' . $row["user_id"] . '</td>
                        <td>' . $row["user_nama"] . '</td>
                        <td>' . $row["user_email"] . '</td>
                        <td><img src="data:image/jpeg;base64,' . base64_encode($row["user_foto"]) . '" width="100"></td>
                        <td>' .  $user_status . '</td>
                    </tr>';
    }
    echo $output;
} else {
    echo 'Data Tidak Ada';
}
