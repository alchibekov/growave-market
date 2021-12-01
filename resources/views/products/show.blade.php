@extends('layouts.master')

@section('content')
    <div class="card mt-3">
        <div class="card-header">
            <nav class="navbar navbar-light bg-light justify-content-between">
                <a class="navbar-brand">{{ $product->name }}</a>
                <a class="btn btn-sm btn-outline-secondary my-2 my-sm-0" href="{{ route('products.index') }}"
                   type="button">
                    {!! \App\Enum\Icon::ARROW_NARROW_LEFT() !!}
                </a>
            </nav>
        </div>
        <div class="card-body">
            <table class="table table-sm table-striped">
                <tbody>
                <tr>
                    <th scope="row" class="col-md-3">#</th>
                    <th class="col-md-9">{{ $product->id }}</th>
                </tr>
                <tr>
                    <th scope="row" class="col-md-3">Название</th>
                    <th class="col-md-9">{{ $product->name }}</th>
                </tr>
                <tr>
                    <th scope="row" class="col-md-3">Описание</th>
                    <th class="col-md-9">{{ $product->description }}</th>
                </tr>
                <tr>
                    <th scope="row" class="col-md-3">Цена</th>
                    <th class="col-md-9">{!! $product->presentPrice() !!}</th>
                </tr>
                </tbody>
            </table>

            <button id="add-to-cart-btn"
                    @if($product->existsInCart()) hidden @endif
                    class="btn btn-success"
                    title="Добавить в корзину"
                    data-action="{{ route('products.add-to-cart', $product->id) }}"
                    data-id="{{ $product->id }}"
                    onclick="addToCart(this)">
                <i>{!! \App\Enum\Icon::ADD_TO_CART() !!}</i>
            </button>
            <a id="go-to-cart-btn"
               @if(!$product->existsInCart()) hidden @endif
               href="{{ route('cart.index') }}"
               class="btn btn-warning"
               title="Перейти в корзину">
                <i>{!! \App\Enum\Icon::ARROW_NARROW_RIGHT() !!}</i>
                <i>{!! \App\Enum\Icon::CART() !!}</i>
            </a>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function addToCart(e) {
            axios.put(e.dataset.action)
                .then(response => {
                    e.hidden = true;
                    document.getElementById('go-to-cart-btn').hidden = false;
                })
                .catch(error => {

                });
        }
    </script>
@endpush
