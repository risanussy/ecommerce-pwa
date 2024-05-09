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
        <form id="methodpay" action="{{ route('cart.buy') }}" method="POST">
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
                <label class="form-check-label" for="a">Instan</label><br>
                <small>Rp. 9.000</small>
              </div>
            </div>
            <div class="mb-3 me-4 form-check d-flex align-items-center">
              <input type="radio" name="send" class="form-check-input me-2" id="b" value="8000">
              <div>
                <label class="form-check-label" for="b">Same Day</label><br>
                <small>Rp. 8.000</small>
              </div>
            </div>
            <div class="mb-3 me-4 form-check d-flex align-items-center">
              <input type="radio" name="send" class="form-check-input me-2" id="c" value="6000">
              <div>
                <label class="form-check-label" for="c">Reguler</label><br>
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
            <input type="hidden" value="Cash on delivery" class="form-control border-0 ps-0" readonly>
            <input type="hidden" value="" name="pay_method" class="form-control border-0 ps-0" id="method" readonly>
            <input type="hidden" value="" name="expedisi" class="form-control border-0 ps-0" id="sendm" readonly>
            <input type="hidden" value="" name="total" id="total-val" class="form-control border-0 ps-0" readonly>
            <div id="snap-container" class="shadow-lg"></div>
            <br>
            <small><b>Total Belanja</b> : <span id="total"></span></small>
          </div>
          <button type="button" id="pay" class="btn btn-primary">Beli</button>
          <a href="/" class="btn btn-outline-danger">Batal</a>
        </form>
      </div>
    </div>
  </div>
  <div id="snap-container"></div>
  <script>
  // Function to update the total
  function updateTotal() {
    let totaly = 0
    let deliveryCost = document.querySelector('input[name="send"]:checked').value;
    document.querySelector('#sendm').value = (deliveryCost == '9000')? 'Instant' : (deliveryCost == '8000')? 'Same day' : 'Reguler';
    let productPrice = {{ $product->harga }};
    
    let quantity = {{ $product->quantity || 1 }};
    if(quantity > 1) {
      totaly = (parseInt(deliveryCost) + parseInt(productPrice)) * quantity;
    }else {
      totaly = parseInt(deliveryCost) + parseInt(productPrice);  
    }

    let formatter = new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR'
    });
    document.getElementById('total').innerHTML = formatter.format(totaly);
    document.getElementById('total-val').value = parseInt(totaly);

    return totaly
  }

  // Add event listeners to the delivery options
  let deliveryOptions = document.querySelectorAll('input[name="send"]');
  deliveryOptions.forEach(function(option) {
    option.addEventListener('change', updateTotal);
  });
  
  // Initial update on page load
  updateTotal();
  </script>
  <script>
    document.querySelector("#pay").onclick = () => {      
      if(document.getElementById('total').innerText.length === 0){
        Swal.fire({
          title: "Error!",
          text: "Pilih pengiriman terlebih dahulu!",
          icon: "error"
        });
      }

      
      axios.post('/api/notif', {
                pesan: "Pesanan Baru",
                user_id: "{{ auth()->user()->id }}",
                admin: 0,
                status: 0,
                })
                .then(response => {
                console.log(response.data);
                // Handle success, e.g., refresh chat or display success message
                  })

      axios.post('/api/midtrans', {
        first_name: "kasir", last_name:"pc", wa: "0895811322300", email: "test@test.com", total: updateTotal()
      })
        .then(res => {
          window.snap.embed(res.data.token, {
            embedId: 'snap-container',
            onSuccess: function(result){                  
              Swal.fire({
                title: "Sukses!",
                text: "Terimakasih telah berbelanja!",
                icon: "success"
              })

              document.querySelector("#method").value = result.payment_type;
              document.querySelector("#methodpay").submit()
            },
            onPending: function(){
              Swal.fire({
                title: "Pending!",
                text: "Selesaikan dulu pembayaran!",
                icon: "warning"
              });
            },
            onError: function(){
              Swal.fire({
                title: "Error!",
                text: "Terjadi kesalahan dalam pembayaran!",
                icon: "error"
              });
            },
            onClose: function(){
              Swal.fire({
                title: "Keluar!",
                text: "Anda keluar tanpa menyelesaikan pembayaran!",
                icon: "error"
              });
            }
          });
        })
    }
    

    
  </script>
@endsection