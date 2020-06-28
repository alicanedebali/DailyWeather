@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        Welcome
                        You are logged in!
                        @if(Auth::user()->cities == null)
                            {!! Form::open(['url' => '/user/cities']) !!}
                            <div class="form-group row">


                                <input id="cities" type="text"
                                       class="form-control @error('cities') is-invalid @enderror" name="cities"
                                       value="{{ old('cities') }}" required autocomplete="cities" autofocus
                                       placeholder="Please enter your cities">
                                <button type="submit" id="btn" class="btn btn-primary">
                                    Kaydet
                                </button>

                            </div>
                            {!! Form::close() !!}

                            @else

                                <br>Your cities temp: {{$temp}}

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
