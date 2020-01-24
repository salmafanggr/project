       <!-- Begin Page Content -->
       <div class="container-fluid">

           <!-- Page Heading -->
           <h1 class="h3 mb-4 text-gray-800"><?= $tittle; ?></h1>

           <div class="row">
               <div class="col-lg-8">
                   <?= form_open_multipart('user/edit'); ?>

                   <div class="form-group row">
                       <label for="email" class="col-sm-2 col-form-label">Email</label>
                       <div class="col-sm-10">
                           <input type="text" class="form-control" id="email" name="email" value="<?= $user['email']; ?>" readonly>
                       </div>
                   </div>
                   <div class="form-group row">
                       <label for="name" class="col-sm-2 col-form-label">Full name</label>
                       <div class="col-sm-10">
                           <input type="text" class="form-control" id="name" name="name" value="<?= $user['name']; ?>">
                           <?= form_error('name', ' <small class="text-danger pl-3">', '</small>'); ?>
                       </div>
                   </div>
                   <div class="form-group row">
                       <label for="name" class="col-sm-2 col-form-label">NIP</label>
                       <div class="col-sm-10">
                           <input type="number" class="form-control" id="nip" name="nip" value="<?= $user['nip']; ?>" readonly>
                           <?= form_error('nip', ' <small class="text-danger pl-3">', '</small>'); ?>
                       </div>
                   </div>
                   <div class="form-group row">
                       <label for="name" class="col-sm-2 col-form-label">Jurusan</label>
                       <div class="col-sm-10">
                           <input type="text" class="form-control" id="jurusan" name="jurusan" value="<?= $user['jurusan']; ?>">
                           <?= form_error('nip', ' <small class="text-danger pl-3">', '</small>'); ?>
                       </div>
                   </div>
                   <div class="form-group row">
                       <label for="name" class="col-sm-2 col-form-label">Gender</label>
                       <div class="col-sm-10 ">
                           <input type="radio" name="gender" id="gender" class="ml-3" value="Laki-Laki" <?php echo ($user['gender'] == 'Laki-Laki') ?  "checked" : "" ;  ?>> Laki-laki
                           <input type="radio" name="gender" id="gender" class="ml-3" value="Perempuan" <?php echo ($user['gender'] == 'Perempuan') ?  "checked" : "" ;  ?>> Perempuan
                           <?= form_error('gender', ' <small class="text-danger pl-3">', '</small>'); ?>
                       </div>
                   </div>
                   <div class="form-group row">
                       <label for="name" class="col-sm-2 col-form-label">Alamat</label>
                       <div class="col-sm-10">
                           <input type="text" class="form-control" id="alamat" name="alamat" value="<?= $user['alamat']; ?>">
                           <?= form_error('alamat', ' <small class="text-danger pl-3">', '</small>'); ?>
                       </div>
                   </div>
                   <div class="form-group row">
                       <label for="name" class="col-sm-2 col-form-label">Pendidikan</label>
                       <div class="col-sm-10">
                           <input type="text" class="form-control" id="pendidikan" name="pendidikan" value="<?= $user['pendidikan']; ?>">
                           <?= form_error('pendidikan', ' <small class="text-danger pl-3">', '</small>'); ?>
                       </div>
                   </div>
                   <div class="form-group row">
                       <label for="name" class="col-sm-2 col-form-label">Keahlian</label>
                       <div class="col-sm-10">
                           <input type="text" class="form-control" id="skills" name="skills" value="<?= $user['skills']; ?>">
                           <?= form_error('skills', ' <small class="text-danger pl-3">', '</small>'); ?>
                       </div>
                   </div>
                   <div class="form-group row">
                       <label for="name" class="col-sm-2 col-form-label">Motto</label>
                       <div class="col-sm-10">
                           <input type="text" class="form-control" id="motto" name="motto" maxlength="100" value="<?= $user['motto']; ?>">
                           <?= form_error('motto', ' <small class="text-danger pl-3">', '</small>'); ?>
                       </div>
                   </div>
                   <div class="form-group row">
                       <div class="col-sm-2">Picture</div>
                       <div class="col-sm-10">
                           <div class="row">
                               <div class="col-sm-3">
                                   <img src="<?= base_url('assets/img/profile/') . $user['image']  ?>" class="img-thumbnail">
                               </div>
                               <div class="col-sm-9">
                                   <div class="custom-file">
                                       <input type="file" class="custom-file-input" id="image" name="image">
                                       <label class="custom-file-label" for="image">Choose file</label>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
                   <div class="form-group row justify-content-end">

                       <div class="col-sm-10">
                           <hr>
                           <button type="submit" class="btn btn-primary">Edit</button>
                       </div>
                   </div>

                   </form>
               </div>
           </div>


       </div>
       <!-- /.container-fluid -->

       </div>
       <!-- End of Main Content -->