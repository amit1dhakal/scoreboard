@extends('layouts.master')
@section('content')
    <main>
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>League</h6>
                        </div>
                        <div class="col-md-6 text-right">
                            @if (count($leagues) < 1)
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#staticBackdrop">
                                    <i class="fas fa-add"></i> Create
                                </button>
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
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th width="250">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($leagues as $league)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $league->name }}</td>
                                    <td>{{ $league->start_date }}</td>
                                    <td>{{ $league->end_date }}</td>
                                    <td>
                                        @if ($league->status == 1)
                                            <span class="badge bg-primary">Running</span>
                                        @elseif($league->status == 2)
                                            <span class="badge bg-success">Completed</span>
                                        @else
                                            <span class="badge bg-warning">Coming</span>
                                        @endif

                                    </td>
                                    <td class="d-flex gap-1">
                                        <a href="{{ route('league.edit', $league->id) }}" class="btn btn-sm btn-primary"><i
                                                class="fas fa-edit"></i> Edit
                                        </a>
                                        <form method="post" action="{{ route('league.destroy', $league->id) }}"
                                            onsubmit="return confirm('Are you sure ?')">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger"><i
                                                    class="fas fa-trash"></i> Delete
                                            </button>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Add League</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('league.store') }}" method="post">
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
                                                    <label class="form-label" for="start_date">Start Date
                                                        <code>*</code></label>
                                                    <input type="date" min="{{ date('Y-m-d') }}" class="form-control"
                                                        name="start_date" id="start_date" required
                                                        value="{{ old('start_date') }}">
                                                    @if ($errors->has('start_date'))
                                                        <span class="text-danger">{{ $errors->first('start_date') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="end_date">End Date
                                                        <code>*</code></label>
                                                    <input type="date" min="{{ date('Y-m-d') }}" class="form-control"
                                                        name="end_date" id="end_date" required
                                                        value="{{ old('end_date') }}">
                                                    @if ($errors->has('end_date'))
                                                        <span class="text-danger">{{ $errors->first('end_date') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="status">Status <code>*</code></label>
                                                    <select class="form-control" required name="status" id="status">
                                                        <option value="0"> Coming </option>
                                                        {{-- <option value="1"> Start </option> --}}

                                                    </select>
                                                    @if ($errors->has('status'))
                                                        <span class="text-danger">{{ $errors->first('status') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                                        <button type="submit" class="btn btn-primary"> Submit <i
                                                class="fa-solid fa-paper-plane"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </main>
@endsection
@section('custom-script')
    @if (Session::has('errors'))
        <script>
            $(document).ready(function() {
                $('#staticBackdrop').modal('show');
            });
        </script>
    @endif
@endsection
