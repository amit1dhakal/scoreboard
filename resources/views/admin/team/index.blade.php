@extends('layouts.master')
@section('content')
    <main>
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Teams</h6>
                        </div>
                        <div class="col-md-6 text-right">
                            @if (@Helper::league()->status == 0)
                                <a class="btn btn-sm btn-primary" href="{{ route('team.create') }}">
                                    <i class="fas fa-add"></i> Create
                                </a>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-striped table-responsive">
                        <thead>
                            <tr>
                                <th>S.N.</th>
                                <th>Name</th>
                                <th>Players</th>
                                <th width="250">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teams as $team)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $team->name }}</td>
                                    <td>
                                        @foreach ($team->players($team->player_ids) as $player)
                                            <span class="badge bg-success">{{ $player->name }}
                                                ({{ $player->jersey_no }})</span>
                                        @endforeach
                                    </td>

                                    <td class="d-flex gap-1">
                                        @if (@Helper::league()->status == 0)
                                            <a href="{{ route('team.edit', $team->id) }}" class="btn btn-sm btn-primary"><i
                                                    class="fas fa-edit"></i> Edit
                                            </a>
                                            <form method="post" action="{{ route('team.destroy', $team->id) }}"
                                                onsubmit="return confirm('Are you sure ?')">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-danger"><i
                                                        class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                            @else
                                           <span class="badge bg-secondary"> League is started </span>
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
