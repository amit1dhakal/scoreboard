@extends('layouts.master')
@section('content')
    <main>
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Team Add</h6>
                        </div>

                    </div>
                </div>
                <form action="{{ route('team.store') }}" method="post">
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
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="player_ids">Select Players <code>*</code></label>
                                    @if ($errors->has('player_ids'))
                                        <span class="text-danger">{{ $errors->first('player_ids') }}</span>
                                    @endif
                                     <div class="row">
                                        @foreach($players as $player)
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <input type="checkbox" name="player_ids[]" value="{{$player->id}}"> {{$player->name}} ({{$player->jersey_no}})
                                        </div>
                                        @endforeach
                                     </div>
                                    
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
