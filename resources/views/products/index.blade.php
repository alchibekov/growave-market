@extends('layouts.master')

@section('header')

@endsection
@section('content')
    <div class="card mt-3">
        <h5 class="card-header">Продукты</h5>
        <div class="card-body">
            <table class="table table-sm table-striped table-hover">
                <thead>
                <tr>
                    <th scope="col" class="col-md-1">#</th>
                    <th scope="col" class="col-md-9">Название</th>
                    <th scope="col" class="col-md-1">Цена</th>
                    <th scope="col" class="col-md-1">Валюта</th>
                </tr>
                </thead>
                <tbody>
                @forelse($products as $product)
                    <tr>
                        <th scope="row" class="col-md-1">{{ $product->id }}</th>
                        <th class="col-md-11">{{ $product->name }}</th>
                        <th class="col-md-0 text-center">{{ $product->price }}</th>
                        <th class="col-md-0">{!! $product->presentCurrency() !!}</th>
                    </tr>
                @empty
                    <tr class="no-data text-center">
                        <td colspan="12">Нет продуктов для отображения</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>


@endsection

@section('scripts')
    <script>
        console.log('foo')
    </script>
@endsection
