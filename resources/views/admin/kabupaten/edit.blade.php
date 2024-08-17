@extends('layouts.app', ['title' => 'Edit Kabupaten'])

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-building"></i> Edit Kabupaten</h6>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.kabupaten.update', $kabupaten->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Kabupaten</label>
                            <input type="text" name="nama" value="{{ old('nama', $kabupaten->nama) }}"
                                placeholder="Masukkan Nama Kabupaten"
                                class="form-control @error('nama') is-invalid @enderror">

                            @error('nama')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Provinsi</label>
                                    <select name="provinsi_id" class="form-control">
                                        <option value="">-- PILIH PROVINSI --</option>
                                        @foreach ($provinsis as $provinsi)
                                            @if($kabupaten->provinsi_id == $provinsi->id)
                                                <option value="{{ $provinsi->id  }}" selected>{{ $provinsi->nama }}</option>
                                            @else
                                                <option value="{{ $provinsi->id  }}">{{ $provinsi->nama }}</option>
                                            @endif
                                        @endforeach
                                    </select>

                                    @error('provinsi_id')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
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
@endsection