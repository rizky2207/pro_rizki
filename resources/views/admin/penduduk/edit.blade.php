@extends('layouts.app', ['title' => 'Edit Penduduk'])

@section('content')
<!-- Konten Halaman -->
<div class="container-fluid">

    <!-- Judul Halaman -->
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-users"></i> Edit Penduduk</h6>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.penduduk.update', $penduduk->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="nama" value="{{ old('nama', $penduduk->nama) }}"
                                placeholder="Masukkan Nama Penduduk"
                                class="form-control @error('nama') is-invalid @enderror">

                            @error('nama')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Nik</label>
                            <input type="text" name="nik" value="{{ old('nik', $penduduk->nik) }}"
                                placeholder="Masukkan Nik Penduduk"
                                class="form-control @error('nik') is-invalid @enderror">

                            @error('nik')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Jenis Kelamin</label><br>
                            <label><input type="radio" name="jenis_kelamin" value="Laki-laki" {{ old('jenis_kelamin',$penduduk->jenis_kelamin) == 'Laki-laki' ? 'checked' : '' }}> Laki-laki</label>
                            <label><input type="radio" name="jenis_kelamin" value="Perempuan" {{ old('jenis_kelamin',$penduduk->jenis_kelamin) == 'Perempuan' ? 'checked' : '' }}> Perempuan</label>
                        
                            @error('jenis_kelamin')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input type="text" name="tanggal_lahir" id="datepicker" value="{{ old('tanggal_lahir',$penduduk->tanggal_lahir) }}" placeholder="Pilih Tanggal Lahir"
                                class="form-control @error('tanggal_lahir') is-invalid @enderror">
                        
                            @error('tanggal_lahir')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>                        
                        

                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" placeholder="Masukkan Alamat" id="floatingTextarea2" style="height: 100px">{{ old('alamat', $penduduk->alamat) }}</textarea>
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
                                    @if($penduduk->provinsi_id == $provinsi->id)
                                        <option value="{{ $provinsi->id }}" selected>{{ $provinsi->nama }}</option>
                                    @else
                                        <option value="{{ $provinsi->id }}">{{ $provinsi->nama }}</option>
                                    @endif
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
                                @if($penduduk->provinsi_id == $provinsi->id)
                                    <option value="{{ $penduduk->kabupaten_id }}" selected>{{ $penduduk->kabupaten->nama }}</option>
                                @else
                                    <option value="">-- Pilih Kabupaten --</option>
                                    @foreach ($kabupatens as $kabupaten)
                                        <option value="{{ $kabupaten->id }}">{{ $kabupaten->nama }}</option>
                                    @endforeach
                                @endif
                            </select>      
                        </div>

                        <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i>
                            UPDATE</button>
                        <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i> RESET</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        $('#datepicker').datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose: true
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
