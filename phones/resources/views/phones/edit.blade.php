
@extends('layouts.master')

@extends('templates.navbar')

@section('title')
    Edit phones
@endsection

@section('main')

<h1>Edit phone</h1>
<div class="col-10 offset-1">
    <form action="/phones/{{$phone->id}}" method="POST">
    @csrf
    @method("put")
    <input type="text" name="name" value="{{$phone->name}}" class="form-control"><br>
    <input type="text" name="brand" value="{{$phone->brand}}" class="form-control"><br>
    <input type="number" name="price" value="{{$phone->price}}" class="form-control"><br>
    <button type="submit" class="btn btn-warning form-control">Save</button>
    </form>
</div>
    
@endsection