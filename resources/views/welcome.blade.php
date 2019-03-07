@extends('layouts.html')
@section('content')
    <div class="row d-block">
        <h1 class="h2">Динамика официального курса заданной валюты</h1>
        <p>&nbsp;</p>
        <div class="col-md-8">
            <form class="needs-validation" novalidate="" method="post" action="{{ route('currency_report') }}">
                {{ csrf_field() }}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="fromDate">С</label>
                    <input type="date" class="form-control" name="fromDate" id="fromDate" value="" required="" />
                    <div class="invalid-feedback">Необходимо выбрать дату начала интервала</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="toDate">До</label>
                    <input type="date" class="form-control" name="toDate" id="toDate" value="" required="" />
                    <div class="invalid-feedback">Необходимо выбрать дату окончания интервала</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="currency">Выбирите валюту</label>
                    <select class="custom-select d-block w-100" id="currency" name="currency" required="">
                        @foreach ($currencies as $currency)
                            <option value="{{ $currency->cbr_code }}">{{ $currency->name }} [{{ $currency->char_code }}]</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Необходимо выбрать валюту</div>
                </div>
            </div>
            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" type="submit">Получить данные</button>
        </form>
        </div>
    </div>
@stop

