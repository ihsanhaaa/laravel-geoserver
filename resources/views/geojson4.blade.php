<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data GeoJSON</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
    </style>
</head>
<body>
    <h1>Data GeoJSON</h1>
    <div id="map"></div>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.vectorgrid@1.3.0/dist/Leaflet.VectorGrid.min.js"></script>
    <script>
        var map = L.map('map').setView([0, 0], 2);

        // Base layers
        var openStreetMap = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19
        }).addTo(map);

        var googleSatellite = L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains:['mt0','mt1','mt2','mt3']
        });

        var googleStreets = L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains:['mt0','mt1','mt2','mt3']
        });

        var googleHybrid = L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains:['mt0','mt1','mt2','mt3']
        });

        // Base layers object
        var baseLayers = {
            "OpenStreetMap": openStreetMap,
            "Google Satellite": googleSatellite,
            "Google Streets": googleStreets,
            "Google Hybrid": googleHybrid
        };

        // Data GeoJSON dari controller
        var geojsonData = @json($geojsonData);

        // Layer control object
        var overlayMaps = {};

        // Loop untuk setiap item GeoJSON dan menambahkannya ke peta
        geojsonData.forEach(function(data, index) {
            var geojsonObject = JSON.parse(data.geojson);

            // Opsi untuk VectorGrid
            var vectorTileOptions = {
                rendererFactory: L.canvas.tile,
                vectorTileLayerStyles: {
                    sliced: {
                        weight: 1,
                        color: 'blue',
                        fillColor: 'green',
                        fillOpacity: 1
                    }
                },
                interactive: true
            };

            // Menambahkan data GeoJSON ke peta menggunakan VectorGrid
            var vectorTileLayer = L.vectorGrid.slicer(geojsonObject, vectorTileOptions);

            // Menambahkan event listener untuk popup
            vectorTileLayer.on('click', function(e) {
                var properties = e.layer.properties;
                var popupContent = 'wadmkc: ' + (properties.wadmkc || 'No data');
                L.popup()
                    .setLatLng(e.latlng)
                    .setContent(popupContent)
                    .openOn(map);
            });

            // Menambahkan layer ke peta
            vectorTileLayer.addTo(map);

            // Menambahkan layer ke overlayMaps dengan nama unik
            overlayMaps[data.name + " " + index] = vectorTileLayer;
        });

        // Menambahkan kontrol layer dengan baseLayers dan overlayMaps
        L.control.layers(baseLayers, overlayMaps).addTo(map);
    </script>
</body>
</html>
