@extends('layouts.master')
@section('content')
    <main class="loginpage">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-sm-12">
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
                                {{ 'Last '. $match->allgoalfoul->first()->type.' by '. $match->allgoalfoul->first()->player->name}} ({{$match->allgoalfoul->first()->player->jersey_no}}) - {{$match->allgoalfoul->first()->team->name}}
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
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>


    <script>
        //  function copyStartDate(){
        //     $('#homeScoreDisplay').html('23');
        //         $('#awayScoreDisplay').html('34');
        //     }
        Pusher.logToConsole = true;

        var pusher = new Pusher('39402eab979ec3288429', {
            cluster: 'mt1'
        });

        var channel = pusher.subscribe('score-board-update');
        channel.bind('scoreboardupdate-event', function(data) {
            // console.log(data.data)
            document.getElementById('homeScoreDisplay_' + data.data.slug).innerHTML = data.data.homeScore;
            document.getElementById('awayScoreDisplay_' + data.data.slug).innerHTML = data.data.awayScore;

            document.getElementById('homeFoulDisplay_' + data.data.slug).innerHTML = data.data.homeFoul;
            document.getElementById('awayFoulDisplay_' + data.data.slug).innerHTML = data.data.awayFoul;
            document.getElementById('timeDisplay_' + data.data.slug).innerHTML = data.data.matchTime;
           
            var html = '';
            if (data.data.matchStatus === 0) {
                var html = '<span class="badge bg-primary">Match is not Started </span>';
            } else if (data.data.matchStatus === 1) {
                var html = '<span class="badge live-watch">First Half </span>';
            } else if (data.data.matchStatus === 2) {
                var html = '<span class="badge bg-warning">Break Time </span>';
            } else if (data.data.matchStatus === 3) {
                var html = '<span class="badge live-watch">Second Half </span>';
            } else if (data.data.matchStatus === 4) {
                var html = '<span class="badge bg-success">Completed </span>';
            }
            document.getElementById('matchStatusUpdate_' + data.data.slug).innerHTML = html;

            if(data.data.lastEvent!=0){
                document.getElementById('lastEventDisplay_' + data.data.slug).innerHTML = data.data.lastEvent;
            }
        });
    </script>
@endsection
