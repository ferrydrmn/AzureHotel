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
    $sql = "SELECT * FROM room";
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
    <title>Azure Hotel - Manajemen Kamar</title>
</head>
<body>
    <main>
        <?php include('include/sidebar.php'); ?>
        <div class="content">
            <div class="content-child">
                <div class="content-super-child" style="justify-content: flex-start;">
                    <h1>Data Kamar</h1>
                    <a href="room_management_add.php" class="blue-button" style="width: 50%; font-size: 18px; text-decoration: none; text-align: center; margin: 10px 0;">Tambah Data Kamar</a>
                    <?php if ($row_number <= 0): ?>
                        <h3>Belum ada data kamar.</h3>
                    <?php else: ?>
                        <table cellspacing="0" cellpadding="0" class="zebra-table">
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Tipe Kamar</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            <?php $i = 1; ?>
                            <?php while($data = mysqli_fetch_array($query)): ?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php echo $data['name'] ?></td>
                                    <?php
                                        $sql_type = "SELECT name FROM room_type WHERE id_type = $data[id_type]";
                                        $query_type = mysqli_query($conn, $sql_type);
                                        $room_type = mysqli_fetch_array($query_type);
                                    ?>
                                    <td><?php echo $room_type['name'] ?></td>
                                    <td><?php echo ucfirst($data['status']) ?></td>
                                    <?php if($data['status'] != 'booked'): ?>
                                    <td>
                                        <a href="room_management_edit.php?id_room=<?php echo $data['id_room'] ?>" class="green-button" style="width: 50%; font-size: 18px;">Edit</a>
                                    </td>
                                    <?php else: ?>
                                        <td>-</td>
                                    <?php endif ?>
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