@extends('layouts.app')

@section('app')
<nav class="navbar navbar-expand-lg bg-light navbar-light border-bottom">
  <div class="container">
    <a class="navbar-brand" href="/">
      <img src="{{ asset('img/logo.png') }}" width="30px">
      <b class="text-success">Koperasi</b> Bayu Karya
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/">Beranda</a>
        </li>
        @auth
        <li class="nav-item">
          <a class="nav-link" href="/cart"><i class="fa-solid fa-cart-shopping me-2"></i>Keranjang</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/resi">Resi</a>
        </li>
        <li class="nav-item">
        </li>
        @endauth
      </ul>
      <div class="d-flex align-items-center">
        @auth
        <a class="nav-link" href="/profil">Profil</a>
        <div class="dropdown mx-3">
            <span type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-bell text-muted fs-5"></i>
            </span>
            <div class="dropdown-menu p-3">
              <ul class="list-group" id="notif-user" style="max-height:300px; min-width: 200px;overflow-y:scroll">
            </div>
            </ul>
        </div>
        <div class="me-3 text-right">
          <p class="p-0 m-0">{{ auth()->user()->name }} | user</p>
        </div>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="btn btn-outline-danger me-2">Logout</button>
        </form>
        @else
        <button class="btn btn-outline-success me-2" data-bs-toggle="modal" data-bs-target="#login">Login</button>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#register">Daftar</button>
        <a href="/admin" class="ms-2 btn btn-info">Login Sebagai Admin</a>
        @endauth
      </div>
    </div>
  </div>
</nav>
<div class="d-flex bg-success text-light pt-2 pb-2">
  <div class="container">
    <marquee behavior="scroll" direction="left" scrollamount="5">
    <span class="me-5">Selamat datang di Koperasi Bayu Karya! Temukan produk berkualitas dan harga terbaik untuk kebutuhan Anda. Selamat berbelanja! 🛍️</span>
    </marquee>
  </div>
</div>

@yield('content')
<!-- Modal -->
<div class="modal fade" id="register" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Register</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" class="form-control @error('role') is-invalid @enderror" id="role" name="role"
            value="user" required>
          <div class="mb-3">
            <label for="nik" class="form-label">NIK</label>
            <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" required>
            @error('nik')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
              value="{{ old('name') }}" required>
            @error('name')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
          <div class="mb-3">
            <label for="no_hp" class="form-label">No Handphone</label>
            <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp"
              value="{{ old('no_hp') }}" required>
            @error('no_hp')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
          <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat"
              value="{{ old('alamat') }}" required></textarea>
            @error('alamat')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
              value="{{ old('email') }}" required>
            @error('email')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
              name="password" required>
            @error('password')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
          <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
              required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Register</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Login Modal -->
<div class="modal fade" id="login" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Login</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="nik" class="form-label">NIK</label>
            <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik"
              value="{{ old('nik') }}" required autofocus>
            @error('email')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
              name="password" required>
            @error('password')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Login</button>
        </div>
      </form>
    </div>
  </div>
</div>
@auth
<button class="btn btn-success" style="position: fixed; right: 20px; bottom: 20px; font-size: 40px"
  data-bs-toggle="modal" data-bs-target="#chat">
  <i class="fa-solid fa-comments text-white"></i>
</button>
@endauth

<!-- Modal -->
<div class="modal fade" id="chat" tabindex="-1" aria-labelledby="chatLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="chatLabel">Chat.</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="w-100 chatbox p-2" style="height: 300px; overflow-y: scroll;">
        </div>
        <hr>
        <form id="chatForm">
          @csrf
          @auth
          <input type="hidden" value="{{ auth()->user()->id  }}" name="user_id" id="user_id">
          <input type="hidden" value="{{ auth()->user()->name  }}" name="uname" id="uname">
          @endauth
          <div class="mb-3">
            <input type="text" class="form-control" id="pesan" name="pesan" placeholder="Chat ...">
          </div>
          <button type="button" class="btn btn-primary" onclick="postChat()">Kirim</button>
        </form>
      </div>
    </div>
  </div>
</div>


@auth
<script>
function postChat() {
  const pesan = document.getElementById('pesan').value;
  const user_id = document.getElementById('user_id').value;
  const uname = document.getElementById('uname').value;

  axios.post('/api/chats', {
      pesan: pesan,
      user_id,
      admin: 0
    })
    .then(response => {
      console.log(response.data);
      document.querySelector("#pesan").value = ""
      // Handle success, e.g., refresh chat or display success message
    })
    .catch(error => {
      console.error(error);
      // Handle error, e.g., display error message
    });

  axios.post('/api/notif', {
      pesan: "Chat Dari : " + uname,
      user_id,
      admin: 0,
      status: 0,
    })
    .then(response => {
      console.log(response.data);
      // Handle success, e.g., refresh chat or display success message
    })
    .catch(error => {
      console.log(error);
      // Handle error, e.g., display error message
    });
}

let loop = (chats) => {
  let tags = []
  chats.map(item => {
    if (item.admin === 1) {
      tags.push(`
          <small class="text-info">Admin</small>
          <div class="card mb-2 bg-info">
            <div class="card-body">
              ${item.pesan}
            </div>
          </div>
        `)
    } else {
      tags.push(`
          <small>Anda</small>
          <div class="card mb-2">
            <div class="card-body">
             ${item.pesan}
            </div>
          </div>
        `)
    }
  })

  return tags.join(' ')
}

const notif = document.querySelector("#notif-user")
const DataNotif = (data) => {
  if(data.length > 0){
    let element = []
    data.reverse().map(e => {
      if(e.admin === 1){
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
  axios.get('/api/chats/{{ auth()->user()->id  }}')
    .then(response => {
      let data = response.data.data;
      let isAdmin = response.data.data.admin;

      document.querySelector('.chatbox').innerHTML = loop(data)
      // Handle success, e.g., refresh chat or display success message
    })
  
  axios.get('/api/notif/{{ auth()->user()->id  }}')
        .then(response => {
          notif.innerHTML = DataNotif(response.data.data);
        })
}, 3000);
</script>
@endauth
@endsection