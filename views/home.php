<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/assets/css/header.css">
	<link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/assets/css/home.css">
    <title>StampyMail</title>
</head>
<body>
	<?php include_once('./views/components/header.php'); ?>
    <div>
		<div class="container-table">
			<div class="wrap-table">
				<div class="table">
					<table>
						<thead>
							<tr class="table-head">
								<th class="column1">Usuario</th>
								<th class="column2">Nombre</th>
								<th class="column3">DNI</th>
								<th class="column4">Email</th>
								<th class="column5">Acciones</th>
							</tr>
						</thead>
						<tbody>
                        <?php
						if(!empty($data['users'])) {
							foreach ($data['users'] as $value) {
								echo '<tr id="user-'.$value->getId().'">';
                                echo '<td class="column1">'. $value->getUsername() . '</td>';
                                echo '<td class="column2">'. $value->getFirstName() . ' ' . $value->getLastName() . '</td>';
                                echo '<td class="column3">'. $value->getDni() . '</td>';
                                echo '<td class="column4">'. $value->getEmail() . '</td>';
                                echo '<td class="column5">
								<a href="'.BASE_URL.'/user/formUser/'.$value->getId().'"><button class="btn-action">Modificar</button></a>';
								if($_SESSION['id'] !== $value->getId()){
									echo '<button onClick="deleteUser('.$value->getId().',event)" class="btn-action">Eliminar</button></td>';
								}
                                echo '</tr>';
                            }/* 
						else {
							echo '<h1>No hay usuarios en el sistema</h1>';
						} */
						?>
						</tbody>
					</table>
						<?php
						}
						else {
							echo '<h1>No hay usuarios en el sistema</h1>';
						}
						?>
                    <button type="button" onClick="newUser()" class="btn-action btn-create">Agregar usuario</button>
				</div>
			</div>
		</div>
	</div>
</body>
<script src="<?=BASE_URL?>/assets/js/user.js"></script>
</html>
