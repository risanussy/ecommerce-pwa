@extends('shop')

@section('content')
  <div class="container pt-4 pb-5">
    <h4 class="mb-3">Keranjang.</h4>
    <button class="btn btn-outline-success me-1" data-bs-toggle="modal" data-bs-target="#expe">Beli Semua</button>
    <button class="btn btn-outline-danger" onclick="deleteAll()"><i class="fa-solid fa-trash-can"></i> Hapus Semua</button>

    <hr>
    @if ($cartItems->isEmpty())
        <p>Keranjang belanja kosong.</p>
    @else
    @foreach ($cartItems as $cartItem)
    <div class="card mb-3 crd-{{ $loop->index }}">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
          <input type="checkbox" value="{{$cartItem->harga}}" class="me-3">
          <div class="d-flex justify-content-center align-items-center overflow-hidden me-2" style="width: 100px; height: 60px">
            <img src="{{ asset('product/'.$cartItem->foto) }}" class="card-img-top" width="110%">
          </div>
          <div>
            <h5>{{ $cartItem->nama }}</h5>
            <h6>total : {{ $cartItem->quantity }}</h6>
            <small>Rp. {{ number_format($cartItem->harga, 0, ',', '.') }}</small>
          </div>
        </div>
        <div>
          <a href="{{ route('cart.show', ['id' => $cartItem->id]) }}" class="btn btn-outline-success me-1">Beli</a>
          <form action="{{ route('cart.destroy', ['id' => $cartItem->id]) }}" method="POST" style="display: inline-block;">
          <button class="btn btn-outline-danger" value="Delete"><i class="fa-solid fa-trash-can"></i></button>
          @method('delete')
          @csrf
          </form>
          <!-- <button class="btn btn-outline-danger" onclick="del({{ $loop->index }})"><i class="fa-solid fa-trash-can"></i></button> -->
        </div>
      </div>
    </div>
    @endforeach
    @endif
  </div>
  
  <div class="modal fade" id="expe" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="addProductModalLabel">Tambah Produk Baru</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <form method="POST">
                      <div class="mb-3">
                          <label for="exp" class="form-label">Nama Produk</label>
                          <select class="form-select" id="exp" name="total" required>
                            <option value="">Pilih Expedisi</option>
                            <option value="9000">Instant</option>
                            <option value="8000">Same Day</option>
                            <option value="6000">Reguler</option>
                          </select>
                      </div>
                      <div id="snap-container"></div>
                      <button class="btn btn-success" type="button" id="cpay">Bayar</button>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
  <script>
    let del = (e) => {
      console.log(document.querySelector('.crd-' + e))
      document.querySelector('.crd-' + e).style.display = 'none';
    }
  </script>

  @auth
  <script>
    let buyAll = () => {
      let checkboxes = document.querySelectorAll('input[type="checkbox"]');
      let exp = document.querySelector('#exp').value;
      let selectedItems = [];

      checkboxes.forEach((checkbox, index) => {
        if (checkbox.checked) {
          selectedItems.push(index);
        }
      });

      // Kirim AJAX request ke backend untuk memproses pembelian semua item yang dicentang
      axios.post('/api/buy-all/{{ auth()->user()->id  }}', { selectedItems, total: exp })
        .then(response => {
          console.log(response.data);
          window.location.reload();
        })
        .catch(error => {
          console.error(error);
          // Handle error, e.g., display error message
        });
    };

    let deleteAll = () => {
      let checkboxes = document.querySelectorAll('input[type="checkbox"]');
      let selectedItems = [];

      checkboxes.forEach((checkbox, index) => {
        if (checkbox.checked) {
          selectedItems.push(index);
        }
      });

      // Kirim AJAX request ke backend untuk menghapus semua item yang dicentang
      axios.post('/api/delete-all/{{ auth()->user()->id  }}', { selectedItems })
        .then(response => {
          console.log(response.data);
          window.location.reload();
        })
        .catch(error => {
          console.error(error);
          // Handle error, e.g., display error message
        });
    };

    document.querySelector("#cpay").onclick = () => {  
      let checkboxes = document.querySelectorAll('input[type="checkbox"]');
      let exp = document.querySelector('#exp').value;
      let selectedItems = [];
      let totalPay = [];

      checkboxes.forEach((checkbox, index) => {
        if (checkbox.checked) {
          selectedItems.push(index);
          totalPay.push(checkbox.value);
        }
      });


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



      count = 0

      totalPay.map(item => {
        count += item
      })


      axios.post('/api/midtrans', {
        first_name: "kasir", last_name:"pc", wa: "0895811322300", email: "test@test.com", total: parseInt(count)
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

              buyAll()
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
  @endauth
@endsection