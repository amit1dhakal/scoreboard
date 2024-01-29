@extends('layouts.master')
@section('content')
    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-6 mt-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Top 5 goal Scorers </h6>
                                </div>
                                <div class="col-md-6 text-right">
                                    @can('Admin')
                                        <h6><a href="{{ route('player.index') }}" class="btn btn-sm btn-primary"><i
                                                    class="fas fa-eye"></i> View all </a></h6>
                                    @endcan
                                </div>

                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th>S.N.</th>
                                        <th>Name</th>
                                        <th>Jersey No</th>
                                        <th>Team</th>
                                        <th>Goals</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($withgoals as $withgoal)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $withgoal->name }}</td>
                                            <td>{{ $withgoal->jersey_no }}</td>
                                            <td>{{ $withgoal->team[0]->name ?? '' }}</td>
                                            <td>{{ $withgoal->goal_count }}</td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>
                <br />
                <div class="col-md-6 mt-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Top 5 Foul Players </h6>
                                </div>
                                <div class="col-md-6 text-right">
                                    @can('Admin')
                                        <h6><a href="{{ route('player.index') }}" class="btn btn-sm btn-primary"><i
                                                    class="fas fa-eye"></i> View all </a></h6>
                                    @endcan
                                </div>

                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th>S.N.</th>
                                        <th>Name</th>
                                        <th>Jersey No</th>
                                        <th>Team</th>
                                        <th>Fouls</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($withfouls as $withfoul)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $withfoul->name }}</td>
                                            <td>{{ $withfoul->jersey_no }}</td>
                                            <td>{{ $withfoul->team[0]->name ?? '' }}</td>
                                            <td>{{ $withfoul->foul_count }}</td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3 mb-3">
                <div class="card-header pt-3 pb-3">
                    <form method="get" action="{{ route('home') }}" onsubmit="return checkSameTeam()">
                        <h5 class="mb-3"> Compare the Teams </h5>
                        <div class="row">
                            <div class="col-md-5 col-sm-12 mb-2">
                                <div class="form-group">
                                    <select name="team_1" id="team_1" class="form-control" required>
                                        <option value="">---select team --- </option>
                                        @foreach ($teams as $team)
                                            <option value="{{ $team->id }}"
                                                @if ($team->id == $old_values['team_1']) selected @endif>{{ $team->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-12  mb-2">
                                <div class="form-group">
                                    <select name="team_2" id="team_2" class="form-control" required>
                                        <option value="">---select team --- </option>
                                        @foreach ($teams as $sas)
                                            <option value="{{ $sas->id }}"
                                                @if ($sas->id == $old_values['team_2']) selected @endif>{{ $sas->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12  mb-2">
                                <button type="submit" class="btn btn-sm btn-primary"> <i class="fas fa-eye"></i> Compare
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($selectedteams as $selectedteam)
                            <div class="col-md-6 col-sm-12">
                                <table class="table">
                                    <tr>
                                        <th colspan="2">{{ $selectedteam->name }}</th>
                                    </tr>

                                    <tr>
                                        <td>Home Ground Goals :</td>
                                        <th> {{ $goals->where('team_id', $selectedteam->id)->where('type', 'Goal')->where('field_site', 'Home')->count() }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>Home Ground Fouls :</td>
                                        <th>{{ $goals->where('team_id', $selectedteam->id)->where('type', 'Foul')->where('field_site', 'Home')->count() }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>Away Ground Goals :</td>
                                        <th>{{ $goals->where('team_id', $selectedteam->id)->where('type', 'Goal')->where('field_site', 'Away')->count() }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>Away Ground Fouls :</td>
                                        <th>{{ $goals->where('team_id', $selectedteam->id)->where('type', 'Foul')->where('field_site', 'Away')->count() }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <td> Total Goals :</td>
                                        <th>{{ $goals->where('team_id', $selectedteam->id)->where('type', 'Goal')->count() }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>Total Fouls :</td>
                                        <th>{{ $goals->where('team_id', $selectedteam->id)->where('type', 'Foul')->count() }}
                                        </th>
                                    </tr>


                                </table>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
    </main>
@endsection

@section('custom-script')
    <script>
        function checkSameTeam() {
            var val1 = $('#team_1').val();
            var val2 = $('#team_2').val();

            if (val1 == val2) {
                alert('First Team and Second Team Must not Same');
                return false;
            } else {
                return true;
            }

        }
        $(document).ready(function() {
            $("#team_1").on('change', function() {

                var team_1 = $('#team_1').val();
                $.ajax({
                    url: "{{ route('teamfilter') }}",
                    type: 'get',
                    data: {

                        id: team_1
                    },
                    success: function(response) {

                        $('#team_2').empty();
                        // for(var i=0;i<response.length;i++){
                        //     $('#team_2').append(`<option value="${response[i].id}"
                    //                        >${response[i].name}
                    //                     </option>`)
                        // }
                        response.map((data) => {
                            $('#team_2').append(
                                `<option value="${data.id}">${data.name} </option>`)
                        })
                    }
                });
            });
        })
    </script>
@endsection
