@extends('layouts.user_type.auth')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/map.css') }}">

    <script src="{!! mix('js/app.js') !!}"></script>

    <details> <!-- Collapisble section. Map creation options expand, when "Add from Template" is clicked. -->
        <summary class="btn btn-primary">
            {{__('Add from Template')}}
        </summary>
        <p>
            <form action="{{ route('maps.add.post') }}" method="POST" class='answerform' name='template_select'>
                @csrf
                <h5>{{__('Select Template:')}}</h5>
                <div class="horizontal-div">
                    <label class="subline">  <!-- These labels are just here, so the image is displayed instead of the radio button. They don't "label" anything. -->
                        <input checked class="hidden_radio" type="radio" name='template' id="emptyTemplate" data-template-id='empty-template' value='emptyTemplate'>
                        <img src="{{ asset('assets/img/map-thumbnails/empty_thumbnail.png') }}" alt="..." style="width: 150px; height: 150px;">
                        <label for='emptyTemplate'>{{__('Empty')}}</label>
                    </label>
                    <label class="subline">
                        <input class="hidden_radio" type="radio" name='template' id="homeNetworkTemplate" data-template-id='home-network-template' value='homeNetworkTemplate'>
                        <img src="{{ asset('assets/img/map-thumbnails/home_network_thumbnail.png') }}" alt="..." style="width: 150px; height: 150px;">
                        <label for='homeNetworkTemplate'>{{__('Home Network')}}</label>
                    </label>
                    <label class="subline">
                        <input class="hidden_radio" type="radio" name='template' id="officeNetworkTemplate" data-template-id='office-network-template' value='officeNetworkTemplate'>
                        <img src="{{ asset('assets/img/map-thumbnails/office_network_thumbnail.png') }}" alt="..." style="width: 150px; height: 150px;">
                        <label for='officeNetworkTemplate'>{{__('Office Network')}}</label>
                    </label>
                    <label class="subline">
                        <input class="hidden_radio" type="radio" name='template' id="companyNetworkTemplate" data-template-id='company-network-template' value='companyNetworkTemplate'>
                        <img src="{{ asset('assets/img/map-thumbnails/company_network_thumbnail.png') }}" alt="..." style="width: 150px; height: 150px;">
                        <label for='companyNetworkTemplate'>{{__('Company Network')}}</label>
                    </label>
                    <label class="subline">
                        <input class="hidden_radio" type="radio" name='template' id="howest" data-template-id='howest' value='howestNetworkTemplate'>
                        <img src="{{ asset('assets/img/map-thumbnails/howest_network_thumbnail.png') }}" alt="..." style="width: 150px; height: 150px;">
                        <label for='companyNetworkTemplate'>{{__('Howest Demonstrator')}}</label>
                    </label>
                </div>
                <div class="horizontal-div">
                        <label for="map_name_input">{{__('Name:')}}</label><input type="text" class="form-control width_300" name="map_name" id="map_name_input" value="" placeholder="{{__('Enter map name here')}}" maxlength="32">
                    <input class="btn btn-primary" id="confirm_add_button" type="submit" value="{{__('Create')}}">
                </div>
            </form>
        </p>
    </details>

    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">{{__('#')}}</th>
            <th scope="col">{{__('Name')}}</th>
            <th scope="col">{{__('Last changed')}}</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>

            @foreach($maps as $mapListElement)
            <tr>
                <th scope="row">{{ $mapListElement->id }}</th>
                <td>{{ $mapListElement->name }}</td>
                <td>{{ $mapListElement->updated_at }}</td>
                <td><a href="{{ route('maps.edit',$mapListElement->id)}}" class="btn btn-primary">{{__('Edit')}}</a></td>
                <td>
                    <form action="{{ route('maps.destroy', $mapListElement->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">{{__('Delete')}}</button>
                    </form>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>

    <div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body" id="mediumBody">
                    <div>
                        <!-- the result to be displayed apply here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
