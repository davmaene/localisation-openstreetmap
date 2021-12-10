<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Localisation sites | Styve App</title>
    <link rel="stylesheet" href="libs/leaflet/leaflet.css" />
    <script src="libs/leaflet/leaflet-src.js"></script>
    <style>
        body{
            margin: 0;
            padding: 0;
        }
        #map { height: 100vh; }
        .for-btn{
            position: absolute;;
            bottom: 0;
            left: 10;
            width: 200px;
            kerning: 45px;
            background-color: #fff;
            z-index: 1988888;
            padding-left: 20px;
            padding-right: 20px;
        }
        .btn-m{
            border-top: 2px solid #ccc;
            padding-top: 10px;
            padding-bottom: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            align-content: center;
            width: 200px;
        }
        .btn{
            padding: 5px;
            cursor: pointer;
            width: 200px;
        }
    </style>
</head>
<body>
    <div class="for-btn">
        <h4>Coordonnées Selectionnées</h4>
        <p>latitude : <span id="lat"></span></p>
        <p>longitude : <span id="lon"></span></p>
        <p>Précision : <span id="acc"></span> mètres</p>
        <div class="btn-m">
            <button class="btn" id="reload">
                <span>Actualiser la page</span>
            </button>
        </div>
        <div class="btn-m">
            <span style="text-align: center; font-size: 15px;">
                &copy; David Maene | 2021
            </span>
        </div>
    </div>
    <div id="map"></div>

    <script>
        (() => {

            const options = {
                enableHighAccuracy: true,
                timeout: 5000,
                maximumAge: 0
            };
            const map = L.map('map').setView([-1.658501, 29.2204548], 13);

            const tiles = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                maxZoom: 18,
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
                    'Imagery © <a href="https://www.mapbox.com/">Mapbox</a> by <a href="https://davidmaene.reitecinfo.net">David Maene</a>',
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1
            }).addTo(map);

            const popup = L.popup();
            function onMapClick(e) {
                popup
                    .setLatLng(e.latlng)
                    .setContent("Position actuelle est : " + e.latlng.toString())
                    .openOn(map);
                
            }
            function success(pos) {
            var crd = pos.coords;

                console.log('Votre position actuelle est :');
                console.log(`Latitude : ${crd.latitude}`);
                console.log(`Longitude : ${crd.longitude}`);
                console.log(`La précision est de ${crd.accuracy} mètres.`);

                document.getElementById("lat").innerHTML = crd.latitude;
                document.getElementById("lon").innerHTML = crd.longitude;
                document.getElementById("acc").innerHTML = Math.round((crd.accuracy + Number.EPSILON) * 100) / 100;

                const marker = L.marker([crd.latitude, crd.longitude])
                    .on('click', onMapClick)
                    .addTo(map);
            }
            function error(err) {
                console.warn(`ERREUR (${err.code}): ${err.message}`);
            }
            function location(){
                navigator.geolocation.getCurrentPosition(success, error, options);
            }
            location()
            document.getElementById("reload").onclick = (e) => {
                e.preventDefault();
                window.location.reload()
            }
            // map.on('click', onMapClick);

            // var circle = L.circle([51.508, -0.11], {
            //     color: 'red',
            //     fillColor: '#f03',
            //     fillOpacity: 0.5,
            //     radius: 500
            // }).addTo(map);

            // var polygon = L.polygon([
            //     [51.509, -0.08],
            //     [51.503, -0.06],
            //     [51.51, -0.047]
            // ]).addTo(map);
        })()
    </script>
</body>
</html>