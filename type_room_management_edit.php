<?php
    session_start();
    include('include/connect.php');
    $verification = '';
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
    if(isset($_GET['id_type'])){
        $id_type = $_GET['id_type'];
    }else{
        header('location:type_room_management.php');
    }
?>

<?php
    $check_array = array('name', 'price', 'bedroom', 'bathroom', 'desc');
    if (!array_diff($check_array, array_keys($_POST))){
        #Eksistensi Foto
        $foto1tipe = $_FILES['foto1']['type'];
        $foto2tipe = $_FILES['foto2']['type'];
        $foto3tipe = $_FILES['foto3']['type'];
         
        include('type_room_management_edit_execute.php');
    }
?>

<?php
    #Ambil informasi
    $sql = "SELECT * FROM room_type WHERE id_type = $id_type";
    $query = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($query);
    #Ambil gambar
    $sql = "SELECT path FROM room_pict WHERE id_type = $id_type";
    $pict = mysqli_query($conn, $sql);
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
    <title>Azure Hotel - Manajemen Tipe Kamar</title>
</head>
<body>
    <main>
        <?php include('include/sidebar.php'); ?>
        <div class="content">
            <div class="content-child" style="height: 90%;">
                <form method="POST" action="" class="content-super-child" style="text-align: center;" enctype="multipart/form-data" style="height: 80vh;">
                    <h1>Edit Data Tipe Kamar</h1>
                    <div class="input-in-content-row" style="width: 80%; justify-content: space-around; margin: 15px 0px;">
                        <?php $i = 0 ?>
                        <?php while($result_pict = mysqli_fetch_array($pict)):  ?>
                            <img src="<?php echo $result_pict[$i] ?>" style="max-width:200px; max-height: 100px;">
                        <?php endwhile ?>
                    </div>
                    <div class="input-in-content-half">
                        <div class="input-in-content-column">
                            <h3>Nama Tipe Kamar:</h3>
                            <input type="text" name="name" class="input-form" value="<?php echo $data['name'] ?>" required>
                        </div>
                        <div class="input-in-content-column">
                            <h3>Harga:</h3>
                            <input type="number" name="price" class="input-form" min="1" value="<?php echo $data['price'] ?>" required>
                        </div>
                    </div>
                    <div class="input-in-content-half">
                        <div class="input-in-content-column">
                            <h3>Kamar Tidur:</h3>
                            <input type="number" name="bedroom" class="input-form" min="1" value="<?php echo $data['bedroom'] ?>" required>
                        </div>
                        <div class="input-in-content-column">
                            <h3>Kamar Mandi:</h3>
                            <input type="number" name="bathroom" class="input-form" min="1" value="<?php echo $data['bathroom'] ?>" required>
                        </div>
                    </div>
                    <div class="input-in-content-row">
                        <div class="input-in-content-column">
                            <h3>Deskripsi:</h3>
                            <textarea class="input-form" name="desc" required><?php echo $data['description'] ?></textarea>
                        </div>
                    </div>
                    <div class="input-in-content-column">
                        <h3>Foto 1</h3>
                        <input type="file" name="foto1">
                        <h3>Foto 2</h3>
                        <input type="file" name="foto2">
                        <h3>Foto 3</h3>
                        <input type="file" name="foto3">
                    </div>
                    <p style="color: red; margin: 10px;"><?php echo $verification ?></p>
                    <div class="input-in-content-row" style="width: 100%; align-items: center; justify-content: center;">
                        <button type="submit" class="blue-button" style="width: 50%; font-size: 24px;">Edit Data</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script src="script/slideshow.js"></script>
</body>
</html>
