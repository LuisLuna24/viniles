@extends('layouts.app')
@section('title', 'Editar sticker')
@section('content')
    @livewire('modules.sticker.edit', ['id' => $id])
@endsection
