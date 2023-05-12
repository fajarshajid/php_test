<!DOCTYPE html>
<html>

<head>
    <title>TEST FAJAR SHAJID</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php
    mysql_connect("localhost", "root", "");
    mysql_select_db("db_test");
    ?>
</head>

<body>

    <center>
        <table>
            <form id="formUser" method="POST" enctype='multipart/form-data'>
                <tr>
                    <td>Nama</td>
                    <td>
                        <input type="text" name="user_nama" onkeyup="validateName()" required id="user_nama">
                        <br>
                        <span id="nama-error" class="error"></span>
                    </td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>
                        <input type="email" name="user_email" onkeyup="validateEmail()" required id="user_email">
                        <span id="email-error" class="error"></span>
                    </td>
                </tr>
                <tr>
                    <td>Gambar</td>
                    <td><input type="file" name="user_foto" required id="user_foto"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="submit-btn" value="Simpan"></td>
                </tr>
            </form>
        </table>
    </center>

    <hr>

    <center>
        <input type="text" name="user_cari" required id="user_cari" placeholder="Cari">
        <br>
        <div id="result"></div>


    </center>


    <script type="text/javascript">
        function validateName() {
            var name = document.getElementById("user_nama").value;
            var regex = /^[a-zA-Z\s]*$/;
            name = name.replace(/[^a-zA-Z\s]/g, "");
            document.getElementById("user_nama").value = name;
            if (!regex.test(name)) {
                $('#nama-error').html("hanya huruf dan spasi yang diizinkan");
                document.getElementById("submit-btn").disabled = true;
            } else {
                $('#nama-error').html("");
                document.getElementById("submit-btn").disabled = false;
            }
        }

        function validateEmail() {
            var email = document.getElementById("user_email").value;
            var regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!regex.test(email)) {
                $('#email-error').html("Email tidak valid");
                document.getElementById("submit-btn").disabled = true;
            } else {
                $('#email-error').html("");
                document.getElementById("submit-btn").disabled = false;
            }

        }

        function load_data(user_cari) {
            $.ajax({
                url: "user_data.php",
                method: "POST",
                data: {
                    user_cari: user_cari
                },
                success: function(data) {
                    $('#result').html(data);
                }
            });
        }

        $('#user_cari').keyup(function() {
            var search = $(this).val();
            if (search != '') {
                load_data(search);
            } else {
                load_data();
            }
        });

        $(document).ready(function() {
            load_data();
        });


        $("form").submit(function(e) {
            e.preventDefault();
            var form = $('#formUser')[0];
            var data = new FormData(form);
            $.ajax({
                url: 'simpan_data.php',
                type: 'post',
                enctype: 'multipart/form-data',
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    alert(data);
                    load_data();
                    form.reset();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        });
    </script>
</body>

</html>