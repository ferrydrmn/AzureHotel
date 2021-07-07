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
    <title>Azure Hotel - Pesan Kamar</title>
</head>
<body>
    <main>
        <?php include('include/sidebar.php'); ?>
        <div class="content">
            <div class="content-child">
                <form method="GET" action="room_book_confirm.php" class="content-super-child" style="text-align: center;">
                    <h1>Pesan Kamar</h1>
                    <div class="input-in-content">
                        <h3>NIK</h3>
                        <input type="text" name="id_card" class="input-form" required>
                    </div>
                    <button type="submit" class="blue-button" style="width: 20%; font-size: 24px;">Pesan</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>