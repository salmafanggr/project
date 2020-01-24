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

        <!-- Absensi -->
        <div class="col-xl-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Presensi Guru</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="float-right">
                        <script>
                        function date_time(id)
                        {
                                date = new Date;
                                year = date.getFullYear();
                                month = date.getMonth();
                                months = new Array('January', 'February', 'March', 'April', 'May', 'June', 'Jully', 'August', 'September', 'October', 'November', 'December');
                                d = date.getDate();
                                day = date.getDay();
                                days = new Array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
                                h = date.getHours();
                                if(h<10)
                                {
                                        h = "0"+h;
                                }
                                m = date.getMinutes();
                                if(m<10)
                                {
                                        m = "0"+m;
                                }
                                s = date.getSeconds();
                                if(s<10)
                                {
                                        s = "0"+s;
                                }
                                result = ''+days[day]+','+' '+d+' '+months[month]+' '+year+' '+h+':'+m+':'+s;
                                document.getElementById(id).innerHTML = result;
                                setTimeout('date_time("'+id+'");','1000');
                                return true;
                        }
                        </script>
                    </div>
                    <table class="table table-stripped">
                        <thead>
                            <th>Nama</th>
                            <th>Jurusan</th>
                            <th>Waktu</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <td><?= $_SESSION['name'] ?></td>
                            <td><?= $_SESSION['jurusan'] ?></td>
                            <td>
                                <span id="date_time"></span>
                                <script type="text/javascript">window.onload = date_time('date_time');</script>
                            </td>
                            <td>
                                <div class="row mx-auto">
                                    <?= form_open('user/masuk'); ?>
                                    <?php
                                        $tgl= date('Y-m-d');
                                        $id = $_SESSION['id'];
                                        $check = $this->db->query("SELECT * FROM absen WHERE user_id=$id AND (waktu_izin IS NOT NULL OR waktu_masuk IS NOT NULL) AND (DATE(waktu_masuk) = CURRENT_DATE() OR DATE(waktu_izin) = CURRENT_DATE())")->num_rows();
                                        if($check > 0){
                                            echo '<button type="submit" class="btn btn-primary btn-md mr-3" disabled>Masuk</button>';
                                        }else{
                                            echo '<button type="submit" class="btn btn-primary btn-md mr-3">Masuk</button>';
                                        }
                                    ?>
                                    </form>
                                    
                                    <?= form_open('user/keluar'); ?>
                                        <?php
                                            $id = $_SESSION['id'];
                                            $check = $this->db->query("SELECT * FROM absen WHERE user_id=$id AND (waktu_masuk IS NOT NULL AND waktu_keluar IS NULL)")->num_rows();
                                            if($check == 0){
                                                echo '<button type="submit" class="btn btn-primary btn-md mr-3" disabled>Keluar</button>';
                                            }else{
                                                echo '<button type="submit" class="btn btn-primary btn-md mr-3">Keluar</button>';
                                            }
                                        ?>
                                    </form>

                                    <?= form_open('user/izin'); ?>
                                        <?php
                                            $user_id = $_SESSION['id'];
                                            $check = $this->db->query("SELECT curdate() FROM absen WHERE user_id=$id AND (waktu_masuk IS NOT NULL OR waktu_izin IS NOT NULL) AND (DATE(waktu_masuk) = CURRENT_DATE() OR DATE(waktu_izin) = CURRENT_DATE())")->num_rows();
                                            if($check > 0){
                                                echo '<button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#exampleModal" disabled>Absen</button>';
                                            }else{
                                                echo '<button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#exampleModal">Absen</button>';
                                            }
                                        ?>
                                    </form>
                                </div>
                            </td>
                        </tbody>
                    </table>
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
                    <h6 class="m-0 font-weight-bold text-primary float-left">Daftar Kehadiran</h6>
                    <button class="btn btn-success float-right"><a href="<?php echo base_url('user/export'); ?>" class="text-white"><i class="fas fa-file-excel"></i> Excel</a></button>
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
                            <tr>
                                <td><?=$absensi->nama?></td>
                                <td><?=$absensi->waktu_masuk?></td>
                                <td><?=$absensi->waktu_keluar?></td>
                                <td><?=$absensi->waktu_izin?></td>
                                <td><?=$absensi->keterangan?></td>
                                <td><?=$absensi->alasan?></td>
                            </tr>
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
      <?= form_open('user/izin'); ?>
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

<script>
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();
if(dd<10) {
  dd='0'+dd
} 

if(mm<10) {
  mm='0'+mm
} 

today = dd+'/'+mm+'/'+yyyy;
document.getElementById("demonew").innerHTML = today;
var myVar=setInterval(function(){myTimer()},1000);

function myTimer() {
    var d = new Date();
    document.getElementById("demo").innerHTML = d.toLocaleTimeString();
}
</script>