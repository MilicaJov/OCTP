@extends('layouts.app')

@section('content')
<form>
    <div class="imgcontainer">
        <img src="{{ asset('images/avatar.png') }}" alt="Avatar" class="avatar"  width = "10">
    </div>

    <div class="container">
        <hr />
        <label for="name">
            <b>{{$user->first_name.' '.$user->last_name}}</b>
        </label> <br /> <hr>
        
        <label><b>My languages: </b></label> <br />
        <ul class="list-group">
            @foreach ($user->languages as $language)
                <li class="list-group-item">
                    {{ $language->name }}
                </li>
            @endforeach
        </ul>
    </div>
    <hr>

    <div class="container">
        <label> <b>Contributed to: </b></label> <br />

        <hr />

        <ul class="list-group">
            @foreach ($user->translations as $translation)
                <li class="list-group-item">
                    
                </li>
            @endforeach
        </ul>

        <a href="{{ url('user/'.$user->id.'/edit') }}" class = "dropbtn"><button type = "button">Edit My Profile</button></a>

        <a href="/document/create"><button type = "button"  class = "uplbtn">Upload new document</button></a>
    </div>

    <div class="container" style="background-color:#f1f1f1">

    </div>

  </form> 
@endsection