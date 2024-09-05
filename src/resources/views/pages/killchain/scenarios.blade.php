<?php
if (!isset($scenarios)) {
    exit ("Scnearios.blade: scenarios is undefined. Please reload this page or contact the webmaster if this problem still remains.");
}
?>

@extends('layouts.user_type.auth')
@section('content')
    {{-- <div class="search-bar">
        <input class="" type="text" id="searchInput" placeholder="Search...">
    </div> --}}
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Phase #</th>
            <th scope="col">Phase Name</th>
        </tr>
        </thead>
        <tbody>
        @foreach($hackersteps as $step)
            <tr>
                <th scope="row">{{ $step->hackerattackstep_id }}</th>
                <td> {{ $step->name }} </td>
                <td> {{ $step->phase_id }} </td>
                <td> {{ $step->phase->name }} </td>
            </tr>
        @endforeach

        </tbody>
    </table>

    <script>
        const searchInput = document.getElementById('searchInput');
        const dataTable = document.getElementById('dataTable');
        const rows = dataTable.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

        searchInput.addEventListener('input', function () {
            const searchText = searchInput.value.toLowerCase();
            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                const rowData = row.textContent.toLowerCase();
                if (rowData.includes(searchText)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });

        const addbtn = document.getElementById('');

    </script>
@endsection
