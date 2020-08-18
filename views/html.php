<!DOCTYPE html>
<html lang="en">
<?php include 'head.php';?>

<body style="background-image: url('mine/bg/bg 1.jpg');background-size: 100%">
    <div class="container-fluid" style="padding-right: 8vw;padding-left: 8vw;padding-top: 10vh;padding-bottom: 10vh">
        <div class="row">
            <?php if (isset($Session['admin'])): ?>
            <div class="col-lg-3 mb-3 col-12">
                <div class="card rounded" style="zoom:85%">
                    <div class="card-header">
                        Menu
                    </div>
                    <ul class="list-group list-group-flush">
                        <a href="Home" class=" list-group-item  list-group-item-action  <?php if ($data['link'] == 'Home'): ?> active <?php endif;?>"><i class="fa fa-home"></i> Home</a>
                        <a href="Panti" class=" list-group-item  list-group-item-action  <?php if ($data['link'] == 'Panti'): ?> active <?php endif;?>"><i class="fa fa-place-of-worship"></i> Panti</a>
                        <a href="User" class=" list-group-item  list-group-item-action  <?php if ($data['link'] == 'User'): ?> active <?php endif;?>"><i class="fa fa-users"></i> User</a>
                        <a href="Metode" class=" list-group-item  list-group-item-action  <?php if ($data['link'] == 'Metode'): ?> active <?php endif;?>"><i class="fa fa-calculator"></i> Metode</a>
                        <a href="Logout" class=" list-group-item  list-group-item-action  <?php if ($data['link'] == 'Logout'): ?> active <?php endif;?>"><i class="fa fa-sign-out-alt"></i> Logout</a>
                    </ul>
                </div>
            </div>
            <div class="col-lg-9 col-12">
                <div class="card rounded">
                    <div class="card-body">
                        <h3><i class="fa <?php echo $data['icon']; ?>"></i>
                            <?php echo $data['judul']; ?>
                        </h3>
                        <hr>
                        <?php include 'Pages/' . $data['path'] . ".php";?>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <?php include 'Pages/' . $data['path'] . ".php";?>
            <?php endif;?>
        </div>
    </div>
    <!-- /#wrapper -->
    <!-- Bootstrap core JavaScript -->
    <?php include 'js.php';?>
    <script type="text/javascript">
    $(function() { $('#jstree_demo_div').jstree(); });

    function rute(datazz) {
        datazz.coordinates = map.getSource('route')._data.coordinates.concat(datazz.coordinates);
        console.log(map.getSource('route')._data.coordinates);

        map.getSource('route').setData(datazz);
        //console.log( map.getSource('route')._data);
        // console.log(map.getSource('route'));


    }

    function kirim(lat, long) {
        var queryString;
        queryString = 'koor=' + long + ',' + lat;
        console.log(queryString);

        jQuery.ajax({

            url: 'Proses',
            data: queryString,
            type: "GET",
            success: function(data) {
                console.log(data);
                data = JSON.parse(data);

                app.hasil = data;
                /*

                map.addSource('route', {
                    'type': 'geojson',
                    'data': data.routes[0].geometry,

                });
                map.addLayer({
                    'id': 'route',
                    'type': 'line',
                    'source': 'route',
                    'layout': {
                        'line-join': 'round',
                        'line-cap': 'round'
                    },
                    'paint': {
                        'line-color': '#888',
                        'line-width': 8
                    }
                });
                */

            },
            error: function() { alert('koneksi gagal') }
        });
    }
    </script>
    <script type="text/javascript">
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
    </script>
    <script type="text/javascript">
    <?php if ($data['link'] == 'Home' || $data['link'] == 'Metode'): ?>
    mapboxgl.accessToken = 'pk.eyJ1Ijoibmt1cm5pYTEwMzEiLCJhIjoiY2szMnNmdTJ2MGVvZDNnb2J5M2FwZmUxYiJ9.NQOOv2ivABH_v75lSXZr2A';
    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [101.44405879883004, 1.6636221106046492], // starting position
        //center: [-97.547760, 35.486067],
        zoom: 12 // starting zoom
    });
    marker = new mapboxgl.Marker();
    map.addControl(new mapboxgl.NavigationControl());
    var geolocate = new mapboxgl.GeolocateControl({
        positionOptions: {
            enableHighAccuracy: true
        },
        trackUserLocation: true
    })
    map.addControl(
        geolocate
    );
    map.on('click', function(e) {
        koor = e.lngLat.toArray();
        //console.log(e);
        marker.setLngLat(koor).addTo(map);
        $('#koor').val(`${koor[0]},${koor[1]}`);
    });

    var places = <?php echo $data['place']; ?>;
    map.on('load', function() {
        //geolocate.trigger();

        <?php if ($data['link'] == 'Home'): ?>

        map.addSource('route', {
            'type': 'geojson',
            'data': {
                "coordinates": [],
                "type": "LineString"
            }

        });
        map.addLayer({
            'id': 'route',
            'type': 'line',
            'source': 'route',
            'layout': {
                'line-join': 'round',
                'line-cap': 'round'
            },
            'paint': {
                'line-color': '#1da1f2',
                'line-width': 8
            }
        });
        <?php endif;?>




        map.loadImage(
            'hotel.png',
            function(error, image) {
                console.log('jalan');
                if (error) throw error;
                map.addImage('cat', image);
                map.addSource('places', {
                    'type': 'geojson',
                    'data': places
                });
                map.addLayer({
                    'id': 'poi-labels',
                    'type': 'symbol',
                    'source': 'places',
                    'layout': {

                        'text-field': ['get', 'description'],
                        'icon-image': 'cat',
                        'icon-size': 0.09,
                        'text-variable-anchor': ['top', 'bottom', 'left', 'right'],
                        'text-radial-offset': 1,
                        'text-justify': 'auto',
                    }
                });
            });
    });
    <?php endif;?>
    </script>
    <?php if ($data['link'] == 'Panti'): ?>
    <script>
    mapboxgl.accessToken = 'pk.eyJ1Ijoibmt1cm5pYTEwMzEiLCJhIjoiY2szMnNmdTJ2MGVvZDNnb2J5M2FwZmUxYiJ9.NQOOv2ivABH_v75lSXZr2A';
    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [101.44405879883004, 1.6636221106046492], // starting position
        //center: [-97.547760, 35.486067],
        zoom: 12 // starting zoom
    });
    map.addControl(new mapboxgl.NavigationControl());
    <?php if (is_null($data['koordinat'])) {$data['koordinat'] = "101.43299154343026, 1.6833998712072002";}?>
    var marker = new mapboxgl.Marker().setLngLat([<?php echo $data['koordinat']; ?>])
        .addTo(map);
    map.getCanvas().style.cursor = 'pointer';
    var places = <?php echo $data['place']; ?>;
    map.on('load', function() {
        map.loadImage(
            'hotel.png',
            function(error, image) {
                console.log('jalan');
                if (error) throw error;
                map.addImage('cat', image);
                map.addSource('places', {
                    'type': 'geojson',
                    'data': places
                });
                map.addLayer({
                    'id': 'poi-labels',
                    'type': 'symbol',
                    'source': 'places',
                    'layout': {

                        'text-field': ['get', 'description'],
                        'icon-image': 'cat',
                        'icon-size': 0.09,
                        'text-variable-anchor': ['top', 'bottom', 'left', 'right'],
                        'text-radial-offset': 1,
                        'text-justify': 'auto',
                    }
                });
            });

    });

    map.on('click', function(e) {
        koor = e.lngLat.toArray();
        //console.log(e);
        marker.setLngLat(koor).addTo(map);
        $('#koor').val(`${koor[0]},${koor[1]}`);
        $('#koor2').val(`${koor[0]},${koor[1]}`);
    });
    </script>
    <?php endif;?>
    <script type="text/javascript">
    var aneh;
    $(document).ready(function() {
        <?php if ($data['link'] == 'Home' || $data['link'] == 'Metode'): ?>



        <?php if (isset($Request->koor)): ?>
        marker.setLngLat([<?php echo $Request->koor; ?>])
            .addTo(map);
        $('#koor').val(`<?php echo $Request->koor; ?>`);
        map.center=[<?php echo $Request->koor; ?>];

        <?php if ($data['link'] == 'Home'): ?>

        kirim(<?php echo explode(',', $Request->koor)[1]; ?>, <?php echo explode(',', $Request->koor)[0]; ?>);
        <?php endif;?>

        <?php else: ?>
        marker.setLngLat([position.coords.longitude, position.coords.latitude])
            .addTo(map);
        $('#koor').val(`${position.coords.longitude},${position.coords.latitude}`);
        kirim(position.coords.latitude, position.coords.longitude);
        <?php endif;?>
        <?php endif;?>



        aneh = $('.tb').DataTable({
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.childRowImmediate,
                    type: 'column',
                    renderer: function(api, rowIdx, columns) {
                        var data = $.map(columns, function(col, i) {
                            return col.hidden ?
                                '<li  class="" data-dtr-index="1" data-dt-row="' + col.rowIndex + '" data-dt-column="' + col.columnIndex + '">' +
                                '<div class="d-flex justify-content-between" >' +

                                '<span class="dtr-title">' + col.title + ':' + '</span> ' +
                                '<span class="dtr-data text-right text-break text-wrap">' + col.data + '</span>' +
                                '</li></div>' :
                                '';
                        }).join('');

                        return data ?
                            $('<ul style="display:block;" class="dtr-details" />').append(data) :
                            false;
                    }
                }
            },
            "dom": '<"p-2 d-flex justify-content-between" f>t<"card-body d-flex justify-content-end" p>',
            "lengthMenu": [
                [5, 10, -1],
                [5, 10, "All"]
            ],
            "language": {
                "paginate": {
                    "previous": "<",
                    "next": ">",
                }
            }
        });
        <?php if ($data['link'] == 'Panti'): ?>
        <?php if (isset($Request->key)): ?>
        marker.setLngLat(<?php echo $data['key']->koordinat; ?>).addTo(map);
        $('#koor').val(<?php echo $data['key']->koordinat; ?>);
        $('#koor2').val(<?php echo $data['key']->koordinat; ?>);
        <?php endif;?>
        <?php endif;?>


    });
    </script>
    <?php if ($data['link'] == 'Home'): ?>
    <script type='text/javascript'>
    var app = new Vue({
        el: '.appx',
        data: {
            kd: null,
            hasil: [],
            rute: [],

        },
        methods: {
            uang() {
                rute(app.rute);
            },


        },


    });
    </script>
    <?php endif;?>
</body>

</html>