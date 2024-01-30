@extends('layouts.master')
@section('content')
    <main>
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>League Edit</h6>
                        </div>

                    </div>
                </div>
                <form action="{{ route('league.update', $league->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="name">Name <code>*</code></label>
                                    <input type="text" class="form-control" name="name" id="name" required
                                        value="{{ old('name') ?? $league->name }}">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="start_date">Start Date <code>*</code></label>
                                    <input type="date" class="form-control" name="start_date" id="start_date" required
                                        value="{{ old('start_date') ?? $league->start_date }}">
                                    @if ($errors->has('start_date'))
                                        <span class="text-danger">{{ $errors->first('start_date') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="end_date">End Date <code>*</code></label>
                                    <input type="date" min="" class="form-control" name="end_date" id="end_date" required
                                        value="{{ old('end_date') ?? $league->end_date }}">
                                    @if ($errors->has('end_date'))
                                        <span class="text-danger">{{ $errors->first('end_date') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="status">Status <code>*</code></label>
                                    <select class="form-control" required name="status" id="status">
                                        @if($league->start_date <= date('Y-m-d'))   <option value="0" @if ($league->status == 0) selected @endif> Coming </option> @endif
                                        <option value="1" @if ($league->status == 1) selected @endif> Start  </option>
                                      @if($league->end_date <= date('Y-m-d'))  <option value="2" @if ($league->status == 2) selected @endif> End  </option> @endif

                                    </select>
                                    @if ($errors->has('status'))
                                        <span class="text-danger">{{ $errors->first('status') }}</span>
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
