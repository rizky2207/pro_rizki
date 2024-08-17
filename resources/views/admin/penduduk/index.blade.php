@extends('layouts.app', ['title' => 'Penduduk'])

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid mb-5">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold"><i class="fas  fa-users"></i> Penduduk</h6>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.penduduk.index') }}" method="GET">
                        <div class="form-group">
                            <div class="contain d-flex align-items-center">

                                <div class="input-group-prepend">
                                    <a href="{{ route('admin.penduduk.create') }}" class="btn btn-primary btn-sm" style="padding-top: 10px;">
                                        <i class="fa fa-plus-circle"></i> TAMBAH
                                    </a>
                                </div>
                            
                                <div class="input-group d-flex align-items-center justify-content-end">
                                    <div class="input-group-append">
                                        <select class="form-control " name="provinsi_id" id="provinsi-dropdown">
                                            <option value="">Pilih Provinsi</option>
                                            @foreach($provinsis as $provinsi)
                                                <option value="{{ $provinsi->id }}">{{ $provinsi->nama }}</option>
                                            @endforeach
                                        </select>
                            
                                        <select name="kabupaten_id" class="form-control" id="kabupaten-dropdown">
                                            <option value="">-- Pilih Kabupaten --</option>
                                        </select>
                                    </div>
                            
                                    <div class="input-group-append">
                                        <input type="text" class="form-control" name="q" placeholder="Cari berdasarkan nama Nik/Nama" style="width: 300px;">
                                        <button type="submit" class="btn btn-primary"> CARI</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align: center;width: 6%">NO.</th>
                                    <th scope="col" style="width: 15%;text-align: center">AKSI</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Nik</th>
                                    <th scope="col">Tanggal Lahir</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">Jenis Kelamin</th>
                                    <th scope="col">Timestamp</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($penduduks as $no => $penduduk)
                                <tr>
                                    <th scope="row" style="text-align: center">
                                        {{ ++$no + ($penduduks->currentPage()-1) * $penduduks->perPage() }}</th>
                                        <td class="text-center">
                                            <a href="{{ route('admin.penduduk.edit', $penduduk->id) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>
    
                                            <button onClick="Delete(this.id)" class="btn btn-sm btn-danger"
                                                id="{{ $penduduk->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    <td>{{ $penduduk->nama }}</td>
                                    <td>{{ $penduduk->nik }}</td>
                                    <td>{{ $penduduk->tanggal_lahir }}</td>
                                    <td>{{ $penduduk->alamat }} {{ $penduduk->provinsi->nama }} {{ $penduduk->kabupaten->nama }} </td>
                                    <td>{{ $penduduk->jenis_kelamin }}</td>
                                    <td>{{$penduduk->created_at->format('d-m-Y')}}</td>
                                </tr>

                                @empty

                                    <div class="alert alert-danger">
                                        Data Belum Tersedia!
                                    </div>

                                @endforelse
                            </tbody>
                        </table>
                        <div style="text-align: center">
                            {{$penduduks->links("vendor.pagination.bootstrap-4")}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<script>

$(document).ready(function() {
    $('#provinsi-dropdown').on('change', function() {
        var provinsi_id = this.value;
        $("#kabupaten-dropdown").html('');
        $.ajax({
            url: "{{ route('admin.penduduk.getKabupaten') }}",
            type: "POST",
            data: {
                provinsi_id: provinsi_id,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(result) {
                $('#kabupaten-dropdown').html('<option value="">-- Pilih Kabupaten --</option>');
                $.each(result.kabupaten, function(key, value) {
                    $("#kabupaten-dropdown").append('<option value="'+value.id+'">'+value.nama+'</option>');
                });
            }
        });
    });
});


    //ajax delete
    function Delete(id) {
        var id = id;
        var token = $("meta[name='csrf-token']").attr("content");

        swal({
            title: "APAKAH KAMU YAKIN ?",
            text: "INGIN MENGHAPUS DATA INI!",
            icon: "warning",
            buttons: [
                'TIDAK',
                'YA'
            ],
            dangerMode: true,
        }).then(function (isConfirm) {
            if (isConfirm) {

                //ajax delete
                jQuery.ajax({
                    url: "/admin/penduduk/" + id,
                    data: {
                        "id": id,
                        "_token": token
                    },
                    type: 'DELETE',
                    success: function (response) {
                        if (response.status == "success") {
                            swal({
                                title: 'BERHASIL!',
                                text: 'DATA BERHASIL DIHAPUS!',
                                icon: 'success',
                                timer: 1000,
                                showConfirmButton: false,
                                showCancelButton: false,
                                buttons: false,
                            }).then(function () {
                                location.reload();
                            });
                        } else {
                            swal({
                                title: 'GAGAL!',
                                text: 'DATA GAGAL DIHAPUS!',
                                icon: 'error',
                                timer: 1000,
                                showConfirmButton: false,
                                showCancelButton: false,
                                buttons: false,
                            }).then(function () {
                                location.reload();
                            });
                        }
                    }
                });

            } else {
                return true;
            }
        })
    }
</script>
@endsection