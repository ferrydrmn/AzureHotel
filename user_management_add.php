<?php
    session_start();
    include('include/connect.php');
?>

<?php
    if(!isset($_SESSION['id_management'])){
        header('location:login.php');
    }else{
        if($_SESSION['level'] != 'admin'){
            header('location:verification.php');
        }
    }
?>

<?php
    $check_array = array('id_card', 'sex', 'fname', 'lname', 'address', 'phone_number','email', 'password');
    if (!array_diff($check_array, array_keys($_POST))){
        #Ambil semua data pelanggan
        $getIdCard = $_POST['id_card'];
        $getEmail = $_POST['email'];
        #Cek NIK
        $sql = "SELECT id_card FROM management WHERE id_card = '$getIdCard'";
        $query_id_card = mysqli_query($conn, $sql);
        $sql = "SELECT email FROM management WHERE email = '$getEmail'";
        $query_email = mysqli_query($conn, $sql);
        if(mysqli_num_rows($query_id_card) >= 1){
            echo "<script>
                alert('Pengguna dengan NIK yang sama telah terdaftar!');
                window.location.href = 'user_management_add.php';
            </script>";
        }else if(mysqli_num_rows($query_email) >= 1){
            echo "<script>
                alert('Pengguna dengan email yang sama telah terdaftar!');
                window.location.href = 'user_management_add.php';
            </script>";
        }else{
            $getSex = $_POST['sex'];
            $getFname = $_POST['fname'];
            $getLname = $_POST['lname'];
            $getAddress = mysqli_real_escape_string($conn,$_POST['address']);
            $getPhoneNumber = $_POST['phone_number'];
            $getPassword = md5($_POST['password']);
            #Query
            $sql = "INSERT INTO management (id_card, fname, lname, address, phone_number, sex, email, password, level, profile_picture) 
            VALUES ('$getIdCard', '$getFname', '$getLname', '$getAddress', '$getPhoneNumber', '$getSex', '$getEmail', '$getPassword', 'receptionist','img/profile.png')";
            $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));;
            if($query){
                echo "<script>
                    alert('Berhasil menambahkan data resepsionis!');
                    window.location.href = 'user_management.php';
                </script>";
            }
        } 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/main.css">
    <link rel="stylesheet" href="style/form.css">
    <link rel="stylesheet" href="style/button.css">
    <link rel="stylesheet" href="style/sidebar.css">
    <link rel="stylesheet" href="style/content.css">
    <title>Azure Hotel - Manajemen Pengguna</title>
</head>
<body>
    <main>
        <?php include('include/sidebar.php'); ?>
        <div class="content">
            <div class="content-child">
                <form method="POST" action="" class="content-super-child" style="text-align: center;">
                    <h1>Tambah Data Pengguna</h1>
                    <div class="input-in-content-half">
                        <div class="input-in-content-column">
                            <h3>NIK</h3>
                            <input type="text" name="id_card" class="input-form" required>
                        </div>
                        <div class="input-in-content-column">
                            <h3>Jenis Kelamin</h3>
                            <select name="sex" class="input-form" required>
                                <option value="male">Pria</option>
                                <option value="female">Wanita</option>
                            </select>
                        </div>
                    </div>
                    <div class="input-in-content-half">
                        <div class="input-in-content-column">
                            <h3>Nama Depan:</h3>
                            <input type="text" name="fname" class="input-form" required>
                        </div>
                        <div class="input-in-content-column">
                            <h3>Nama Belakang:</h3>
                            <input type="text" name="lname" class="input-form" required>
                        </div>
                    </div>
                    <div class="input-in-content-row">
                        <div class="input-in-content-column">
                            <h3>Alamat:</h3>
                            <textarea class="input-form" name="address" required></textarea>
                        </div>
                    </div>
                    <div class="input-in-content-row">
                        <div class="input-in-content-column">
                            <h3>Nomor HP:</h3>
                            <input type="text" name="phone_number" class="input-form" style="width: 50%;" required>
                        </div>
                    </div>
                    <div class="input-in-content-row">
                        <div class="input-in-content-column">
                            <h3>Email:</h3>
                            <input type="email" name="email" class="input-form" style="width: 50%;" required>
                        </div>
                    </div>
                    <div class="input-in-content-row">
                        <div class="input-in-content-column">
                            <h3>Password:</h3>
                            <input type="password" name="password" class="input-form" style="width: 50%;" required>
                        </div>
                    </div>
                    <div class="input-in-content-half" style="width: 100%;margin: 10px 0px;">
                        <div class="input-in-content-row" style="width: 100%; align-items: center; justify-content: center;">
                            <button type="submit" class="blue-button" style="width: 50%; font-size: 24px;">Tambah Data</button>
                        </div>
                        <div class="input-in-content-row" style="width: 100%; align-items: center; justify-content: center;">
                            <a href="edit_customer.php" class="green-button" style="width: 50%; font-size: 24px; text-decoration: none;">Edit Data</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>