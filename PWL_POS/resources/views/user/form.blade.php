{{-- resources/views/user/form.blade.php --}}
@extends('layout.app')

{{-- Customize layout sections --}}
@section('subtitle', 'User')
@section('content_header_title', 'User')
@section('content_header_subtitle', isset($user) ? 'Edit' : 'Create')

{{-- Content body: main page content --}}
@section('content')
    <div class="container">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ isset($user) ? 'Edit User' : 'Buat User Baru' }}</h3>
            </div>
            
            @if (isset($user))
                <form method="POST" action="{{ route('users.update', $user->user_id) }}">
                @method('PUT')
            @else
                <form method="POST" action="{{ route('users.store') }}">
            @endif
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="level_id">Level</label>
                        <select class="form-control" id="level_id" name="level_id" required>
                            <option value="">-- Pilih Level --</option>
                            @foreach($levels as $level)
                                <option value="{{ $level->level_id }}" {{ isset($user) && $user->level_id == $level->level_id ? 'selected' : '' }}>
                                    {{ $level->level_nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" 
                              value="{{ isset($user) ? $user->username : old('username') }}" 
                              maxlength="20" required>
                        <small class="form-text text-muted">Maksimal 20 karakter</small>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" name="nama" 
                              value="{{ isset($user) ? $user->nama : old('nama') }}" 
                              maxlength="100" required>
                        <small class="form-text text-muted">Maksimal 100 karakter</small>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" 
                               {{ isset($user) ? '' : 'required' }}>
                        @if(isset($user))
                            <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah password</small>
                        @endif
                    </div>
                    @if(isset($user))
                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                    @endif
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{ isset($user) ? 'Update' : 'Submit' }}</button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection