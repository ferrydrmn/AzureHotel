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
    $id_management = $_SESSION['id_management'];
?>

<?php
    $check_array = array('sex', 'fname', 'lname', 'address', 'phone_number');
    if (!array_diff($check_array, array_keys($_POST))){
        #Cek apakah user mengupload foto profil baru atau tidak, dan apakah formatnya jpeg atau png
        $pptype = $_FILES['profile_picture']['type'];
        if($pptype == 'image/png' or $pptype == 'image/jpg' or $pptype == 'image/jpeg'){
            #Update foto profile baru ke database
            $ppname = 'FP'.$id_management.'.png';
            $pptemp = $_FILES['profile_picture']['tmp_name'];
            $directory_final = 'user/'.$ppname;
            move_uploaded_file($pptemp,$directory_final);
            $sql = "UPDATE management SET profile_picture = '$directory_final'  WHERE id_management = $id_management";
            $query = mysqli_query($conn, $sql);
        }
        #Ambil semua data dari form
        $getSex = $_POST['sex'];
        $getFname = $_POST['fname'];
        $getLname = $_POST['lname'];
        $getAddress = mysqli_real_escape_string($conn,$_POST['address']);
        $getPhoneNumber = $_POST['phone_number'];
        #Update data ke dalam database
        $sql = "UPDATE management SET sex = '$getSex', fname = '$getFname', lname = '$getLname', address = '$getAddress', phone_number = '$getPhoneNumber' WHERE id_management = $id_management";
        $query = mysqli_query($conn, $sql);
        if($query){
            echo "
            <script>
                alert('Edit data berhasil!');
                window.location.href = 'user_setting.php';
            </script>
            ";
        }
    }
?>

<?php
    $sql = "SELECT * FROM management WHERE id_management = $id_management";
    $query = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($query);
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
    <title>Azure Hotel - Pengaturan Pengguna</title>
</head>
<body>
    <main>
        <?php include('include/sidebar.php'); ?>
        <div class="content">
            <div class="content-child">
                <form method="POST" action="" enctype="multipart/form-data" class="content-super-child" style="text-align: center;">
                    <h1>Edit Informasi Profil</h1>
                    <div class="input-in-content-half">
                        <div class="input-in-content-column">
                            <h3>NIK</h3>
                            <h3><?php echo $data['id_card'] ?>
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
                            <input type="text" name="fname" class="input-form" value="<?php echo $data['fname'] ?>" required>
                        </div>
                        <div class="input-in-content-column">
                            <h3>Nama Belakang:</h3>
                            <input type="text" name="lname" class="input-form" value="<?php echo $data['lname'] ?>" required>
                        </div>
                    </div>
                    <div class="input-in-content-row">
                        <div class="input-in-content-column">
                            <h3>Alamat:</h3>
                            <textarea class="input-form" name="address" required><?php echo $data['address'] ?></textarea>
                        </div>
                    </div>
                    <div class="input-in-content-row">
                        <div class="input-in-content-column">
                            <h3>Nomor HP:</h3>
                            <input type="text" name="phone_number" class="input-form" style="width: 50%;" value = "<?php echo $data['phone_number'] ?>" required>
                        </div>
                    </div>
                    <div class="input-in-content-row">
                        <div class="input-in-content-column" style="margin: 10px 0;">
                            <h3>Email:</h3>
                            <h3><?php echo $data['email'] ?>
                        </div>
                    </div>
                    <div class="input-in-content-row">
                        <div class="input-in-content-column">
                            <h3>Foto Profil:</h3>
                            <input type="file" name="profile_picture">
                        </div>
                    </div>
                    <div class="input-in-content-half" style="width: 100%;">
                        <div class="input-in-content-row" style="width: 100%; align-items: center; justify-content: center;">
                            <button type="submit" class="green-button" style="width: 50%; font-size: 24px; text-decoration: none;">Edit Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>