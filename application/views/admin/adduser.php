<!-- Begin Page Content -->
<div class="container-fluid">

   <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">><?= $tittle; ?></h1>

    <div class="row">
        <div class="col-lg-8">
            <form class="user" method="post" action="<?= base_url('admin/adduser') ?>">
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Full name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Full Name" value="<?= set_value('name') ?>">
                    <?= form_error('name', ' <small class="text-danger pl-3">', '</small>'); ?>
                </div>
            </div>
           <div class="form-group row">
               <label for="name" class="col-sm-2 col-form-label">NIP</label>
                <div class="col-sm-10">
                   <input type="text" class="form-control" id="nip" name="nip" placeholder="NIP" value="<?= set_value('nip') ?>">
                   <?= form_error('nip', ' <small class="text-danger pl-3">', '</small>'); ?>
                </div>
           </div>
           <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Alamat</label>
               <div class="col-sm-10">
                   <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat" value="<?= set_value('alamat') ?>">
                    <?= form_error('alamat', ' <small class="text-danger pl-3">', '</small>'); ?>
               </div>
           </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="email" name="email" placeholder="Email Address" value="<?= set_value('email') ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                <input type="password" class="form-control" id="password1" name="password1" placeholder="Password">
                   <?= form_error('password1', ' <small class="text-danger pl-3">', '</small>'); ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                <input type="password" class="form-control" id="password2" name="password2" placeholder="Repeat Password">
                </div>
            </div>
            <div class="form-group row justify-content-end">
                <div class="col-sm-10">
                <hr>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </div>
            </form>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->