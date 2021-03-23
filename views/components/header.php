<?php include_once('./views/components/config.php'); ?>
<div class="header">
    <div class="">
        <a href='<?= BASE_URL ?>/default/home'>Inicio</a>
    </div>
    <div class="logout">
        <?php
        if ($_SESSION['loggedIn']) {
            echo "<a>{$_SESSION['username']}</a><a href='".BASE_URL."/auth/logout'>Cerrar Sesion</a>";
        }
        ?>
    </div>
</div>
