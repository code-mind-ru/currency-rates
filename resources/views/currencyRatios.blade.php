@extends('layouts.html')


@section('content')
    <div class="row d-block">
        <h1 class="h2">Динамика курса {{ $currency->name }} [ {{ $currency->char_code }} ]</h1>
        <canvas class="my-4 w-100" id="currencyChart" width="900" height="380"></canvas>

        <div class="table-responsive">
            <table class="table table-striped table-sm" id="currency-table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Валюта</th>
                    <th>Код ЦБ РФ</th>
                    <th>Код ISO</th>
                    <th>Дата</th>
                    <th>Курс</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($currencyRatios as $ratio)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $ratio->name }}</td>
                        <td>{{ $ratio->cbr_code }}</td>
                        <td>{{ $ratio->char_code }}</td>
                        <td data-order="{{ $ratio->getDate()->format('U') }}">{{ $ratio->getDate()->format('d-m-Y') }}</td>
                        <td data-order="{{ $ratio->price }}">{{ $ratio->price }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@stop

@push('scripts')
    <script src="//cdn.datatables.net/buttons/1.5.4/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.5.4/js/buttons.flash.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="//cdn.datatables.net/buttons/1.5.4/js/buttons.html5.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.5.4/js/buttons.print.min.js"></script>

    <script>
        (function () {

            $('#currency-table').DataTable({
                dom: 'Bfrtip',
                searching: false,
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

            var ctx = document.getElementById('currencyChart')
            var currencyChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [
                        @foreach ($currencyRatios as $ratio)
                            '{{ $ratio->getDate()->format('d-m-Y') }}',
                        @endforeach
                    ],
                    datasets: [{
                        data: [
                            @foreach ($currencyRatios as $ratio)
                            {{ $ratio->price }},
                            @endforeach
                        ],
                        lineTension: 0,
                        backgroundColor: 'transparent',
                        borderColor: '#007bff',
                        borderWidth: 4,
                        pointBackgroundColor: '#007bff'
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: false
                            }
                        }]
                    },
                    legend: {
                        display: false
                    }
                }
            })

        }())
    </script>
@endpush





