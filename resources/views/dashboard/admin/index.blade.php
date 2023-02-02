@extends('app')

@section('content')
<div class="panel-body">
    <div class="row">
        <div class="col-md-3">
            <div class="metric">
                <span class="icon"><i class="lnr lnr-enter-down"></i></span>
                <p>
                    <span class="number">{{ $barangMasuk }}</span>
                    <span class="title">Barang Masuk</span>
                </p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="metric">
                <span class="icon"><i class="lnr lnr-exit-up"></i></span>
                <p>
                    <span class="number">{{ $barangKeluar }}</span>
                    <span class="title">Barang Keluar</span>
                </p>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-9">
            <div id="myChart" class="ct-chart"></div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script src="https://code.highcharts.com/highcharts.js"></script>

    <script>
        Highcharts.chart('myChart', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Grafik Barang Masuk dan Keluar'
    },
    subtitle: {
        text: 'Dihitung berdasarkan bulan'
    },
    xAxis: {
        categories: [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Jumlah barang yang masuk dan keluar'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [ {
        name: 'Barang Masuk',
        data: {!! json_encode($totalIn) !!}

    }, {
        name: 'Barang Keluar',
        data: {!! json_encode($totalOut) !!}

    }]
});
    </script>

@endpush