@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        @empty($user)
        <div class="alert alert-danger alert-dismissible">
            <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
            Data yang Anda cari tidak ditemukan.
        </div>
        @else
        <div class="row">
            <div class="col-md-3 text-center">
                <div class="profile-image-container mb-3">
                    @if($user->path_foto)
                        <img id="preview-image" src="{{ asset('storage/'.$user->path_foto) }}" alt="Foto Profil" class="img-thumbnail rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <img id="preview-image" src="{{ asset('images/default-avatar.png') }}" alt="Foto Profil" class="img-thumbnail rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                    @endif
                </div>
            </div>
            <div class="col-md-9">
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th width="200">ID</th>
                        <td>{{ $user->user_id }}</td>
                    </tr>
                    <tr>
                        <th>Level</th>
                        <td>{{ $user->level->level_nama }}</td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td>{{ $user->username }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $user->nama }}</td>
                    </tr>
                    <tr>
                        <th>Password</th>
                        <td>********</td>
                    </tr>
                </table>
            </div>
        </div>
        @endempty
        <a href="{{ url('user') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
    </div>
</div>
@endsection

@push('css')
@endpush 

@push('js') 
@endpush