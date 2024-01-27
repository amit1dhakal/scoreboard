@extends('layouts.master')
@section('content')
    <main>
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Match Create</h6>
                        </div>

                    </div>
                </div>
                <form action="{{ route('match.store') }}" method="post">
                    @csrf
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="name">Name <code>*</code></label>
                                    <input type="text" class="form-control" name="name" id="name" required
                                        value="{{ old('name') }}">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="team1_id">Team 1 <code>*</code></label>
                                    <select  class="form-control" name="team1_id" id="team1_id" required > 
                                       @foreach($teams as $team)
                                       <option value="{{$team->id}}" @if(old('team1_id')==$team->id) selected @endif>{{$team->name}}</option>
                                       @endforeach
                                    </select>
                                    @if ($errors->has('team1_id'))
                                        <span class="text-danger">{{ $errors->first('team1_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="team2_id">Team 2 <code>*</code></label>
                                    <select  class="form-control" name="team2_id" id="team2_id" required
                                       > 
                                       @foreach($teams as $team)
                                       <option value="{{$team->id}}" @if(old('team2_id')==$team->id) selected @endif>{{$team->name}}</option>
                                       @endforeach
                                    </select>
                                    @if ($errors->has('team2_id'))
                                        <span class="text-danger">{{ $errors->first('team2_id') }}</span>
                                    @endif
                                </div>
                            </div>
                           


                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary"> Submit <i
                                class="fa-solid fa-paper-plane"></i></button>
                    </div>

                </form>
            </div>
        </div>
    </main>
@endsection
