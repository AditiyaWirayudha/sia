@extends('layout.app')

@section('title')
    Kelas
@endsection

@section('content')

 <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Data Kelas</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Kelas</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Kelas</h3>
                        <div class="card-tools">
                            <button type="button" onclick="addForm('{{route('kelas.store')}}')" class="btn btn-tool"><i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class=" table table-hover text-nowrap" style="width:100%">
                            <thead>

                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>

                            </thead>
                           
                        </table>
                    </div>
                </div>

            </section>

@includeif('kelas.form')
@endsection

@push('script')

    <script>

        let table;

        $(function(){
            table = $('.table').DataTable({
                proccesing: true,
                autowidth: false,
                ajax: {
                    url: '{{ route ('kelas.data')}}'
                },
                columns:[
                    {data: 'DT_RowIndex'},
                    {data: 'nama'},
                    {data: 'aksi'},
                ]
            });
        })

        $('#modalForm').on('submit', function(e){

            if(! e.preventDefault()){
                $.post($('#modalForm form').attr('action'), $('#modalForm form').serialize())
                .done((response) => {
                    $('#modalForm').modal('hide');
                    table.ajax.reload();

                    iziToast.success({
                    title:'SUCCESS',
                    message:'Data Berhasil Disimpan',
                    position : 'topRight' 
                })
                })

                .fail((errors) =>{

                    iziToast.error({
                    title:'ERROR',
                    message:'Data Gagal Disimpan',
                    position : 'topRight' 
                })
                return;
                })
            }              
            
        })

        function addForm(url){

            $('#modalForm').modal('show');
            $('#modalForm .modal-title').text('Tambah Data Kelas');
            
            $('#modalForm form')[0].reset();
            $('#modalForm form').attr('action',url);
            $ ('#modalForm [name=_method]').val('post');
        }
        function editData(url){
            
            $('#modalForm').modal('show');
            $('#modalForm .modal-title').text('Edit Data Kelas');

            $('#modalForm form')[0].reset();
            $('#modalForm form').attr('action',url);
            $('#modalForm [name=_method]').val('put');

            $.get(url)
            .done((response)=>{
                $('#modalForm [name=nama]').val(response.nama);
                
            })

            .fail((errors)=>{
                alert('Tidak Dapat Menampilkan Data');
                return;
            })
        }

        function deleteData(url){

            swal({
                title: "Yaqin Kah DECKK?",
                text: "Jika anda klik ok maka data akan di hapus",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {

                    $.post(url, {

                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method':'delete'
                    })

                    .done((response)=>{
                        swal({
                            title: "ANJAYYY",
                            text:"Data Berhasil Dihapus",
                            icon: "success",
                        });
                        return;
                    })
        
                    .fail((errors)=>{
                        swal({
                            title: "Gagal",
                            text:"Data Gagal Dihapus",
                            icon: "error",
                        });
                        return;
                    })
        
                    table.ajax.reload()
                    
                } 

                });

            
    }

    </script>

@endpush