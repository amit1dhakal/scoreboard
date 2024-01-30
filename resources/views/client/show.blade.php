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
                        <div class="col-md-8 col-sm-12">

                            <span class="badge bg-secondary"> Match Date :
                                {{ Carbon\Carbon::parse($match->date)->format('M-d, Y') }} </span>
                            @include('admin.include.matchstatus')

                        </div>


                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        {{-- home team --}}
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

                            </div>
                        </div>
                        {{-- home team section end --}}
                        {{-- away team --}}
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

                            </div>
                        </div>
                        {{-- away team section end --}}

                    </div>
                </div>


                <div class="card-footer d-flex justify-content-between">

                    <div>
                        @if ($match->status == 4)
                            Winner : {{ $match->winnerteam->name ?? '' }}
                        @endif
                    </div>

                    <div> Game Referee: {{ $match->referee->name ?? '' }} </div>
                </div>


            </div>

    </main>
@endsection
