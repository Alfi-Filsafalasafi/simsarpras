@extends('layouts.app')

@section('title', 'Tambah Prasarana')
@section('page_title', 'Tambah Prasarana')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white fw-semibold">
            <i class="bi bi-plus-circle me-2"></i>Form Tambah Prasarana
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('prasarana.store') }}" enctype="multipart/form-data">
                @csrf
                @include('prasarana._form')
            </form>
        </div>
    </div>
@endsection