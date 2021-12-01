@extends('layouts.master')

@section('content')
    <div class="card mt-3">
        <div class="card-header">
            <nav class="navbar navbar-light justify-content-between">
                <h5 class="navbar-brand">Продукты</h5>
                <a class="btn btn-sm btn-warning my-2 my-sm-0" href="{{ route('cart.index') }}"
                   type="button">
                    {!! \App\Enum\Icon::ARROW_NARROW_RIGHT() !!}
                    {!! \App\Enum\Icon::CART() !!}
                </a>
            </nav>
        </div>
        <div class="card-body">
            <table class="table table-sm table table-hover">
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
                    <tr onclick="window.location.href='{{ route('products.show', ['product' => $product]) }}'">
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
        @if($products->hasPages())
            <div class="card-footer">
                {{ $products->links('pagination.default') }}
            </div>
        @endif
    </div>
@endsection
