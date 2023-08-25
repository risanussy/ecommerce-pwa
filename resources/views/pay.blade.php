@extends('shop')

@section('content')
  <div class="container pt-4 pb-5">
    <h3 class="mb-3">Checkout</h3>
    <div class="row">
      <div class="col-md-4">
          <div class="d-flex justify-content-center align-items-center overflow-hidden me-2" style="width: 100%; height: 200px">
            <img src="https://i0.wp.com/www.astronauts.id/blog/wp-content/uploads/2023/01/Ini-Manfaat-Buah-Apel-Untuk-Kesehatan.jpg?fit=1280%2C854&ssl=1" class="card-img-top" width="110%">
          </div>
          <h1 class="mt-4">Apel uenak</h1>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore, ex?</p>
      </div>
      <div class="col">
        <form>
          <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea class="form-control"></textarea>
          </div>
          <h4 class="mb-3">Pengiriman</h4>
          <div class="d-flex">
            <div class="mb-3 me-4 form-check d-flex align-items-center">
              <input type="radio" name="send" class="form-check-input me-2" id="a">
              <div>
                <label class="form-check-label" for="a">Gojek</label><br>
                <small>Rp. 9.000</small>
              </div>
            </div>
            <div class="mb-3 me-4 form-check d-flex align-items-center">
              <input type="radio" name="send" class="form-check-input me-2" id="b">
              <div>
                <label class="form-check-label" for="b">Grab</label><br>
                <small>Rp. 8.000</small>
              </div>
            </div>
            <div class="mb-3 me-4 form-check d-flex align-items-center">
              <input type="radio" name="send" class="form-check-input me-2" id="c">
              <div>
                <label class="form-check-label" for="c">Maxim</label><br>
                <small>Rp. 6.000</small>
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="text" class="form-control" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label">Pembayaran</label>
            <input type="text" value="Cash on delivery" class="form-control border-0 ps-0" readonly>
            <small>siapkan uang cash untuk pembayaran nanti</small><br>
            <small><b>Total Belanja</b> : Rp. 200.000</small>
          </div>
          <button type="submit" class="btn btn-primary">Beli</button>
          <button type="submit" class="btn btn-outline-danger">Batal</button>
        </form>
      </div>
    </div>
  </div>
@endsection