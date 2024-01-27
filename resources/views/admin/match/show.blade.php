@extends('layouts.master')
@section('content')
    <main>
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <h6>Match Details</h6>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            @include('admin.include.matchstatus')
                        </div>
                        @if (@Helper::league()->status == 1)
                            <div class="col-md-4 col-sm-12 text-right">
                                @if ($match->status < 4)
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#matchStart">
                                        @if ($match->status == 0)
                                            Start
                                        @elseif($match->status == 1)
                                            Break
                                        @elseif($match->status == 2)
                                            Second Half Start
                                        @else
                                            End Match
                                        @endif
                                    </button>
                                @endif
                            </div>

                            <div class="modal fade" id="matchStart" data-bs-backdrop="static" data-bs-keyboard="false"
                                tabindex="-1" aria-labelledby="matchStartLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="matchStartLabel">
                                                @if ($match->status == 0)
                                                    Start the Match
                                                @elseif($match->status == 1)
                                                    Break
                                                @elseif($match->status == 2)
                                                    Second Half Start
                                                @else
                                                    End The Match
                                                @endif
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('match.statuschange', $match->slug) }}" method="post"
                                            @if ($match->status == 0) onsubmit="return checkFieldSide()" @endif>
                                            @csrf
                                            <div class="modal-body">
                                                @if ($match->status == 0)
                                                    <div class="row">
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
                                                    </div>
                                                @elseif($match->status == 1)
                                                    <p>Break time start now </p>
                                                @elseif($match->status == 2)
                                                    <p>Second haif start now </p>
                                                @elseif($match->status == 3)
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                            for="name">Who Win the Match
                                                            <code>*</code></label>
                                                        <select type="text" class="form-control" name="winner_team_id" required>
                                                            <option value="">  ---select the team -- </option>
                                                            @foreach ($match->teams($match->team_ids) as $winteam)
                                                            <option value="{{$winteam->id}}"> {{$winteam->name}}</option>
                                                            @endforeach
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
                        @endif

                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        @foreach ($match->teams($match->team_ids) as $team)
                            <div class="col-md-6 col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>{{ $team->name }} ({{ $team->field_site ?? 'Home' }})</h6>

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
                                                @php
                                                    $total_goal = 0;
                                                    $total_foul = 0;
                                                @endphp
                                                @foreach ($team->players($team->player_ids) as $player)
                                                    @php
                                                        $goal = $player->goal($match->id)->count();
                                                        $foul = $player->foul($match->id)->count();
                                                        $total_goal = $total_goal + $goal;
                                                        $total_foul = $total_foul + $foul;

                                                    @endphp
                                                    <tr>
                                                        <td> {{ $loop->iteration }} </td>
                                                        <td> {{ $player->name }} ({{ $player->jersey_no }}) </td>
                                                        <td> {{ $goal }} </td>
                                                        <td> {{ $foul }} </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>

                                                    <th colspan="2" class="text-right">Total : </th>
                                                    <th> {{ $total_goal }} </th>
                                                    <th> {{ $total_foul }} </th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    @if (in_array($match->status, [1, 3]))
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <form method="post" action="{{ route('goal.store') }}">
                                                        @csrf
                                                        <input type="hidden" name="match_id" value="{{ $match->id }}">
                                                        <input type="hidden" name="team_id" value="{{ $team->id }}">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <select class="form-control" name="player_id" required>
                                                                        <option value="">--- Select Player ---
                                                                        </option>
                                                                        @foreach ($team->players($team->player_ids) as $playersel)
                                                                            <option value="{{ $playersel->id }}">
                                                                                {{ $playersel->name }}
                                                                                ({{ $playersel->jersey_no }})
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="form-group">
                                                                    <select class="form-control" name="type" required>
                                                                        <option value="">--- Select Type --- </option>
                                                                        <option value="Goal">Goal </option>
                                                                        <option value="Foul">Foul </option>

                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-2">
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
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
                 
                @if($match->status ==4)
                <div class="card-footer">
                    Winner : {{$match->winnterteam->name??""}}
                </div>
                @endif

            </div>
        </div>
    </main>
@endsection

@section('custom-script')
    <script>
        function checkFieldSide() {
            var val1 = $('#field_side_1').val();
            var val2 = $('#field_side_2').val();

            if (val1 == val2) {
                alert('You are selected the same field for both team')
                return false;
            } else {
                return true;
            }

        }
    </script>
@endsection
