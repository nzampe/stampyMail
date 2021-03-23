<!DOCTYPE html>
<html lang="en">
    <head>
        <title>StampyMail</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/assets/css/login.css">
        <script src="<?= BASE_URL ?>/assets/js/auth.js"></script>
    </head>
    <body>
    <?php include_once('./views/components/config.php'); ?>
        <div>
            <div class="container-login">
                <div class="wrap-login">
                    <form id="login-form" class="login-form" onsubmit='login(event);' method="post">
                        <span class="login-title">
                            StampyMail
                        </span>
                        <p id="error" name="error"></p>
                        <div class="input-username">
                            <input class="input" type="text" id="username" name="username" placeholder="Username" required>
                            <span class=""></span>
                        </div>

                        <div>
                            <input class="input" type="password" id="password" name="password" placeholder="Password" required>
                            <span class=""></span>
                        </div>
        
                        <div class="container-login-btn ">
                            <button type="submit" class="login-btn">
                                ENTRAR
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
