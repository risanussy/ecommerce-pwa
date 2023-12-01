@extends('admin')

@section('dashboard')
<div class="mt-5">
    <div class="row mb-3">
        <div class="col">
            <h3 class="mb-2">User Data</h3>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="table-responsive over">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">No HP</th>
                            <th scope="col">Email</th>
                            <th scope="col">Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usersDatas as $userData)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td>{{ $userData->name }}</td>
                            <td>{{ $userData->no_hp }}</td>
                            <td>{{ $userData->email }}</td>
                            <td>{{ $userData->alamat }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelector(".sell").classList.remove("active")
    document.querySelector(".product").classList.remove("active")
    document.querySelector(".users").classList.add("active")
    document.querySelector(".chat").classList.remove("active")
</script>
@endsection
