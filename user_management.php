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
    $sql = "SELECT * FROM management WHERE level = 'receptionist'";
    $query = mysqli_query($conn, $sql);
    $row_number = mysqli_num_rows($query);
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
    <title>Azure Hotel - Manajemen Pegawai</title>
</head>
<body>
    <main>
        <?php include('include/sidebar.php'); ?>
        <div class="content">
            <div class="content-child">
                <div class="content-super-child" style="justify-content: flex-start;">
                    <h1>Data Pegawai</h1>
                    <a href="user_management_add.php" class="blue-button" style="font-size: 20px; margin: 10px 0;">Tambahkan Data Resepsionist</a>
                    <?php if ($row_number <= 0): ?>
                        <h3>Belum ada data customer.</h3>
                    <?php else: ?>
                        <table cellspacing="0" cellpadding="0" class="zebra-table">
                            <tr>
                                <th>No.</th>
                                <th>NIK</th>
                                <th>Nama Depan</th>
                                <th>Nama Belakang</th>
                                <th>No. HP</th>
                                <th>Aksi</th>
                            </tr>
                            <?php $i = 1; ?>
                            <?php while($data = mysqli_fetch_array($query)): ?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php echo $data['id_card'] ?></td>
                                    <td><?php echo $data['fname'] ?></td>
                                    <td><?php echo $data['lname'] ?></td>
                                    <td><?php echo $data['phone_number'] ?></td>
                                    <td>
                                        <a href="user_setting_password_admin.php?id_management=<?php echo $data['id_management'] ?>" class="green-button" style="text-decoration: none;">Edit Password</a>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                            <?php endwhile ?>
                        </table>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </main>
</body>
</html>