@extends('layouts.app')

@section('content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Status Code</th>
                <th scope="col">Content Length</th>
                <th scope="col">Heading</th>
                <th scope="col">Keywords</th>
                <th scope="col">Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($domains as $domain)
                <tr>
                    <td>
                        <a href="{{$domain->name}}">{{$domain->name}}</a>
                    </td>
                    <td>
                        {{$domain->status_code}}
                    </td>
                    <td>
                        {{$domain->content_length}}
                    </td>
                    <td>
                        {{$domain->heading}}
                    </td>
                    <td>
                        {{$domain->keywords}}
                    </td>
                    <td>
                        {{$domain->description}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if (count($domains) > 1)
        <div class="d-flex justify-content-center">
            {{$domains->links()}}
        </div>
    @endif
@endsection