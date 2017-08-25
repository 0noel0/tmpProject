<?php 

require 'top.php';

$res = getPrototypeInstance()->select("id AS ID, order_id AS Codigo, catalog_number AS Catalogo, description AS Descripcion", "items", "WHERE ID < 100");
$data = $res["res"];
?>

<div class="row">
	<div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                Items
                <span class="tools pull-right">
                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                 </span>
            </header>
            <div class="panel-body" style="display: block;">
                <div class="adv-table">
                	<table class="display table table-bordered table-striped" id="items">
                		<thead>
                			<tr>
                			    <th>ID</th>
                			    <th>Codigo</th>
                			    <th>Catalogo</th>
                			    <th>Descripcion</th>
                			    <th>Accion</th>
                			</tr>
                		</thead>
                		<tbody>
                			<?php foreach ($data as $value) { ?>
                			<tr>
                			    <td><?php echo $value["ID"] ?></td>
                			    <td><?php echo $value["Codigo"] ?></td>
                			    <td><?php echo $value["Catalogo"] ?></td>
                			    <td><?php echo $value["Descripcion"] ?></td>
                			    <td class="text-center">
                			    	<button type="button" class="btn btn-primary" onclick=<?php echo "'agregarACotizacion(".json_encode($value).")'"; ?>>Agregar a cotizacion</button>
                			    </td>
                			</tr>
                			<?php } ?>
                		</tbody>
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

var items = [];
function agregarACotizacion(item){
	$("#row-cotizacion").show();
	item["Accion"] = "<button class='btn btn-danger' onclick='quitarItem("+items.length+")'>Delete item</button>";
	items.push(item);

	$("#cotizacion").empty();
	buildHtmlTable(items, "#cotizacion");
}

function quitarItem(index){
	items.splice(index, 1);

	for(var i = 0; i < items.length; i++){
		items[i]["Accion"] = "<button class='btn btn-danger' onclick='quitarItem("+i+")'>Delete item</button>";
	}

	$("#cotizacion").empty();
	buildHtmlTable(items, "#cotizacion");
}

$(document).ready( function () {
    $('#items').dataTable({
	    "language": {
		    "decimal":        "",
		    "emptyTable":     "No data available in table",
		    "info":           "Showing _START_ to _END_ of _TOTAL_ entries",
		    "infoEmpty":      "Showing 0 to 0 of 0 entries",
		    "infoFiltered":   "(filtered from _MAX_ total entries)",
		    "infoPostFix":    "",
		    "thousands":      ",",
		    "lengthMenu":     "Show _MENU_ entries",
		    "loadingRecords": "Loading...",
		    "processing":     "Processing...",
		    "search":         "Buscar:",
		    "zeroRecords":    "No matching records found",
		    "paginate": {
		        "first":      "First",
		        "last":       "Last",
		        "next":       "Next",
		        "previous":   "Previous"
		    },
		    "aria": {
		        "sortAscending":  ": activate to sort column ascending",
		        "sortDescending": ": activate to sort column descending"
		    }
		}
    });
});
</script>
<div class="row" id="row-cotizacion" style="display:none;">
	<div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                Items cotizacion
                <span class="tools pull-right">
                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                 </span>
            </header>
            <div class="panel-body" style="display: block;">
                <div class="adv-table">
                	<table class="display table table-bordered table-striped" id="cotizacion">
                		<thead>
                			<tr>
                			    <th>ID</th>
                			    <th>Codigo</th>
                			    <th>Catalogo</th>
                			    <th>Descripcion</th>
                			</tr>
                		</thead>
                	</table>
                </div>
                <br>
                <button type="button" class="btn btn-primary">Generar cotizacion</button>
            </div>
        </section>
	</div>
</div>

<?php require 'bottom.php';?>