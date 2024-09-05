@extends('layouts.user_type.auth')

@section('content')

    <!-- Code for company profile settings page -->
    <div class="p-6 py-4 bg-white vh-auto rounded-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <!-- Category tabs -->
            <div class="nav nav-tabs w-100 border-bottom" id="categoryTabs" role="tablist">
                @foreach($categories as $cIndex => $category)
                    <a class='nav-link {{$cIndex+1 === 1 ? 'active' : ''}}' id='category{{$category->category_id}}-tab' data-bs-toggle="tab" href='#category{{$category->category_id}}'
                        role="tab" aria-controls='category{{$category->category_id}}' aria-selected="true">{{__($category->name)}}
                    </a>
                @endforeach
                    <a class='nav-link {{count($categories)+1 === 1 ? 'active' : ''}}' id='maturity-score-tab' onclick="maturityScore()" data-bs-toggle="tab" href='#maturity-score'
                       role="tab" aria-controls='maturity-score' aria-selected="true">{{__("Maturity Score")}}
                    </a>
            </div>

            <!-- check form to see if expert mode is enabled or not -->
            <div class="px-4 form-check form-switch">

                @if($isExpert === 'true')
                    <input class="form-check-input" type="checkbox" role="switch" id="isExpertSwitch" checked>
                    <label class="form-check-label" for="isExpertSwitch">{{__('Expert')}}</label>
                @else
                    <input class="form-check-input" type="checkbox" role="switch" id="isExpertSwitch">
                    <label class="form-check-label" for="isExpertSwitch">{{__('Expert')}}</label>
                @endif

            </div>

            <!-- Profile selection drop-down -->
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="profileDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">

                    @if(isset($profile))
                        {{$profile->profile_name}}
                    @else
                    {{__('Show profiles')}}
                    @endif
                </button>

                <ul class="dropdown-menu" aria-labelledby="profileDropdown">

                    @if(isset($company_profiles))
                        @foreach($company_profiles as $profil)
                            <li><a class="dropdown-item"
                                   href="{{ url('/settings/' . $profil->profile_name) }}">{{$profil->profile_name}}</a>
                            </li>
                        @endforeach
                    @endif

                    <li><a class="dropdown-item" href="#">
                            <form action="/settings" method="post">{{ csrf_field() }}
                                    <label for="name">{{__('Profile name')}}</label>
                                    <input id="name" class="form-control" name="name" required="" type="text" value="{{ old('name') }}" placeholder="{{__('Profile name')}}">
                                <button class="btn btn-primary" type="submit">{{__('Add profile')}}</button>
                            </form>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div>

        <!-- Main content area -->
            @if(isset($profile))
                <div id="profile" data-profile-id="{{ $profile->profile_id }}"></div> <!-- für js -->
                <div id="profilename" data-profile-name="{{ $profile->profile_name }}"></div>
            @endif


        <div class="tab-content" id="myTabContent">
            <!-- Category 1 content -->
            @php $qIndex = 1 @endphp
            @foreach($categories as $index => $category)

                <div class='tab-pane fade {{$index+1 === 1 ? 'show active' : ''}}' id='category{{$category->category_id}}' role="tabpanel" aria-labelledby='category{{$category->category_id}}-tab'>
                    <h2>{{__('Category')}} {{$index+1}} - {{__($category->name)}}</h2>
                    <div>

                        <!-- Iterates through all questions -->
                    @foreach($category->questions as $question)
                        @php
                            $lastAnswer = "";
                        @endphp
                            <div class="mb-4">
                                <h4>{{__($question->question)}}</h4>
                                <form class="answerform" method="POST" name='{{$question->question_id}}_answers'>
                                    <!-- Iterates through all answer options -->
                                    @foreach($question->answers as $aIndex => $answer)
                                        @php
                                            $currentAnswer = $answer->answer;
                                            if (str_starts_with($currentAnswer, "+")) {
                                                $currentAnswer = $lastAnswer." AND".substr($currentAnswer, 1);
                                            }
                                            $lastAnswer = $currentAnswer;
                                        @endphp
                                        <div class="form-check">
                                            @csrf
                                            <!-- Adds possible extra questions if expert mode is enabled -->
                                            @if(isset($company_answers[$qIndex]) && $company_answers[$qIndex] == $answer->answer_id)
                                                <input {{boolval($answer->is_expert) && ($isExpert == 'false' || !isset($isExpert)) ? 'disabled' : ''}}
                                                    checked class="form-check-input" type="radio" name='{{$question->question_id}}' answer_id='{{$answer->answer_id}}' id='q{{$question->question_id}}Option{{$answer->answer_id}}' value='{{__($answer->answer)}}'>
                                            @else
                                                <input {{boolval($answer->is_expert) && ($isExpert == 'false' || !isset($isExpert)) ? 'disabled' : ''}}
                                                       class="form-check-input" type="radio" name='{{$question->question_id}}' answer_id='{{$answer->answer_id}}' id='q{{$question->question_id}}Option{{$answer->answer_id}}' value='{{__($answer->answer)}}'>
                                            @endif
                                            <label class="{{boolval($answer->is_expert) && ($isExpert == 'false' || !isset($isExpert)) ? 'text-danger' : ''}}
                                            form-check-label" for='q{{$question->question_id}}Option{{$answer->answer_id}}'>{{__($currentAnswer)}}</label>
                                        </div>
                                    @endforeach
                                </form>
                            </div>
                            @php $qIndex++ @endphp
                        @endforeach
                    </div>
                </div>
            @endforeach
            <!-- Maturity Score -->
            <div class='tab-pane fade {{$index+1 === 1 ? 'show active' : ''}}' id='maturity-score' role="tabpanel" aria-labelledby='maturity-score-tab'>
                <h2>{{__('Maturity Score')}}</h2>
                <div id="maturity-score-content">
                    Maturity score is being calculated...
                </div>
            </div>
        </div>
    </div>

        <!-- includes the jQuery library in the web page-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        // On change of input it should send a request to the backend to update the answer

        const forms = document.querySelectorAll('.answerform');
        const isExpertSwitch = document.querySelector('#isExpertSwitch');
        var profilename = document.getElementById('profilename').getAttribute('data-profile-name');
        sessionStorage.setItem("profile-id-"+{{auth()->user()->id}}, document.getElementById('profile').getAttribute('data-profile-id'));

        <!-- Event listener for expert button -->
        isExpertSwitch.addEventListener('change', async function () {
            if(isExpertSwitch.checked){
                await Swal.fire({
                    title: 'Are you sure? Please only change this if you are an expert.',
                    showDenyButton: true,
                    confirmButtonText: 'I am an expert',
                    denyButtonText: `Take me back to safety`,
                }).then((result) => {
                    if(result.isConfirmed){
                        location.replace('/settings/' + profilename + '?isExpert=' + this.checked);
                    }else{
                        this.checked = false;
                    }
                });
            }else{
                location.replace('/settings/' + profilename + '?isExpert=' + this.checked);
            }
        });

        // if the inputs on the form change, coinsole.log the input attributes
        forms.forEach(form => {
            let inputs = $(form).find('input');
            inputs.on('change', function() {
                // Get the question id
                let questionId = $(this).attr('name');
                // Get the answer
                let answer = $(this).attr('answer_id');
                // Get Profile_id
                var profileId = document.getElementById('profile').getAttribute('data-profile-id');

                // Send the request to the backend
                $.ajax({
                    url: '/company/settings',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        profile_id: profileId,
                        question_id: questionId,
                        answer_id: answer
                    },
                });
            });
        });

        /**
         * Method to fetch Profile ID and update Maturity Score Tab
         */
        function maturityScore() {
            //retrieves the profile ID from the session storage
            var profileId = sessionStorage.getItem("profile-id-"+{{auth()->user()->id}});

            //Fetch Data from Server, Profile ID
            fetch('../company/recommendation', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    profile_id: profileId
                })
            })
                //Check if Response is OK
                .then(async response => {
                    if (response.ok) {
                        return response.json();
                    }

                    const text = await response.text();
                    var newWindow = window.open();
                    newWindow.document.write(text);

                    throw new Error('Something went wrong');
                }) //Stores the first element of the response data in the session storage with the key profile-baseline-profileID
                .then(data => {
                    sessionStorage.setItem("profile-baseline-"+profileId, JSON.stringify(data[0]));

                    //Updates the inner HTML of the element to be displayed: The baseline score (data[0]), The user's level (data[1]), A list of recommendations (data[2])
                    document.getElementById("maturity-score-content").innerHTML = `Baseline: ${JSON.stringify(data[0])}<br>Your Level: ${JSON.stringify(data[1])}<br><br>Recommendations:<ul>`;
                    for (const answer of data[2]) {
                        document.getElementById("maturity-score-content").innerHTML += `<li>${answer}</li>`;
                    }
                    document.getElementById("maturity-score-content").innerHTML += "</ul>";
                })
                .catch(error => { //error handling
                    console.error('Fetch error:', error);
                })
        }
    </script>
@endsection
