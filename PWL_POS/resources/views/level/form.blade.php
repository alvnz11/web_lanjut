{{-- resources/views/level/form.blade.php --}}
@extends('layout.app')

{{-- Customize layout sections --}}
@section('subtitle', 'Level')
@section('content_header_title', 'Level')
@section('content_header_subtitle', isset($level) ? 'Edit' : 'Create')

{{-- Content body: main page content --}}
@section('content')
    <div class="container">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ isset($level) ? 'Edit Level' : 'Buat Level Baru' }}</h3>
            </div>
            
            @if (isset($level))
                <form method="POST" action="{{ route('level.update', $level->level_id) }}">
                @method('PUT')
            @else
                <form method="POST" action="{{ route('level.store') }}">
            @endif
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="kodeLevel">Kode Level</label>
                        <input type="text" class="form-control" id="kodeLevel" name="kodeLevel" 
                               value="{{ isset($level) ? $level->level_kode : old('kodeLevel') }}">
                    </div>
                    <div class="form-group">
                        <label for="namaLevel">Nama Level</label>
                        <input type="text" class="form-control" id="namaLevel" name="namaLevel" 
                               value="{{ isset($level) ? $level->level_nama : old('namaLevel') }}">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{ isset($level) ? 'Update' : 'Submit' }}</button>
                    <a href="{{ route('level.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection