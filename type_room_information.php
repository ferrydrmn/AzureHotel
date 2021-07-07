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
    <title>Azure Hotel - Informasi Tipe Kamar</title>
</head>
<body>
    <main>
        <?php include('include/sidebar.php'); ?>
        <div class="content">
            <div class="content-child">
                <div class="content-super-child" style="justify-content: flex-start;">
                    <h1>Informasi Kamar</h1>       
                    <div class="input-in-content-row" style="flex-wrap: wrap; justify-content: space-around; width: 100%;">             
                    <?php if ($row_number <= 0): ?>
                        <h3>Belum ada informasi tipe kamar.</h3>
                    <?php else: ?>
                        <?php while($data = mysqli_fetch_array($query)): ?>
                            <div class="card">
                                <img src="galery/P<?php echo $data['id_type'] ?>1.png" alt="Room Picture">
                                <a href="type_room_information_detail.php?id_type=<?php echo $data['id_type'] ?>"><?php echo $data['name'] ?></a>
                                <h3><?php echo $data['price'].'/malam' ?>
                            </div>
                        <?php endwhile ?>
                    <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>