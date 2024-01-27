@extends('layouts.master')
@section('content')
    <main>
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Matches</h6>
                        </div>
                        <div class="col-md-6 text-right">
                            @if (@Helper::league()->status == 0)
                                <a href="{{ route('match.create') }}" class="btn btn-sm btn-primary">
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
                                <th>Teams</th>
                                <th>Status</th>
                                <th width="250">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($matches as $match)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $match->name }}</td>
                                    <td>
                                        @foreach ($match->teams($match->team_ids) as $team)
                                            {{ $team->name }} @if ($loop->iteration == 1)
                                                ,
                                            @endif
                                        @endforeach
                                    </td>

                                    <td>
                                        @include('admin.include.matchstatus')

                                    </td>
                                    <td class="d-flex gap-1">
                                        @if (@Helper::league()->status == 0)
                                            <a href="{{ route('match.edit', $match->slug) }}"
                                                class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit
                                            </a>
                                        @endif
                                        <a href="{{ route('match.show', $match->slug) }}"
                                            class="btn btn-sm btn-secondary"><i class="fas fa-eye"></i> Show
                                        </a>
                                        @if (@Helper::league()->status == 0)
                                            <form method="post" action="{{ route('match.destroy', $match->slug) }}"
                                                onsubmit="return confirm('Are you sure ?')">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-danger"><i
                                                        class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
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
