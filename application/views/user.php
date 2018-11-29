<h1><?php echo $judul; ?></h1>
<div>Tabel User | <a class="btn btn-default" href="<?php echo base_url() ?>index.php/user/tambah">Tambah</a>
</div>
<table class="table">
    <tr>
        <td>No</td>
        <td>Username</td>
        <td>Password</td>
        <td>Aksi</td>
    </tr>
    <?php
    $nourut = 1;
    foreach ($rows as $row) {
        ?>
        <tr>
            <td><?php echo $nourut++; ?></td>
            <td><?php echo $row->username; ?></td>
            <td><?php echo $row->password; ?></td>
            <td>
                <a href="<?php echo base_url() ?>index.php/user/ubah/<?php echo $row->id_user; ?>">Edit</a>
                <a href="<?php echo base_url() ?>index.php/user/delete/<?php echo $row->id_user; ?>">Delete</a>
            </td>
        </tr>
        <?php
    }
    ?> 
</table>