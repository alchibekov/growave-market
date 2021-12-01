@extends('layouts.master')

@section('content')
    <div class="card mt-3">
        <div class="card-header bg-info">
            <nav class="navbar justify-content-between">
                <h5 class="navbar-brand">Корзина</h5>
                <a class="btn btn-sm btn-warning my-2 my-sm-0" href="{{ url()->previous() }}"
                   type="button">
                    {!! \App\Enum\Icon::ARROW_NARROW_LEFT() !!}
                </a>
            </nav>
        </div>
        <div class="card-body">
            <table class="table table-sm table-striped">
                <thead>
                <tr>
                    <th scope="col" class="col-md-1">#</th>
                    <th scope="col" class="col-md-6">Название</th>
                    <th scope="col" class="col-md-2 text-center">Количество</th>
                    <th scope="col" class="col-md-1 text-center">Цена</th>
                    <th scope="col" class="col-md-1 text-center">Итого</th>
                    <th scope="col" class="col-md-1 text-center">Валюта</th>
                    <th scope="col" class="col-md-0">Удалить</th>
                </tr>
                </thead>
                <tbody>
                @forelse($products as $product)
                    <tr id="product-{{ $product->id }}">
                        <th scope="row" class="col-md-1">{{ $product->id }}</th>
                        <th class="col-md-6">
                            <a href="{{ route('products.show', ['product' => $product]) }}">
                                {{ $product->name }}
                            </a>
                        </th>
                        <th scope="col" class="col-md-2 text-center">
                            <button class="btn btn-link text-success p-0"
                                    data-id="{{ $product->id }}"
                                    data-url="{{ route('products.add-to-cart', $product->id) }}"
                                    onclick="increaseProductInCart(this)"
                                    title="Увеличить количество">
                                {!! \App\Enum\Icon::SQUARE_PLUS() !!}
                            </button>
                            <span id="count-{{ $product->id }}">{{ $product->count }}</span>
                            <button class="btn btn-link text-danger p-0"
                                    data-id="{{ $product->id }}"
                                    data-url="{{ route('products.decrease-product-in-cart', $product->id) }}"
                                    title="Уменьшить количество"
                                    onclick="decreaseProductInCart(this)">
                                {!! \App\Enum\Icon::SQUARE_MINUS() !!}
                            </button>
                        </th>
                        <th class="col-md-1 text-center" id="price-{{$product->id}}">{{ $product->price }}</th>
                        <th class="col-md-1 text-center" id="amount-{{$product->id}}">{{ $product->price * $product->count }}</th>
                        <th class="col-md-1 text-center">{!! $product->presentCurrency() !!}</th>
                        <th scope="col" class="col-md-0 text-center">
                            <button class="btn btn-link text-danger p-0"
                                    data-id="{{ $product->id }}"
                                    data-url="{{ route('products.remove-from-cart', $product->id) }}"
                                    onclick="removeFromCart(this)" title="Удалить из корзины">
                                {!! \App\Enum\Icon::TRASH() !!}
                            </button>
                        </th>
                    </tr>
                @empty
                    <tr class="no-data text-center">
                        <td colspan="12">{{ $cartIsEmpty }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function recalculateAmount(id, response) {
            document.getElementById(`count-${id}`).innerHTML = response.data.count;

            let amount = document.getElementById(`amount-${id}`);
            let price = parseInt(document.getElementById(`price-${id}`).innerHTML);
            amount.innerHTML = `${price * response.data.count}`;
        }

        function increaseProductInCart(e) {
            axios.put(e.dataset.url)
                .then(response => {
                    recalculateAmount(e.dataset.id, response)
                })
        }

        function decreaseProductInCart(e) {
            axios.put(e.dataset.url)
                .then(response => {
                    recalculateAmount(e.dataset.id, response)

                    if (response.data.count === 0) {
                        document.getElementById(`product-${e.dataset.id}`).remove();
                    }
                })
        }

        function removeFromCart(e) {
            axios.delete(e.dataset.url)
                .then(response => {
                    document.getElementById(`product-${e.dataset.id}`).remove();
                })
        }
    </script>
@endpush
