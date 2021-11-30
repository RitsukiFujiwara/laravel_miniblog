@extends('layouts.app')
@section('content')

<h1>ブログ一覧</h1>
<ul>
    @foreach($blogs as $blog)
    {{-- <li>{{ $blog->title }}  {{ $blog->user()->first()->name }}</li> --}}
    <li>{{ $blog->title }}  {{ $blog->user->name }}</li>
    {{-- <li>{{ $blog->title }} {{ $blog->user ? $blog->user->name : '(退会者)'}}</li> --}}
    @endforeach
</ul>
    
@endsection