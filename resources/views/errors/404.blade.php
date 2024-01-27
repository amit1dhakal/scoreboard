@extends('layouts.master')
@section('content')
<style>
    .error-body{
     text-align: center;
    }
    </style>

    <main class="loginpage">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-sm-12">
                    <div class="card">

                        <div class="card-body error-body" >
                         <h4>404</h4>
                         <p>This page is not found</p>
                         <p><a href="{{route('client.index')}}">Go to Home </a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
