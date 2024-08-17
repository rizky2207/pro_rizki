@extends('layouts.app', ['title' => 'Tambah Penduduk'])

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold"><i class="fas  fa-users"></i> Tambah Penduduk</h6>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.penduduk.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label>Nik</label>
                            <input type="text" name="nik" value="{{ old('nik') }}" placeholder="Masukkan Nik Penduduk"
                                class="form-control @error('nik') is-invalid @enderror">

                            @error('nik')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Nama Penduduk</label>
                            <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan Nama Penduduk"
                                class="form-control @error('nama') is-invalid @enderror">

                            @error('nama')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Jenis Kelamin</label><br>
                            <label><input type="radio" name="jenis_kelamin" value="Laki-laki" {{ old('jenis_kelamin') == 'laki-laki' ? 'checked' : '' }}> Laki-laki</label>
                            <label><input type="radio" name="jenis_kelamin" value="Perempuan" {{ old('jenis_kelamin') == 'perempuan' ? 'checked' : '' }}> Perempuan</label>
                        
                            @error('jenis_kelamin')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input type="text" name="tanggal_lahir" id="datepicker" value="{{ old('tanggal_lahir') }}" placeholder="Pilih Tanggal Lahir"
                                class="form-control @error('tanggal_lahir') is-invalid @enderror">
                        
                            @error('tanggal_lahir')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>                        

                        <div class="form-group">
                            <label>Alamat</label>
                                <textarea name="alamat" value="{{ old('alamat') }}"   class="form-control @error('alamat') is-invalid @enderror" placeholder="Masukkan Alamat" id="floatingTextarea2" style="height: 100px"></textarea>
                            @error('alamat')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div> 
                        <div class="form-group">
                            <label>Provinsi</label>
                                <select name="provinsi_id" class="form-control" id="provinsi-dropdown">
                                    <option value="">-- Pilih Provinsi --</option>
                                    @foreach ($provinsis as $provinsi)
                                            <option value="{{ $provinsi->id }}">{{ $provinsi->nama }}</option>
                                    @endforeach
                                </select>
                        
                                @error('provinsi_id')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>
                                
                        <div class="form-group">
                            <label for="kabupaten">Kabupaten</label>
                                <select name="kabupaten_id" class="form-control" id="kabupaten-dropdown">
                                        <option value="">-- Pilih Kabupaten --</option>
                                </select>      
                        </div>
                  
                        
                    
                        <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i>
                            Simpan</button>
                        <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i> Reset</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<script>

$(function () {
        // Inisialisasi Datepicker
        $("#datepicker").datepicker({
            dateFormat: 'yy-mm-dd', // Set format tanggal yang diinginkan
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+0" // Sesuaikan rentang tahun sesuai kebutuhan
        });
    });

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

</script>
@endsection