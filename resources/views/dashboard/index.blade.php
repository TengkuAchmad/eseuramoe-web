@extends('layout.app')

@push('addon-style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js">
@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Dashboard</h1>
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <a href="{{ route('result.index') }}" class="text-decoration-none">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Results</h4>
                        </div>
                        <div class="card-body">
                            {{ $resultCount }}
                        </div>
                    </div>
                </div>
            </a>
        </div>


        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <a href="{{ route('model.index') }}" class="text-decoration-none">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-cube"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Models</h4>
                        </div>
                        <div class="card-body">
                            {{ $modelCount }}
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="fas fa-search"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Detected</h4>
                    </div>
                    <div class="card-body">
                        {{ $detectedCount }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Last Update</h4>
                    </div>
                    <div class="card-body">
                        {{ \Carbon\Carbon::parse($timestamp)->format('H:i') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
