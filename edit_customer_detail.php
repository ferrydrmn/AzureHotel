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
    if(isset($_GET['id_customer'])){
        $id_customer = $_GET['id_customer'];
        $sql = "SELECT * FROM customer WHERE id_customer = $id_customer";
        $query = mysqli_query($conn, $sql);
        if(mysqli_num_rows($query) <= 0){
            header('location:edit_customer.php');
        }else{
            $data = mysqli_fetch_array($query);
        }
    }else{
        header('location:edit_customer.php');
    }   
?>

<?php
    $check_array = array('sex', 'fname', 'lname', 'address', 'phone_number','email');
    if (!array_diff($check_array, array_keys($_POST))){
        #Ambil semua data pelanggan
        $getIdCard = $_POST['id_card'];
        #Cek NIK
        $sql = "SELECT id_card FROM customer WHERE id_card = '$getIdCard'";
        $query = mysqli_query($conn, $sql);
        $getSex = $_POST['sex'];
        $getFname = $_POST['fname'];
        $getLname = $_POST['lname'];
        $getAddress = mysqli_real_escape_string($conn,$_POST['address']);
        $getPhoneNumber = $_POST['phone_number'];
        $getEmail = $_POST['email'];
        #Query
        $sql = "UPDATE customer SET sex = '$getSex', fname = '$getFname', 
        lname = '$getLname', address='$getAddress', phone_number='$getPhoneNumber', email = '$getEmail'
        WHERE id_customer = $id_customer";
        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));;
        if($query){
            echo "<script>
                alert('Berhasil mengubah data customer!');
                window.location.href = 'edit_customer.php';
            </script>";
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
    <title>Azure Hotel - Manajemen Customer</title>
</head>
<body>
    <main>
        <?php include('include/sidebar.php'); ?>
        <div class="content">
            <div class="content-child">
                <form method="POST" action="" class="content-super-child" style="text-align: center;">
                    <h1>Tambah Data Customer</h1>
                    <div class="input-in-content-half">
                        <div class="input-in-content-column">
                            <h3>NIK</h3>
                            <h3><?php echo $data['id_card']; ?></h3>
                        </div>
                        <div class="input-in-content-column">
                            <h3>Jenis Kelamin</h3>
                            <select name="sex" class="input-form" required>
                                <option value="male">Pria</option>
                                <option value="female">Wanita</option>
                            </select>
                        </div>
                    </div>
                    <div class="input-in-content-half">
                        <div class="input-in-content-column">
                            <h3>Nama Depan:</h3>
                            <input type="text" name="fname" class="input-form" value="<?php echo $data['fname']; ?>" required>
                        </div>
                        <div class="input-in-content-column">
                            <h3>Nama Belakang:</h3>
                            <input type="text" name="lname" class="input-form" value="<?php echo $data['lname']; ?>"" required>
                        </div>
                    </div>
                    <div class="input-in-content-row">
                        <div class="input-in-content-column">
                            <h3>Alamat:</h3>
                            <textarea class="input-form" name="address" required><?php echo $data['address']; ?></textarea>
                        </div>
                    </div>
                    <div class="input-in-content-row">
                        <div class="input-in-content-column">
                            <h3>Nomor HP:</h3>
                            <input type="text" name="phone_number" class="input-form" style="width: 50%;" value="<?php echo $data['phone_number']; ?>" required>
                        </div>
                    </div>
                    <div class="input-in-content-row">
                        <div class="input-in-content-column">
                            <h3>Email:</h3>
                            <input type="email" name="email" class="input-form" style="width: 50%;" value="<?php echo $data['email']; ?>" required>
                        </div>
                    </div>
                    <div class="input-in-content-half" style="width: 100%;">
                        <div class="input-in-content-row" style="width: 100%; align-items: center; justify-content: center;">
                            <button type="submit" class="green-button" style="width: 25%; font-size: 24px; text-decoration: none;">Edit Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>