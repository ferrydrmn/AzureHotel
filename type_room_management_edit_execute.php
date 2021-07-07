<?php
    $cekFormatFoto1 = true;
    $cekFormatFoto2 = true;
    $cekFormatFoto3 = true;
    
    if($_FILES['foto1']['name'] != ''){
        $foto1tipe = $_FILES['foto1']['type'];
        if(!($foto1tipe == 'image/png' or $foto1tipe == 'image/jpeg' or $foto1tipe == 'image/jpg')){
            $cekFormatFoto1 = false;
        }
    }

    if($_FILES['foto2']['name'] != ''){
        $foto2tipe = $_FILES['foto2']['type'];
        if(!($foto2tipe == 'image/png' or $foto2tipe == 'image/jpg' or $foto2tipe == 'image/jpeg')){
            $cekFormatFoto2 = false;
        }
    }
    if($_FILES['foto3']['name'] != ''){
        $foto3tipe = $_FILES['foto3']['type'];
        if(!($foto3tipe == 'image/png' or $foto3tipe == 'image/jpg' or $foto3tipe == 'image/jpeg')){
            $cekFormatFoto3 = false;
        }
    }

    if($cekFormatFoto1 == true and $cekFormatFoto2 == true and $cekFormatFoto3 == true){
        #Memasukkan data ke dalam database

        $getName = $_POST['name'];
        $getPrice = $_POST['price'];
        $getBedroom = $_POST['bedroom'];
        $getBathroom = $_POST['bathroom'];
        $getDescription = mysqli_real_escape_string($conn, $_POST['desc']);
        
        $sql = "UPDATE room_type SET name = '$getName', price = $getPrice, bedroom = $getBedroom, bathroom = $getBathroom, description = '$getDescription'WHERE id_type = $id_type"; 
        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));;

        if(!$query){
            $verification = "Nama tipe kamar telah digunakan!";
        }else{
            #Memasukkan data foto ke dalam database

            $directory = 'galery';

            if($_FILES['foto1']['name'] != ''){
                $foto1 = "P".$id_properti."1.png";
                $foto_temp1 = $_FILES['foto1']['tmp_name'];
                move_uploaded_file($foto_temp1,$directory."/".$foto1);
            }

            if($_FILES['foto2']['name'] != ''){
                $foto2 = "P".$id_properti."2.png";
                $foto_temp2 = $_FILES['foto2']['tmp_name'];
                move_uploaded_file($foto_temp2,$directory."/".$foto2);
            }

            if($_FILES['foto3']['name'] != ''){
                $foto3 = "P".$id_properti."3.png";
                $foto_temp3 = $_FILES['foto3']['tmp_name'];
                move_uploaded_file($foto_temp3,$directory."/".$foto3);
            }

            echo "
                <script>
                    alert('Edit data berhasil!');
                    window.location.href = 'type_room_management.php';
                </script>
            ";
        }
    }else{
        $verification = "Ekstensi foto harus PNG atau JPEG!";
    }
?>