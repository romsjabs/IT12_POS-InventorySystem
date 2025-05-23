@extends('layouts.dashboard')

@section('title', 'Attendance')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/style-dashboard-attendance.css') }}">
@endsection

@section('content')
<div class="wrapper2">

    <h1>Attendance</h1>

    <div class="attendance">

        <div class="attendance-tab">

            <div class="attendance-search">

                <i class="fa-solid fa-magnifying-glass"></i>

                <input type="search" id="attendance-search" name="search" placeholder="Search..">

            </div>

            <div class="buttons">
            
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#new-modal">
                    New
                </button>
                @if ($attendance->count() > 0)
                    <button type="button" class="btn btn-secondary btn-sm">Edit</button>
                    <button type="button" class="btn btn-secondary btn-sm">Cancel</button>
                @endif

            </div>

        </div>

        <div class="attendance-table">

            <table class="table table-hover attendance" id="attendance-table">

                <thead>
                    <tr>
                        <th scope="col">User ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Time-in</th>
                        <th scope="col">Time-out</th>
                        <th scope="col">Estimated rate</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>

                <tbody id="attendance-table-body">
                    @foreach ($attendance as $record)
                    <tr>
                        <td class="table-data"></td>
                        <td class="table-data"></td>
                        <td class="table-data"></td>
                        <td class="table-data"></td>
                        <td class="table-data"></td>
                        <td class="table-data"></td>
                        <td class="table-data"></td>
                    </tr>
                    @endforeach
                </tbody>

            </table>

        </div>

    </div>

</div>
@endsection