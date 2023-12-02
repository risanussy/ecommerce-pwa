@extends('shop')

@section('content')
  <div class="container pt-4 pb-5">
    <h3 class="mb-3">Checkout</h3>
    <div class="row">
      <div class="col-md-4">
          <div class="d-flex justify-content-center align-items-center overflow-hidden me-2 shadow-lg" style="width: 80%; height: 200px">
            <img src="{{ asset('product/'.$product->foto) }}" class="card-img-top" width="110%">
          </div>
          <h1 class="mt-4">{{ $product->nama }}</h1>
          <p>{{ $product->deskripsi }}</p>
      </div>
      <div class="col">
        <form action="{{ route('cart.buy') }}" method="POST">
          @csrf
          <input type="hidden" value="{{ $product->id }}" name="product_id">
          @auth
          <input type="hidden" value="{{ auth()->user()->id  }}" name="user_id">
          @endauth
          <input type="hidden" value="{{ $product->tid }}" name="transaction_id">
          <input type="hidden" value="{{ $product->quantity }}" name="quantity">
          <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea class="form-control" name="alamat">{{ $userData }}</textarea>
          </div>
          <h4 class="mb-3">Pengiriman</h4>
          <div class="d-flex">
            <div class="mb-3 me-4 form-check d-flex align-items-center">
              <input type="radio" name="send" class="form-check-input me-2" id="a" value="9000">
              <div>
                <label class="form-check-label" for="a">Gojek</label><br>
                <small>Rp. 9.000</small>
              </div>
            </div>
            <div class="mb-3 me-4 form-check d-flex align-items-center">
              <input type="radio" name="send" class="form-check-input me-2" id="b" value="8000">
              <div>
                <label class="form-check-label" for="b">Grab</label><br>
                <small>Rp. 8.000</small>
              </div>
            </div>
            <div class="mb-3 me-4 form-check d-flex align-items-center">
              <input type="radio" name="send" class="form-check-input me-2" id="c" value="6000">
              <div>
                <label class="form-check-label" for="c">Maxim</label><br>
                <small>Rp. 6.000</small>
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="text" value="{{ $product->harga }}" class="form-control" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label">Pembayaran</label>
            <input type="text" value="Cash on delivery" class="form-control border-0 ps-0" readonly>
            <input type="hidden" value="" name="total" id="total-val" class="form-control border-0 ps-0" readonly>
            <small>siapkan uang cash untuk pembayaran nanti</small><br>
            <small><b>Total Belanja</b> : <span id="total"></span></small>
          </div>
          <button type="submit" class="btn btn-primary">Beli</button>
          <a href="/" class="btn btn-outline-danger">Batal</a>
        </form>
      </div>
    </div>
  </div>

  <script>
  // Function to update the total
  function updateTotal() {
    let deliveryCost = document.querySelector('input[name="send"]:checked').value;
    let productPrice = {{ $product->harga }};
    
    let quantity = {{ $product->quantity || 1 }};
    let totaly = 0
    if(quantity > 1) {
      totaly = (parseInt(deliveryCost) + parseInt(productPrice)) * quantity;
    }else {
      totaly = parseInt(deliveryCost) + parseInt(productPrice);  
    }
    console.log(totaly); 


    let formatter = new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR'
    });
    document.getElementById('total').innerHTML = formatter.format(totaly);
    document.getElementById('total-val').value = parseInt(totaly);
  }

  // Add event listeners to the delivery options
  let deliveryOptions = document.querySelectorAll('input[name="send"]');
  deliveryOptions.forEach(function(option) {
    option.addEventListener('change', updateTotal);
  });

  // Initial update on page load
  updateTotal();
</script>
@endsection