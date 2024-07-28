<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data GeoJSON GeoServer</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
    </style>
</head>
<body>
    <h1>Data GeoJSON GeoServer</h1>
    <div id="map"></div>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.vectorgrid@1.3.0/dist/Leaflet.VectorGrid.min.js"></script>
    <script>
        var map = L.map('map').setView([0, 0], 2);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19
        }).addTo(map);

        // Data GeoJSON dari controller
        var geojsonData = @json($geojsonData);

        // Opsi untuk VectorGrid
        var vectorTileOptions = {
            rendererFactory: L.canvas.tile,
            vectorTileLayerStyles: {
                sliced: {
                    weight: 1,
                    color: 'blue',
                    fillColor: 'lightblue',
                    fillOpacity: 0.5
                }
            },
            interactive: true,
            getFeatureId: function(f) {
                return f.properties.id;
            }
        };

        // Menambahkan data GeoJSON ke peta menggunakan VectorGrid
        var vectorTileLayer = L.vectorGrid.slicer(geojsonData, vectorTileOptions);

        // Menambahkan interaksi untuk menampilkan popup
        vectorTileLayer.on('click', function(e) {
            var properties = e.layer.properties;
            L.popup()
                .setLatLng(e.latlng)
                .setContent('wadmkc: ' + properties.wadmkc)
                .openOn(map);
        });

        vectorTileLayer.addTo(map);
    </script>
</body>
</html>
