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
    #Cek tipe kamar
    $sql = "SELECT id_type, name FROM room_type";
    $query = mysqli_query($conn, $sql);
    if($query){
        if(mysqli_num_rows($query) <= 0){
            echo "<script>
                alert('Belum ada data jenis kamar!');
                window.location.href = 'type_room_management.php';
            </script>";
        }
    }
?>

<?php
    $check_array = array('name', 'id_type');
    if (!array_diff($check_array, array_keys($_POST))){
        #Ambil semua data kamar
        $getName = $_POST['name'];
        $getIdType = $_POST['id_type'];
        #Input data ke dalam database
        $sql = "INSERT INTO room (name, id_type, status) VALUES ('$getName',$getIdType,'free')";
        $query = mysqli_query($conn, $sql);
        if($query){
            echo "<script>
                alert('Berhasil menambahkan data kamar!');
                window.location.href = 'room_management.php';
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
    <title>Azure Hotel - Manajemen kamar</title>
</head>
<body>
    <main>
        <?php include('include/sidebar.php'); ?>
        <div class="content">
            <div class="content-child">
                <form method="POST" action="" class="content-super-child" style="text-align: center;">
                    <h1>Tambah Data Kamar</h1>
                    <div class="input-in-content-half">
                        <div class="input-in-content-column" style="justify-content: center;">
                            <h3>Nama Kamar</h3>
                            <input type="text" name="name" class="input-form" required>
                        </div>
                        <div class="input-in-content-column" style="justify-content: center;">
                            <h3>Jenis Kamar</h3>
                            <select name="id_type" class="input-form" required>
                                <?php while($data = mysqli_fetch_array($query)): ?>
                                    <option value="<?php echo $data['id_type'] ?>"><?php echo $data['name'] ?></option>
                                <?php endwhile ?>
                            </select>
                        </div>
                    </div>
                    <div class="input-in-content-half" style="width: 100%;">
                        <div class="input-in-content-row" style="width: 100%; align-items: center; justify-content: center;">
                            <button type="submit" class="blue-button" style="width: 50%; font-size: 24px;">Tambah Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>