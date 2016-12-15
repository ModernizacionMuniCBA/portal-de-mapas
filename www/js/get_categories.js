		var gobAbiertoAPI = "https://gobiernoabierto.cordoba.gob.ar/api";
		var gobAbiertoAPI_categories = "/tipo-actividad/"
		var formatJson = "?format=json";
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
			url: "generated.json",
			// url: "https://modernizacionmunicba.github.io/portal-de-mapas/www/generated.json",
			success: handleData
		});
		function handleData(data) {
			$.each(data.results, function(i, category) {
					$('#accordion').append('<div class="panel panel-mapas"><div class="panel-heading collapsed" role="tab" id="heading-'+category.id+'" data-toggle="collapse" data-parent="#accordion" href="#collapse-'+category.id+'" aria-expanded="false" aria-controls="collapse-'+category.id+'"><h4 class="panel-title"><a class="collapsed" role="button">'+category.titulo+'</a></h4><h5 class="panel-title panel-subtitle"><a class="collapsed" role="button">'+category.descripcion+'</a></h5></div><div id="collapse-'+category.id+'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-'+category.id+'"><div class="panel-body" id="category-'+category.id+'-menu">');
					$.each(category.subcategorias, function(j, layer) {
						$('#category-'+category.id+'-menu').append('<a href="#mapa-'+layer.id+'"><div class="map-layer-selector" id="mapa-'+layer.id+'" style="cursor: pointer;" onclick="if(!$(this).hasClass(\'active\')){toggleLayer('+layer.id+');} setActiveLayer(this);"><h4 class="title">'+layer.titulo+'</h4><h5 class="title subtitle">'+layer.descripcion+'</h5></div></a>');
						layers[layer.id] = new google.maps.KmlLayer({
						  url: layer.url,
						  preserveViewport: true
						});
						layers_titles[layer.id] = layer.titulo;
					});
					$('#accordion').append('</div></div>');
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
			}
		}
		function setActiveLayer(obj) {
			$('.map-layer-selector.active').removeClass('active');
			$(obj).addClass("active");
		}
