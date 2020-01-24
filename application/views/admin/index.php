       <!-- Begin Page Content -->
       <div class="container-fluid">

            <div class="row">

                <!-- Content Column -->
                <div class="col-lg-12 mb-4">
                    <!-- Project Card Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Guru</h6>
                        </div>
                        <div class="card-body">
                        <table class="display table table-stripped" id="datatable" style="width:100%">
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
                    <input type="hidden" name="id" id="id">

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

<script>
    $(document).ready(function(){
        show_list();
        $('#datatable').DataTable({
            responsive: true
        });

        function show_list(){
            $.ajax({
                type  : 'GET',
                url   : '<?php echo base_url('admin/show')?>',
                async : true,
                dataType : 'json',
                success : function(data){
                    var html = '';
                    var i;
                    for(i=0; i<data.length; i++){
                        html += '<tr>'+
                                '<td>'+data[i].id+'</td>'+
                                '<td>'+'<img type src="assets/img/profile/'+data[i].image+'" class="img d-block mx-auto rounded" width="100">'+'</td>'+
                                '<td>'+data[i].name+'</td>'+
                                '<td>'+data[i].nip+'</td>'+
                                '<td>'+data[i].jurusan+'</td>'+
                                '<td>'+data[i].email+'</td>'+
                                '<td>'+data[i].alamat+'</td>'+
                                '<td style="text-align:right;">'+
                                    '<a href="javascript:void(0);" class="btn btn-info btn-sm item_edit" data-id="'+data[i].id+'" data-name="'+data[i].name+'" data-nip="'+data[i].nip+'" data-jurusan="'+data[i].jurusan+'">Edit</a>'+' '+
                                    '<a href="javascript:void(0);" class="btn btn-danger btn-sm item_delete" data-product_code="'+data[i].product_code+'">Delete</a>'+
                                '</td>'+
                                '</tr>';
                    }
                    $('#show_data').html(html);
                }
 
            });
        }

        //get data for update record
        $('#show_data').on('click','.item_edit',function(){
            var id = $(this).data('id');
            var name = $(this).data('name');
            var nip = $(this).data('nip');
            var jurusan = $(this).data('jurusan');
             
            $('#Modal_Edit').modal('show');
            $('[name="id"]').val(id);
            $('[name="name"]').val(name);
            $('[name="nip"]').val(nip);
            $('[name="jurusan"]').val(jurusan);
        });
 
        //update record to database
         $('#btn_update').on('click',function(){
            var id = $('#id').val();
            var name = $('#name').val();
            var nip = $('#nip').val();
            var jurusan = $('#jurusan').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo base_url('admin/update')?>",
                dataType : "JSON",
                data : {id:id , name:name, nip:nip, jurusan:jurusan},
                success: function(data){
                    $('[name="id"]').val("");
                    $('[name="name"]').val("");
                    $('[name="nip"]').val("");
                    $('[name="jurusan"]').val("");
                    $('#Modal_Edit').modal('hide');
                    show_list();
                }
            });
            return false;
        });


    });
</script>