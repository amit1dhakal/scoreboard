@extends('layouts.master')
@section('content')
    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
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
                <div class="col-md-6">
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
    </main>
@endsection
