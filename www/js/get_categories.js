window.mobilecheck = function() {
	var check = false;
	(function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
	return check;
};

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
