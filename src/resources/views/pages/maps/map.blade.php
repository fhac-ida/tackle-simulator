@extends('layouts.user_type.auth')

@push('styling')
    <link rel="stylesheet" href="{{ asset('css/map.css') }}">
    <link rel="stylesheet" href="{{ asset('css/canvasOverlay.css') }}">
@endpush
    {{--
        the navigation bar at the top can be found here
        src/resources/views/layouts/navbars/auth/nav.blade.php
    --}}
@section('content')
    {{--
        creation of the applications top bar buttons
        these are set into rows via bootstrap classes
    --}}
    <div class="row">
        <div class="col-xl-12 col-sm-12 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-12">
                            <!--<h2>{{__('Map')}} {{ $map->name }}</h2>-->

                            <!-- first 3 red buttons -->

                            <!-- add (+) button -->
                            <button
                                class="button_no_margin btn btn-icon btn-primary"
                                type="button"
                                id="newElementBtn"
                                title="Add new Element"
                            >
                                <i class="ni ni-fat-add text-lg opacity-10" ></i>
                            </button>

                            <!-- remove all connections (scissors) button -->
                            <button class="button_no_margin btn btn-icon btn-primary"
                                    type="button"
                                    id="clearLinksBtn"
                                    title="Remove all Connections"
                            >
                                <i class="ni ni-scissors text-lg opacity-10" aria-hidden="true"></i>
                            </button>

                            <!-- save map (folder) button -->
                            <button class="button_no_margin btn btn-icon btn-primary"
                                    type="button"
                                    id="saveLinksBtn"
                                    title="Save Map"
                            >
                                <i class="ni ni-folder-17 text-lg opacity-10" aria-hidden="true"></i>
                            </button>

                            |

                            <!-- the 3 blue buttons -->

                            <!-- create group (binder) button -->
                            <button
                                class="button_no_margin btn btn-icon btn-info"
                                id="group-elements-button"
                                title="Group selected Elements"
                            >
                                <i class="ni ni-collection text-lg opacity-10"></i>
                            </button>

                            <!-- delete group (cog) button -->
                            <button
                                class="button_no_margin btn btn-icon btn-info"
                                id="manage-groups-button"
                                title="Settings"
                            >
                                <i class="ni ni-settings-gear-65 text-lg opacity-10"></i>
                            </button>

                            <!-- deselect all (two squares) button -->
                            <button
                                class="button_no_margin btn btn-icon btn-info"
                                id="deselect-groups-button"
                                title="Deselect Group"
                            >
                                <i class="ni ni-ungroup text-lg opacity-10"></i>
                            </button>

                            |

                            <!-- start simulation button -->
                            <button
                                style=""
                                type="button"
                                id="startSimulationButton"
                                class="button_no_margin btn btn-icon btn-primary"
                            >
                                <i class="text-lg opacity-10" aria-hidden="true"></i> {{__('Start Simulation')}}
                            </button>

                            <!-- scenario form -->
                            <div style="display: inline">
                                <label for="scenarioSelector">{{__('Attack Scenario:')}}</label>
                                <select class="form-control" id="scenarioSelector" style="width: auto; display: inline">
                                    @if (count($scenarios) > 0)
                                        <option value="" selected disabled>{{__('Select a scenario...')}}</option>
                                        @foreach ($scenarios as $key => $scenario)
                                            <option {{ $key == (sizeof($scenarios)-1) ? 'selected':''  }} value="{{ $scenario['id'] }}">{{ $scenario['name'] }}</option>
                                        @endforeach
                                    @else
                                        <option selected disabled value="">{{__('No scenarios available')}}</option>
                                    @endif
                                </select>
                            </div>

                            <div style="display: inline">
                                <label for="reportSelector">{{__('Simulation results:')}}</label>
                                <select class="form-control" id="reportSelector" style="width: auto; display: inline">
                                    @if (count($reports) > 0)
                                        <option value="" selected disabled>{{__('Select a report...')}}</option>
                                        @foreach ($reports as $key => $report)
                                            <option {{ $key == (sizeof($reports)-1) ? 'selected':''  }} value="{{ $report }}">{{ $report }}</option>
                                        @endforeach
                                    @else
                                        <option selected disabled value="">{{__('No reports available')}}</option>
                                    @endif
                                </select>
                            </div>

                        </div>
                    </div>

                    <!-- shows the currently selected node underneath the buttons in the bar -->
                    <div class="row mt-2">
                        <div class="col-12">
                            <span class="">{{__('Selected Element: ')}}<span class="badge bg-gradient-info" id="selected-element">None</span></span>
                            <div id="groupListDiv">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--
        places the simulation map into the page
        maps origin in src/public/js/jointjs/jointMapConfig.js
    -->
    <div class="row mt-4">
        <div class="col-lg-12" id="holderParentDiv">
            <div class="card">
                <div style="height: 65vh" class="card-body p-3">
                    <!-- gets already created maps with settings from "myholder" -->
                    <div id="myholder"></div>

                    <div id="overlay" style="display: none"></div>

                </div>
            </div>
        </div>

        <!-- Places the hacking information pop-up on the right when a node is selected -->
        <div class="col-lg-3" id="hackingInfoDiv" style="display: none;">
            <div class="card">
                <div style="height: 65vh; overflow-y: scroll" class="card-body p-3">
                    <button class="btn-outline-secondary" aria-label="Close alert" type="button" id="hackingInfoDivCloseBtn">
                        <span aria-hidden="true">&times;</span>
                    </button>

                    <div style="display: inline">
                        <label for="reportSelector">{{__('Simulation results:')}}</label>
                        <!-- Displays currently available reports in a drop-down menu -->
                        <select class="form-control" id="reportSelector" style="width: auto; display: inline">
                            @if (count($reports) > 0)
                                <option value="" selected disabled>{{__('Select a report...')}}</option>
                                @foreach ($reports as $key => $report)
                                    <option {{ $key == (sizeof($reports)-1) ? 'selected':''  }} value="{{ $report }}">{{ $report }}</option>
                                @endforeach
                            @else
                                <option selected disabled value="">{{__('No reports available')}}</option>
                            @endif
                        </select>
                    </div>

                    <!-- initialises div for the possible Killchains -->
                    <div class="row">
                        <div class="col-12" id="killchain-stats"></div>
                        <div class="col-12" id="killchain"></div>
                    </div>

                    <!-- initialises div for the Recommended Actions -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>{{__('Recommended Actions:')}}</h5>
                        </div>
                    </div>
                    <div class="row" id="recommended-actions"></div>
                </div>
            </div>
        </div>
    </div>


    @push('js')
        <script type="module" src="{{ asset ('js/jointjs/jointMapConfig.js') }}"></script>

        <script type="module">
            // Gives a recommendation if the device resolution is too low
            if(window.screen.width < 1000)  {
                Swal.fire({
                    position: 'center',
                    icon: 'info',
                    title: "Low resolution",
                    text: "We recommend using this program on a device with a higher resolution, such as a desktop, notebook or tablet computer.",
                    showConfirmButton: true,
                });
            }

            // Import //
            import {
                DARK_COLOR,
                graph,
                LINE_WIDTH,
                LIST_ITEM_HEIGHT,
                LIST_ITEM_WIDTH,
                MODEL_HEIGHT,
                MODEL_RADIUS,
                paper,
                showLinkTools,
                HardwareObject,
                createNewDefaultElement
            } from "{{ asset ('js/jointjs/jointMapConfig.js') }}";
            import {OverlayError} from "{{ asset ('js/errorhandling/error.js') }}";

            @if($graph != null)
                //inserts JSON data from the server side into the jointJS graph variable
                graph.fromJSON({!! $graph !!});

                let graphic = document.getElementById('v-2');

                let maxDistX = 0; //The distance of the hardware object furthest from the origin
                let maxDistY = 0;
                let posX = 0;
                let posY = 0;
                let amount = 0;

                /**
                 * Determines the new Max distance of the graph
                 * by looking at all nodes x and y positing and updating if something higher is found
                 */
                for (const hwObject of graph.attributes.cells.models) {
                    if ( hwObject.attributes.hasOwnProperty('position')) {

                        const distX = Math.abs(hwObject.attributes.position.x);
                        const distY = Math.abs(hwObject.attributes.position.y);

                        posX += hwObject.attributes.position.x;
                        posY += hwObject.attributes.position.y;
                        amount++;

                        if (distX > maxDistX) {
                            maxDistX = distX;
                        }
                        if (distY > maxDistY) {
                            maxDistY = distY;
                        }
                    }
                }

                //calculates the average x and y position to centre the paper
                let avgX = posX/amount/graphic.clientWidth;
                let avgY = posY/amount/graphic.clientHeight;
                paper.translate(avgX, avgY);

                //ensures that the entire graph fits within the view of the graphic element, by comparing the maximum distances in the x and y directions
                let newScale = 0;
                if (maxDistX >= maxDistY) {
                    newScale = (graphic.clientWidth-64)/maxDistX;
                }
                else {
                    newScale = graphic.clientHeight/maxDistY;
                }

                // Set a minimum and maximum scale for the paper
                if (newScale > 0.1 && newScale < 2) {
                    // Zoom the paper
                    paper.scale(newScale, newScale);
                }
            @endif

            //code for selection feature
            let selection = []; // array for currently selected nodes
            let groupListDiv = document.getElementById('groupListDiv');
            var offsetX = 0; // To store the initial mouse position relative to the element
            var offsetY = 0;

            var simulationStartElement = null;
            var simData = null;

            var scenarioSelector = document.getElementById('scenarioSelector');

            /**
             * Event listener for clicking on hardware objects
             */
            paper.on('cell:pointerdown', function (cellView, evt) {
                if (cellView.model.attributes.type == "HardwareObject") {
                    //checks if control key is pressed
                    if(evt.ctrlKey)  {
                        addElementToSelection(cellView.model);
                    }
                    //checks if the Element is not already highlighted
                    else if(!isHighlighted(cellView.model)) {
                        selectOneElement(cellView.model);
                    }
                }
            });

            /**
             * Event listener for selecting a report
             */
            var reportSelector = document.getElementById('reportSelector');
            reportSelector.addEventListener('change', function () {
                //looks for map specific currently selected report
                fetch('/hackerattacks/LoadReport?filename=' + encodeURIComponent(@json($map->id)+'/'+this.value))
                    //checks for Network response and returns report as JSON if everything is OK
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Netzwerkantwort war nicht OK');
                        }
                        return response.json();
                    })
                    //takes the data from the response, saves it in the session variable and uses it to update the simulation data
                    .then(data => {
                        sessionStorage.setItem("simData", JSON.stringify(data));

                        updateSimData(selection[0]);
                    })
                    .catch(error => {
                        console.error('Fetch error:', error);
                    });
            });

            const startSimulationButton = document.getElementById('startSimulationButton');

            /**
             * Event listener for the Start Simulation Button
             */
            startSimulationButton.addEventListener('click', function () {
                simulationStartElement = null;

                //Set the simulationStartElement only if one Element is selected
                if(selection.length == 1)  {
                    simulationStartElement = selection[0];
                }
                //Response in case no Element was highlighted
                else if(selection.length == 0)  {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: "No highlighted element to start simulation from.",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    return;
                }
                //Response in case multiplle Elements were highlighted
                else {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: "You cant select multiple objects to start simulation from.",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    return;
                }

                //Simulation loading animation
                Swal.fire({
                    title: 'Simulation running',
                    html: 'Please wait...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                let bfs_items = [];

                /**
                 * Breadth-First Search to gather items for the simulation
                 *
                 * bfs_items.push is a callback function for each node visited during the BFS traversal
                 * and adds an object containing data about the current node to the bfs_items array
                 *
                 * @param currentElement $e
                 * @param currentDepth $d
                 */
                graph.bfs(simulationStartElement, (e, d) => bfs_items.push({
                    cid: e.cid,
                    hardwareID: e.attributes.attrs.device_id.text,
                    settings: e.attributes.attrs.settings,
                    /* Searches for neighbor Elements for the current node e
                       gets the cid of the target node if e is the source of the connection
                       gets the cid of the source node if e is not the source of the connection
                     */
                    neighbors: Array.from(graph.getConnectedLinks(e), (conn, i) => e.cid == graph.getCell(conn.attributes.source.id).cid ? graph.getCell(conn.attributes.target.id).cid : graph.getCell(conn.attributes.source.id).cid)
                }));

                //Pushing further information
                bfs_items.push({map_id: @json($map->id)});
                let profile_id = sessionStorage.getItem("profile-id-"+{{auth()->user()->id}});
                if (profile_id != null) {
                    bfs_items.push({profile_baseline: sessionStorage.getItem("profile-baseline-"+profile_id)});
                }
                else {
                    bfs_items.push({profile_baseline: null});
                }

                bfs_items.push({scenario_id: scenarioSelector.options[scenarioSelector.selectedIndex].value});

                // Fetch simulation data from the server
                fetch('/hackerattacks/SimAttackTest', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        //CSRF token to prevent cross-site request forgery attacks
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(bfs_items)
                })
                    .then(async response => {
                        // KEEP FOR DEBUGGING THE HACKERATTACKCONTROLLER AND SCENARIOSERVICE
                        /*const text = await response.text();
                        var newWindow = window.open();
                        newWindow.document.write(text);*/

                        if (response.ok) {
                            return response.json();
                        }
                        throw new Error('Something went wrong during hacking simulation');
                    })
                    .then(data => {
                        simData = data[0];
                        // simData is converted to a JSON string and stored in the sessionStorage to persist across page reloads within the same session
                        sessionStorage.setItem("simData", JSON.stringify(simData));
                        Swal.hideLoading();
                        Swal.close();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Simulation complete',
                            showConfirmButton: false,
                            timer: 1500
                        })

                        let reportSelectorElement = document.getElementById('reportSelector');
                        reportSelectorElement.options[reportSelectorElement.selectedIndex].selected = false; //deselects current option
                        reportSelectorElement.innerHTML += `<option selected value="${data[1]}">${data[1]}</option>`; //Adds newly created report as a new option to the drop down
                        updateSimData(simulationStartElement);

                    })
                    .catch(error => {
                        console.error('Error: ', error);
                    });
            });

            // Initialises graph groupList and creates groupButtons on page reload
            if (graph.get('groupList') === undefined) {
                graph.set('groupList', []);
            }
            addAllSelectGroupButtons();

            /**
             * Adds all group buttons by calling addOneGroupSelect on every group in the group list
             * used for creating all group buttons on page reload above
             */
            function addAllSelectGroupButtons()  {
                graph.get('groupList').forEach(function (group) {
                    addOneGroupSelectButton(group);
                });
            }

            /**
             * Adds a button for a single group of nodes
             * by creating the necessary HTML Elements and adding an on-click Event listener that selects all elements included in the group
             *
             * @param group
             */
            function addOneGroupSelectButton(group) {

                //Initialises div, button and declares button attributes
                let divToAdd = document.createElement('div');
                let buttonToAdd = document.createElement('button');
                buttonToAdd.textContent = group.groupName;
                buttonToAdd.id = group.groupName;
                buttonToAdd.className = 'badge bg-gradient-info'; // btn btn-icon btn-info
                buttonToAdd.style.margin = '2px';

                /**
                 * Event listener for newly created button
                 * Selects the elements corresponding to the group
                 */
                buttonToAdd.onclick = function () {
                    deselectAll();

                    //Gets all group elements
                    Array.prototype.forEach.call(group.groupElements, gEl => {

                        //Gets all graph elements
                        let elements = graph.getElements();
                        //checks for every element in the graph
                        elements.forEach(function (element) {
                            let bool = false;

                            //If the current Element is part of the group element it is selected
                            group.groupElements.forEach(function (gElement) {
                                if (gElement.id === element.id) {
                                    bool = true;
                                }
                            });

                            if (bool) {
                                addElementToSelection(element);
                            }
                        });
                    });
                };

                divToAdd.append(buttonToAdd);
                groupListDiv.append(divToAdd);
            }

            // further Eventlisteners //

            //Eventlistener for the create new element button
            const createBtn = document.getElementById('newElementBtn');
            createBtn.addEventListener('click', openNewElementForm);

            //Eventlistener for the group elements button
            const groupBtn = document.getElementById('group-elements-button');
            groupBtn.addEventListener('click', () => {

                let groupList = graph.get('groupList');
                let groupName = "";

                //Response if nothing got selected
                if(selection.length <= 0){
                    new OverlayError('Please select at least one Element to group').displayError();
                    return;
                }

                //Sets the group name
                groupName = prompt("Enter a group name:");

                //Sends error if the group name already exists
                if(groupList.find((element) => element.groupName === groupName)){
                    new OverlayError('Group name already in use').displayError();
                    return;
                }

                //Response if no name has been entered
                if (groupName == null || groupName === "") {
                    new OverlayError('Please enter a group name').displayError();
                    return;
                }

                let shallowClone = { ...selection };

                //Pushes group into grouplist
                let arraylength = groupList.push({ 'groupName': groupName, 'groupElements': shallowClone });
                //set group into graph
                graph.set(groupList);
                saveMap();
                window.location.reload(); // Add group select button for latest group
            });

            //Eventlistener for the manage group Elements button
            const manageGroupBtn = document.getElementById('manage-groups-button');
            manageGroupBtn.addEventListener('click', () => {

                Swal.fire({
                    //Create an Alert which lists all groupList Elements
                    title: 'Delete Group',
                    //Adds a div for the groups in the group list
                    html: '<div id="groupList"></div>',
                    showCloseButton: true,
                    didOpen: () => {
                        let groupList = graph.get('groupList');
                        let groupListDiv = document.getElementById('groupList');
                        //Adds the individual groups from the group list as HTML Objects to the map option bar
                        groupList.forEach(function (group) {
                            let groupDiv = document.createElement('div');
                            groupDiv.className = 'groupDiv';
                            groupDiv.id = group.groupName;
                            groupDiv.textContent = group.groupName;

                            //EventListener to removes group from groupList
                            groupDiv.addEventListener('click', function () {
                                let index = groupList.indexOf(group);
                                if(index > -1) {
                                    groupList.splice(index, 1);
                                }
                                document.getElementById(group.groupName).remove();
                                Swal.close();
                            });

                            groupListDiv.append(groupDiv);
                        });
                    },
                });

            });

            //Eventlistener for the deselect group button
            const deselectGroupBtn = document.getElementById('deselect-groups-button');
            deselectGroupBtn.addEventListener('click', () => {
                deselectAll();
            });

            const holderParentDiv = document.getElementById('holderParentDiv');
            const hackingInfoDiv = document.getElementById('hackingInfoDiv');
            const hackingInfoDivCloseBtn = document.getElementById('hackingInfoDivCloseBtn');

            //Eventlistener for the hackingInformationClose button
            hackingInfoDivCloseBtn.addEventListener('click', () => {
                hideHackingInfoDiv();
            });

            /**
             * Shows the hackingInfo on the right when selecting an Element
             */
            function showHackingInfoDiv()  {
                holderParentDiv.classList.add('col-lg-9');
                holderParentDiv.classList.remove('col-lg-12');
                hackingInfoDiv.style.display = 'block';
            }

            /**
             * Hides the HackingInfo when clicking the close button
             */
            function hideHackingInfoDiv()  {
                hackingInfoDiv.style.display = 'none';
                holderParentDiv.classList.add('col-lg-12');
                holderParentDiv.classList.remove('col-lg-9');
            }

            /**
             * Eventlistener for the clear all links button
             *
             * removes all links between the Elements
             */
            const clearLinksBtn = document.getElementById('clearLinksBtn');
            clearLinksBtn.addEventListener('click', function () {
                graph.getLinks().forEach(function (link) {
                    link.remove();
                });
                saveMap();
            });

            /**
             * Eventlistener for the save all links button
             */
            var saveButton = document.getElementById('saveLinksBtn');
            saveButton.addEventListener('click', saveMap);


            //stores the previous position of the mouse during the drag operation
            let prevPos = {x: null, y: null};

            /**
             * Eventlistener for pointermove
             *
             * Moves all selected Elements on drag
             */
            paper.on("element:pointermove", (elementView, evt, x, y) => {
                //Execute if element is in selection, more than one element is selected and when the current mouse position is different from previous
                if (selection.length > 1 && (prevPos.x !== x || prevPos.y !== y) && selection.includes(elementView.model)){

                    let dx = 0;
                    let dy = 0;

                    //first Element to move workaround to intially set the movement distance
                    if(prevPos.x === null || prevPos.y === null){
                        dx = evt.originalEvent.movementY * 10;
                        dy = evt.originalEvent.movementY * 10;
                    }else{ //calculates moving distance
                        dx = x - prevPos.x;
                        dy = y - prevPos.y;
                    }

                    //Move all selected elements
                    selection.forEach((element) => {
                        if(element !== elementView.model)
                            element.translate(dx, dy);
                    });
                    //Updates previous position
                    prevPos.x = x;
                    prevPos.y = y;
                }
            });

            /**
             * This event is triggered when a user releases the mouse button after dragging an element on the paper
             */
            paper.on("element:pointerup", (elementView, evt, x, y) => {
                prevPos.x = null;
                prevPos.y = null;
            });

            /**
             * Shows the LinksTolls
             * in our case an x button to remove the link
             */
            paper.on('link:mouseenter', (linkView) => {
                showLinkTools(linkView);
            });

            /**
             * Hides the LinksTolls
             * returns to original Link display when you no longer hover the link
             */
            paper.on('link:mouseleave', (linkView) => {
                linkView.removeTools();
            });

            //Zoom with mousewheel
            paper.on('blank:mousewheel', function (evt, x, y, delta) {
                zoomPaper(evt, x, y, delta)
            });



            //Zoom with mousewheel
            paper.on('cell:mousewheel', function (cellView, evt, x, y, delta) {
                zoomPaper(evt, x, y, delta, cellView)
            });

            //Dragging the paper
            paper.on('blank:pointerdown', function (event, x, y) {
                let scale = paper.scale();
                let dragStartPosition = {x: x * scale.sx, y: y * scale.sy};

                paper.on('blank:pointermove', function (event) {
                    paper.translate(
                        event.offsetX - dragStartPosition.x,
                        event.offsetY - dragStartPosition.y);
                });
                paper.on('blank:pointerup', function (evt, x, y) {
                    // Remove the event listeners for dragging
                    paper.off('blank:pointermove');
                    paper.off('blank:pointerup');
                });
            });



            // (Async) functions //
            /**
             * Goes through all the necessary steps when creating a new Element
             * Creates a form to ask for the necessary information and with that then creates a new Element with the necessary functionality
             *
             * @returns {Promise<void>}
             */
            async function openNewElementForm() {
                //Creates a Form asking for the necessary information to create an Element
                //Awaits the required information and sets them after they got entered

                //Name
                const {value: name} = await Swal.fire({
                    title: '{{__('What is the name of the new element?')}}',
                    input: 'text',
                    inputValue: '{{__('New Element')}}',
                    showCancelButton: true,
                    //makes sure the Element gets a name
                    inputValidator: (value) => {
                        if (!value) {
                            return '{{__('You need to write something! :)')}}'
                        }
                    }
                });

                if (name) {
                    //Description
                    const {value: description} = await Swal.fire({
                        title: '{{__('Would you like to briefly describe the Element?')}}',
                        input: 'text',
                        inputLabel: '{{__('Given name: ')}}' + name,
                        showCancelButton: true,
                    });

                    //Device selection
                    let { value: device } = await Swal.fire({
                        title: '{{__('Select predefined device')}}',
                        input: 'select',
                        inputOptions: {
                            //Displays all divices for choice
                            @foreach($types as $type)
                                '{{$type}}': {
                                    @foreach($devices as $device)
                                        @if($device->type == $type)
                                            '[{{$device->id}}] {{$device->name}} {{$device->type}}': '{{$device->name}} ({{$device->vendor}})',
                                        @endif
                                    @endforeach
                                },
                            @endforeach
                        },
                        inputPlaceholder: '{{__('Select a device')}}',
                        showCancelButton: true,
                        inputValidator: (value) => {
                            return new Promise((resolve) => {
                                if (value) {
                                    resolve()
                                } else {
                                    resolve('{{__('You need to select something :)')}}')
                                }
                            });
                        }
                    });

                    //If a device got selected
                    if(device){

                        //Splits the selected device string into an array
                        var n = device.split(" ");

                        //Extracts the last element of the array n which represents the device type
                        var type = n[n.length - 1]

                        //Removes the type part from the original device string, leaving the device name and ID
                        device = device.slice(0, -type.length-1)

                        //Asks if the Information is correct
                        Swal.fire({
                            title: '{{__('Is this correct?')}}',
                            html:
                                '<b>Name:</b> ' + name + '<br>' +
                                '<b>{{__('Description:')}}</b> ' + description + '<br>' +
                                '<b>{{__('Device:')}}</b> ' + device + '<br>',
                            showDenyButton: true,
                            confirmButtonText: '{{__('Save')}}',
                            denyButtonText: `{{__('Don\'t save')}}`,
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                const regex = /\[(\d+)\]/; // Regular expression to match [number]
                                const device_id = device.match(regex)[1];

                                //Sends a request to the server to fetch the interfaces of the selected device
                                fetch("/hardwareobjects/" + parseInt(device_id) + "/interfaces/")
                                    .then(response => response.json())
                                    //Uses the fetched data to create an settings object
                                    .then(data => {

                                        let settings = {
                                            "hasBackup": !!data.hasBackup,
                                            "hasFirewall": !!data.hasFirewall,
                                            "hasEncryption": !!data.hasEncryption,
                                            "hasMemoryPassword": !!data.hasMemoryPassword,
                                            "hasPassword": !!data.hasPassword,
                                            "hasUserManagement": !!data.hasUserManagement
                                        };

                                        //Calls the method to create the new element
                                        let element = createNewDefaultElement(description, name, '', settings, device_id, type);

                                        //Handle the data returned from the controller
                                        //Iterates over each interface in the fetched data
                                        data["interfaces"].forEach(item => {
                                            //Get category names and color
                                            fetch(/interfaces/+ item["interfacecategory_id"])
                                                .then(async response => {
                                                    if (response.ok) {
                                                        return response.json();
                                                    }
                                                    /*
                                                    // KEEP FOR DEBUGGING THE HACKERATTACKCONTROLLER AND SCENARIOSERVICE
                                                    const text = await response.text();
                                                    var newWindow = window.open();
                                                    newWindow.document.write(text);
                                                    */
                                                    throw new Error('Something went wrong');
                                                })

                                                //Adds the default ports to the element based on the interface data
                                                .then(data => {
                                                    for (let i = 0; i < item["pivot"]["maxConnections"]; i++) {
                                                        element.addDefaultPort(element.getPorts().length, data['colorcode'], data["name"]);
                                                    }
                                                }).catch(error => {
                                                // Handle any errors that occur during the request
                                                console.error('Error:', error);

                                            });
                                        });

                                        graph.addCell(element);

                                        addContextMenuToObject(element);

                                        saveMap();

                                    })
                                    .catch(error => {
                                        // Handle any errors that occur during the request
                                        console.error('Error:', error);
                                    });
                            }
                        });
                    }
                }
            }

            /**
             * Clones an Element
             *
             * @param element
             * @param graph
             * @param translation
             */
            function cloneElement(element, graph, translation = 20){
                let clone = element.clone();
                //moves the cloned element sligthly to avoid confusion
                clone.translate(20, 20);
                graph.addCell(clone);
                addContextMenuToObject(clone);
            }

            /**
             * Highlights a cell and calls updateSimData() and showHackingInfoDiv() to display the hacking data of the highlighted element
             *
             * @param cell
             */
            function highlightCell(cell) {
                updateSimData(cell);
                showHackingInfoDiv();
                joint.highlighters.addClass.add(
                    cell.findView(paper),
                    "body",
                    "selection",
                    { className: "selection" }
                );
            }

            /**
             * Checks if something is highlighted in the cell view
             *
             * @param cellView
             * @returns {boolean}
             */
            function isHighlighted(cellView)  {
                //If the length is greater than 0 highlighters are applied thus the cell is highlighted.
                return joint.dia.HighlighterView.get(cellView.findView(paper)).length > 0;
            }

            /**
             * Deselects an Element
             *
             * @param cell
             */
            function unhighlightCell(cell) {
                joint.highlighters.addClass.remove(cell.findView(paper), "selection");
            }

            /**
             * Updates the Simulation data
             *
             * @param cell
             */
            function updateSimData(cell) {
                //Check if the cell is empty
                if(cell == null) return;

                //Prepare cellID, simData, killchainStats and recommended-actions
                const cid = cell.cid;
                const simData = JSON.parse(sessionStorage.getItem("simData"));
                const killchainDiv = document.getElementById('killchain');
                const killchainStatsDiv = document.getElementById('killchain-stats');
                const recommendedActionsDiv = document.getElementById('recommended-actions');

                //Checks if simData exists and if it contains data for the cellID.
                if (simData && simData[cid]) {
                    const cid_data = simData[cid]["sequences"]; //Saves simulation steps for the cell
                    let deniedCount = 0;
                    let successfulCount = 0;
                    killchainDiv.innerHTML = '<div class="accordion" id="killchainAccordion">'; //Killchain display area

                    recommendedActionsDiv.innerHTML = `<div class="accordion" id="mitigationAccordion">`; //Recomended actions display area

                    //Iterates over each item in the cid_data array
                    cid_data.forEach(item => {
                        let ids = item.hackerstep_sequence.map(step => step.id); //Extracts the IDs of each hacker step sequence
                        let success = item.success ? 'hacked' : 'denied'; //Determines if the attack was successful or denied.
                        if (success == 'hacked') {
                            successfulCount++;

                            //Display Kill Chain for Successful Attacks
                            killchainDiv.innerHTML += `<b>Possible Killchain:</b>`;

                            if(ids[0] == 0) { //Checks if the first ID is 0, indicating the starting node
                                killchainDiv.innerHTML += `
                                    <div class="accordion-item">
                                        <button class="accordion-button border-bottom collapsed" style="padding:0" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-ks" aria-expanded="false" aria-controls="collapse-ks">
                                             -> ${item.hackerstep_sequence[0].name}
                                            <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3" aria-hidden="true"></i>
                                            <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3" aria-hidden="true"></i>
                                        </button>

                                        <div id="collapse-ks" class="accordion-collapse collapse" aria-labelledby="heading-ks" data-bs-parent="#killchainAccordion" style="">
                                                <div class="accordion-body text-sm opacity-8">
                                                    <h6>The device selected to start the simulation is always assumed to be hacked</h6>
                                                </div>
                                            </div>
                                        </div>
                                    `
                                return;
                            }

                            //Iterates over each step in the hacker step sequence
                            item.hackerstep_sequence.forEach(function (step)  {
                                try {
                                    //Adds an accordion item for each step in the kill chain, displaying the step name and missing mitigation flags
                                    killchainDiv.innerHTML += `
                                        <div class="accordion-item">
                                            <button class="accordion-button border-bottom collapsed" style="padding:0" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-ks` + step.id + `" aria-expanded="false" aria-controls="collapse-ks` + step.id + `">
                                                -> ${step.name}
                                                <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3" aria-hidden="true"></i>
                                                <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3" aria-hidden="true"></i>
                                            </button>

                                            <div id="collapse-ks` + step.id + `" class="accordion-collapse collapse" aria-labelledby="heading-ks` + step.id + `" data-bs-parent="#killchainAccordion" style="">
                                                <div class="accordion-body text-sm opacity-8">
                                                    <h6>This attack was successful because the device is missing the following mitigation flags:</h6>
                                                    <ul>
                                                        ${step.missing_mitigation}
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>`

                                    //Display Recommended Mitigations
                                    let mitigationsAsArray = JSON.parse(JSON.stringify(step.mitigations)); //coversion
                                    let mitigationsFormatted = ''; //Initialization

                                    //Checks for mitigations
                                    if(mitigationsAsArray != null && mitigationsAsArray.length > 0) {
                                        //Iterates over each mitigation and formats it as a list item
                                        for (const mitig of mitigationsAsArray) {
                                            mitigationsFormatted += '<li>' + mitig.name + '(' + mitig.effort + '): ' + mitig.description + '</li>';
                                        }
                                    }
                                    else {
                                        mitigationsFormatted = 'Based on your current company profile, it is not necessary to mitigate this attack.';
                                    }

                                    //Places the recommended actions in the placeholder
                                    recommendedActionsDiv.innerHTML += `

                                        <div class="accordion-item mb-3">
                                            <h5 class="accordion-header" id="heading` + step.id + `">
                                              <button class="accordion-button border-bottom font-weight-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse` + step.id + `" aria-expanded="false" aria-controls="collapse` + step.id + `">
                                                ` + step.name + `
                                                <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3" aria-hidden="true"></i>
                                                <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3" aria-hidden="true"></i>
                                              </button>
                                            </h5>
                                            <div id="collapse` + step.id + `" class="accordion-collapse collapse" aria-labelledby="heading` + step.id + `" data-bs-parent="#mitigationAccordion" style="">
                                              <div class="accordion-body text-sm opacity-8">
                                                ` + mitigationsFormatted + `
                                              </div>
                                            </div>
                                        </div>


                                        `;

                                }catch (e) {
                                    console.error(step.mitigations+' throws an error:')
                                    console.error(e);
                                }
                            })

                        } else {
                            deniedCount++;
                        }
                    });

                    recommendedActionsDiv.innerHTML += `</div>`;
                    //Display hacked status
                    if(successfulCount > 0)  {
                        killchainStatsDiv.innerHTML = `<span class="badge bg-gradient-danger">{{__('Hacked:')}} ${successfulCount}</span><br><span class="badge bg-gradient-success"> {{__('Denied:')}} ${deniedCount}</span><br><br>`
                    }
                    else {
                        killchainStatsDiv.innerHTML = `<span class="badge bg-gradient-success">No successful attacks</span><br><br>`
                    }

                    killchainDiv.innerHTML += `</div>`;
                } else {
                    //Display if object wasn't reached
                    killchainStatsDiv.innerHTML = "";
                    killchainDiv.innerHTML = "<p>{{__('This element wasn\'t reached in this simulation')}}</p>";
                    recommendedActionsDiv.innerHTML = "";
                }
            }

            /**
             * Adds an Element to Selection by checking if it is already in the selection array and adding it if it is not
             *
             * @param el
             */
            function addElementToSelection(el) {
                //Find element in selection
                let index = selection.indexOf(el);
                if (index > -1) { // Object already found in selection array -> index equals index in selection array
                    //Element is already in selection -> remove it
                    selection.splice(index, 1);
                    unhighlightCell(el);
                } else {
                    //Element is not in selection -> add it
                    selection.push(el);
                    highlightCell(el);
                }

                // Refresh "Selected Element:" indicator in header
                if(selection.length > 0)  {
                    document.getElementById("selected-element").innerHTML = "";
                    selection.forEach((element) => {
                        if (element.attributes.attrs.label) {
                            document.getElementById("selected-element").innerHTML += element.attributes.attrs.label.text + "(" + element.cid + ") | ";
                        }
                    });
                    let curSelectedElementHTML = document.getElementById("selected-element").innerHTML;
                    document.getElementById("selected-element").innerHTML = curSelectedElementHTML.substring(0, curSelectedElementHTML.length -2);
                }
                else {
                    document.getElementById("selected-element").innerHTML = "None";
                }
            }

            /**
             * Selects One Element
             *
             * @param el
             */
            function selectOneElement(el)  {
                deselectAll();
                selection.push(el);
                highlightCell(el);
                //Checks if the selected element has a label attribute and if it does it updates the innerHTML of the selected-element to display the label text and the cid
                if (el.attributes.attrs.label) {
                    document.getElementById("selected-element").innerHTML = el.attributes.attrs.label.text + "(" + el.cid + ")";
                }
            }

            /**
             * Deselects All selected Elements and set array to empty
             */
            function deselectAll(){
                selection.forEach((element) => {
                    unhighlightCell(element);
                });
                selection = [];
            }

            /**
             * Saves the entire map
             */
            function saveMap() {
                //gets map URL
                const url = "{{ route('mapobjects.update', $map->id) }}";

                //Post request to update the map Object
                fetch(url, {
                    method : "POST",
                    credentials: "same-origin", //Ensures that cookies are included in the request for CSRF protection
                    body: JSON.stringify({ //Conversion
                        data: graph.toJSON()
                    }),
                    //Sets the content type to JSON and includes the CSRF token for security
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                }).then(function(response) { //Handles server response
                    if(response.ok) {
                        return response.json();
                    }
                    throw new Error(response.json());
                }).then(function(response) { //Success message
                    console.log("Request successful", response.data);

                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    })


                }).catch(function(error) { //Error handling
                    console.log("Something went wrong", error);

                        Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: error.message,
                        showConfirmButton: false,
                        timer: 1500
                    })

                })
            }

            /**
             * Removes a created groupButton
             *
             * @param groupName
             */
            function removeOverlayGroupButton(groupName){
                let button = document.getElementById(groupName);
                button.remove();
            }


            /**
             * Functionality for zooming in and out of the paper
             *
             * @param evt
             * @param x
             * @param y
             * @param delta
             * @param cellView
             */
            function zoomPaper(evt, x, y, delta, cellView = null) {
                evt.preventDefault(); // Prevent the default action of the event

                // Get the current scale of the paper
                const oldScale = paper.scale().sx;
                // Get the new scale of the paper by adding a delta value to the old scale
                const newScale = oldScale + delta * .1; // Calculate the new scale of the paper

                // Set a minimum and maximum scale for the paper
                if (newScale > 0.1 && newScale < 2) {
                    // Calculate the scaling factor between the old and new scale
                    const beta = oldScale / newScale;

                    // Calculate the adjustments needed for the translation to maintain the focal point
                    const ax = x - (x * beta);
                    const ay = y - (y * beta);

                    // Get the current translation of the paper
                    const translate = paper.translate();

                    // Calculate the new translation values
                    const nextTx = translate.tx - ax * newScale;
                    const nextTy = translate.ty - ay * newScale;

                    // Apply the new translation values to the paper
                    paper.translate(nextTx, nextTy);

                    // Get the current transformation matrix of the paper
                    const ctm = paper.matrix();

                    // Set the new scale values in the transformation matrix
                    ctm.a = newScale;
                    ctm.d = newScale;

                    // Apply the transformation matrix to the paper
                    paper.matrix(ctm);
                }
            }

            /**
             * Add context menu to map object
             *
             * @param element
             */
            function addContextMenuToObject(element)  {
                // Get the current settings, description, and label of the element
                let object_settings = element.attributes.attrs.settings;
                let description_text = element.attributes.attrs.description.text;
                let label_text = element.attributes.attrs.label.text;

                // Creates a new VanillaContextMenu for the Element
                new VanillaContextMenu({
                    // This ensures that the context menu is associated with a specific element in the JointJS graph
                    scope: document.querySelectorAll('[model-id="' + element.id + '"]')[0],
                    menuItems: [
                        //Edit option
                        {
                            label: '{{__('Edit')}}',
                            callback: (mouseevent) => {
                                //Popoup for editing an Element
                                Swal.fire({
                                    title: '{{__('Edit Element')}}',
                                    html:
                                        '<input id="swal-input1" value="' + label_text + '" class="swal2-input" placeholder="Name">' +
                                        '<input id="swal-input2" value="' + description_text + '" class="swal2-input" placeholder="Description">' +
                                        Object.keys(object_settings).map(function (key) {
                                            if (object_settings[key] === true) {
                                                return '<div style="display:flex;justify-content:center;margin:20px"> <label style="margin-bottom:0px;margin-right:50px" for="swal-input-' + key + '">' + key + '</label>' + '<input id="swal-input-' + key + '" type="checkbox" placeholder="' + key + '" checked> </div>'
                                            }
                                            return '<div style="display:flex;justify-content:center;margin:20px"> <label style="margin-bottom:0px;margin-right:50px" for="swal-input-' + key + '">' + key + '</label>' + '<input id="swal-input-' + key + '" type="checkbox" placeholder="' + key + '"> </div>'
                                        }).join(''),
                                    focusConfirm: false,
                                    preConfirm: () => {
                                        //Get the values entered in the pop-up form
                                        return [
                                            document.getElementById('swal-input1').value,
                                            document.getElementById('swal-input2').value,
                                            Object.keys(object_settings).map(function (key) {
                                                return document.getElementById('swal-input-' + key.value)
                                            }),
                                        ]
                                    }
                                }).then((result) => { //Update the settings based on the values entered in the pop-up form
                                    if (result.isConfirmed) {
                                        object_settings = {
                                            "hasBackup": document.getElementById('swal-input-hasBackup').checked,
                                            "hasFirewall": document.getElementById('swal-input-hasFirewall').checked,
                                            "hasEncryption": document.getElementById('swal-input-hasEncryption').checked,
                                            "hasMemoryPassword": document.getElementById('swal-input-hasMemoryPassword').checked,
                                            "hasPassword": document.getElementById('swal-input-hasPassword').checked,
                                            "hasUserManagement": document.getElementById('swal-input-hasUserManagement').checked
                                        };
                                        //Update the element's attributes with the new values
                                        label_text = result.value[0];
                                        description_text = result.value[1];
                                        element.attr({
                                            label: {
                                                text: label_text ? label_text : '',
                                            },
                                            description: {
                                                text: description_text ? description_text : '',
                                            },
                                            settings: object_settings
                                        });
                                    }
                                });
                            },
                        },
                        'hr',
                        //Delete option
                        {
                            label: '{{__('Delete')}}',
                            callback: (mouseevent) => {
                                // Remove the selected element(s) from the graph
                                if(selection.length > 1) {
                                    selection.forEach((element) => {
                                        graph.removeCells(element);
                                    });
                                } else {
                                    graph.removeCells(element);
                                }
                                selection = [];
                            },
                        },
                        'hr',
                        //Select Option
                        {
                            label: '{{__('Select')}}',
                            callback: (mouseevent) => {
                                selectOneElement(element)
                            }
                        },
                        'hr',
                        //Clone Option
                        {
                            label: '{{__('Clone')}}',
                            callback: (mouseevent) => {
                                if(selection.length > 1) {
                                    selection.forEach((element) => {
                                        cloneElement(element, graph)
                                    });
                                } else {
                                    cloneElement(element, graph)
                                }
                            },
                        }
                    ]
                })
            }

            // Context menu on page load/reload
            graph.getElements().forEach(function (element, i) { //cids vergleichen
                addContextMenuToObject(element);
            });
        </script>

    @endpush

@endsection


