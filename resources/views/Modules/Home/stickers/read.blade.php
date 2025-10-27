@extends('layouts.app-home')
@section('content')
    @livewire('modules.home.stickers.read', ['slug' => $slug])
@endsection
