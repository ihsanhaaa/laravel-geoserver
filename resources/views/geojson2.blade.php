<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data GeoJSON GeoServer</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
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

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([0, 0], 2);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19
        }).addTo(map);

        // Data GeoJSON
        var geojsonData = @json($geojsonData);

        // Menambahkan data GeoJSON ke peta
        L.geoJSON(geojsonData).addTo(map);
    </script>
</body>
</html>
