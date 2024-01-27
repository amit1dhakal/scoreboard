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
                         <h4>403</h4>
                         <p>You have not allow this page</p>
                         <p><a href="{{route('client.index')}}">Go to Home </a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
