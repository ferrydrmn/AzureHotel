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
    if(isset($_GET['id_type'])){
        $id_type = $_GET['id_type'];
    }else{
        header('location:type_room_information.php');
    }
?>

<?php
    $sql = "SELECT * FROM room_type WHERE id_type = $id_type";
    $query = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($query);
    $sql = "SELECT path FROM room_pict WHERE id_type = $id_type";
    $query_pict = mysqli_query($conn, $sql) or die(mysqli_error($conn));
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
    <style>
        .input-in-content-column{
            margin: 5px 0px;
        }
    </style>
    <title>Azure Hotel - Informasi Tipe Kamar</title>
</head>
<body>
    <main>
        <?php include('include/sidebar.php'); ?>
        <div class="content">
            <div class="content-child" style="width: 90%; height: 90vh;">
                <div class="content-super-child" style="justify-content: flex-start;">
                    <h1>Informasi Kamar</h1>       
                        <div class="input-in-content-row">             
                        <!-- Slideshow container -->
                        <div class="slideshow-container">

                        <!-- Full-width images with number and caption text -->
                        <?php $i = 1 ?>
                        <?php while($pict = mysqli_fetch_array($query_pict)): ?>
                        <div class="mySlides fade">
                        <div class="numbertext"><?php echo $i ?> / 3</div>
                        <img src="<?php echo $pict['path'] ?>" style="max-width: 500px; max-height: 300px;">
                        </div>
                        <?php $i ++ ?>
                        <?php endwhile ?>

                        <!-- Next and previous buttons -->
                        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                        <a class="next" onclick="plusSlides(1)">&#10095;</a>
                        </div>
                        <br>

                        <!-- The dots/circles -->
                        <div style="text-align:center">
                        <span class="dot" onclick="currentSlide(1)"></span>
                        <span class="dot" onclick="currentSlide(2)"></span>
                        <span class="dot" onclick="currentSlide(3)"></span>
                        </div>
                    </div>
                    <div class="input-in-content-column">
                        <h2>Tipe Ruangan:</h2>
                        <h4><?php echo $data['name'] ?>
                    </div>
                    <div class="input-in-content-column">
                        <h2>Deskripsi:</h2>
                        <h4><?php echo $data['description'] ?>
                    </div>
                    <div class="input-in-content-row">
                        <div class="input-in-content-column">
                            <h2>Kamar Tidur:</h2>
                            <h4><?php echo $data['bedroom'] ?>
                        </div>
                        <div class="input-in-content-column">
                            <h2>Kamar Mandi:</h2>
                            <h4><?php echo $data['bathroom'] ?>
                        </div>
                        <div class="input-in-content-column">
                            <h2>Harga:</h2>
                            <h4><?php echo 'Rp. '.$data['price'].'/malam' ?>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </main>
    <script src="script/slideshow.js"></script>
</body>
</html>