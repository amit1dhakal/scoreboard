@extends('layouts.master')
@section('content')
    <main>
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-3 col-sm-12">
                            <h5>Match Details</h5>
                        </div>
                        <div class="col-md-7 col-sm-12" style="justify-content:space-between;">
                            <span class="badge bg-warning"> Referee: {{ $match->referee->name ?? '' }}
                            </span>

                            <span class="badge bg-secondary"> Match Date :
                                {{ Carbon\Carbon::parse($match->date)->format('M-d, Y') }} </span>

                            @if (in_array($match->status, [1, 2, 3]))
                                <span class="badge bg-info"> Match Time :
                                    <span id="adminDisplayTime_{{ $match->slug }}">
                                        {{ Helper::timeCorrection($match->time) }} </span>
                                </span>
                            @endif
                            @include('admin.include.matchstatus')
                        </div>

                        @if (@Helper::league()->status == 1 && $match->date == date('Y-m-d'))
                            <div class="col-md-2 col-sm-12 text-right">
                                @if ($match->status < 4)
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#matchStart">
                                        @if ($match->status == 0)
                                            Start
                                        @elseif($match->status == 1)
                                            Break Time
                                        @elseif($match->status == 2)
                                            Second Half Start
                                        @else
                                            End Match
                                        @endif
                                    </button>
                                @endif


                            </div>
                            {{-- match status update section --}}
                            <div class="modal fade" id="matchStart" data-bs-backdrop="static" data-bs-keyboard="false"
                                tabindex="-1" aria-labelledby="matchStartLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="matchStartLabel">
                                                @if ($match->status == 0)
                                                    Start the Match
                                                @elseif($match->status == 1)
                                                    Break Time
                                                @elseif($match->status == 2)
                                                    Second Half Start
                                                @else
                                                    End The Match
                                                @endif
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('match.statuschange', $match->slug) }}" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                @if ($match->status == 0)
                                                    <p>Let's Start The Match </p>
                                                    {{-- <div class="row">
                                                        @foreach ($match->teams($match->team_ids) as $teamstatuschange)
                                                            <input type="hidden" name="team_ids[]"
                                                                value="{{ $teamstatuschange->id }}">
                                                            <div class="col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="name">{{ $teamstatuschange->name }}
                                                                        <code>*</code></label>
                                                                    <select type="text" class="form-control"
                                                                        id="field_side_{{ $loop->iteration }}"
                                                                        name="field_sites[]" required>
                                                                        <option
                                                                            @if ($teamstatuschange->field_site == 'Home') selected @endif>
                                                                            Home</option>
                                                                        <option
                                                                            @if ($teamstatuschange->field_site == 'Away') selected @endif>
                                                                            Away</option>
                                                                    </select>

                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div> --}}
                                                @elseif($match->status == 1)
                                                    <p>Break time start now </p>
                                                @elseif($match->status == 2)
                                                    <p>Second half start now </p>
                                                @elseif($match->status == 3)
                                                    <div class="col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="name">Who Win the Match
                                                                <code>*</code></label>
                                                            <select type="text" class="form-control"
                                                                name="winner_team_id" required>
                                                                <option value=""> ---select the team -- </option>
                                                                <option value="{{ $match->hometeam->id }}">
                                                                    {{ $match->hometeam->name }}</option>
                                                                <option value="{{ $match->awayteam->id }}">
                                                                    {{ $match->awayteam->name }}</option>

                                                            </select>

                                                        </div>
                                                    </div>
                                                @endif

                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary"> Done <i
                                                        class="fa-solid fa-paper-plane"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- match status update section  end --}}
                        @else
                         @if(@Helper::league()->status == 0 )
                            <div class="col-md-2 col-sm-12">
                                <p class="text-danger">League is not Started</p>
                            </div>
                            @endif
                        @endif


                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        {{-- home team section start --}}
                        <div class="col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6>{{ $match->hometeam->name }}</h6>

                                </div>
                                <div class="card-body">
                                    <table class="table table-responsive">
                                        <thead>
                                            <tr>
                                                <th> S.N. </th>
                                                <th> Name </th>
                                                <th> Goals </th>
                                                <th> Fouls </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($match->hometeam->player as $homewayplayer)
                                                <tr>
                                                    <td> {{ $loop->iteration }} </td>
                                                    <td> {{ $homewayplayer->name }} ({{ $homewayplayer->jersey_no }})
                                                    </td>
                                                    <td> {{ $match->goal->where('player_id', $homewayplayer->id)->count() ?? 0 }}
                                                    </td>
                                                    <td> {{ $match->foul->where('player_id', $homewayplayer->id)->count() ?? 0 }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>

                                                <th colspan="2" class="text-right">Total : </th>
                                                <th> {{ $match->goal->where('team_id', $match->hometeam->id)->count() ?? 0 }}
                                                </th>
                                                <th> {{ $match->foul->where('team_id', $match->hometeam->id)->count() ?? 0 }}
                                                </th>

                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                {{-- goal or foul update section start for home team --}}
                                @if (in_array($match->status, [1, 3]))
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <form method="post" action="{{ route('goal.store') }}">
                                                    @csrf
                                                    <input type="hidden" name="match_id" value="{{ $match->id }}">
                                                    <input type="hidden" name="team_id"
                                                        value="{{ $match->hometeam->id }}">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <select class="form-control" name="player_id" required>
                                                                    <option value="">--- Select Player ---
                                                                    </option>
                                                                    @foreach ($match->hometeam->player as $homeplayersel)
                                                                        <option value="{{ $homeplayersel->id }}">
                                                                            {{ $homeplayersel->name }}
                                                                            ({{ $homeplayersel->jersey_no }})
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <select class="form-control" name="type" required>
                                                                    <option value="">--- Select Type --- </option>
                                                                    <option value="Goal">Goal </option>
                                                                    <option value="Foul">Foul </option>

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-10 mt-2">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Remarks..." name="remarks">
                                                            </div>
                                                        </div>
                                                        <div class="col-2 mt-2">
                                                            <div class="form-group">
                                                                <button type="submit" class="btn btn-sm btn-primary"><i
                                                                        class="fa-solid fa-paper-plane"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                {{-- goal or foul update section end for home team --}}
                            </div>
                        </div>
                        {{-- home team section end --}}
                        {{-- away team section start --}}
                        <div class="col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6>{{ $match->awayteam->name }}</h6>

                                </div>
                                <div class="card-body">
                                    <table class="table table-responsive">
                                        <thead>
                                            <tr>
                                                <th> S.N. </th>
                                                <th> Name </th>
                                                <th> Goals </th>
                                                <th> Fouls </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($match->awayteam->player as $awaywayplayer)
                                                <tr>
                                                    <td> {{ $loop->iteration }} </td>
                                                    <td> {{ $awaywayplayer->name }} ({{ $awaywayplayer->jersey_no }})
                                                    </td>
                                                    <td> {{ $match->goal->where('player_id', $awaywayplayer->id)->count() ?? 0 }}
                                                    </td>
                                                    <td> {{ $match->foul->where('player_id', $awaywayplayer->id)->count() ?? 0 }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>

                                                <th colspan="2" class="text-right">Total : </th>
                                                <th> {{ $match->goal->where('team_id', $match->awayteam->id)->count() ?? 0 }}
                                                </th>
                                                <th> {{ $match->foul->where('team_id', $match->awayteam->id)->count() ?? 0 }}
                                                </th>

                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                {{-- goal or foul update section start for away team --}}
                                @if (in_array($match->status, [1, 3]))
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <form method="post" action="{{ route('goal.store') }}">
                                                    @csrf
                                                    <input type="hidden" name="match_id" value="{{ $match->id }}">
                                                    <input type="hidden" name="team_id"
                                                        value="{{ $match->awayteam->id }}">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <select class="form-control" name="player_id" required>
                                                                    <option value="">--- Select Player ---
                                                                    </option>
                                                                    @foreach ($match->awayteam->player as $awayplayersel)
                                                                        <option value="{{ $awayplayersel->id }}">
                                                                            {{ $awayplayersel->name }}
                                                                            ({{ $awayplayersel->jersey_no }})
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <select class="form-control" name="type" required>
                                                                    <option value="">--- Select Type --- </option>
                                                                    <option value="Goal">Goal </option>
                                                                    <option value="Foul">Foul </option>

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-10 mt-2">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Remarks..." name="remarks">
                                                            </div>
                                                        </div>
                                                        <div class="col-2 mt-2">
                                                            <div class="form-group">
                                                                <button type="submit" class="btn btn-sm btn-primary"><i
                                                                        class="fa-solid fa-paper-plane"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                {{-- goal or foul update section end for away team --}}
                            </div>
                        </div>
                        {{-- away team section end --}}

                    </div>
                </div>

                @if ($match->status == 4)
                    <div class="card-footer">
                        Winner : {{ $match->winnerteam->name ?? '' }}
                    </div>
                @endif

            </div>
            <br />
            {{-- last 5 svents section --}}
            <div class="card">
                <div class="card-header">
                    <h6>Last Five Events </h6>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>S.N.</th>
                                <th>Team Name</th>
                                <th>Player Name</th>
                                <th>Goal/Foul</th>
                                <th>Event Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <body>
                            @foreach ($match->allgoalfoul->take(5) as $goalfoul)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $goalfoul->team->name ?? '' }}</td>
                                    <td>{{ $goalfoul->player->name ?? '' }} ({{ $goalfoul->player->jersey_no ?? '' }})
                                    </td>
                                    <td>{{ $goalfoul->type }} @if ($goalfoul->remarks)
                                            ({{ $goalfoul->remarks }})
                                        @endif
                                    </td>
                                    <td>at {{ $goalfoul->event_time }} minutes</td>
                                    <td>
                                        @if (in_array($match->status, [1, 2, 3]) && $loop->iteration == 1)
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#goalEdit1"><i class="fas fa-edit"></i> Edit </button>

                                            <div class="modal fade" id="goalEdit1" data-bs-backdrop="static"
                                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="matchStartLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-md">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="matchStartLabel">
                                                                Edit last Event
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('goal.update') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="goal_id"
                                                                value="{{ $goalfoul->id }}">
                                                            <div class="modal-body">

                                                                <div class="col-md-12 col-sm-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="type"> Type
                                                                            <code>*</code></label>
                                                                        <select type="text" class="form-control"
                                                                            name="type" required>
                                                                            <option value=""> ---select Type --
                                                                            </option>
                                                                            <option value="Goal"
                                                                                @if ($goalfoul->type == 'Goal') selected @endif>
                                                                                Goal </option>
                                                                            <option value="Foul"
                                                                                @if ($goalfoul->type == 'Foul') selected @endif>
                                                                                Foul</option>
                                                                        </select>

                                                                    </div>
                                                                </div>
                                                                @php
                                                                    $forgoalupdate = $goalfoul->team_id == $match->home_team_id ? $match->hometeam->player : $match->awayteam->player;
                                                                @endphp
                                                                <div class="col-md-12 col-sm-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="type"> Player
                                                                            <code>*</code></label>
                                                                        <select type="text" class="form-control"
                                                                            name="player_id" required>
                                                                            <option value=""> ---select Player --
                                                                            </option>
                                                                            @foreach ($forgoalupdate as $goalupdatep)
                                                                                <option value="{{ $goalupdatep->id }}"
                                                                                    @if ($goalupdatep->id == $goalfoul->player_id) selected @endif>
                                                                                    {{ $goalupdatep->name }}
                                                                                    ({{ $goalupdatep->jersey_no }})
                                                                                </option>
                                                                            @endforeach
                                                                        </select>

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 col-sm-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label"> Remarks </label>
                                                                        <input type="text" name="reamrks"
                                                                            class="form-control" placeholder="Remarks...."
                                                                            value="{{ $goalfoul->remarks }}">
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary"> Done <i
                                                                        class="fa-solid fa-paper-plane"></i></button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </body>
                    </table>
                </div>
            </div>
            {{-- last 5 svents section end --}}
    </main>

@endsection

@section('custom-script')
@endsection
