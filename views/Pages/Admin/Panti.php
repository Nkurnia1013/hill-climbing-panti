<div class="row ">
    <div class=" col-12 mb-5">
        <div class="card rounded shadow">
            <h5 class="text-dark ml-2 text-center mt-1 pt-1">Form Input</h5>
            <form action="Action.php" method="post" enctype="multipart/form-data">
                <div class=" card-body ">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <?php foreach ($data['form'] as $isi): ?>
                                <?php if ($isi['name'] == 'idkecamatan'): ?>
                                <div class="form-grup col-6 mb-2 input-group-sm">
                                    <label class="form-control-label text-dark">
                                        <?php echo $isi['label']; ?></label>
                                    <select class="form-control" name="input[]">
                                        <?php foreach ($data['kecamatan'] as $k): ?>
                                        <option value="<?php echo $k->idkecamatan; ?>">
                                            <?php echo $k->kecamatan; ?>
                                        </option>
                                        <?php endforeach;?>
                                    </select>
                                    <input type="hidden" name="tb[]" value="<?php echo $isi['name']; ?>">
                                </div>
                                <?php else: ?>
                                <?php include $komponen . '/Input.php';?>
                                <?php endif;?>
                                <?php endforeach;?>
                                <div class="form-grup col-6 mb-2 input-group-sm">
                                    <label>Titik Koordinat</label>
                                    <input type="text" disabled="" value="<?php echo $data['koordinat']; ?>" id="koor" class="form-control" name="">
                                    <input type="hidden" name="input[]" value="<?php echo $data['koordinat']; ?>" id="koor2">
                                    <input type="hidden" name="tb[]" value="koordinat">
                                </div>
                                <div id='map' style="width: 100%;height: 500px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <input type="hidden" name="table" value="panti">
                    <?php if (!isset($Request->key)): ?>
                    <button type="submit" name="aksi" value="insert" class="btn btn-sm  btn-primary">Tambah</button>
                    <?php else: ?>
                    <input type="hidden" name="key" value="<?php echo $Request->key; ?>">
                    <input type="hidden" name="primary" value="idpanti">
                    <input type="hidden" name="link" value="Panti">
                    <button type="submit" name="aksi" value="update" class="btn btn-sm  btn-info">Edit</button>
                    <button type="submit" name="aksi" value="delete" class="btn btn-sm  btn-danger">Hapus</button>
                    <a href="Panti" class="btn btn-sm  btn-warning">Kembali</a>
                    <?php endif;?>
                </div>
            </form>
        </div>
    </div>
    <?php if (isset($Request->key)): ?>
    <div class=" col-7 mb-5" style="zoom:85%">
        <div class="card rounded shadow" style="zoom:85%">
            <h5 class="text-dark ml-2 text-center mt-1 pt-1">Tabel Foto</h5>
            <form action="Action.php" method="post" enctype="multipart/form-data">
                <table width="100%" class="text-wrap mb-0 tb table table-borderless table-striped table-hover ">
                    <thead class="">
                        <tr>
                            <th>Foto</th>
                            <th>Deskripsi</th>
                            <th data-priority="1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['foto'] as $v => $k): ?>
                        <tr>
                            <td>
                                <a href="upload/<?php echo $k->foto; ?>" target="_blank">
                                    <img style="width: 300px" src="upload/<?php echo $k->foto; ?>" alt="..." class="img-thumbnail">
                                </a>
                            </td>
                            <td>
                                <?php $k->desk = explode("\r\n", $k->desk);?>
                                <?php foreach ($k->desk as $k2): ?>
                                <p class="pb-0 mb-0 text-justify">
                                    <?php echo $k2; ?>
                                </p>
                                <?php endforeach;?>
                            </td>
                            <td class="text-right ">
                                <a href="?key=<?php echo $k->idpanti; ?>&idfoto=<?php echo $k->idfoto; ?>" class="btn btn-warning btn-sm">Kelola</a>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th><input type="file" name="input[]"></th>
                            <th>
                                <textarea class="form-control" maxlength="100" name="input[]"><?php echo $data['foto.key']['desk']; ?></textarea>
                                <input type="hidden" name="tb[]" value="desk">
                                <input type="hidden" name="input[]" value="<?php echo $Request->key; ?>">
                                <input type="hidden" name="tb[]" value="idpanti">
                            </th>
                            <th>
                                <input type="hidden" name="table" value="foto">
                                <?php if (!isset($Request->idfoto)): ?>
                                <button type="submit" name="aksi" value="insert" class="btn btn-sm  btn-primary">Tambah</button>
                                <?php else: ?>
                                <input type="hidden" name="key" value="<?php echo $Request->idfoto; ?>">
                                <input type="hidden" name="primary" value="idfoto">
                                <button type="submit" name="aksi" value="update" class="btn btn-sm  btn-info">Edit</button>
                                <button type="submit" name="aksi" value="delete" class="btn btn-sm  btn-danger">Hapus</button>
                                <a href="?key=<?php echo $Request->key; ?>" class="btn btn-sm  btn-warning">Kembali</a>
                                <?php endif;?>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>
    <div class=" col-5 mb-5" style="zoom:85%">
        <div class="card rounded shadow" style="zoom:85%">
            <h5 class="text-dark ml-2 text-center mt-1 pt-1">Tabel Contact Person</h5>
            <form action="Action.php" method="post" enctype="multipart/form-data">
                <table width="100%" class="text-wrap mb-0 tb table table-borderless table-striped table-hover ">
                    <thead class="">
                        <tr>
                            <th>Nama</th>
                            <th>No Hp</th>
                            <th data-priority="1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['cp'] as $v => $k): ?>
                        <tr>
                            <td>
                                <?php echo $k->nama; ?>
                                <div class="text-muted">Jabatan: <strong>
                                        <?php echo $k->jabatan; ?></strong></div>
                            </td>
                            <td>
                                <?php echo $k->nohp; ?>
                            </td>
                            <td class="text-right ">
                                <a href="?key=<?php echo $k->idpanti; ?>&idcp=<?php echo $k->idcp; ?>" class="btn btn-warning btn-sm">Kelola</a>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>
                                <input type="text" name="input[]" value="<?php echo $data['cp.key']['nama']; ?>" class="form-control" placeholder="Nama">
                                <input type="hidden" name="tb[]" value="nama">
                                <div>
                                    <input type="text" name="input[]" value="<?php echo $data['cp.key']['jabatan']; ?>"  class="form-control" placeholder="Jabatan">
                                    <input type="hidden" name="tb[]" value="jabatan">
                                </div>
                            </th>
                            <th>
                                <input type="text" name="input[]" value="<?php echo $data['cp.key']['nohp']; ?>" class="form-control" placeholder="No HP">
                                <input type="hidden" name="tb[]" value="nohp">
                                <input type="hidden" name="input[]" value="<?php echo $Request->key; ?>">
                                <input type="hidden" name="tb[]" value="idpanti">
                            </th>
                            <th>
                                <input type="hidden" name="table" value="cp">
                                <?php if (!isset($Request->idcp)): ?>
                                <button type="submit" name="aksi" value="insert" class="btn btn-sm  btn-primary">Tambah</button>
                                <?php else: ?>
                                <input type="hidden" name="key" value="<?php echo $Request->idcp; ?>">
                                <input type="hidden" name="primary" value="idcp">
                                <button type="submit" name="aksi" value="update" class="btn btn-sm  btn-info">Edit</button>
                                <button type="submit" name="aksi" value="delete" class="btn btn-sm  btn-danger">Hapus</button>
                                <a href="?key=<?php echo $Request->key; ?>" class="btn btn-sm  btn-warning">Kembali</a>
                                <?php endif;?>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>
    <?php endif;?>
    <div class=" col-12 mb-5">
        <div class="card rounded shadow" style="zoom:85%">
            <h5 class="text-dark ml-2 text-center mt-1 pt-1">Tabel Data</h5>
            <table width="100%" class="text-wrap mb-0 tb table table-borderless table-striped table-hover ">
                <thead class="">
                    <tr>
                        <th class="w-1">#</th>
                        <?php foreach ($data['form'] as $e): ?>
                        <?php if ($e['tb']): ?>
                        <th class="">
                            <?php echo $e['label']; ?>
                        </th>
                        <?php endif;?>
                        <?php endforeach;?>
                        <th data-priority="1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['data'] as $v => $k): ?>
                    <tr>
                        <td>
                            <?php echo $v + 1; ?>
                        </td>
                        <?php foreach ($data['form'] as $e1): ?>
                        <?php if ($e1['tb']): ?>
                        <td class="text-wrap">
                            <?php $b = $e1['name'];?>
                            <?php if ($b == 'harga'): ?>
                            Rp.
                            <?php echo number_format($k->$b); ?>
                            <?php elseif (in_array($b, ['visi', 'misi'])): ?>
                            <?php $k->$b = explode("\r\n", $k->$b);?>
                            <ul>
                                <?php foreach ($k->$b as $kx): ?>
                                <li>
                                    <?php echo $kx; ?>
                                </li>
                                <?php endforeach;?>
                            </ul>
                            <?php else: ?>
                            <?php echo $k->$b; ?>
                            <?php endif;?>
                        </td>
                        <?php endif;?>
                        <?php endforeach;?>
                        <td class="text-right ">
                            <a href="?key=<?php echo $k->idpanti; ?>" class="btn btn-warning btn-sm">Kelola</a>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>