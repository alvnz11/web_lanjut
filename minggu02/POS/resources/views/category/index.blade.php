@extends('category.layout')

@section('content')
<div class="profile-button-container">
    <a href="{{ url('/user/1/name/John') }}" class="btn-back">Profile</a>
</div>
    <div class="category-container">
        <h2>Daftar Kategori</h2>
        <ul class="category-list">
            <li><a href="{{ url('category/food-beverage') }}">Food & Beverage</a></li>
            <li><a href="{{ url('category/beauty-health') }}">Beauty & Health</a></li>
            <li><a href="{{ url('category/home-care') }}">Home Care</a></li>
            <li><a href="{{ url('category/baby-kid') }}">Baby & Kid</a></li>
        </ul>

        <div class="back-button-container">
            <a href="{{ url('/') }}" class="btn-back">Kembali ke Halaman Awal</a>
        </div>
    </div>
@endsection
