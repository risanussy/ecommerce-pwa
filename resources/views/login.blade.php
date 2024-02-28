@extends('layouts.app')

@section('app')
<div class="d-flex justify-content-center align-items-center" style="height: 100vh; background-color: gainsboro;">
  <div class="w-25 p-4 py-5 shadow-lg rounded bg-light">
    <form method="POST" action="{{ route('login') }}">
      @csrf
      <!-- Tambahkan token CSRF -->
      <div class="mb-3">
        <label for="nik" class="form-label">NIK</label>
        <input type="text" class="form-control" id="nik" name="nik">
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password">
      </div>
      <button type="submit" class="btn btn-primary">Login</button>
    </form>
  </div>
</div>
@endsection