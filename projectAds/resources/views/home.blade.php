@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-4">
           @include('home.partials.sidebar')                                                    
        </div> 
        <div class="col-8">
            <h2>All ads</h2>
            <ul class="list-group">
                @foreach ($all_ads as $ad)
                    <li class="list-group-items">
                        <a href="{{ route("home.singleAd", ["id"=>$ad->id]) }}">
                            {{ $ad->title }}
                        </a>
                    </li> 
                @endforeach
            </ul>
        </div> 
    </div>
</div>
@endsection
