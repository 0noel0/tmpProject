<?php 
require 'top.php';

$res = getPrototypeInstance()->select("u.id AS ID, ud.name AS Nombre, ud.last_name AS Apellido, ut.name AS Tipo", "users AS u, user_detail AS ud, user_type AS ut", "WHERE ud.id = u.detail_id AND ut.id = u.type_id");
$data = json_encode($res["res"]);
?>

<div class="row">
	<div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
            	Administracion de usuarios
            </header>
            <div class="panel-body" style="display: block;">
                <div class="adv-table">
                	<table class="display table table-bordered table-striped" id="usuarios">
                	</table>
                </div>
            </div>
        </section>
	</div>
</div>

<script type="text/javascript">

function buildHtmlTable(myList, selector) {
  var columns = addAllColumnHeaders(myList, selector);
  for (var i = 0; i < myList.length; i++) {
    var row$ = $('<tr/>');
    for (var colIndex = 0; colIndex < columns.length; colIndex++) {
      var cellValue = myList[i][columns[colIndex]];
      if (cellValue == null) cellValue = "";
      row$.append($('<td/>').html(cellValue));
    }
    $(selector).append(row$);
  }
}
function addAllColumnHeaders(myList, selector) {
  var columnSet = [];
  var headerTr$ = $('<tr/>');
  for (var i = 0; i < myList.length; i++) {
    var rowHash = myList[i];
    for (var key in rowHash) {
      if ($.inArray(key, columnSet) == -1) {
        columnSet.push(key);
        headerTr$.append($('<th/>').html(key));
      }
    }
  }
  $(selector).append(headerTr$);
  return columnSet;
}

<?php echo "var items = ".$data.";"; ?>
for(var i = 0; i < items.length; i++){
	items[i]["Accion"] = "<div class='col-xs-6'>";
	items[i]["Accion"] += "<form action=' method='post'>";
	items[i]["Accion"] += "<input type='hidden' name='id' value="+items[i]["ID"]+">"
	items[i]["Accion"] += "<input type='hidden' name='method' value='update'>"
	items[i]["Accion"] += "<button class='btn btn-info' type='submit'>Actualizar</button>";
	items[i]["Accion"] += "</form>";
	items[i]["Accion"] += "</div>";

	items[i]["Accion"] += "<div class='col-xs-6'>";
	items[i]["Accion"] += "<form action=' method='post'>";
	items[i]["Accion"] += "<input type='hidden' name='id' value="+items[i]["ID"]+">"
	items[i]["Accion"] += "<input type='hidden' name='method' value='delete'>"
	items[i]["Accion"] += "<button class='btn btn-info' type='submit'>Eliminar</button>";
	items[i]["Accion"] += "</form>";
	items[i]["Accion"] += "</div>";
}
buildHtmlTable(items, "#usuarios");

</script>

<?php require 'bottom.php';?>