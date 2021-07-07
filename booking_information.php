<?php
    session_start();
    include('include/connect.php');
?>

<?php
    if(!isset($_SESSION['id_management'])){
        header('location:login.php');
    }else{
        if($_SESSION['level'] != 'receptionist'){
            header('location:verification.php');
        }
    }
?>

<?php
    $sql = "SELECT * FROM data_meminjam WHERE status = 'active' ";
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
    <title>Azure Hotel - Informasi Pemesanan</title>
</head>
<body>
    <main>
        <?php include('include/sidebar.php'); ?>
        <div class="content">
            <div class="content-child">
                <div class="content-super-child" style="justify-content: flex-start;">
                    <h1>Informasi Pemesanan</h1>
                    <?php if ($row_number <= 0): ?>
                        <h3>Belum ada data pemesanan.</h3>
                    <?php else: ?>
                        <table cellspacing="0" cellpadding="0" class="zebra-table">
                            <tr>
                                <th>No.</th>
                                <th>Nama Customer</th>
                                <th>Kamar</th>
                                <th>Tangal Mulai</th>
                                <th>Durasi (hari)</th>
                                <th>Tanggal Selesai</th>
                                <th>Bayar</th>
                                <th>Aksi</th>
                            </tr>
                            <?php $i = 1; ?>
                            <?php while($data = mysqli_fetch_array($query)): ?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php echo $data['fname'].' '.$data['lname'] ?></td>
                                    <td><?php echo $data['room_name'] ?></td>
                                    <td><?php echo $data['start_date'] ?></td>
                                    <td><?php echo $data['duration'] ?></td>
                                    <td><?php echo $data['end_date'] ?></td>
                                    <td><?php echo $data['pay'] ?></td>
                                    <td><a href="booking_edit.php?id_book=<?php echo $data['id_book'] ?>" class="green-button" style="text-decoration: none;">Edit</a></td>
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