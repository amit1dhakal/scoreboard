@extends('layouts.master')
@section('content')
    <main>
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Players</h6>
                        </div>
                        <div class="col-md-6 text-right">
                            @if (@Helper::league()->status == 0)
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#staticBackdrop">
                                    <i class="fas fa-add"></i> Create
                                </button>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Add Player</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('player.store') }}" method="post">
                                @csrf
                                <div class="modal-body">

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <label class="form-label" for="name">Name <code>*</code></label>
                                                <input type="text" class="form-control" name="name" id="name"
                                                    required value="{{ old('name') }}">
                                                @if ($errors->has('name'))
                                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label class="form-label" for="jersey_no">Jersey No
                                                    <code>*</code></label>
                                                <input type="number" min="1" class="form-control" required
                                                    name="jersey_no" id="jersey_no" value="{{ old('jersey_no') }}">
                                                @if ($errors->has('jersey_no'))
                                                    <span class="text-danger">{{ $errors->first('jersey_no') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary"> Submit <i
                                            class="fa-solid fa-paper-plane"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-striped table-responsive">
                        <thead>
                            <tr>
                                <th>S.N.</th>
                                <th>Name</th>
                                <th>Jersey No</th>
                                <th width="250">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($players as $player)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $player->name }}</td>
                                    <td>{{ $player->jersey_no }}</td>

                                    <td class="d-flex gap-1">
                                        @if (@Helper::league()->status == 0)
                                            <a href="{{ route('player.edit', $player->id) }}"
                                                class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form method="post" action="{{ route('player.destroy', $player->id) }}"
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
