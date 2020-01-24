       <!-- Begin Page Content -->
       <div class="container-fluid ">

           <!-- Page Heading -->
           <h1 class="h3 mb-4 text-gray-800"><?= $tittle; ?></h1>
           <div class="row">
               <div class="col-xl-7">
                   <?= $this->session->flashdata('message'); ?>
               </div>
           </div>

           <!-- Profile -->
           <div class="row">

               <!-- Profile -->
               <div class="col-xl-7">
                   <div class="card shadow mb-4">
                       <!-- Card Header - Dropdown -->
                       <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                           <h6 class="m-0 font-weight-bold text-primary"> Profil Guru </h6>
                       </div>
                       <!-- Card Body -->
                       <div class="card-body">
                           <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="mx-auto d-block" style="width: 150px;">
                           <div></div>
                           <dl class="row mt-4 mb-4 pb-3">
                               <dt class="col-sm-4">Nama</dt>
                               <dd class="col-sm-8"><?= $user['name']; ?></dd>

                               <dt class="col-sm-4">NIP</dt>
                               <dd class="col-sm-8"><?= $user['nip']; ?></dd>

                               <dt class="col-sm-4">Jurusan</dt>
                               <dd class="col-sm-8"><?= $user['jurusan']; ?></dd>

                               <dt class="col-sm-4">Jenis Kelamin</dt>
                               <dd class="col-sm-8"><?= $user['gender']; ?></dd>

                               <dt class="col-sm-4">Email address</dt>
                               <dd class="col-sm-8">
                                   <a href="#"><?= $user['email']; ?></a>
                               </dd>
                           </dl>
                       </div>
                   </div>
               </div>

               <!-- Absensi -->
               <div class="col-xl-5">
                   <div class="card card-primary shadow mb-4">
                       <div class="card-header card-header py-3 d-flex flex-row align-items-center justify-content-between">
                           <h6 class="m-0 font-weight-bold text-primary">About Me</h6>
                       </div>
                       <!-- /.card-header -->
                       <div class="card-body">
                           <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>

                           <p class="text-muted"><?= $user['alamat']; ?></p>

                           <hr>

                           <strong><i class="fas fa-book mr-1"></i> Pendidikan</strong>

                           <p class="text-muted">
                               <?= $user['pendidikan']; ?>
                           </p>

                           <hr>

                           <strong><i class="fas fa-pencil-alt mr-1"></i> Keahlian</strong>

                           <p class="text-muted">
                               <?= $user['skills']; ?>
                           </p>

                           <hr>

                           <strong><i class="far fa-file-alt mr-1"></i> Motto</strong>

                           <p class="text-muted"><?= $user['motto']; ?>
                       </div>
                       <!-- /.card-body -->
                   </div>
                   <!-- /.card -->
               </div>
           </div>
       </div>