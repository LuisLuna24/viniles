@extends('layouts.app-home')
@section('content')
    @livewire('modules.home.productos.read',['slug' => $slug])
@endsection
