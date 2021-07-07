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
    $sql = "SELECT * FROM customer";
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
    <title>Azure Hotel - Manajemen Customer</title>
</head>
<body>
    <main>
        <?php include('include/sidebar.php'); ?>
        <div class="content">
            <div class="content-child">
                <div class="content-super-child" style="justify-content: flex-start;">
                    <h1>Edit Data Customer</h1>
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
                                    <td><a href="edit_customer_detail.php?id_customer=<?php echo $data['id_customer'] ?>" class="green-button" style="text-decoration: none;">Edit</a></td>
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