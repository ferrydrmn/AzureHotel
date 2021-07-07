<?php
    session_start();
    include('include/connect.php');
?>

<?php
    if(!isset($_SESSION['id_management'])){
        header('location:login.php');
    }
?>

<?php
    $id_management = $_SESSION['id_management'];
    $sql = "SELECT * FROM management WHERE id_management = $id_management";
    $query = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($query);
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
    <title>Azure Hotel - Pengaturan Pengguna</title>
</head>
<body>
    <main>
        <?php include('include/sidebar.php'); ?>
        <div class="content">
            <div class="content-child">
                <div class="content-super-child">
                    <h1>Informasi Pengguna</h1>
                    <img src="<?php echo $data['profile_picture']; ?>" alt="Profile Picture" class="profile-picture">
                    <div class="input-in-content-column" style="width: 100%; justify-content: center; align-items: center;">
                        <h3><?php echo $data['fname'] . ' ' . $data['lname'] ?></h3>
                        <h5><?php echo ucfirst($data['level'])  ?>
                    </div>
                    <div class="input-in-content-half" style="width: 100%;">
                        <div class="input-in-content-row" style="width: 100%; align-items: center; justify-content: center;">
                            <a href="user_setting_password.php" class="blue-button" style="width: 50%; font-size: 24px; text-decoration: none; text-align: center;">Edit Password</a>
                        </div>
                        <div class="input-in-content-row" style="width: 100%; align-items: center; justify-content: center;">
                            <a href="user_setting_information.php" class="green-button" style="width: 50%; font-size: 24px; text-decoration: none; text-align: center;">Edit Informasi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>