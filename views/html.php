<!DOCTYPE html>
<html lang="en">
<?php include 'head.php';?>

<body style="background-image: url('mine/bg/bg 1.jpg');background-size: 100%">
    <div class="container-fluid" style="padding-right: 8vw;padding-left: 8vw;padding-top: 10vh;padding-bottom: 10vh">
        <div class="row">
            <?php if (isset($Session['admin'])): ?>
            <div class="col-3">
                <div class="card rounded" style="zoom:85%">
                    <div class="card-header">
                        Menu
                    </div>
                    <ul class="list-group list-group-flush">
                        <a href="Dashboard" class=" list-group-item  list-group-item-action  <?php if ($data['link'] == 'Dashboard'): ?> active <?php endif;?>"><i class="fa fa-home"></i> Dashboard</a>
                        <a href="Panti" class=" list-group-item  list-group-item-action  <?php if ($data['link'] == 'Panti'): ?> active <?php endif;?>"><i class="fa fa-place-of-worship"></i> Panti</a>
                        <a href="Kecamatan" class=" list-group-item  list-group-item-action  <?php if ($data['link'] == 'Kecamatan'): ?> active <?php endif;?>"><i class="fa fa-map-signs"></i> Kecamatan</a>
                        <a href="User" class=" list-group-item  list-group-item-action  <?php if ($data['link'] == 'User'): ?> active <?php endif;?>"><i class="fa fa-users"></i> User</a>
                        <a href="Logout" class=" list-group-item  list-group-item-action  <?php if ($data['link'] == 'Logout'): ?> active <?php endif;?>"><i class="fa fa-sign-out-alt"></i> Logout</a>
                    </ul>
                </div>
            </div>
            <div class="col-9">
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
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
    </script>
    <script type="text/javascript">
        <?php if ($data['link'] == 'Home'): ?>
             mapboxgl.accessToken = 'pk.eyJ1Ijoibmt1cm5pYTEwMzEiLCJhIjoiY2szMnNmdTJ2MGVvZDNnb2J5M2FwZmUxYiJ9.NQOOv2ivABH_v75lSXZr2A';
    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [101.44405879883004, 1.6636221106046492], // starting position
        //center: [-97.547760, 35.486067],
        zoom: 12 // starting zoom
    });
    map.addControl(new mapboxgl.NavigationControl());

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
    var marker = new mapboxgl.Marker().setLngLat([101.43299154343026, 1.6833998712072002])
        .addTo(map);
    map.getCanvas().style.cursor = 'pointer';



    map.on('click', function(e) {
        koor = e.lngLat.toArray();
        //console.log(e);
        marker.setLngLat(koor).addTo(map);
        $('#koor').val(`[${koor[0]},${koor[1]}]`);
        $('#koor2').val(`[${koor[0]},${koor[1]}]`);
    });
    </script>
    <?php endif;?>
    <script type="text/javascript">
    var aneh;
    $(document).ready(function() {

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
</body>

</html>