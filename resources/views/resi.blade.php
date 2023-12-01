@extends('shop')

@section('content')
  <div class="container pt-4 pb-5">
    <h4 class="mb-3">Transaksi.</h4>
    <hr>
    @if ($cartItems->isEmpty())
        <p>Transaksi Kosong.</p>
    @else
    @foreach ($cartItems->reverse() as $cartItem)
    <div class="card mb-3 crd-{{ $loop->index }}">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
          <div class="d-flex justify-content-center align-items-center overflow-hidden me-2" style="width: 100px; height: 60px">
            <img src="{{ asset('product/'.$cartItem->foto) }}" class="card-img-top" width="110%">
          </div>
          <div>
            <h5>{{ $cartItem->nama }}</h5>
            <h6>Nomer Resi : {{ strtotime($cartItem->created_at) }}{{ $cartItem->id }}</h6>
            <small>total : {{ $cartItem->quantity }}</small>
            <small> | </small>
            <small>Rp. {{ number_format($cartItem->total, 0, ',', '.') }}</small>
          </div>
        </div>
        <div>
          @if ($cartItem->process == 1)
              <span style="cursor: default !important;" class="btn btn-warning pea">Sedang Konfirmasi</span>
          @elseif ($cartItem->process == 0)
              <span style="cursor: default !important;" class="btn btn-danger pea">Dibatalkan</span>
          @elseif ($cartItem->process == 2)
              <span style="cursor: default !important;" class="btn btn-info pea">Sedang Dikirim</span>
          @elseif ($cartItem->process == 3)
              <span style="cursor: default !important;" class="btn btn-success pea">Selesai</span>
          @endif
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
@endsection