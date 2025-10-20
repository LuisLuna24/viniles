@extends('layouts.app')
@section('title', 'Configurtaciónes')
@section('content')
    @livewire('modules.configuraciones.edit', ['id' => $id])
@endsection
