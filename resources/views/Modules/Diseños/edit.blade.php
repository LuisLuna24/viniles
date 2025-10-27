@extends('layouts.app')
@section('title', 'Editar diseño')
@section('content')
    @livewire('modules.disenos.edit', ['diseno_id' => $id])
@endsection
