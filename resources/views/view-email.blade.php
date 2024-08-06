{{-- get all users --}}
@foreach($emails as $user)
    {{ $user->email }}<br>
@endforeach