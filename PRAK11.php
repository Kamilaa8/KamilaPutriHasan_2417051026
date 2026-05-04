<?php
// 1. KONEKSI DATABASE
$conn = mysqli_connect("localhost", "root", "", "praktikum_crud");

// 2. CREATE (INSERT DATA) - menggunakan POST
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    mysqli_query($conn, "INSERT INTO mahasiswa (nama) VALUES ('$nama')");
}

// 3. DELETE - menggunakan GET
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id=$id");
}

// 4. AMBIL DATA UNTUK EDIT (GET)
$edit = false;
if (isset($_GET['edit'])) {
    $edit = true;
    $id = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE id=$id");
    $row = mysqli_fetch_assoc($result);
}

// 5. UPDATE DATA (POST)
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    mysqli_query($conn, "UPDATE mahasiswa SET nama='$nama' WHERE id=$id");
}
?>

<h2>CRUD Sederhana</h2>

<!-- FORM TAMBAH / EDIT -->
<form method="POST">
    <input type="hidden" name="id" value="<?= $edit ? $row['id'] : '' ?>">
    <input type="text" name="nama" placeholder="Masukkan nama" 
           value="<?= $edit ? $row['nama'] : '' ?>">

    <?php if ($edit): ?>
        <button type="submit" name="update">Update</button>
    <?php else: ?>
        <button type="submit" name="tambah">Tambah</button>
    <?php endif; ?>
</form>

<br>

<!-- READ (MENAMPILKAN DATA) -->
<table border="1" cellpadding="10">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Aksi</th>
    </tr>

    <?php
    $data = mysqli_query($conn, "SELECT * FROM mahasiswa");
    $no = 1;
    while ($d = mysqli_fetch_assoc($data)) {
    ?>
    <tr>
        <td><?= $no++; ?></td>
        <td><?= $d['nama']; ?></td>
        <td>
            <!-- GET untuk edit & delete -->
            <a href="?edit=<?= $d['id']; ?>">Edit</a>
            <a href="?hapus=<?= $d['id']; ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
        </td>
    </tr>
    <?php } ?>
</table>