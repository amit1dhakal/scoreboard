@extends('layouts.master')
@section('content')
    <main>
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Player Edit</h6>
                        </div>

                    </div>
                </div>
                <form action="{{ route('player.update', $player->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="name">Name <code>*</code></label>
                                    <input type="text" class="form-control" name="name" id="name" required
                                        value="{{ old('name') ?? $player->name }}">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="jersey_no">Jersey No <code>*</code></label>
                                    <input type="text" class="form-control" name="jersey_no" id="jersey_no" required
                                        value="{{ old('jersey_no') ?? $player->jersey_no }}">
                                    @if ($errors->has('jersey_no'))
                                        <span class="text-danger">{{ $errors->first('jersey_no') }}</span>
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
