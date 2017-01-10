var gobAbiertoAPI = "https://gobiernoabierto.cordoba.gob.ar/api/";
var gobAbiertoAPI_capas = "capas-de-mapas/?portal_id=1"
var formatJson = "&format=json";
var map;
var layers = [];
var layers_titles = [];
function initMap() {
	map = new google.maps.Map(document.getElementById('map'), {
		zoom: 14,
		center: {lat: -31.420180, lng: -64.188787}
	});
	layers_titles[0]="";
	layers[0] = new google.maps.KmlLayer({
		url: '',
		preserveViewport: true
	});
}

$.ajax({
	dataType: "json",
	url: gobAbiertoAPI+gobAbiertoAPI_capas+formatJson,
	// url: "https://modernizacionmunicba.github.io/portal-de-mapas/www/generated.json",
	success: handleData
});
function handleData(data) {
	var categories = [];
	$.each(data.results, function(i, map) {
		if (categories.indexOf(map.categoria.id) == -1 ){
			categories.push(map.categoria.id);
			$('#accordion').append('<div class="panel panel-mapas"><div class="panel-heading collapsed" role="tab" id="heading-'+map.categoria.id+'" data-toggle="collapse" data-parent="#accordion" href="#collapse-'+map.categoria.id+'" aria-expanded="false" aria-controls="collapse-'+map.categoria.id+'"><h4 class="panel-title"><a class="collapsed" role="button">'+map.categoria.nombre+'</a></h4><h5 class="panel-title panel-subtitle"><a class="collapsed" role="button">'+map.categoria.descripcion+'</a></h5></div><div id="collapse-'+map.categoria.id+'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-'+map.categoria.id+'"><div class="panel-body" id="category-'+map.categoria.id+'-menu"></div></div>');
		}
	});
	$.each(categories, function(i, category_ID) {
			$.ajax({
				dataType: "json",
				url: gobAbiertoAPI+gobAbiertoAPI_capas+'&categoria_id='+category_ID+''+formatJson,
				success: handleDataMaps
			});
	});

}
function handleDataMaps(data) {
	$.each(data.results, function(i, map) {
		$('#category-'+map.categoria.id+'-menu').append('<a href="#mapa-'+map.id+'"><div class="map-layer-selector" id="mapa-'+map.id+'" style="cursor: pointer;" onclick="if(!$(this).hasClass(\'active\')){toggleLayer('+map.id+');} setActiveLayer(this);"><h4 class="title">'+map.titulo+'</h4><h5 class="title subtitle">'+map.descripcion+'</h5></div></a>');
		var dd = new Date();
		var nn = dd.getMinutes();

		layers[map.id] = new google.maps.KmlLayer({
			url: map.recurso.url.replace("viewer","kml") + "&tm=" + nn,
			preserveViewport: false
		});
		layers_titles[map.id] = map.titulo;
	});
	var url = document.location.toString();
	if (url.match('#')) {
		var string = url.split('#')[1];
		var type = string.split('-')[0];
		var valor = string.split('-')[1];
		if (type == "mapa"){
			toggleLayer(valor);
			$('#mapa-'+valor).addClass("active");
			var panel = $('#mapa-'+valor).closest('.collapse');
			panel.collapse();
		}
	}
}
function toggleLayer(i) {
	for (var j = 0; j < layers.length; j++) {
		if(layers[j]!=null){
			if(layers[j].getMap() !== null) {
				layers[j].setMap(null);
			}
		}
	}
	if(layers[i].getMap() === null) {
		layers[i].setMap(map);
		$('.header-title').html(layers_titles[i]);
		touchAnalytics('/portal-de-mapas/www/#mapa-'+i, 'Portal de mapas. MAPA ' + i);
	}
}
function setActiveLayer(obj) {
	$('.map-layer-selector.active').removeClass('active');
	$(obj).addClass("active");
	$('#menu-wrapper').removeClass("active");
	$('#menu-button').removeClass("active");
}
