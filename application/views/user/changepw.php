       <!-- Begin Page Content -->
       <div class="container-fluid">

           <!-- Page Heading -->
           <h1 class="h3 mb-4 text-gray-800"><?= $tittle; ?></h1>


           <div class="row">
               <div class="col-lg-6">
                   <?= $this->session->flashdata('message'); ?>
                   <form action="<?= base_url('user/changepw') ?>" method="post">
                       <div class="form-group">
                           <label for="currentpw">Current Password</label>
                           <input type="password" class="form-control" id="currentpw" name="currentpw">
                           <?= form_error('currentpw', ' <small class="text-danger pl-3">', '</small>'); ?>
                       </div>
                       <div class="form-group">
                           <label for="newpw1">New Password</label>
                           <input type="password" class="form-control" id="newpw1" name="newpw1">
                           <?= form_error('newpw1', ' <small class="text-danger pl-3">', '</small>'); ?>
                       </div>
                       <div class="form-group">
                           <label for="newpw2">Repeat Password</label>
                           <input type="password" class="form-control" id="newpw2" name="newpw2">
                           <?= form_error('newpw2', ' <small class="text-danger pl-3">', '</small>'); ?>
                       </div>
                       <div class="form-group">
                           <button type="submit" class="btn btn-primary">Change Password</button>
                       </div>
                   </form>
               </div>


           </div>




       </div>
       <!-- /.container-fluid -->

       </div>
       <!-- End of Main Content -->