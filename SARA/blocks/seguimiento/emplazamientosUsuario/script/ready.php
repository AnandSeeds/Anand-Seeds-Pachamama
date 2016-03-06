
var datos = [
    {
        "0": "3.34526",
        "longitud": "3.34526",
        "1": "-76.54557",
        "latitud": "-76.54557"
    },
    {
        "0": "3.34526",
        "longitud": "3.34526",
        "1": "-76.54557",
        "latitud": "-76.54557"
    },
    {
        "0": "3.34524",
        "longitud": "3.34524",
        "1": "-76.54557",
        "latitud": "-76.54557"
    },
    {
        "0": "3.34528",
        "longitud": "3.34528", 
        "1": "-76.545479",
        "latitud": "-76.545479"
    },
    {
        "0": "3.34529",
        "longitud": "3.34529",
        "1": "-76.545532",
        "latitud": "-76.545532"
    },
    {
        "0": "3.34522",
        "longitud": "3.34522",
        "1": "-76.545464",
        "latitud": "-76.545464"
    },
    {
        "0": "3.34487",
        "longitud": "3.34487",
        "1": "-76.545403",
        "latitud": "-76.545403"
    },
    {
        "0": "3.34457",
        "longitud": "3.34457",
        "1": "-76.545303",
        "latitud": "-76.545303"
    },
    {
        "0": "3.34429",
        "longitud": "3.34429",
        "1": "-76.54525",
        "latitud": "-76.54525"
    },
    {
        "0": "3.3437",
        "longitud": "3.3437",
        "1": "-76.545052",
        "latitud": "-76.545052"
    },
    {
        "0": "3.34344",
        "longitud": "3.34344",
        "1": "-76.54496",
        "latitud": "-76.54496"
    },
    {
        "0": "3.34329",
        "longitud": "3.34329",
        "1": "-76.544693",
        "latitud": "-76.544693"
    },
    {
        "0": "3.34332",
        "longitud": "3.34332",
        "1": "-76.544693",
        "latitud": "-76.544693"
    },
    {
        "0": "3.34336",
        "longitud": "3.34336",
        "1": "-76.544472",
        "latitud": "-76.544472"
    },
    {
        "0": "3.3445",
        "longitud": "3.3445",
        "1": "-76.544373",
        "latitud": "-76.544373"
    },
    {
        "0": "3.34482",
        "longitud": "3.34482",
        "1": "-76.544449",
        "latitud": "-76.544449"
    },
    {
        "0": "3.34514",
        "longitud": "3.34514",
        "1": "-76.544449",
        "latitud": "-76.544449"
    },
    {
        "0": "3.34559",
        "longitud": "3.34559",
        "1": "-76.544891",
        "latitud": "-76.544891"
    },
    {
        "0": "3.34561",
        "longitud": "3.34561",
        "1": "-76.545212",
        "latitud": "-76.545212"
    },
    {
        "0": "3.34584",
        "longitud": "3.34584",
        "1": "-76.545372",
        "latitud": "-76.545372"
    },
    {
        "0": "3.34586",
        "longitud": "3.34586",
        "1": "-76.545708",
        "latitud": "-76.545708"
    },
    {
        "0": "3.34547",
        "longitud": "3.34547",
        "1": "-76.54583",
        "latitud": "-76.54583"
    },
    {
        "0": "3.34514",
        "longitud": "3.34514",
        "1": "-76.545692",
        "latitud": "-76.545692"
    },
    {
        "0": "3.34526",
        "longitud": "3.34526",
        "1": "-76.54557",
        "latitud": "-76.54557"
    },
    {
        "0": "3.34526",
        "longitud": "3.34526",
        "1": "-76.54557",
        "latitud": "-76.54557"
    },
    {
        "0": "3.34526",
        "longitud": "3.34526",
        "1": "-76.54557",
        "latitud": "-76.54557"
    },
    {
        "0": "3.34526",
        "longitud": "3.34526",
        "1": "-76.54557",
        "latitud": "-76.54557"
    },
    {
        "0": "3.34526",
        "longitud": "3.34526",
        "1": "-76.54557",
        "latitud": "-76.54557"
    }
];
var features = new Array();
for (var i = 0; i < datos.length; i++){
	var geometry = {
		"geometry" : {
			"type" : "Point",
			"coordinates" : [datos[i].longitud, datos[i].latitud]
		},
		"type" : "Feature",
		"properties" : {
			"popupContent" : "Huerta <br> 1"
		},
		"id" : 51
	};
	features.push(geometry);
}
var bicycleRental = {
	"type" : "FeatureCollection",
	"features" : features
}

var bicycleRental2 = {
	"type" : "FeatureCollection",
	"features" : [{
		"geometry" : {
			"type" : "Point",
			"coordinates" : [-104.9998241, 39.7471494]
		},
		"type" : "Feature",
		"properties" : {
			"popupContent" : "Huerta"
		},
		"id" : 51
	}, {
		"geometry" : {
			"type" : "Point",
			"coordinates" : [-104.9983545, 39.7502833]
		},
		"type" : "Feature",
		"properties" : {
			"popupContent" : "Jardín"
		},
		"id" : 52
	}, {
		"geometry" : {
			"type" : "Point",
			"coordinates" : [-104.9963919, 39.7444271]
		},
		"type" : "Feature",
		"properties" : {
			"popupContent" : "Jardín"
		},
		"id" : 54
	}, {
		"geometry" : {
			"type" : "Point",
			"coordinates" : [-104.9960754, 39.7498956]
		},
		"type" : "Feature",
		"properties" : {
			"popupContent" : "Huerta"
		},
		"id" : 55
	}, {
		"geometry" : {
			"type" : "Point",
			"coordinates" : [-104.9933717, 39.7477264]
		},
		"type" : "Feature",
		"properties" : {
			"popupContent" : "Huerta"
		},
		"id" : 57
	}, {
		"geometry" : {
			"type" : "Point",
			"coordinates" : [-104.9913392, 39.7432392]
		},
		"type" : "Feature",
		"properties" : {
			"popupContent" : "Huerta"
		},
		"id" : 58
	}, {
		"geometry" : {
			"type" : "Point",
			"coordinates" : [-104.9788452, 39.6933755]
		},
		"type" : "Feature",
		"properties" : {
			"popupContent" : "Huerta"
		},
		"id" : 74
	}]
};


// var freeBus = {
	// "type" : "FeatureCollection",
	// "features" : [{
		// "type" : "Feature",
		// "geometry" : {
			// "type" : "LineString",
			// "coordinates" : [[-105.00341892242432, 39.75383843460583], [-105.0008225440979, 39.751891803969535]]
		// },
		// "properties" : {
			// "popupContent" : "This is free bus that will take you across downtown.",
			// "underConstruction" : false
		// },
		// "id" : 1
	// }, {
		// "type" : "Feature",
		// "geometry" : {
			// "type" : "LineString",
			// "coordinates" : [[-105.0008225440979, 39.751891803969535], [-104.99820470809937, 39.74979664004068]]
		// },
		// "properties" : {
			// "popupContent" : "This is free bus that will take you across downtown.",
			// "underConstruction" : true
		// },
		// "id" : 2
	// }, {
		// "type" : "Feature",
		// "geometry" : {
			// "type" : "LineString",
			// "coordinates" : [[-104.99820470809937, 39.74979664004068], [-104.98689651489258, 39.741052354709055]]
		// },
		// "properties" : {
			// "popupContent" : "This is free bus that will take you across downtown.",
			// "underConstruction" : false
		// },
		// "id" : 3
	// }]
// };
// 
// var lightRailStop = {
	// "type" : "FeatureCollection",
	// "features" : [{
		// "type" : "Feature",
		// "properties" : {
			// "popupContent" : "18th & California Light Rail Stop"
		// },
		// "geometry" : {
			// "type" : "Point",
			// "coordinates" : [-104.98999178409576, 39.74683938093904]
		// }
	// }, {
		// "type" : "Feature",
		// "properties" : {
			// "popupContent" : "20th & Welton Light Rail Stop"
		// },
		// "geometry" : {
			// "type" : "Point",
			// "coordinates" : [-104.98689115047453, 39.747924136466565]
		// }
	// }]
// };


// var campus = {
	// "type" : "Feature",
	// "properties" : {
		// "popupContent" : "This is the Auraria West Campus",
		// "style" : {
			// weight : 2,
			// color : "#999",
			// opacity : 1,
			// fillColor : "#B0DE5C",
			// fillOpacity : 0.8
		// }
	// },
	// "geometry" : {
		// "type" : "MultiPolygon",
		// "coordinates" : [[[[-105.00432014465332, 39.74732195489861], [-105.00715255737305, 39.74620006835170], [-105.00921249389647, 39.74468219277038], [-105.01067161560059, 39.74362625960105], [-105.01195907592773, 39.74290029616054], [-105.00989913940431, 39.74078835902781], [-105.00758171081543, 39.74059036160317], [-105.00346183776855, 39.74059036160317], [-105.00097274780272, 39.74059036160317], [-105.00062942504881, 39.74072235994946], [-105.00020027160645, 39.74191033368865], [-105.00071525573731, 39.74276830198601], [-105.00097274780272, 39.74369225589818], [-105.00097274780272, 39.74461619742136], [-105.00123023986816, 39.74534214278395], [-105.00183105468751, 39.74613407445653], [-105.00432014465332, 39.74732195489861]], [[-105.00361204147337, 39.74354376414072], [-105.00301122665405, 39.74278480127163], [-105.00221729278564, 39.74316428375108], [-105.00283956527711, 39.74390674342741], [-105.00361204147337, 39.74354376414072]]], [[[-105.00942707061768, 39.73989736613708], [-105.00942707061768, 39.73910536278566], [-105.00685214996338, 39.73923736397631], [-105.00384807586671, 39.73910536278566], [-105.00174522399902, 39.73903936209552], [-105.00041484832764, 39.73910536278566], [-105.00041484832764, 39.73979836621592], [-105.00535011291504, 39.73986436617916], [-105.00942707061768, 39.73989736613708]]]]
	// }
// };

// var coorsField = {
	// "type" : "Feature",
	// "properties" : {
		// "popupContent" : "Coors Field"
	// },
	// "geometry" : {
		// "type" : "Point",
		// "coordinates" : [-104.99404191970824, 39.756213909328125]
	// }
// };

map = L.map('map').setView([39.74739, -105], 13);

// L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6IjZjNmRjNzk3ZmE2MTcwOTEwMGY0MzU3YjUzOWFmNWZhIn0.Y8bhBaUMqFiPrDRW9hieoQ', {
// maxZoom : 18,
// attribution : 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' + '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' + 'Imagery © <a href="http://mapbox.com">Mapbox</a>',
// id : 'mapbox.light'
// }).addTo(map);

L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
	attribution : '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

var baseballIcon = L.icon({
	iconUrl : 'baseball-marker.png',
	iconSize : [32, 37],
	iconAnchor : [16, 37],
	popupAnchor : [0, -28]
});

function onEachFeature(feature, layer) {
	var popupContent = "<p> Tipo:" + feature.geometry.type + "</p>";

	if (feature.properties && feature.properties.popupContent) {
		popupContent += feature.properties.popupContent;
	}

	layer.bindPopup(popupContent);
}


//L.geoJson([bicycleRental, campus], {
capa = L.geoJson([bicycleRental], {
	
	style : function(feature) {
		return feature.properties && feature.properties.style;
	},

	onEachFeature : onEachFeature,

	pointToLayer : function(feature, latlng) {
		return L.circleMarker(latlng, {
			radius : 8,
			fillColor : "#ff7800",
			color : "#000",
			weight : 1,
			opacity : 1,
			fillOpacity : 0.8
		});
	}
}).addTo(map);
map.fitBounds(capa.getBounds());


// capa.query().bounds(function (error, latlngbounds) {
    // map.fitBounds(latlngbounds);
// });

// capa.on('ready', function() {
    // // featureLayer.getBounds() returns the corners of the furthest-out markers,
    // // and map.fitBounds() makes sure that the map contains these.
    // map.fitBounds(featureLayer.getBounds());
// });

// L.geoJson(freeBus, {
// 
	// filter : function(feature, layer) {
		// if (feature.properties) {
			// // If the property "underConstruction" exists and is true, return false (don't render features under construction)
			// return feature.properties.underConstruction !== undefined ? !feature.properties.underConstruction : true;
		// }
		// return false;
	// },
// 
	// onEachFeature : onEachFeature
// }).addTo(map);

// var coorsLayer = L.geoJson(coorsField, {
// 
	// pointToLayer : function(feature, latlng) {
		// return L.marker(latlng, {
			// icon : baseballIcon
		// });
	// },
// 
	// onEachFeature : onEachFeature
// }).addTo(map);


cargarEventosMapa();

function cargarEventosMapa() {
	var mapmargin = 100;
	$('#map').css("height", ($(window).height() - mapmargin));
	mapmargin2 = 50;
	$('#map').css("width", ($(window).width() - mapmargin2));
	$(window).on("resize", resizeScreen);
	resizeScreen();
	function resizeScreen(e) {
		$('#map').css("width", ($(window).width() - mapmargin2));

		if ($(window).width() >= 980) {
			$('#map').css("height", ($(window).height() - mapmargin));
			$('#map').css("margin-top", 10);
		} else {
			$('#map').css("height", ($(window).height() - (mapmargin + 30)));
			$('#map').css("margin-top", -21);
		}

		map.invalidateSize();
	}
}