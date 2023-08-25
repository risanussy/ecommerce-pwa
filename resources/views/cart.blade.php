@extends('shop')

@section('content')
  <div class="container pt-4 pb-5">
    <h4 class="mb-3">Keranjang.</h4>
    <hr>
    @if ($cartItems->isEmpty())
        <p>Keranjang belanja kosong.</p>
    @else
    @foreach ($cartItems as $cartItem)
    <div class="card mb-3">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div class="d-flex">
          <div class="d-flex justify-content-center align-items-center overflow-hidden me-2" style="width: 100px; height: 60px">
            <img src="{{ asset('product/'.$cartItem->foto) }}" class="card-img-top" width="110%">
          </div>
          <div>
            <h5>{{ $cartItem->nama }}</h5>
            <small>{{ $cartItem->harga }}</small>
          </div>
        </div>
        <div>
          <a href="{{ route('products.show', ['product' => $cartItem->product_id]) }}" class="btn btn-outline-success me-1">Beli</a>
          <form action="{{ route('cart.destroy', $cartItem->id) }}" method="POST" style="display: inline-block;">
              @csrf
              @method('DELETE')
          <button class="btn btn-outline-danger"><i class="fa-solid fa-trash-can"></i></button>
          </form>
        </div>
      </div>
    </div>
    @endforeach
    @endif
  </div>
@endsection