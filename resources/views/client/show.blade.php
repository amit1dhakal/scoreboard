@extends('layouts.master')
@section('content')
    <main class="loginpage">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-6 col-sm-12">
                    <div class="card">
                        <div class="card-header scoreboardheader">
                            <div> Score Board </div>
                            <div id="matchStatusUpdate_{{ $match->slug }}"> @include('admin.include.matchstatus') </div>
                        </div>

                        <div class="card-body scoreboard">
                            <div class="display-time" id="timeDisplay_{{$match->slug}}">
                               {{Helper::timeCorrection($match->time)}}
                            </div>
                            <hr />
                            <div class="display-team">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="team-name">{{ $match->hometeam->name ?? '' }}</div>
                                          <h6>Goals</h6>
                                        <div class="team-score" id="homeScoreDisplay_{{ $match->slug }}">
                                            {{ $match->goal->where('team_id', $match->hometeam->id)->count() ?? '' }}</div>
                                    </div>
                                    <div class="col-6">
                                        <div class="team-name">{{ $match->awayteam->name ?? '' }}</div>
                                        <h6>Goals</h6>
                                        <div class="team-score" id="awayScoreDisplay_{{ $match->slug }}">
                                            {{ $match->goal->where('team_id', $match->awayteam->id)->count() ?? '' }}</div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <h6>Fouls</h6>
                                        <div class="team-score" id="homeFoulDisplay_{{ $match->slug }}">
                                            {{ $match->foul->where('team_id', $match->hometeam->id)->count() ?? '' }}</div>
                                    </div>
                                    <div class="col-6">
                                        <h6>Fouls</h6>
                                        <div class="team-score" id="awayFoulDisplay_{{ $match->slug }}">
                                            {{ $match->foul->where('team_id', $match->awayteam->id)->count() ?? '' }}</div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer displayMatchFooter" id="lastEventDisplay_{{$match->slug}}">
                            <p>@isset($match->allgoalfoul->first()->player)
                                {{ 'Last '. $match->allgoalfoul->first()->type.' by '. $match->allgoalfoul->first()->player->name}} ({{$match->allgoalfoul->first()->player->jersey_no}}) at {{$match->allgoalfoul->first()->event_time}} minutes for {{$match->allgoalfoul->first()->team->name}}
                                @endisset 
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>

    {{-- <button onclick="copyStartDate()">CLick </button> --}}
@endsection

@section('custom-script')
    <!-- Laravel Echo -->

    <!-- Pusher -->
   
@endsection
