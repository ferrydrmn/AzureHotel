<div class="sidebar">
    <ul>
    <img src="img/icon.png" alt="Azure Hotel" style="width: 200px; margin: 20px;">
        <?php if($_SESSION['level'] == 'receptionist'): ?>
            <li><a href="room_book.php">Pesan Kamar</a></li>
            <li><a href="add_customer.php">Manajemen Customer</a></li>
            <li><a href="booking_information.php">Informasi Pemesanan</a></li>
            <li><a href="type_room_information.php">Informasi Tipe Kamar</a></li>
        <?php elseif($_SESSION['level'] == 'admin'): ?>
            <li><a href="user_management.php">Manajemen Pengguna</a></li>
            <li><a href="room_management.php">Manajemen Kamar</a></li>
            <li><a href="type_room_management.php">Manajemen Tipe Kamar</a></li>
        <?php else: ?>
            <li><a href="income_information.php">Informasi Pendapatan</a></li>
            <li><a href="room_information.php">Informasi Kamar</a></li>
        <?php endif ?>
        <li><a href="user_setting.php">Pengaturan Pengguna</a></li>
        <li class="logout-sidebar"><a href="logout.php">Logout</a></li>
    </ul>
</div>