<?php 

require 'top.php';

$hasReturned = false;

if(isset($_FILES['file'])){
	$res = uploadExcel();
	if($res != "error"){
		$res2 = proccessExcel($res);
		$hasReturned = $res2;
	}
}

?>
<?php if($hasReturned){ ?>
<div class="row">
	<div class="col-md-12">
	    <div class="panel panel-default">
	        <div class="panel-body">
	            <h1>Importacion hecha satisfactoriamente.</h1>
	        </div>
	    </div>
	</div>
</div>
<?php }else{ ?>
<div class="row">
	<div class="col-md-12">
	    <div class="panel panel-default">
	        <div class="panel-heading">
	            <h3 class="panel-title">Importar data desde Excel</h3>
	        </div>
	        <div class="panel-body">
	            <h2 class="lead">Importacion de XLS o XLSX</h2>
	            <form id="fileupload" action="" method="POST" enctype="multipart/form-data" class="">
	            	<div class="row fileupload-buttonbar">
	            	    <div class="col-lg-5">
	            	        <span class="btn btn-success fileinput-button">
	            	        	<i class="glyphicon glyphicon-plus"></i>
	            	        	<span>Agregar archivo</span>
	            	        	<input type="file" name="file" id="file" accept=".xlsx,.xls">
	            	        </span>
	            	        <button type="submit" name="submit" id="submit" class="btn btn-primary start">
	            	            <i class="glyphicon glyphicon-upload"></i>
	            	            <span>Importar</span>
	            	        </button>
	            	    </div>
	            	    <div class="col-lg-7">
	            	    	<h3 id="selectedArchive"></h3>
	            	    </div>
	            	</div>
	            </form>
	            <br>
	            <div class="panel panel-default">
	                <div class="panel-heading">
	                    <h3 class="panel-title">Notas</h3>
	                </div>
	                <div class="panel-body">
	                    <ul>
	                        <li>El tamaño maximo de un archivo xls o xlsx permitido es de <strong>10 MB</strong>.</li>
	                        <li>La importacion podria durar hasta <strong>5 minutos</strong>.</li>
	                        <li>Los archivos de importacion quedaran guardados en la carpeta <strong>/uploads</strong>.</li>
	                    </ul>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
</div>
<div class="clearfix"></div>
<br>
<br>
<br>
<div id="loading" class="row" style="display: none;">
	<div class="col-lg-2"></div>
	<div class="col-lg-8 text-center">
		<div class="progress progress-striped active progress-sm">
			<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
			    <span class="sr-only">Lorem ipsum</span>
			</div>
		</div>
		<h3>La importacion podria durar hasta 5 minutos.</h3>
		<h2>Porfavor espere.</h2>
	</div>
	<div class="col-lg-2"></div>
</div>
<?php } ?>

<script type="text/javascript">
	$('#file').on('change', function() {
		var f = this.value;
		f = f.replace(/.*[\/\\]/, ''); 
	  	$("#selectedArchive").html("Archivo seleccionado: "+f);
	})

	$("#submit").click(function() {
		$("#loading").show()
	});
</script>

<?php require 'bottom.php';?>