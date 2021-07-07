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
    $sql = "SELECT * FROM room_type";
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
    <title>Azure Hotel - Manajemen Tipe Kamar</title>
</head>
<body>
    <main>
        <?php include('include/sidebar.php'); ?>
        <div class="content">
            <div class="content-child">
                <div class="content-super-child" style="justify-content: flex-start;">
                    <h1>Data Tipe Kamar</h1>
                    <a href="type_room_management_add.php" class="blue-button" style="width: 50%; font-size: 18px; text-decoration: none; text-align: center; margin: 10px 0;">Tambah Data Tipe Kamar</a>
                    <?php if ($row_number <= 0): ?>
                        <h3>Belum ada data tipe kamar.</h3>
                    <?php else: ?>
                        <table cellspacing="0" cellpadding="0" class="zebra-table">
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Kamar Tidur</th>
                                <th>Kamar Mandi</th>
                                <th>Aksi</th>
                            </tr>
                            <?php $i = 1; ?>
                            <?php while($data = mysqli_fetch_array($query)): ?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><a href="type_room_information_detail.php?id_type=<?php echo $data['id_type'] ?>"><?php echo $data['name'] ?></a></td>
                                    <td><?php echo $data['price'] ?></td>
                                    <td><?php echo $data['bedroom'] ?></td>
                                    <td><?php echo $data['bathroom'] ?></td>
                                    <td><a href="type_room_management_edit.php?id_type=<?php echo $data['id_type'] ?>" class="green-button">Edit</a></td>
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