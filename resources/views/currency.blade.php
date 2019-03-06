@extends('layouts.html')
@section('content')

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Dashboard</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group mr-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                </div>
                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                    <span data-feather="calendar"></span>
                    This week
                </button>
            </div>
        </div>

        <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>

        <h2>Валюты</h2>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
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
                @foreach ($currencies as $currency)
                    <tr>
                        <td>{{ $currency->id }}</td>
                        <td>{{ $currency->name }}</td>
                        <td>{{ $currency->cbr_code }}</td>
                        <td>{{ $currency->char_code }}</td>
                        <td></td>
                        <td></td>
                        {{--@if ($currency->lastRate()->date )--}}
                            {{--<td>{{ $currency->lastRate()->date->format('d-m-Y') }}</td>--}}
                            {{--<td>{{ $currency->lastRate()->price }}</td>--}}
                        {{--@else--}}
                            {{--<td></td>--}}
                            {{--<td></td>--}}
                        {{--@endif--}}


{{--                        <td>{{ $currency->lastRate()->price }}</td>--}}
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </main>
    {{--<nav class="col-md-2 d-none d-md-block bg-light sidebar">--}}
        {{--<div class="sidebar-sticky">--}}
            {{--<ul class="nav flex-column">--}}
                {{--<li class="nav-item">--}}
                    {{--<a class="nav-link active" href="#">--}}
                        {{--<span data-feather="home"></span>--}}
                        {{--Dashboard <span class="sr-only">(current)</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a class="nav-link" href="#">--}}
                        {{--<span data-feather="file"></span>--}}
                        {{--Orders--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a class="nav-link" href="#">--}}
                        {{--<span data-feather="shopping-cart"></span>--}}
                        {{--Products--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a class="nav-link" href="#">--}}
                        {{--<span data-feather="users"></span>--}}
                        {{--Customers--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a class="nav-link" href="#">--}}
                        {{--<span data-feather="bar-chart-2"></span>--}}
                        {{--Reports--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a class="nav-link" href="#">--}}
                        {{--<span data-feather="layers"></span>--}}
                        {{--Integrations--}}
                    {{--</a>--}}
                {{--</li>--}}
            {{--</ul>--}}

            {{--<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">--}}
                {{--<span>Saved reports</span>--}}
                {{--<a class="d-flex align-items-center text-muted" href="#">--}}
                    {{--<span data-feather="plus-circle"></span>--}}
                {{--</a>--}}
            {{--</h6>--}}
            {{--<ul class="nav flex-column mb-2">--}}
                {{--<li class="nav-item">--}}
                    {{--<a class="nav-link" href="#">--}}
                        {{--<span data-feather="file-text"></span>--}}
                        {{--Current month--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a class="nav-link" href="#">--}}
                        {{--<span data-feather="file-text"></span>--}}
                        {{--Last quarter--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a class="nav-link" href="#">--}}
                        {{--<span data-feather="file-text"></span>--}}
                        {{--Social engagement--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a class="nav-link" href="#">--}}
                        {{--<span data-feather="file-text"></span>--}}
                        {{--Year-end sale--}}
                    {{--</a>--}}
                {{--</li>--}}
            {{--</ul>--}}
        {{--</div>--}}
    {{--</nav>--}}


@stop





