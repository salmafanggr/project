       <!-- Begin Page Content -->
       <div class="container-fluid">

       <div class="row">
        <div class="col-lg-8">
            <?= $this->session->flashdata('message'); ?>
        </div>
        </div>

            <div class="row">

                <!-- Content Column -->
                <div class="col-lg-12 mb-4">
                    <!-- Project Card Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Guru</h6>
                        </div>
                        <div class="card-body">
                        <table class="display table table-stripped" id="datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>Nama</th>
                                    <th>NIP</th>
                                    <th>Jurusan</th>
                                    <th>Email</th>
                                    <th>Alamat</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="show_data">
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
        <!-- MODAL EDIT -->
        <form>
            <div class="modal fade" id="Modal_Edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Nama</label>
                            <div class="col-md-10">
                              <input type="text" name="name" id="name" class="form-control" placeholder="Nama">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">NIP</label>
                            <div class="col-md-10">
                              <input type="text" name="nip" id="nip" class="form-control" placeholder="NIP">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Jurusan</label>
                            <div class="col-md-10">
                              <input type="text" name="jurusan" id="jurusan" class="form-control" placeholder="Jurusan">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Email</label>
                            <div class="col-md-10">
                              <input type="text" name="email" id="email" class="form-control" placeholder="email">
                            </div>
                        </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" type="submit" id="btn_update" class="btn btn-primary">Update</button>
                  </div>
                </div>
              </div>
            </div>
            </form>
        <!--END MODAL EDIT-->

        <!--MODAL HAPUS-->
        <div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hapus Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="form-horizontal">
                    <div class="modal-body">
                                           
                            <input type="hidden" name="id" id="hapus_id">
                            <div class="alert alert-warning"><p>Apakah Anda yakin mau memhapus barang ini?</p></div>
                                         
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button class="btn_hapus btn btn-danger" id="btn_hapus">Hapus</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!--END MODAL HAPUS-->

        <!--MODAL CONFIRM-->
        <form>
            <div class="modal fade" id="Modal_Confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                        <input type="hidden" name="id" id="confirm_id">
                        <input type="hidden" id="is_confirm" value="1">
                        <div class="alert alert-warning"><p>Apakah Anda yakin Konfirmasi akun ini?</p></div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" type="submit" id="btn_confirm" class="btn btn-primary">Confirm</button>
                  </div>
                </div>
              </div>
            </div>
            </form>
        <!--END MODAL EDIT-->
        <!--END MODAL CONFIRM-->

<script>
    $(document).ready(function(){
        $('#datatable').DataTable({
            ajax:"<?php echo base_url('admin/show')?>",
            "aoColumns": [
                { "data": "id" },
                {
                    "mData": "image",
                    "mRender": function (data, type, row) {
                        return "<img src='assets/img/profile/" + data + "' class='img-rounded' width='50'>";
                    }
                },
                { "data": "name" },
                { "data": "nip" },
                { "data": "jurusan" },
                { "data": "email" },
                { "data": "alamat" },
                {
                    "mData": "id",
                    "mRender": function (data, type, row) {
                        return "<div class='row'>"
                        +"<a href='javascript:void(0);' class='btn btn-info btn-sm item_edit' data='"+data+"'>Edit</a>"
                        +"<a href='javascript:void(0);' class='btn btn-danger btn-sm item_hapus' data='"+data+"'>Hapus</a>"
                        +"<a href='javascript:void(0);' class='btn btn-warning btn-sm item_confirm' data='"+data+"'>Confirm</a>"
                        +"</div>";
                    }
                },
            ]
        });

        //get data for update record
        $('#show_data').on('click','.item_edit',function(){
            var id = $(this).attr("data");
            $.ajax({
                type : "GET",
                url  : "<?php echo base_url('admin/get_data')?>",
                dataType : "JSON",
                data : {id:id},
                success: function(data){
                    $.each(data,function(id, name, nip, jurusan, email){
                        $('#Modal_Edit').modal('show');
                        $('[name="id"]').val(data.id);
                        $('[name="name"]').val(data.name);
                        $('[name="nip"]').val(data.nip);
                        $('[name="jurusan"]').val(data.jurusan);
                        $('[name="email"]').val(data.email);
                    });
                }
            });
            return false;
        });
 
        //update record to database
         $('#btn_update').on('click',function(){
            var id = $('#edit_id').val();
            var name = $('#name').val();
            var nip = $('#nip').val();
            var jurusan = $('#jurusan').val();
            var email = $('#email').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo base_url('admin/update')?>",
                dataType : "JSON",
                data : {id:id , name:name, nip:nip, jurusan:jurusan, email:email},
                success: function(data){
                    $('[name="id"]').val("");
                    $('[name="name"]').val("");
                    $('[name="nip"]').val("");
                    $('[name="jurusan"]').val("");
                    $('[name="email"]').val("");
                    $('#Modal_Edit').modal('hide');
                    $('#datatable').DataTable().ajax.reload();
                }
            });
            return false;
        });

        //GET HAPUS
        $('#show_data').on('click','.item_hapus',function(){
            var id=$(this).attr('data');
            $('#ModalHapus').modal('show');
            $('[name="id"]').val(id);
        });

        //Hapus Barang
        $('#btn_hapus').on('click',function(){
            var id=$('#hapus_id').val();
            $.ajax({
            type : "POST",
            url  : "<?php echo base_url('admin/hapus')?>",
            dataType : "JSON",
                data : {id: id},
                success: function(data){
                        $('#ModalHapus').modal('hide');
                        $('#datatable').DataTable().ajax.reload();
                }
            });
            return false;
        });

        //GET CONFIRM
        $('#show_data').on('click','.item_confirm',function(){
            var id=$(this).attr('data');
            $('#Modal_Confirm').modal('show');
            $('[name="id"]').val(id);
        });

        $('#btn_confirm').on('click',function(){
            var id=$('#confirm_id').val();
            var is_confirm=$('#is_confirm').val();
            $.ajax({
            type : "POST",
            url  : "<?php echo base_url('admin/confirm')?>",
            dataType : "JSON",
                data : {id: id, is_confirm:is_confirm},
                success: function(data){
                    $('[name="id"]').val("");
                    $('[name="is_confirm"]').val("");
                    $('#Modal_Confirm').modal('hide');
                    if(data === false){
                        alert("Sudah dikonfirmasi");
                    }else{
                        alert("Berhasil dikonfirmasi");
                        $('#datatable').DataTable().ajax.reload();
                    }
                }
            });
            return false;
        });

    });
</script>