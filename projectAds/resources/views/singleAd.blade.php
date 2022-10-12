@extends('layouts.master')
@section('main')

    <div class="row">
        @if (isset($single_ad->image1))
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <img src="/ad_images/{{ $single_ad->image1 }}" class="img-fluid">
                    </div>
                </div>
            </div> 
        @endif
        @if (isset($single_ad->image2))
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <img src="/ad_images/{{ $single_ad->image2 }}" class="img-fluid">
                </div>
            </div>
        </div>
        @endif
        @if (isset($single_ad->image3))
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <img src="/ad_images/{{ $single_ad->image3 }}" class="img-fluid">
                </div>
            </div>
        </div>
        @endif 
        <div class="col-12">
            <h1 class="display-4">{{ $single_ad->title }} <span class="btn btn-succes">
                    {{ $single_ad->category->name }} </h1>
            <p>{{ $single_ad->body }}</p>
            <button class="btn btn-warning">{{ $single_ad->user->name }}</button>
            <button class="btn btn-danger">{{ $single_ad->price }}</button>
        </div> 
    </div>

    @if (auth()->check() && auth()->user()->id !== $single_ad->user_id) 
    <div class="row mt-3">
        <div class="col-6">
            <form action="{{ route("sendMessage", ["id"=>$single_ad->id]) }}" method="POST">
                @csrf
                <textarea name="msg" class="form-control" 
                placeholder="send message to {{ $single_ad->user->name }}" cols="30" rows="10"></textarea><br>
                <button type="submit" class="btn btn-primary form control">Send</button>
            </form>
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get("message") }}    
                </div>        
            @endif
           
        </div>
    </div>
    @endif    
   
@endsection