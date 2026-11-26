@extends('layouts.app')

@section('title', 'Ubah Prasarana')
@section('page_title', 'Ubah Prasarana')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white fw-semibold">
            <i class="bi bi-pencil-square me-2"></i>Form Ubah Prasarana
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('prasarana.update', $prasarana) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('prasarana._form')
            </form>
        </div>
    </div>
@endsection