@extends('layouts.app')

@section('content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Name</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{$name}}</td>
            </tr>
        </tbody>
    </table>
@endsection