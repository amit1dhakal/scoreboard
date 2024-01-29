@extends('layouts.master')
@section('content')
    <main>
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Users and Referees</h6>
                        </div>
                        <div class="col-md-6 text-right">
                            <a class="btn btn-sm btn-primary" href="{{ route('user.create') }}">
                                <i class="fas fa-add"></i> Create
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-striped table-responsive">
                        <thead>
                            <tr>
                                <th>S.N.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th width="250">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td> {{ $user->email }} </td>
                                    <td>{{ $user->role }}</td>
                                    <td class="d-flex gap-1">
                                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-primary"><i
                                                class="fas fa-edit"></i> Edit
                                        </a>
                                        @if ($user->id != 1)
                                            <form method="post" action="{{ route('user.destroy', $user->id) }}"
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
