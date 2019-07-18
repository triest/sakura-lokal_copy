<!DOCTYPE html>
<html>
<head>
    <title>Определение местоположения пользователя</title>
    <script src="https://maps.api.2gis.ru/2.0/loader.js"></script>
</head>
<body>
<div id="map" style="width: 100%; height: 400px;"></div>
<script>
    DG.then(function() {
        var map;

        map = DG.map('map', {
            center: [54.98, 82.89],
            zoom: 13
        });

        map.locate({setView: true, watch: true})
            .on('locationfound', function(e) {
                DG.marker([e.latitude, e.longitude]).addTo(map);
            })
            .on('locationerror', function(e) {
                DG.popup()
                    .setLatLng(map.getCenter())
                    .setContent('Доступ к определению местоположения отключён')
                    .openOn(map);
            });
    });
</script>
</body>
</html>