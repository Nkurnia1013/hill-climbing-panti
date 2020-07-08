<div class="col-12 mx-auto">
    <div class="card rounded">
        <div class="card-body">
            <div class="d-flex  justify-content-between">
                <span>
                    <h3><i class="fa <?php echo $data['icon']; ?>"></i>
                        <?php echo $data['judul']; ?>
                    </h3>
                </span>
                <span>
                    <a href="Login" class="btn btn-warning">Login</a>
                </span>
            </div>
            <hr>
            <form>
                <div class="row">
                    <div class="form-grup col-6  input-group-sm">
                        <label class="form-control-label text-dark">Kecamatan</label>
                        <div class="input-group ">
                            <select class="form-control" name="idkecamatan">
                                <?php foreach ($data['kecamatan'] as $k): ?>
                                <option value="<?php echo $k->idkecamatan; ?>">
                                    <?php echo $k->kecamatan; ?>
                                </option>
                                <?php endforeach;?>
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary" type="submit">Search</button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
        <div id="map" style="width: 100%;height: 450px"></div>
    </div>
</div>