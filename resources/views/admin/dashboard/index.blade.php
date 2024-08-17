@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->


    <!-- Content Row -->

    <div class="row">

        <!-- Area Chart -->
        <div class="col-md-4">

            <div class="card border-0 shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold">Data Penduduk</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    {{-- <h5>{{ moneyFormat($revenueMonth) }}</h5> --}}
                </div>
            </div>
        </div>

        

    </div>

</div>
@endsection