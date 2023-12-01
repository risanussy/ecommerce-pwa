@extends('shop')

@section('content')
  <div class="container pt-4 pb-5">
    <h4 class="mb-3">Keranjang.</h4>
    <button class="btn btn-outline-success me-1" onclick="buyAll()">Beli Semua</button>
    <button class="btn btn-outline-danger" onclick="deleteAll()"><i class="fa-solid fa-trash-can"></i> Hapus Semua</button>

    <hr>
    @if ($cartItems->isEmpty())
        <p>Keranjang belanja kosong.</p>
    @else
    @foreach ($cartItems as $cartItem)
    <div class="card mb-3 crd-{{ $loop->index }}">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
          <input type="checkbox" class="me-3">
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
      let selectedItems = [];

      checkboxes.forEach((checkbox, index) => {
        if (checkbox.checked) {
          selectedItems.push(index);
        }
      });

      // Kirim AJAX request ke backend untuk memproses pembelian semua item yang dicentang
      axios.post('/api/buy-all/{{ auth()->user()->id  }}', { selectedItems })
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
  </script>
  @endauth
@endsection