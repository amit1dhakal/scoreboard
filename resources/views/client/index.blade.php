@extends('layouts.master')
@section('content')
    <main>
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h6> All Maches of {{ Helper::league()->name ?? '' }} </h6>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-responsive">
                        <thead>
                            <tr>
                                <th>S.N.</th>
                                <th>Name</th>
                                <th>Home Team</th>
                                <th>Away Team</th>
                                <th>Winner Team</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th width="250">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($matches as $match)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $match->name }}</td>
                                    <td>{{ $match->hometeam->name ?? '' }}</td>
                                    <td>{{ $match->awayteam->name ?? '' }}</td>
                                    <td>{{ $match->winnerteam->name ?? '' }}</td>
                                    <td>{{ Carbon\Carbon::parse($match->date)->format('M-d, Y') }}</td>
                                    <td>@include('admin.include.matchstatus')</td>
                                    <td>
                                        @if(in_array($match->status,[1,2,3]))
                                        <a href="{{ route('client.show', $match->slug) }}" class="btn btn-sm btn-primary"><i
                                                class="fas fa-eye"></i> Show
                                        </a>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </main>
@endsection
