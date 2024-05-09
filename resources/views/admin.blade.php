@extends('layouts.app')

@section('app')
  <div class="container mt-3">
    <div class="row mb-3">
      <div class="col">
        <h3 class="text-success d-flex">
          Dashboard 
          @if(Auth::user()->role == 'manager')
          <span class="ms-2">Kepala Koperasi</span>
          @endif
          @if(Auth::user()->role == 'admin')
          <span class="ms-2">Admin</span>
          @endif
          <div class="dropdown ms-3">
            <span type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-bell text-muted fs-5"></i>
            </span>
            <div class="dropdown-menu p-3 ">
              <ul class="list-group" id="notif-admin" style="max-height:300px; min-width: 300px;overflow-y:scroll">
            </div>
            </ul>
          </div>
        </h3>
      </div>
    </div>
    <div class="row">
      <div class="col">
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link sell active" aria-current="page" href="/admin/sell">Penjualan</a>
        </li>
        @if(Auth::user()->role !== 'manager')
          <li class="nav-item">
            <a class="nav-link product" href="/admin/product">Produk</a>
          </li>
          <li class="nav-item">
            <a class="nav-link chat" href="/admin/chat">Chat</a>
          </li>
        @endif
        <li class="nav-item">
          <a class="nav-link users" href="/admin/list">Users</a>
        </li>
      </ul>
      </div>
    </div>
    <div>
      @yield('dashboard')
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-outline-danger me-2 mt-5">Logout</button>
      </form>
    </div>
    <br><br><br>
  </div>


  <script>
    const notif = document.querySelector("#notif-admin")
    const DataNotif = (data) => {
      if(data.length > 0){
        let element = []
        data.reverse().map(e => {
          if(e.admin === 0){
            element.push(`<li class="list-group-item">` + e.pesan + "</li>")
          }
        })

        if(element.length > 0){
          return element.join(" ")
        }else {
          return '<i class="text-center">Data Kosong</i>'
        }
      }else {
        return '<i class="text-center">Data Kosong</i>'
      }
    }

    setInterval(() => {
        axios.get('/api/notif')
          .then(response => {
            notif.innerHTML = DataNotif(response.data.data);
          })
        
    }, 3000);
  </script>
@endsection