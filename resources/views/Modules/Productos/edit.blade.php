@extends('layouts.app')
@section('title', 'Editar productos')
@section('content')
    @livewire('modules.productos.update', ['id' => $id])
@endsection
