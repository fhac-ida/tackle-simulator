@extends('layouts.user_type.auth')

@section('content')
    <!-- Page where you either create or select a company profile -->
    <div class="p-6 py-4 bg-white vh-auto rounded-3">
        <h5>{{__('Please select or create a company profile:')}}</h5>
        <ul class="hidden_dot">

            <!-- Displays the list of existing company profiles
                 and links you to the settings page src/resources/views/company/settings.blade.php
            -->
            @if(isset($company_profiles))
                @foreach($company_profiles as $profil)
                    <li><a class="dropdown-item"
                        href="{{ url('/settings/' . $profil->profile_name) }}">{{$profil->profile_name}}</a>
                    </li>
                @endforeach
            @endif

            <!-- creates the input fields and adds the new company profile to the list -->
            <li><a href="#">
                    <form class="horizontal-div" action="/settings" method="post">{{ csrf_field() }}
                        <label class="horizontal-div width_75" for="name">{{__('Profile name')}}:</label>
                        <input id="name" class="form-control width_400" name="name" required="" type="text" value="{{ old('name') }}" placeholder="{{__('Profile name')}}">
                        <input class="btn btn-primary" type="submit" value="{{__('Add profile')}}">
                    </form>
                </a>
            </li>
        </ul>
    </div>

@endsection

