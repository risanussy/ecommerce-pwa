@extends('layouts.app')

@section('app')
  <div class="container mt-3">
    <div class="row mb-3">
      <div class="col">
        <h3 class="text-success">Dashboard Admin</h3>
      </div>
    </div>
    <div class="row">
      <div class="col">
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link sell active" aria-current="page" href="/admin/sell">Penjualan</a>
        </li>
        <li class="nav-item">
          <a class="nav-link product" href="/admin/product">Produk</a>
        </li>
      </ul>
      </div>
    </div>
    <div>
    @yield('dashboard')
    </div>
  </div>
@endsection