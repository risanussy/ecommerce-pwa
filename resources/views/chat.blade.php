@extends('admin')

@section('dashboard')
<div class="mt-5">
    <div class="row mb-3">
        <div class="col">
            <h3 class="mb-2">Chatting</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="table-responsive over">
              <table class="table align-middle">
              <thead>
                  <tr>
                    <th scope="col">Nama</th>
                    <th scope="col">Action</th>
                  </tr>
              </thead>
              <tbody>
                @php
                    $previousUserName = '';
                @endphp

                @foreach ($chats->reverse() as $chat)
                    @if ($chat->user_name !== $previousUserName)
                        <tr>
                            <td>{{ $chat->user_name }}</td>
                            <td>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#chatAd{{ $loop->index + 1 }}">Balas Chat</button>
                                
                                <div class="modal fade" id="chatAd{{ $loop->index + 1 }}" tabindex="-1" aria-labelledby="chatLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="chatLabel">Chat.</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="w-100 chatboxAdmin p-2" style="height: 300px; overflow-y: scroll;">
                                        </div>
                                        <hr>
                                        <form id="chatForm">
                                        @csrf
                                        @auth
                                        <input type="hidden" value="{{ $chat->uid }}" name="user_id" id="user_id">
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
                                    
                                    axios.post('/api/chats', { pesan: pesan, user_id, admin: 1})
                                    .then(response => {
                                    console.log(response.data);
                                        // Handle success, e.g., refresh chat or display success message
                                    })
                                    .catch(error => {
                                        console.error(error);
                                        // Handle error, e.g., display error message
                                    });
                                }

                                let loop = (chats) => {
                                    let tags = []
                                    chats.map(item => {
                                    if (item.admin === 1){
                                        tags.push(`
                                        <small class="text-info">Admin</small>
                                        <div class="card mb-2 bg-info">
                                            <div class="card-body">
                                            ${item.pesan}
                                            </div>
                                        </div>
                                        `)
                                    }else {
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

                                setInterval(() => {
                                    axios.get('/api/chats/{{ $chat->uid }}')
                                    .then(response => {
                                        let data = response.data.data ;
                                        let isAdmin = response.data.data.admin;

                                        document.querySelector('.chatboxAdmin').innerHTML = loop(data)
                                        // Handle success, e.g., refresh chat or display success message
                                    })    
                                }, 1000);
                                </script>
                                @endauth
                            </td>
                        </tr>
                    @endif
                    @php
                        $previousUserName = $chat->user_name;
                    @endphp
                @endforeach
              </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelector(".sell").classList.remove("active")
    document.querySelector(".chat").classList.add("active")
    document.querySelector(".product").classList.remove("active")
    document.querySelector(".users").classList.remove("active")
</script>
@endsection