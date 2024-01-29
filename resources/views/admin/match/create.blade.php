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
                <form action="{{ route('match.store') }}" method="post" onsubmit="return checkFieldSide()">
                    @csrf
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6 col-sm-12">
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
                                    <label class="form-label" for="date">Date <code>*</code></label>
                                    <input type="date" min="{{@Helper::league()->start_date}}"  max="{{@Helper::league()->end_date}}" class="form-control" name="date" id="date" required
                                        value="{{ old('date') }}">
                                    @if ($errors->has('date'))
                                        <span class="text-danger">{{ $errors->first('date') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="home_team_id">Home Team <code>*</code></label>
                                    <select class="form-control" name="home_team_id" id="home_team_id" required>
                                        @foreach ($teams as $team)
                                            <option value="{{ $team->id }}"
                                                @if (old('home_team_id') == $team->id) selected @endif>{{ $team->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('home_team_id'))
                                        <span class="text-danger">{{ $errors->first('home_team_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="away_team_id">Away Team<code>*</code></label>
                                    <select class="form-control" name="away_team_id" id="away_team_id" required>
                                        @foreach ($teams as $team)
                                            <option value="{{ $team->id }}"
                                                @if (old('away_team_id') == $team->id) selected @endif>{{ $team->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('away_team_id'))
                                        <span class="text-danger">{{ $errors->first('away_team_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="user_id">Referee<code>*</code></label>
                                    <select class="form-control" name="user_id" id="user_id" required>
                                        <option value="">--- select referee --- </option>
                                         @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if (old('user_id') == $user->id) selected @endif>{{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('user_id'))
                                        <span class="text-danger">{{ $errors->first('user_id') }}</span>
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
@section('custom-script')
    <script>
        function checkFieldSide() {
            var val1 = $('#home_team_id').val();
            var val2 = $('#away_team_id').val();

            if (val1 == val2) {
                alert('Home Team and Away Team is same');
                return false;
            } else {
                return true;
            }

        }
    </script>
@endsection
