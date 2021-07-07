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
    if(isset($_GET['id_room'])){
        $id_room = $_GET['id_room'];
    }else{
        header('location:room_management.php');
    }
?>

<?php
    $check_array = array('name', 'id_type', 'status');
    if (!array_diff($check_array, array_keys($_POST))){
        #Ambil semua data kamar
        $getName = $_POST['name'];
        $getIdType = $_POST['id_type'];
        $getStatus = $_POST['status'];
        #Cek Nama (nama ruangan bersifat unik)
        #Input data ke dalam database
        $sql = "UPDATE room SET name = '$getName', id_type = '$getIdType', status = '$getStatus' WHERE id_room = '$id_room'";
        $query = mysqli_query($conn, $sql); //or die(mysqli_error($conn));
        if($query){
            echo "<script>
                alert('Berhasil mengedit data kamar!');
                window.location.href = 'room_management.php';
            </script>";
        }else{
            echo "<script>
                alert('Nama ruangan telah digunakan!');
                window.location.href = 'room_management_edit.php?id_room=$id_room';
            </script>";
        }
    }
?>

<?php
    #Data kamar
    $sql = "SELECT name FROM room WHERE id_room = $id_room";
    $query_room = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($query_room);
    #Data tipe kamar
    $sql = "SELECT id_type, name FROM room_type";
    $query_type = mysqli_query($conn, $sql);
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
                <form method="POST" action="" class="content-super-child" style="text-align: center;">
                    <h1>Edit Data Kamar</h1>
                    <div class="input-in-content-half">
                        <div class="input-in-content-column" style="justify-content: center;">
                            <h3>Nama Kamar</h3>
                            <input type="text" name="name" class="input-form" value="<?php echo $data['name'] ?>" required>
                        </div>
                        <div class="input-in-content-column" style="justify-content: center;">
                            <h3>Jenis Kamar</h3>
                            <select name="id_type" class="input-form" required>
                                <?php while($type = mysqli_fetch_array($query_type)): ?>
                                    <option value="<?php echo $type['id_type'] ?>"><?php echo $type['name'] ?></option>
                                <?php endwhile ?>
                            </select>
                        </div>
                    </div>
                    <div class="input-in-content-column">
                        <h3>Status:</h3>
                        <select name="status" class="input-form" style="width: 25%;" required>
                            <option value="free">Free</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                    </div>
                    <div class="input-in-content-half" style="width: 100%;">
                        <div class="input-in-content-row" style="width: 100%; align-items: center; justify-content: center;">
                            <button type="submit" class="green-button" style="width: 50%; font-size: 24px;">Edit Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>