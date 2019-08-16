@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <h1 class="display-4">Search for the page that you would like to analyse</h1>
        <hr>
        <form action="/domains" method="post">
            <div class="form-group d-flex">
            <label for="analyserInput"></label>
            <input type="text" class="form-control" name="url" id="analyserInput" aria-describedby="analyser" placeholder="Enter url">
            <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
        @isset($errors)
            <span class="text-danger">{{$errors['url']}}</span>
        @endisset
    </div>
@endsection
