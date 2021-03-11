<div class="header">
    <div class="">
        <a href='/stampymail/default/home'>Inicio</a>
    </div>
    <div class="logout">
        <?php
        if ($_SESSION['loggedIn']) {
            echo ("<a>{$_SESSION['username']}</a>
             <a href='/stampymail/auth/logout'>Cerrar Sesion</a>");
        }
        ?>
    </div>
</div>