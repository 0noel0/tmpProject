<?php require 'top.php';?>

<div class="row">
	<div class="col-sm-12">
	    <section class="panel">
	        <header class="panel-heading">
	            Bienvenido <?php echo $isAdmin ? 'Administrador' : $userName; ?>
	        </header>
	        <div class="panel-body">
	            Bienvenido al sistema de cotizaciones
	        </div>
	    </section>
	</div>
</div>

<?php require 'bottom.php';?>