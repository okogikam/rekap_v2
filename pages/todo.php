<?php

if(isset($_POST['tambah'])){
    $isi = get_input($_POST['catatan']);
    $tipe = get_input($_POST['tipe']);
    $result = savecatatan($isi,$tipe,$conn);
}
if(isset($_GET['i']) && isset($_GET['id'])){
    $i = get_input($_GET['i']);
    $id = get_input($_GET['id']);
    if($i == "del_ctt"){
        $result = hapuscatatan($id,$conn);
    }
}

$todo = todo($conn);
$catatan = catatan($conn);
$surat =surat($conn);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper kanban">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1>To-Do</h1>
                </div>
                <div class="col-sm-6 d-none d-sm-block">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">To-Do</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content pb-3">
        <div class="container-fluid h-100">
            <div class="card card-row card-secondary">
                <div class="card-header">
                    <h3 class="card-title">
                        Catatan
                    </h3>
                    <span class="float-right">
                        <button id="tambah" class="btn btn-secondary m-0 p-0" data-toggle="modal"
                            data-target="#myCatatan"><i class="fas fa-plus"></i></button>
                    </span>
                </div>
                <div class="card-body">
                    <?php display_catatan($p,$catatan); ?>
                </div>
            </div>
            <div class="card card-row card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        To Do
                    </h3>
                    <span class="float-right">
                        <button id="tambah" class="btn btn-primary m-0 p-0" data-toggle="modal" data-target="#myToDo"><i
                                class="fas fa-plus"></i></button>
                    </span>
                </div>
                <div class="card-body">
                    <?php display_catatan($p,$todo); ?>
                </div>
            </div>
            <div class="card card-row card-default">
                <div class="card-header bg-info">
                    <h3 class="card-title">
                        <a href="http://e-office.fkip.ulm.ac.id" target="_blank">Surat</a>
                    </h3>
                    <span class="float-right">
                        <button id="tambah" class="btn btn-info m-0 p-0" data-toggle="modal" data-target="#mySurat"><i
                                class="fas fa-plus"></i></button>
                    </span>
                </div>
                <div class="card-body">
                    <?php display_catatan($p,$surat); ?>
                </div>
            </div>
        </div>
    </section>
    <aside>
        <div class="modal fade" tabindex="-1" role="dialog" id="mySurat">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="#" method="POST">
                        <div class="modal-header">
                            <h4 class="modal-title">Tambah Surat</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <textarea name="catatan" class="form-control" rows="10"></textarea>
                            <input type="hidden" name="tipe" value="surat">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" name="tambah" value="Tambah">
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div class="modal fade" tabindex="-1" role="dialog" id="myToDo">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="#" method="POST">
                        <div class="modal-header">
                            <h4 class="modal-title">Tambah To-do</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <textarea name="catatan" class="form-control" rows="10"></textarea>
                            <input type="hidden" name="tipe" value="todo">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" name="tambah" value="Tambah">
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div class="modal fade" tabindex="-1" role="dialog" id="myCatatan">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="#" method="POST">
                        <div class="modal-header">
                            <h4 class="modal-title">Tambah Catatan</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <textarea name="catatan" class="form-control" rows="10"></textarea>
                            <input type="hidden" name="tipe" value="catatan">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" name="tambah" value="Tambah">
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </aside>
</div>