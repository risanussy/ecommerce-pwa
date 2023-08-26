@extends('shop')

@section('content')
  <div class="container pt-4 pb-5">
    <div class="info">

    </div>
      <div class="px-5 py-3 rounded-3 bg-success py-3 bg-opacity-10">
        <div class="d-flex align-items-center">
          <img src="{{ asset('img/plant-doodle.svg') }}" height="120px">
          <div>
            <h2>Terimakasih telah belanja Di GreenPlace</h2>
            <p>Jangan lupa siapkan uang cashmu karena pembayaran akan langsung dengan kurirnya</p>
          </div>
        </div>
      </div>
      <div class="mt-5">
        <h3 class="mb-3">Produk.</h3>
        <div class="d-flex gap-4 flex-wrap">
          @foreach ($products as $product)
          <div class="card" style="width: 300px;">
            <div class="d-flex justify-content-center align-items-center overflow-hidden" style="width: 100%; height: 200px">
              <img src="{{ asset('product/'.$product->foto) }}" class="card-img-top" width="110%">
            </div>
            <div class="card-body">
              <h5 class="card-title">{{ $product->nama }}</h5>
              <p class="card-text">Rp. {{ number_format($product->harga, 0, ',', '.') }}</p>
              <div>
                @auth
                <a href="{{ route('products.show', ['product' => $product->id]) }}" class="btn btn-primary">Beli</a>
                <form action="{{ route('cart.store') }}" method="POST" class="d-inline-block">
                  @csrf
                  <input type="hidden" value="{{ auth()->user()->id }}" name="user_id">
                  <input type="hidden" value="{{ $product->id }}" name="product_id">
                  <button type="submit" class="btn btn-outline-primary"><i class="fa-solid fa-cart-plus"></i></button>
                </form>
                @else
                <button onclick="login()" class="btn btn-primary">Beli</button>
                @endauth
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
  </div>
  <script>
    let login = () => {
      document.querySelector('.info').innerHTML = `
      <div class="alert alert-danger" role="alert">
        Login Terlebih dahulu
      </div>`
    }
  </script>
@endsection