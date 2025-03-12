@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'User')
@section('content_header_title', 'CRUD')
@section('content_header_subtitle', 'Users')

@section('content')
    <div class="container">
        <div class="card">
            <div class="d-flex justify-content-between align-items-center p-3">
                <span>Manage User</span>
                <a href="{{ route('users.create') }}" class="btn btn-primary">Add</a>
            </div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush
