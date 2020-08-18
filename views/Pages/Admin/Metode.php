<div class="row ">
    <div class=" col-12 mb-2">
        <form>
            <div class="card rounded shadow">
                <div class="d-flex justify-content-between">
                    <span>
                        <h5 class="text-dark ml-2  mt-1 pt-1">Menentukan Titik awal</h5>
                    </span>
                </div>
                <div class="card-body table-responsive">
                    <div class="form-grup col-lg-6 col-12 mb-2 input-group-sm">
                        <label>Titik Koordinat</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" readonly="" id="koor" name="koor">
                            <div class="input-group-append">
                                <span><button type="submit" class="btn btn-primary">Set</button></span>
                            </div>
                        </div>
                    </div>
                    <div id="map" style="width: 100%;height: 500px"></div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php if (isset($Request->koor)): ?>
<div class="row ">
    <div class=" col-12 mb-2">
        <div class="card rounded shadow" style="zoom:85%">
            <h5 class="text-dark ml-2  mt-1 pt-1">1. Menentukan Jarak</h5>
            <div class="card-body table-responsive">
                <table class="table table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Perpindahan</th>
                            <th>Jarak</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['rute'] as $k): ?>

                        <tr>
                            <td>0</td>
                            <td><strong>Titik awal </strong>[0] ke <strong><?php echo $data['panti'][$k][0]->nama; ?></strong>[<?php echo $k; ?>]
                                        [0,<?php echo $k; ?>]

                            </td>
                            <td>
                                    <?php echo round($data['hasil']->distances[0][$k], 2); ?>Km

                            </td>
                        </tr>
                        <?php endforeach;?>

                            <?php foreach ($data['level'] as $t => $k): ?>
                            <tr>
                                <td><?php echo $t + 1; ?></td>
                                <td>
                                    <strong>
                                        <?php echo $data['panti'][$data['rute'][$k['kombi'][0]]][0]->nama; ?> [<?php echo $data['rute'][$k['kombi'][0]]; ?>]</strong> ke <strong>
                                        <?php echo $data['panti'][$data['rute'][$k['kombi'][1]]][0]->nama; ?> [<?php echo $data['rute'][$k['kombi'][1]]; ?>]</strong>

                                        [<?php echo $data['rute'][$k['kombi'][0]]; ?>,<?php echo $data['rute'][$k['kombi'][1]]; ?>]
                                </td>
                                <td>
                                    <?php echo round($data['hasil']->distances[$data['rute'][$k['kombi'][0]]][$data['rute'][$k['kombi'][1]]], 2); ?>Km
                                </td>
                            </tr>
                            <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php /* ?>
<div class="row ">
<div class=" col-12 mb-2">
<div class="card rounded shadow" style="zoom:85%">
<h5 class="text-dark ml-2  mt-1 pt-1">1. Menentukan Jarak</h5>
<div class="card-body table-responsive">
<table class="table table-bordered" width="100%">
<tr>
<th>Dari/Ke</th>
<?php foreach ($data['rute'] as $v => $k): ?>
<th>
<?php echo $data['panti'][$k][0]->nama; ?> <strong>[
<?php echo $k; ?>]</strong>
</th>
<?php endforeach;?>
</tr>
<?php foreach ($data['rute'] as $v => $k): ?>
<tr>
<th>
<?php echo $data['panti'][$k][0]->nama; ?> <strong>[
<?php echo $k; ?>]</strong>
</th>
<?php foreach ($data['rute'] as $vx => $kx): ?>
<td>
<?php echo round($data['hasil']->distances[$k][$kx] / 1000, 2); ?>Km
</td>
<?php endforeach;?>
</tr>
<?php endforeach;?>
</table>
</div>
</div>
</div>
</div>
<?php */;?>
<?php /* ?>
<div class="row ">
<div class=" col-12 mb-2">
<div class="card rounded shadow" style="zoom:85%">
<h5 class="text-dark ml-2  mt-1 pt-1">2. Rumus Kombinasi</h5>
<div class="card-body table-responsive">
<div class="d-flex  align-items-center">
<span class="d-flex align-items-center">
<span>=</span>
<span class="text-center">
n!
<hr class="border border-dark m-0 p-0">
2!(n-2)!
</span>
</span>
<span class="d-flex align-items-center">
<span>=</span>
<span class="text-center">
<?php echo count($data['rute']); ?>!
<hr class="border border-dark m-0 p-0">
2!(
<?php echo count($data['rute']); ?>-2)!
</span>
</span>
<span class="d-flex align-items-center">
<span>=</span>
<span class="text-center">
<?php for ($i = count($data['rute']); $i > count($data['rute']) - 3; $i--): ?>
<?php if ($i == count($data['rute']) - 2) {echo $i . "! ";} else {echo $i . " x ";}?>
<?php endfor;?>
<hr class="border border-dark m-0 p-0">
2!
<?php echo count($data['rute']) - 2; ?>!
</span>
</span>
<span class="d-flex align-items-center">
<span>=</span>
<span class="text-center">
<?php for ($i = count($data['rute']); $i > count($data['rute']) - 2; $i--): ?>
<?php if ($i == count($data['rute']) - 1) {echo $i;} else {echo $i . " x ";}?>
<?php endfor;?>
<hr class="border border-dark m-0 p-0">
2 x 1
</span>
</span>
<span class="d-flex align-items-center">
<span>=</span>
<span class="text-center">
<?php $hasil = 1;?>
<?php for ($i = count($data['rute']); $i > count($data['rute']) - 2; $i--): ?>
<?php $hasil *= $i;?>
<?php endfor;?>
<?php echo $hasil; ?>
<hr class="border border-dark m-0 p-0">
2
</span>
</span>
<span class="d-flex align-items-center">
<span>=</span>
<span class="text-center">
<?php $hasil = 1;?>
<?php for ($i = count($data['rute']); $i > count($data['rute']) - 2; $i--): ?>
<?php $hasil *= $i;?>
<?php endfor;?>
<?php echo $hasil / 2; ?>
</span>
</span>
</div>
</div>
</div>
</div>
</div>
<?php */;?>
<div class="row ">
    <?php /* ?>
<div class=" col-3 mb-2">
<div class="card rounded shadow" style="zoom:85%">
<h5 class="text-dark ml-2  mt-1 pt-1">3. Daftar Perubahan</h5>
<div class="card-body table-responsive">
<ul>
<?php foreach ($data['kombi'] as $v => $k): ?>
<li>
<?php echo $v + 1; ?>. <strong>
<?php echo $data['rute'][$k[0]]; ?>->
<?php echo $data['rute'][$k[1]]; ?></strong>(
<?php echo $k[0]; ?>,
<?php echo $k[1]; ?>)
</li>
<?php endforeach;?>
</ul>
</div>
</div>
</div>
<?php */;?>
    <div class=" col-12 mb-2">
        <div class="card rounded shadow" style="zoom:85%">
            <h5 class="text-dark ml-2  mt-1 pt-1">2. Node Rute</h5>
            <div class="card-body table-responsive">
                <div id="jstree_demo_div">
                    <ul>
                        <li data-jstree='{"icon":"fa fa-random"}'>
                            <?php echo implode(',', $data['rute']); ?> => <strong>
                                <?php echo $data['root']['jarak']; ?>Km</strong>
                            <?php kucing($data['level']);?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif;?>
<?php

function kucing($level)
{
    include 'views/Komponen/List.php';

}
?>