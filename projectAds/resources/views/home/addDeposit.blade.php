@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-4">
           @include('home.partials.sidebar')                                                    
        </div> 
        <div class="col-8">   
            <form action="{{ route("home.addDeposit") }}" method="POST">
                @csrf
                <label for="deposit">Add deposit</label>
                     @error('deposit')
                    <p class="bg-warning">{{ $errors->first("deposit") }}</p>
                    @enderror
                <input type="text" placeholder="deposit" name="deposit" class="form-control"><br>
                <button type="submit" class="btn btn-info">Add deposit</button>
            </form>
        </div> 
    </div>
</div>
@endsection