<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $tittle; ?></h1>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>
    <!-- Content Row -->

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
                    <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="rounded mx-auto d-block rounded-circle" style="width: 150px;">
                    <div></div>
                    <dl class="row mt-4 mb-4 pb-3">
                        <dt class="col-sm-4">Nama</dt>
                        <dd class="col-sm-8"><?= $user['name']; ?></dd>

                        <dt class="col-sm-4">NIP</dt>
                        <dd class="col-sm-8"><?= $user['nip']; ?></dd>

                        <dt class="col-sm-4">Alamat</dt>
                        <dd class="col-sm-8">
                            <address class="mb-0">
                                <?= $user['alamat']; ?>
                            </address>
                        </dd>

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
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Absensi</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <?php
                    $date = mktime(date('m'), date('d'), date('Y'));
                    echo date('l-d-M-Y', $date) . "<br>";
                    date_default_timezone_set('Asia/Jakarta');
                    $time = date('h:i:s');
                    echo $time . " ";
                    $m = date('H');
                    if (($m >= 6) && ($m <= 11)) {
                        echo "am";
                    } else if (($m > 11) && ($m <= 15)) {
                        echo "am";
                    } else if (($m > 15) && ($m <= 18)) {
                        echo "pm";
                    } else {
                        echo "pm";
                    }
                    ?>
                    <div class="row mx-auto mt-3">
                        <?= form_open('absen/masuk'); ?>
                            <?php
                                $id = $_SESSION['id'];
                                $check = $this->db->query("SELECT curdate() FROM absen WHERE user_id=$id OR waktu_izin IS NULL AND waktu_masuk IS NULL")->num_rows();
                                if($check == 0){
                                    echo '<button type="submit" class="btn btn-primary btn-lg mr-3">Masuk</button>';
                                }else{
                                    echo '<button type="submit" class="btn btn-primary btn-lg mr-3" disabled>Masuk</button>';
                                }
                            ?>
                        </form>
                        
                        <?= form_open('absen/keluar'); ?>
                            <?php
                                $id = $_SESSION['id'];
                                $check = $this->db->query("SELECT curdate() FROM absen WHERE user_id=$id AND waktu_masuk IS NOT NULL AND waktu_keluar IS NULL")->num_rows();
                                if($check == 0){
                                    echo '<button type="submit" class="btn btn-primary btn-lg mr-3" disabled>Keluar</button>';
                                }else{
                                    echo '<button type="submit" class="btn btn-primary btn-lg mr-3">Keluar</button>';
                                }
                            ?>
                        </form>

                        <?= form_open('absen/izin'); ?>
                            <?php
                                $user_id = $_SESSION['id'];
                                $check = $this->db->query("SELECT curdate() FROM absen WHERE user_id=$id OR waktu_masuk IS NULL AND waktu_izin IS NULL")->num_rows();
                                if($check == 0){
                                    echo '<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#exampleModal">Absen</button>';
                                }else{
                                    echo '<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#exampleModal" disabled>Absen</button>';
                                }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col-lg-12 mb-4">
            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Jadwal Pelajaran</h6>
                </div>
                <div class="card-body">
                    <h1>INI JADWAL PELAJARAN </h1>
                </div>
            </div>
        </div>

    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?= form_open('absen/izin'); ?>
        <div class="modal-body">
            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <select class="custom-select" name="keterangan">
                    <option selected>Pilih salah satu</option>
                    <option value="Sakit">Sakit</option>
                    <option value="Izin">Izin</option>
                </select>
            </div>
            <div class="form-group">
                <label for="alasan">Alasan / Penjelasan</label>
                <input type="text" class="form-control" name="alasan" placeholder="Masukakan Sebab / Alasan">
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>