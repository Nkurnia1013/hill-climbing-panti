<div class="col-12 mx-auto">
    <div class="card rounded">
        <?php if (!isset($Session['admin'])): ?>
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
        </div>
        <?php endif;?>
        <div class="row no-gutters ">
            <?php if (isset($Request->koor)): ?>
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
                                    <input type="text" class="form-control" value="<?php echo $Request->koor; ?>" readonly="" id="koor" name="koor">
                                    <div class="input-group-append">
                                        <span><button type="submit" class="btn btn-primary">Set</button></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-4 col-12 appx">
                <div class="card   rounded shadow mb-2 text-white bg-dark mb-3">
                    <div class="card-header">Berikut Rute paling efisien untuk anda mengunjungi panti-panti yang ada di Dumai</div>
                    <div class="card-body">
                        <table class="table bg-light table-striped " style="zoom:100%" width="100%">
                            <tr v-for="(a,index) in hasil.rule.detail" v-if="index>0">
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <span> {{a.nama}}</span>
                                        <span><button data-toggle="collapse" :data-target="'#rute'+index" class="btn btn-sm btn-primary">Detail</button></span>
                                    </div>
                                    <div class="collapse mt-2 mb-3" :id="'rute'+index">
                                        <table class="table" width="100%">
                                            <tr>
                                                <td>
                                                    <div class="d-flex justify-content-between">
                                                        <span>Website:</span>
                                                        <span>
                                                            <span class="badge badge-primary"><a class="text-reset" target="_blank" :href="a.panti.link">Kunjungi</a></span>
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex justify-content-between">
                                                        <span>Jarak:</span>
                                                        <span>
                                                            <span class="badge badge-success">{{(hasil.routes[0].legs[index-1].distance/1000).toFixed(2) }} Km</span>
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr v-for="(b,name) in hasil.routes[0].legs[index-1].steps">
                                                <td>
                                                    <a href="javascript:;" v-on:click="rute=b.geometry;uang()">
                                                        <div class="d-flex justify-content-between">
                                                            <span>{{Number(name)+1}}.{{b.maneuver.instruction}}</span>
                                                            <span>
                                                                <span class="badge badge-success">{{(b.distance/1000).toFixed(2) }} Km</span>
                                                            </span>
                                                        </div>
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-12">
                <div id="map" style="width: 100%;height:100%"></div>
            </div>
            <?php else: ?>
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
            <?php endif;?>
        </div>
    </div>
</div>