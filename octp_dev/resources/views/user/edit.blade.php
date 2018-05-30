@extends('layouts.app')

@section('content')
<form method="post" action="{{ url('user/'.$user->id) }}">
        @method('PUT');
        @csrf
        <div class="imgcontainer">
            <img src="{{ asset('images/avatar.png') }}" alt="Avatar" class="avatar"  width = "10">
        </div>

        <div class="container">
            <label> <b>To make changes you must click the "Save changes" button. </b></label> <br />
            <hr />
            <label for="firstName"><b>First name</b></label>
            <input type="text" value="{{ $user->first_name }}" name="firstName" required>
            <label for="lastName"><b>Last name</b></label>
            <input type="text" value="{{ $user->last_name }}" name="lastName" required>

            <label for="vehicle"><b>Languages: </b></label> <br />
            @foreach ($languages as $language)
                <input type="checkbox" name="language[]" value="{{ $language->name }}" @if(in_array($language->name, $userLanguages)) checked @endif > 
                    {{ $language->name }} <br/>
            @endforeach

            <button type="submit">Save changes</button>

        </div>
</form>
<form>
        <div class="container">
            <label> <b>Here you can change your passowrd </b></label> <br />
            <hr />
            <label for="pass"><b>*Old password</b></label>
            <input type="password" placeholder="Password" name="pass" required>

            <label for="newpass"><b>*New password</b></label>
            <input type="password" placeholder="New Password" name="newpass" required>

            <label for="rnewpass"><b>*Retype new password</b></label>
            <input type="password" placeholder="Retype new password" name="rnewpass" required>

            <button type="submit">Save changes</button>

        </div>
</form>
<form>
        <div class="container">
            <label> <b>Here you can change your email </b></label> <br />
            <hr />
            <label for="email"><b>*New Email</b></label>
            <input type="email" placeholder="Email" name="email" required>

            <button type="submit">Save changes</button>

        </div>
</form>
<form>
        <div class="container">
            <label> <b>Here you can delete your account </b></label> <br />
            <hr />

            <button type="button" id="deleteButton" class="btn btn-danger">Delete Your Account</button>
            <input type="hidden" id="deleteLink" value="{{ route('user.destroy', $user->id) }}" />
        </div>
</form>
@endsection