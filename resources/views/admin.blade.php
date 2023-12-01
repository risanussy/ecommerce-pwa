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
        <li class="nav-item">
          <a class="nav-link users" href="/admin/list">Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link chat" href="/admin/chat">Chat</a>
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
@endsection