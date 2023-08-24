@extends('shop')

@section('content')
  <div class="container pt-4 pb-5">
    <h4 class="mb-3">Keranjang.</h4>
    <hr>
    <div class="card">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div class="d-flex">
          <div class="d-flex justify-content-center align-items-center overflow-hidden me-2" style="width: 100px; height: 100%">
            <img src="https://i0.wp.com/www.astronauts.id/blog/wp-content/uploads/2023/01/Ini-Manfaat-Buah-Apel-Untuk-Kesehatan.jpg?fit=1280%2C854&ssl=1" class="card-img-top" width="110%">
          </div>
          <div>
            <h5>Apple quality</h5>
            <small>Rp. 100.000</small>
          </div>
        </div>
        <div>
          <button class="btn btn-outline-success me-1">Beli</button>
          <button class="btn btn-outline-danger"><i class="fa-solid fa-trash-can"></i></button>
        </div>
      </div>
    </div>
  </div>
@endsection