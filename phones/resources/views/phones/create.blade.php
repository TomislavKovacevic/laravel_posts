@extends('layouts.master')

@extends('templates.navbar')

@section('title')
    New phone
@endsection

@section('main')
<h1 class="display-4">New phone</h1>
<div class="col-10 offset-1">
    <form action="/phones" method="POST">
    @csrf
    <input type="text" name="name" placeholder="name" id="name"
            class="{{ $errors->has("name") ? "red" : "" }}" value=" {{ old("name") }}" ><br>
    <input type="text" name="brand" placeholder="brand" id="brand"
            class="{{ $errors->has("brand") ? "red" : "" }}" value=" {{ old("brand") }}" ><br>
    <input type="number" name="price" placeholder="price" id="price"
            class="{{ $errors->has("price") ? "red" : "" }}" value=" {{ old("price") }}" ><br>
    <button type="submit" class="btn btn-primary form-control">Save</button>
    </form>
    @if ($errors->any())
    <p class="red-text">There was an error, try again later</p>    
    @endif
</div>
    
@endsection