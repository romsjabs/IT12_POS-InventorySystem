@extends('layouts.master')

@section('title', 'Users')

@include('partials.dashboard-menu')

@section('content')
<div class="wrapper2">

    <h1>Users</h1>

    <div class="products">

        <div class="products-tab">

            <div class="product-search">

                <i class="fa-solid fa-magnifying-glass"></i>

                <input type="search" id="session-search" name="search" placeholder="Search..">

            </div>

            <div class="buttons">
            
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#new-modal">New</button>
                <button type="button" class="btn btn-secondary btn-sm">Edit</button>
                <button type="button" class="btn btn-secondary btn-sm">Save</button>
                <button type="button" class="btn btn-danger btn-sm">Delete</button>

            </div>

        </div>

        <div class="products-table">

            <table class="table table-hover products">

                <thead>
                    <tr>
                        <th scope="col">User ID</th>
                        <th scope="col">Date registered</th>
                        <th scope="col">Username</th>
                        <th scope="col">Name</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>0001</td>
                        <td>2025-01-01</td>
                        <td>romsjabs</td>
                        <td>Last, First M.I.</td>
                    </tr>
                </tbody>

            </table>

        </div>

    </div>

</div>
@endsection