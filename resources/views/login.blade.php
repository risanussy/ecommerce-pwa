@extends('layouts.app')

@section('app')
  <div class="d-flex justify-content-center align-items-center" style="height: 100vh; background-color: gainsboro;">
    <div class="w-25 p-4 py-5 shadow-lg rounded bg-light">
      <form method="POST" action="{{ route('login') }}">
        @csrf <!-- Tambahkan token CSRF -->
        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
          <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
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
