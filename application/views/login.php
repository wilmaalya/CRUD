<!doctype html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" href="<?php echo base_url() ?>asset/bootstrap/bootstrap.css"/>
    </head>
    <body>
        <div style="margin: auto; width: 225px; margin-top: 100px; border: 1px solid lightgray; padding: 0px 15px">
            <h3>Please Login</h3>
            <form action="<?php echo $action ?>" method="post">
                Username <br>
                <input name="username" type="text" /><br>
                Password <br>
                <input name="password" type="password" /><br>
                <input name="submit" type="submit" value="Login" class="btn btn-primary" />
                <div class="text-center text-error">
                    <?php echo $error; ?>
                </div>
            </form>
        </div>    
    </body>
</html>