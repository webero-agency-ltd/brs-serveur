@extends('layouts.app')

@section('content')
<div id="application" data-base="{{ route( 'home' , [] , false ) }}" style="height:100%;">
    <app-admin :user="{{ Auth::user() }}"></app-admin>
</div>
@endsection
