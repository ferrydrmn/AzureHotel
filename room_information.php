<?php
    session_start();
    include('include/connect.php');
?>

<?php
    if(!isset($_SESSION['id_management'])){
        header('location:login.php');
    }else{
        if($_SESSION['level'] != 'manager'){
            header('location:verification.php');
        }
    }
?>

<?php
    $sql = "select room.name as room_name, room_type.name as type_name, room.status, room.id_room, room_type.id_type FROM room JOIN room_type ON room.id_type = room_type.id_type";
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
                    <h1 style="margin-bottom: 10px;">Informasi Kamar</h1>
                    <?php if ($row_number <= 0): ?>
                        <h3>Belum ada data kamar.</h3>
                    <?php else: ?>
                        <table cellspacing="0" cellpadding="0" class="zebra-table">
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Tipe Kamar</th>
                                <th>Status</th>
                            </tr>
                            <?php $i = 1; ?>
                            <?php while($data = mysqli_fetch_array($query)): ?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php echo $data['room_name'] ?></td>
                                    <td><a href="type_room_information_detail.php?id_type=<?php echo $data['id_type'] ?>"><?php echo $data['type_name'] ?></a></td>
                                    <td><?php echo ucfirst($data['status']) ?></td>
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