<?php
    session_start();
    include('include/connect.php');
?>

<?php
    if(!isset($_SESSION['id_management'])){
        header('location:login.php');
    }else{
        if($_SESSION['level'] != 'manager'){
            header('location:verification.php');
        }
    }
?>

<?php
    if(isset($_GET['setting'])){
        $getSetting = $_GET['setting'];
        if($getSetting == 'year'){
            $messageIncome = "Hari";
            $sql = "SELECT year(start_date) as year, count(id_book) as count, sum(pay) AS income FROM data_meminjam WHERE status = 'finished' GROUP BY year(start_date)";
            $query = mysqli_query($conn, $sql);
            $row_number = mysqli_num_rows($query);
        }else if($getSetting == 'month'){
            $messageIncome = "Bulan";
            $sql = "SELECT monthname(start_date) as month, year(start_date) as year, count(id_book) as count, sum(pay) AS income FROM data_meminjam WHERE status = 'finished' GROUP BY monthname(start_date)";
            $query = mysqli_query($conn, $sql);
            $row_number = mysqli_num_rows($query);
        }else{
            $messageIncome = "Hari";
            $sql = "SELECT start_date, count(id_book) as count, sum(pay) AS income FROM data_meminjam WHERE status = 'finished' GROUP BY start_date";
            $query = mysqli_query($conn, $sql);
            $row_number = mysqli_num_rows($query);
        }
    }else{
        $messageIncome = "Hari";
        $sql = "SELECT start_date, count(id_book) as count, sum(pay) AS income FROM data_meminjam WHERE status = 'finished' GROUP BY start_date";
        $query = mysqli_query($conn, $sql);
        $row_number = mysqli_num_rows($query);
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
    <title>Azure Hotel - Informasi Pendapatan</title>
</head>
<body>
    <main>
        <?php include('include/sidebar.php'); ?>
        <div class="content">
            <div class="content-child">
                <div class="content-super-child" style="justify-content: flex-start;">
                    <h1>Informasi Pendapatan</h1>
                    <?php if ($row_number <= 0): ?>
                        <h3>Belum ada data pendapatan.</h3>
                    <?php else: ?>
                        <form method="GET" action="">
                            <div class="input-in-content-column" style="margin: 10px; justify-content: space-around; width: 100%;">
                                <select name="setting" class="input-form" style="width: 100%;">
                                    <option value="day">Hari</option>
                                    <option value="month">Bulan</option>
                                    <option value="year">Tahun</option>
                                </select>
                                <button type="submit" class="blue-button" style="margin-top: 10px;">Submit</button>
                            </div>
                        </form>
                        <table cellspacing="0" cellpadding="0" class="zebra-table">
                            <tr>
                                <th>No.</th>
                                <th><?php echo $messageIncome ?></th>
                                <th>Jumlah Pemesanan</th>
                                <th>Pendapatan (Rp.)</th>
                            </tr>
                            <?php $i = 1; ?>
                            <?php while($data = mysqli_fetch_array($query)): ?>
                                <?php if(isset($_GET['setting'])): ?>
                                    <?php if($_GET['setting'] == 'year'): ?>
                                        <tr>
                                            <td><?php echo $i ?></td>
                                            <td><?php echo $data['year'] ?></td>
                                            <td><?php echo $data['count'] ?></td>
                                            <td><?php echo $data['income'] ?></td>
                                        </tr>
                                    <?php elseif($_GET['setting'] == 'month'): ?>
                                        <tr>
                                            <td><?php echo $i ?></td>
                                            <td><?php echo $data['month'].' '.$data['year'] ?></td>
                                            <td><?php echo $data['count'] ?></td>
                                            <td><?php echo $data['income'] ?></td>
                                        </tr>
                                    <?php else: ?>
                                        <tr>
                                            <td><?php echo $i ?></td>
                                            <td><?php echo $data['start_date'] ?></td>
                                            <td><?php echo $data['count'] ?></td>
                                            <td><?php echo $data['income'] ?></td>
                                        </tr>
                                    <?php endif ?>
                                <?php else: ?>
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td><?php echo $data['start_date'] ?></td>
                                        <td><?php echo $data['count'] ?></td>
                                        <td><?php echo $data['income'] ?></td>
                                    </tr>
                                <?php endif ?>
                                <?php $i++; ?>
                            <?php endwhile ?>
                        </table>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </main>
</body>
</html>