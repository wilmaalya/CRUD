<form action="<?php echo $action; ?>" method="post">
    <table>
        <tr>
            <td>Username</td>
            <td><input type="text" name="username"  value="<?php echo $username; ?>"/><?php echo form_error('username'); ?></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type="password" name="password"  value="<?php echo $password; ?>"/><?php echo form_error('password'); ?></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type="hidden" name="id_user" value="<?php echo $id_user; ?>" />
                <input type="submit" name="submit" value="<?php echo $tombol; ?>" />
            </td>
        </tr>
 
    </table>
</form>