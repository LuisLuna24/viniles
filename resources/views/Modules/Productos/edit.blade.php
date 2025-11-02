@extends('layouts.app')
@section('title', 'Editar Producto')
@section('content')
    @livewire('modules.productos.edit',['id' => $id])
@endsection
