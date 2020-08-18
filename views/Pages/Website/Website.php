<div class="col-12 mx-auto">
    <div class="card rounded">
        <?php if (!isset($Session['admin'])): ?>

        <div class="card-body">
            <div class="d-flex  justify-content-start">

                <span class="mx-2"> <a href="Home" class="btn btn-warning "><< Kembali</a></span>
                <span class="mx-2">
                    <h3><i class="fa <?php echo $data['icon']; ?>"></i>
                        <?php echo $data['judul']; ?>
                    </h3>
                </span>
                <span>
                </span>
            </div>
            <hr>
        </div>
    <?php endif;?>
        <div class="px-5 mb-5">
            <div class="row mt-3">
                <div class="col-6">
                    <div class="card rounded shadow mb-2" style="zoom:85%">
                        <h6 class="text-dark ml-2 mt-1 pt-1">Informasi Panti </h6>
                        <div class="jumbotron p-2 bg-warning">
                            <table class="table bg-light table-striped table-hover">
                                <tr>
                                    <td class="py-2 ">Alamat</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-right">
                                        <?php echo $data['data']->alamat; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="py-2 ">Contact Person:</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="py-2 ">
                                        <ul>
                                            <?php foreach ($data['data']->cp as $k2): ?>
                                            <li>
                                                <div class="d-flex justify-content-between">
                                                    <span>
                                                        <?php echo $k2->nama; ?>
                                                        <div><strong>
                                                                <?php echo $k2->jabatan; ?></strong></div>
                                                    </span>
                                                    <span>
                                                        <span class="badge badge-dark">
                                                            <?php echo $k2->nohp; ?></span>
                                                    </span>
                                                </div>
                                            </li>
                                            <?php endforeach;?>
                                        </ul>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="card rounded shadow mb-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center pb-2">
                                        <div class="dot-indicator bg-danger mr-2"></div>
                                        <p class="mb-0">Perempuan</p>
                                    </div>
                                    <h4 class="font-weight-semibold"><?php echo $data['data']->perempuan; ?> Anak</h4>
                                    <?php @$per = (($data['data']->perempuan) / ($data['data']->perempuan + $data['data']->lakilaki)) * 100;?>
                                    <div class="progress progress-md">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $per; ?>%" aria-valuenow="<?php echo $per; ?>" aria-valuemin="0" aria-valuemax="<?php echo $per; ?>"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-4 mt-md-0">
                                    <div class="d-flex align-items-center pb-2">
                                        <div class="dot-indicator bg-primary mr-2"></div>
                                        <p class="mb-0">Laki Laki</p>
                                    </div>
                                    <h4 class="font-weight-semibold"><?php echo $data['data']->lakilaki; ?> Anak</h4>
                                    <?php @$per = (($data['data']->lakilaki) / ($data['data']->perempuan + $data['data']->lakilaki)) * 100;?>

                                    <div class="progress progress-md">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $per; ?>%" aria-valuenow="<?php echo $per; ?>" aria-valuemin="0" aria-valuemax="<?php echo $per; ?>"></div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card rounded shadow mb-2" style="zoom:85%">
                        <h6 class="text-dark ml-2 mt-1 pt-1">Visi </h6>
                        <div class="jumbotron bg-warning">
                            <h1 class="text-center h2">“
                                <?php $data['data']->visi = explode("\r\n", $data['data']->visi);?>
                                <?php foreach ($data['data']->visi as $k2): ?>
                                <?php echo $k2; ?>
                                <?php endforeach;?>” </h1>
                        </div>
                    </div>
                    <div class="card rounded shadow mb-2" style="zoom:85%">
                        <h6 class="text-dark ml-2 mt-1 pt-1">Misi </h6>
                        <div class="jumbotron  bg-warning p-3 ">
                            <?php $data['data']->misi = explode("\r\n", $data['data']->misi);?>
                            <?php foreach ($data['data']->misi as $v => $k2): ?>
                            <div class="d-flex">
                                <span class="mb-0 px-3 mb-2 py-2 shadow text-wrap bg-white rounded-pill ">
                                    <?php echo $v + 1; ?>.
                                    <?php echo $k2; ?>
                                </span>
                            </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="carouselExampleIndicators" class="carousel text-center  slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <?php foreach ($data['data']->foto as $v => $k): ?>
                <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $v; ?>" class="<?php if ($v == 0): ?>active<?php endif;?>"></li>
                <?php endforeach;?>
            </ol>
            <div class="carousel-inner">
                <?php foreach ($data['data']->foto as $v => $k): ?>
                <div class="carousel-item <?php if ($v == 0): ?>active<?php endif;?>">
                    <img src="upload/<?php echo $k->foto; ?>" class="d-block w-100 " alt="...">
                    <div class="carousel-caption  d-none d-md-block ">
                        <?php $k->desk = explode("\r\n", $k->desk);?>
                        <?php foreach ($k->desk as $k2): ?>
                        <p class="">
                            <?php echo $k2; ?>
                        </p>
                        <?php endforeach;?>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>