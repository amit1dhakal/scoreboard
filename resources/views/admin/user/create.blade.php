@extends('layouts.master')
@section('content')
    <main>
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>User or Referee Add</h6>
                        </div>

                    </div>
                </div>
                <form action="{{ route('user.store') }}" method="post">
                    @csrf
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="name">Name <code>*</code></label>
                                    <input type="text" class="form-control" name="name" id="name" required
                                        value="{{ old('name') }}">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="email">Email <code>*</code></label>
                                    <input type="email" class="form-control" name="email" id="email" required
                                        value="{{ old('email') }}">
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="role">Role <code>*</code></label>
                                    <select type="role" class="form-control" name="role" id="role" required>
                                        <option value="">---select role ---</option>
                                        <option value="Admin" @if (old('role') == 'Admin') selected @endif>Admin
                                        </option>
                                        <option value="Referee" @if (old('role') == 'Referee') selected @endif>Referee
                                        </option>
                                    </select>
                                    @if ($errors->has('role'))
                                        <span class="text-danger">{{ $errors->first('role') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="password">Password <code>*</code></label>
                                    <input type="password" class="form-control" name="password" id="password" required
                                        value="">
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="password">Password Confirm<code>*</code></label>
                                    <input type="password" class="form-control" name="password_confirmation"
                                        id="password_confirmation" required value="">
                                    @if ($errors->has('password_confirmation'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary"> Submit <i
                                class="fa-solid fa-paper-plane"></i></button>
                    </div>

                </form>
            </div>
        </div>
    </main>
@endsection
