<!-- Start Navbar -->
<!-- creation and positioning of the applications Navigation bar using bootstrap classes -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">

                <!-- places the Tackle logo in the top left corner and makes it a hyperlink that takes you back to the map selection page. -->
                <li> <a class="align-items-center d-flex m-0 navbar-brand text-wrap" href="{{ route('maps.index') }}">
                        <!-- Tackle logo -->
                        <img src="{{ asset('assets/img/tackle-logo/tackle_512px.png') }}" class="navbar-brand-img h-100" alt="..."
                         width="40" height="40">
                    </a>
                <li/>

                <!-- shows the name of the current map in the navbar -->
                <!-- workaround mit blade isset -->
                @isset($map)
                <li>
                    <h3 class="map-title">{{__('Map')}} {{ $map->name }}</h3>
                </li>
                @endisset

                <style>
                    .padding{
                        margin-left: 8px
                    }
                    .map-title {
                        margin-left: 8px;
                        font-size: 1.25rem; /* Make the title smaller */
                        font-weight: normal; /* Adjust weight if necessary */
                        font-family: inherit; /* Use the same font as the buttons */
                    }
                </style>
            </ol>
        </nav>

        <style>
            p{
                margin-left: 5px;
            }
        </style>


        <!-- creates the right part of the navbar with the buttons -->
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 d-flex justify-content-end" id="navbar">
            <ul class="navbar-nav  justify-content-end">

                <li class="px-3 nav-item d-flex align-items-center"></li>

                <!-- button to return to the map selection page -->
                <li class="px-3 nav-item d-flex align-items-center">
                    <a href="{{ url('maps')}}" class="nav-link text-body font-weight-bold px-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-map" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15.817.113A.5.5 0 0 1 16 .5v14a.5.5 0 0 1-.402.49l-5 1a.502.502 0 0 1-.196 0L5.5 15.01l-4.902.98A.5.5 0 0 1 0 15.5v-14a.5.5 0 0 1 .402-.49l5-1a.5.5 0 0 1 .196 0L10.5.99l4.902-.98a.5.5 0 0 1 .415.103zM10 1.91l-4-.8v12.98l4 .8V1.91zm1 12.98 4-.8V1.11l-4 .8v12.98zm-6-.8V1.11l-4 .8v12.98l4-.8z"/>
                        </svg>
                        <span class="d-sm-inline d-none">Maps</span>
                    </a>
                </li>

                <!-- button to get to the Kill-Chain page -->
                <li class="px-3 nav-item d-flex align-items-center">
                    <a href="{{ route('killchain.index') }}" class="nav-link text-body font-weight-bold px-0">
                        <i class="fas fa-solid fa-link ps-2 pe-2 text-center text-dark"></i>
                        <span class="d-sm-inline d-none">Kill-Chain</span>
                    </a>
                </li>

                <!-- Sign out button -->
                <li class="px-3 nav-item d-flex align-items-center">
                    <a href="{{ url('/logout')}}" class="nav-link text-body font-weight-bold px-0">
                        <i class="fa fa-user me-sm-1"></i>
                        <span class="d-sm-inline d-none">{{__('Sign out')}}</span>
                    </a>
                </li>

                <!-- Button to access the Profile Settings page
                     this will take you to a page where you can create or select a company profile src/resources/views/company/selectProfile.blade.php
                     and once you have selected a company profile, will take you to the settings page src/resources/views/company/settings.blade.php
                -->

                <li class="nav-item px-3 d-flex align-items-center">
                    <a href="{{ url('/settings') }}" class="nav-link text-body p-0">
                    <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                        <span class="d-sm-inline d-none">Profile Settings</span>
                    </a>
                </li>

                <!-- drop down menu to switch language (currently English and German)-->
                <li class="switch">
                    @include('components.language-switch')
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->
