<?php
    session_start();
    include("include/connect.php");
    $verification = '';
?>

<?php
    if(!isset($_SESSION['id_management'])){
        header('location:login.php');
    }
?>

<?php 
    if(isset($_GET['id_management'])){
        $id_management = $_GET['id_management'];
        $sql = "SELECT level FROM management WHERE id_management = $id_management";
        $query = mysqli_query($conn, $sql);
        if($query){
            $data = mysqli_fetch_array($query);
            if($data['level'] == 'manager'){
                header('location:user_management.php');
            }
        }
    }else{
        header('location:user_management.php');
    }   
?>

<?php
     $check_array = array('old_password', 'new_password', 'new_password_confirmation');
     if (!array_diff($check_array, array_keys($_POST))){
        #Ambil password
        $getOldPassword = md5($_POST['old_password']);
        $getNewPassword = md5($_POST['new_password']);
        $getNewPasswordConfirmation = md5($_POST['new_password_confirmation']);
        if($getNewPassword != $getNewPasswordConfirmation){
            $verification = 'Password baru dengan konfirmasi password baru tidak sama';
        }else{
            $id_management = $_GET['id_management'];
            $sql = "SELECT password FROM management WHERE id_management = $id_management";
            $query = mysqli_query($conn, $sql);
            if($query){
                $data = mysqli_fetch_array($query);
                if($getOldPassword == $data['password']){
                    $sql = "UPDATE management SET password = '$getNewPassword' WHERE id_management = $id_management";
                    $query = mysqli_query($conn, $sql);
                    if($query){
                        echo "
                        <script>
                            alert('Berhasil mengubah password!');
                            window.location.href = 'user_setting.php';
                        </script>
                        ";
                    }
                }else{
                    $verification = 'Password lama salah!';
                }
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
    <title>Azure Hotel - Ganti Password</title>
</head>
<body>
    <main>
        <form method="POST" action="" class="form">
            <div class="form-header">
                <h1 style="font-size: 28px;">GANTI PASSWORD</h1>
            </div>
            <input name="old_password" type="password" class="input-form" placeholder="Password Lama" required>
            <input name="new_password" type="password" class="input-form" placeholder="Password Baru" required>
            <input name="new_password_confirmation" type="password" class="input-form" placeholder="Konfirmasi Password Baru" required>
            <p style="color: red; margin: 10px;"><?php echo $verification; ?></p>
            <button type="submit" class="blue-button" style="font-size: 20px; width: 45%;">GANTI PASSWORD</button> 
            <a href="user_management.php" class="green-button" style="font-size: 20px; text-decoration: none; width: 45%; text-align: center;">KEMBALI</a>
        </form>
    </main>
</body>
</html>