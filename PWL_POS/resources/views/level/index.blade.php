@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Level')
@section('content_header_title', 'CRUD')
@section('content_header_subtitle', 'Level')

@section('content')
    <div class="container">
        <div class="card">
            <div class="d-flex justify-content-between align-items-center p-3">
                <span>Manage Level</span>
                <a href="{{ route('level.create') }}" class="btn btn-primary">Add</a>
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
