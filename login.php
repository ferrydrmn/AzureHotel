<?php
    session_start();
    include('include/connect.php');
    $verification='';
?>

<?php
    if(isset($_SESSION['id_management'])){
        header('location:verification.php');
    }
?>

<?php
    if(isset($_POST['email']) and isset($_POST['password'])){
        #Mengambil data dari POST
        $getEmail = $_POST['email'];
        $getPassword = md5($_POST['password']);
        #Mengambil data dari database
        $sql = "SELECT id_management, email, password, level FROM management WHERE email = '$getEmail'";
        $queryExecute = mysqli_query($conn, $sql);
        $fetchData = mysqli_fetch_array($queryExecute);
        #Menecocokkan data dari POST dengan data dari database
        if($getEmail == $fetchData['email'] and $getPassword == $fetchData['password']){
            $_SESSION['id_management'] = $fetchData['id_management'];
            $_SESSION['level'] = $fetchData['level'];
            header('location:room_book.php');
        }else{
            $verification = 'Email atau password salah!';
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
    <title>Azure Hotel - Login</title>
</head>
<body>
    <main>
        <form method="POST" action="" class="form">
            <div class="form-header">
                <img src="img/icon.png" alt="AzureHotelIcon" class="icon">
                <h1>LOG IN</h1>
            </div>
            <input name="email" type="email" class="input-form" placeholder="Email" required>
            <input name="password" type="password" class="input-form" placeholder="Password" required>
            <p style="color: red"><?php echo $verification; ?></p>
            <button type="submit" class="blue-button" style="font-size: 24px; width: 45%;">LOG IN</button> 
        </form>
    </main>
</body>
</html>