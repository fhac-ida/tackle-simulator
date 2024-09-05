<?php
if (!isset($scenarios)) {
    exit ("Scnearios.blade: scenarios is undefined. Please reload this page or contact the webmaster if this problem still remains.");
}
?>

@extends('layouts.user_type.auth')
@section('content')
    <div class="container my-4">
        <details> <!-- Collapsible section -->
            <summary class="btn btn-primary">
                {{__('Add scenario')}}
            </summary>
            <p>
            <form action="{{ route('scenarios.add.post') }}" method="POST" class='answerform' name='create-scenario'>
                @csrf
                <div class="horizontal-div" style="align-items: start">
                    @foreach($phases as $phase)
                        <div>
                            {{ $phase->name }}
                            @foreach($hackersteps as $step)
                                @if($step->phase_id == $phase->id)
                                    <div class="form-check">
                                        <input type="checkbox" name="hackerstep-{{$step->id}}" id="hackerstep-{{$step->id}}" value="true">
                                        <label for="hackerstep-{{$step->id}}">{{$step->name}}</label>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>
                <div class="horizontal-div">
                    <label for="scenario_name_input">{{__('Name:')}}</label><input type="text" class="form-control width_300" name="scenario_name" id="scenario_name_input" value="" placeholder="{{__('Enter scenario name here')}}" maxlength="32">
                    <input class="btn btn-primary" id="confirm_add_button" type="submit" value="{{__('Create')}}">
                </div>
            </form>
            </p>
        </details>

        <h1 class="mb-4">{{__('Scenarios')}}</h1>
        @foreach ($scenarios as $scenario)
            <div class="card mb-3">
                <div class="card-header">
                    <h2>{{ $scenario->name }}</h2>
                    <h5>{{__('Possible kill chains: ')}}({{ count($scenario->paths) }})</h5>
                </div>
                <div class="card-body">
                    @foreach($scenario->paths as $path)
                        <div class="card-text">
                            @php
                                $steps = array_map(function($step) {
                                    return '#'. $step['hackerattackstep_id'] . ' ' . $step['name'];
                                }, $path);
                            @endphp
                            <p>{{ implode(' -> ', $steps) }}</p>
                        </div>
                    @endforeach
                </div>

                {{-- @php
                    $stepsByPhase = $scenario->hackerattackSteps->groupBy('phase_id');
                @endphp
                @foreach ($stepsByPhase as $phaseId => $steps)
                    <div class="card-body">
                        <h3 class="card-title">Phase {{ $steps->first()->phase->name }}</h3>
                        <ul class="list-group list-group-flush">
                            @foreach ($steps as $step)
                                <li class="list-group-item">{{ $step->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach --}}
            </div>

        @endforeach
    </div>
@endsection
