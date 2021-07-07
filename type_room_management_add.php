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
    $check_array = array('name', 'price', 'bedroom', 'bathroom', 'desc');
    if (!array_diff($check_array, array_keys($_POST))){
        #Eksistensi Foto
        $foto1tipe = $_FILES['foto1']['type'];
        $foto2tipe = $_FILES['foto2']['type'];
        $foto3tipe = $_FILES['foto3']['type'];
        #Nama Tipe Ruangan
        $getName = $_POST['name'];
        #Cek Nama Tipe Ruangan (nama tipe ruangan harus unik)
        $sql = "SELECT name FROM room _type WHERE name = '$getName'";
        $query = mysqli_query($conn, $sql);
        if(mysqli_num_rows($query) >= 1){
            $verification = "Nama tipe kamar telah digunakan!";
        }else{
            if(($foto1tipe == 'image/png' or $foto1tipe == 'image/jpg' or $foto1tipe == 'image/jpeg') and ($foto2tipe == 'image/png' or $foto2tipe == 'image/jpeg' or $foto2tipe == 'image/jpg') and ($foto3tipe == 'image/png' or $foto3tipe == 'image/jpg' or $foto3tipe == 'image/jpeg')){
                #Memasukkan data ke dalam database
                $getPrice = $_POST['price'];
                $getBedroom = $_POST['bedroom'];
                $getBathroom = $_POST['bathroom'];
                $getDescription = mysqli_real_escape_string($conn, $_POST['desc']);
                
                $sql = "INSERT INTO room_type (name, price, description, bedroom, bathroom) VALUES ('$getName', $getPrice, '$getDescription', $getBedroom, $getBathroom)" or die(mysqli_error($conn));
                $query = mysqli_query($conn, $sql);

                if(!$query){
                    $verification = "Nama tipe kamar telah digunakan!";
                }else{
                    #Memasukkan data foto ke dalam database
                    $query = mysqli_query($conn,"SELECT id_type FROM room_type WHERE name = '$getName'");
                    $data = mysqli_fetch_array($query);
                    $id_type = $data['id_type'];
        
                    $foto1 = "P".$id_type."1.png";
                    $foto2 = "P".$id_type."2.png";
                    $foto3 = "P".$id_type."3.png";
        
                    $foto_temp1 = $_FILES['foto1']['tmp_name'];
                    $foto_temp2 = $_FILES['foto2']['tmp_name'];
                    $foto_temp3 = $_FILES['foto3']['tmp_name'];
        
                    $directory = "galery";
                    
                    move_uploaded_file($foto_temp1,$directory."/".$foto1);
                    move_uploaded_file($foto_temp2,$directory."/".$foto2);
                    move_uploaded_file($foto_temp3,$directory."/".$foto3);
                
                    $path_foto = $directory."/".$foto1;
                    $query = mysqli_query($conn,"INSERT INTO room_pict (path, id_type) VALUES ('$path_foto', '$id_type')");
                    
                    $path_foto = $directory."/".$foto2;
                    $query = mysqli_query($conn,"INSERT INTO room_pict (path, id_type) VALUES ('$path_foto', '$id_type')");
                    
                    $path_foto = $directory."/".$foto3;
                    $query = mysqli_query($conn,"INSERT INTO room_pict (path, id_type) VALUES ('$path_foto', '$id_type')");
        
                    echo "
                        <script>
                            alert('Insert data berhasil!');
                            window.location.href = 'type_room_management.php';
                        </script>
                    ";
                }
            }else{
                $verification = "Ekstensi foto harus PNG atau JPEG!";
            }
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
    <title>Azure Hotel - Manajemen Tipe Kamar</title>
</head>
<body>
    <main>
        <?php include('include/sidebar.php'); ?>
        <div class="content">
            <div class="content-child">
                <form method="POST" action="" class="content-super-child" style="text-align: center;" enctype="multipart/form-data">
                    <h1>Tambah Data Tipe Kamar</h1>
                    <div class="input-in-content-half">
                        <div class="input-in-content-column">
                            <h3>Nama Tipe Kamar:</h3>
                            <input type="text" name="name" class="input-form" required>
                        </div>
                        <div class="input-in-content-column">
                            <h3>Harga:</h3>
                            <input type="number" name="price" class="input-form" min="1" required>
                        </div>
                    </div>
                    <div class="input-in-content-half">
                        <div class="input-in-content-column">
                            <h3>Kamar Tidur:</h3>
                            <input type="number" name="bedroom" class="input-form" min="1" required>
                        </div>
                        <div class="input-in-content-column">
                            <h3>Kamar Mandi:</h3>
                            <input type="number" name="bathroom" class="input-form" min="1" required>
                        </div>
                    </div>
                    <div class="input-in-content-row">
                        <div class="input-in-content-column">
                            <h3>Deskripsi:</h3>
                            <textarea class="input-form" name="desc" required></textarea>
                        </div>
                    </div>
                    <div class="input-in-content-column">
                        <h3>Foto 1</h3>
                        <input type="file" name="foto1" required>
                        <h3>Foto 2</h3>
                        <input type="file" name="foto2" required>
                        <h3>Foto 3</h3>
                        <input type="file" name="foto3" required>
                    </div>
                    <p style="color: red; margin: 10px;"><?php echo $verification ?></p>
                    <div class="input-in-content-row" style="width: 100%; align-items: center; justify-content: center;">
                        <button type="submit" class="blue-button" style="width: 50%; font-size: 24px;">Tambah Data</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
