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

    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col-lg-12 mb-4">
            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary float-left">Daftar Kehadiran</h6>
                    <button class="btn btn-success float-right"><a href="<?php echo base_url('absen/export'); ?>" class="text-white"><i class="fas fa-file-excel"></i> Excel</a></button>
                </div>
                <div class="card-body">
                    <table class="table table-stripped">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Masuk</th>
                                <th>Keluar</th>
                                <th>Izin</th>
                                <th>Keterangan</th>
                                <th>Alasan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($absen as $absensi): ?>
                                <td><?=$absensi->nama?></td>
                                <td><?=$absensi->waktu_masuk?></td>
                                <td><?=$absensi->waktu_keluar?></td>
                                <td><?=$absensi->waktu_izin?></td>
                                <td><?=$absensi->keterangan?></td>
                                <td><?=$absensi->alasan?></td>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
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