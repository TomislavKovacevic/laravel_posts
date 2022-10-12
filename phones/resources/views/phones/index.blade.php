@extends('layouts.master')

@extends('templates.navbar')

@section('title')
    All phones
@endsection

@section('main')
    <h1 class="display-4 m-3"> All phones</h1>

    <table>
        <thead>
          <tr>
              <th>Name</th>
              <th>Brand</th>
              <th>Price</th>
              <th>Delete</th>
              <th>Update</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            @foreach ($all_phones as $phone)

            <td>{{ $phone->name }}</td>
            <td>{{ $phone->brand }}</td>
            <td>{{ $phone->price }}</td>
            <td>
              <form action="/phones/{{ $phone->id }}" method="POST">
                @csrf
                @method("delete")
              <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
            </td>
            <td>
              <a href="/phones/{{$phone->id}}/edit" class="btn btn-warning btn-sm">Update</a>
            </td>
          </tr>
          @endforeach
         
        </tbody>
      </table>

@endsection





