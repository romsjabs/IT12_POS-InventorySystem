@extends('layouts.dashboard')

@section('title', 'Users')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/style-dashboard-users.css') }}">
@endsection

@section('content')
<div class="wrapper2">

    <h1>Users</h1>

    <div class="users">

        <div class="users-tab">

            <div class="user-search">

                <i class="fa-solid fa-magnifying-glass"></i>

                <input type="search" id="users-search" name="search" placeholder="Search..">

            </div>

            <div class="buttons">
            
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#new-modal">
                    <i class="fa-solid fa-plus"></i>
                    <span>New</span>
                </button>

            </div>

        </div>

        <div class="users-table">
            
            <table class="table table-hover users" id="users-table">

                <thead>
                    <tr>
                        <th class="table-row" scope="col">User ID</th>
                        <th class="table-row" scope="col">Date registered</th>
                        <th class="table-row" scope="col">Username</th>
                        <th class="table-row" scope="col">Name</th>
                        <th class="table-row" scope="col">Role</th>
                        <th class="table-row" scope="col">Action</th>
                    </tr>
                </thead>

                <tbody id="users-table-body">
                    @forelse ($users as $user)
                    <tr>
                        <td class="table-data">{{ $user->id }}</td>
                        <td class="table-data">
                            {{ $user->created_at
                                ->timezone('Asia/Manila')
                                ->format('Y-m-d h:i A') }}
                        </td>
                        <td class="table-data">
                            {{ $user->username }}
                        </td>
                        <td class="table-data fw-bold">
                            @if ($user->userRecord)
                                {{ strtoupper($user->userRecord->lastname) }},
                                @if ($user->userRecord->extension)
                                    {{ strtoupper($user->userRecord->extension) }}
                                @endif
                                {{ strtoupper($user->userRecord->firstname) }}
                                @if ($user->userRecord->middlename)
                                    {{ strtoupper($user->userRecord->middlename[0]) }}.
                                @endif
                            @else
                                undefined
                            @endif
                        </td>
                        <td class="table-data">
                            {{ ucfirst($user->role) }}
                        </td>
                        <td class="table-data">

                            <span class="view-btn">

                                <button type="button" class="btn btn-primary btn-sm view-user" data-bs-toggle="modal" data-bs-target="#userInfoModal"
                                data-id="{{ $user->id }}"
                                data-username="{{ $user->username }}"
                                data-email="{{ $user->email }}"
                                data-role="{{ $user->role }}"
                                data-created="{{ $user->created_at->timezone('Asia/Manila')->format('Y-m-d h:i A') }}"
                                
                                @if ($user->userRecord)
                                    data-firstname="{{ $user->userRecord->firstname }}"
                                    data-middlename="{{ $user->userRecord->middlename }}"
                                    data-lastname="{{ $user->userRecord->lastname }}"
                                    data-extension="{{ $user->userRecord->extension }}"
                                    data-gender="{{ $user->userRecord->gender }}"
                                    data-birthdate="{{ $user->userRecord->birthdate }}"
                                @endif>
                                    <i class="fa-solid fa-eye view"></i>
                                    <span>View</span>
                                </button>
                                
                            </span>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center fw-bold">No users found.</td>
                    </tr>
                    @endforelse
                    <tr id="users-no-results" style="display: none;">
                        <td colspan="6" class="text-center fw-bold">No results   found.</td>
                    </tr>
                </tbody>

            </table>

        </div>

    </div>

</div>

@include('dashboard.modals.users.info')

@endsection