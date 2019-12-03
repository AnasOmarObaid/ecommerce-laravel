@extends('layouts.Dashboard.app')
@section('app')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">@lang('site.dash')</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item active">Home</li>
          <li class="breadcrumb-item"><a href="#">@lang('site.dash')</a></li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{$orders}}</h3>

            <p>Orders</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="{{route('order.index')}}" class="small-box-footer">More info <i
              class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{$products}}</h3>

            <p>Products</p>
          </div>
          <div class="icon">
            <i class="fab fa-product-hunt"></i>
          </div>
          <a href="{{route('show.products')}}" class="small-box-footer">More info <i
              class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner" style="color:white">
            <h3>{{$users}}</h3>

            <p>Members</p>
          </div>
          <div class="icon">
            <i class="fas fa-user-tie"></i>
          </div>
          <a href="{{url('dashboard/user/show')}}" class="small-box-footer" style="color:white !important">More info <i
              style="color:white" class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>{{$clients}}</h3>

            <p>Clients</p>
          </div>
          <div class="icon">
            <i class="fas fa-users"></i>
          </div>
          <a href="{{route('show.clients')}}" class="small-box-footer">More info <i
              class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
    </div>
  </div>
  <div class="container-fluid" style="margin-top:15px">
    <!-- solid sales graph -->
    <div class="card bg-gradient-info">
      <div class="card-header border-0">
        <h3 class="card-title">
          <i class="fas fa-th mr-1"></i>
          Sales Graph
        </h3>

        <div class="card-tools">
          <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <canvas class="chart" id="line-chart" style="height: 250px;"></canvas>
      </div>
      <!-- /.card-body -->
      <div class="card-footer bg-transparent">
        <div class="row">
          <div class="col-4 text-center">
            <input type="text" class="knob" data-readonly="true" value="20" data-width="60" data-height="60"
              data-fgColor="#39CCCC">

            <div class="text-white">Mail-Orders</div>
          </div>
          <!-- ./col -->
          <div class="col-4 text-center">
            <input type="text" class="knob" data-readonly="true" value="50" data-width="60" data-height="60"
              data-fgColor="#39CCCC">

            <div class="text-white">Online</div>
          </div>
          <!-- ./col -->
          <div class="col-4 text-center">
            <input type="text" class="knob" data-readonly="true" value="30" data-width="60" data-height="60"
              data-fgColor="#39CCCC">

            <div class="text-white">In-Store</div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.card-footer -->
    </div>
    <!-- /.card -->
  </div>
  @push('scripts')
  <script>
    // Sales graph chart
var salesGraphChartCanvas = $('#line-chart').get(0).getContext('2d');
    //$('#revenue-chart').get(0).getContext('2d');
    var salesGraphChartData = {
        labels: ['2011 Q1', '2011 Q2', '2011 Q3', '2011 Q4', '2012 Q1', '2012 Q2', '2012 Q3', '2012 Q4', '2013 Q1', '2013 Q2'],
        datasets: [{
            label: 'Digital Goods',
            fill: false,
            borderWidth: 2,
            lineTension: 0,
            spanGaps: true,
            borderColor: '#efefef',
            pointRadius: 3,
            pointHoverRadius: 7,
            pointColor: '#efefef',
            pointBackgroundColor: '#efefef',
            data: [2666, 2778, 4912, 3767, 6810, 5670, 4820, 15073, 10687, 8432]
        }]
    }

    var salesGraphChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
            display: false,
        },
        scales: {
            xAxes: [{
                ticks: {
                    fontColor: '#efefef',
                },
                gridLines: {
                    display: false,
                    color: '#efefef',
                    drawBorder: false,
                }
            }],
            yAxes: [{
                ticks: {
                    stepSize: 5000,
                    fontColor: '#efefef',
                },
                gridLines: {
                    display: true,
                    color: '#efefef',
                    drawBorder: false,
                }
            }]
        }
    }

    // This will get the first returned node in the jQuery collection.
    var salesGraphChart = new Chart(salesGraphChartCanvas, {
        type: 'line',
        data: salesGraphChartData,
        options: salesGraphChartOptions
    })

  </script>
  @endpush

</section>
<!-- /.content -->
@endsection