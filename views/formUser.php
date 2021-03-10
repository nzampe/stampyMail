<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="/stampymail/assets/css/header.css">
	<link rel="stylesheet" type="text/css" href="/stampymail/assets/css/formUser.css">
    <title>Formulario de usuario</title>
</head>
<body>
	<?php include_once('./views/components/header.php');
    if(!empty($data['user'])){
        $user = $data['user'];
        $titleBtn = "Editar";
    }
    else {
        $user = null;
        $titleBtn = "Agregar";
    }
    ?>
    <div>
        <form id="user-form" class="user-form" onsubmit="actionUser(event);" method="POST">
            <?php
                if($user){
                    echo '<input type="hidden" name="id" value="'.$user['id'].'">';
                }
            ?>
            <p>Nombre:</p>
            <input id="firstName" name="firstName" type="text" class="field" value="<?= $user ? $user['username'] : '' ?>" required> <br/>
            
            <p>Apellido:</p>
            <input id="lastName" name="lastName" type="text" class="field" value="<?= $user ? $user['lastName'] : '' ?>" required> <br/>
            
            <p>Username:</p>
            <input id="username" name="username" type="text" class="field" value="<?= $user ? $user['username'] : '' ?>" required> <br/>
            
            <p>Password:</p>
            <input id="password" name="password" type="password" class="field" value="<?= $user ? $user['password'] : '' ?>" required> <br/>
            
            <p>Email:</p>
            <input id="email" name="email" type="text" class="field" value="<?= $user ? $user['email'] : '' ?>" required> <br/>
            
            <p>DNI:</p>
            <input id="dni" name="dni" type="text" class="field" value="<?= $user ? $user['dni'] : '' ?>" > <br/>
            
            <p id="error" name="error"></p>

            <div class="center-content">
                <button type="submit" class="btn-action"><?php echo $titleBtn ?></button>
            </div>
        </form>
    </div>
</body>
<script src="/stampymail/assets/js/user.js"></script>
</html>