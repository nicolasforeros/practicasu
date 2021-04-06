@extends('layouts.app')

@section('content')
<main class="py-4">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header font-weight-bold">{{ __('New Company') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('company.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nit" class="col-md-4 col-form-label text-md-right">{{ __('Nit') }}</label>

                            <div class="col-md-6">
                                <input id="nit" type="text" class="form-control @error('nit') is-invalid @enderror" name="nit" value="{{ old('nit') }}" required autocomplete="nit">

                                @error('nit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sector" class="col-md-4 col-form-label text-md-right">{{ __('Sector') }}</label>

                            <div class="col-md-6">
                                <!-- <input id="sector" type="sector" class="form-control @error('sector') is-invalid @enderror" name="sector" required autocomplete="new-sector"> -->

                                <select id="sector" name="sector" class="form-control @error('sector') is-invalid @enderror" value="{{ old('sector') }}" required>
                                    @if (isset($sectors))
                                        @foreach ($sectors as $sector)
                                            <option value="{{ $sector }}"> {{ $sector }} </option>
                                        @endforeach
                                    @endif
                                </select> 

                                @error('sector')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="country" class="col-md-4 col-form-label text-md-right">{{ __('Country') }}</label>

                            <div class="col-md-6">
                                <!-- <input id="country" list="countriesList" class="form-control @error('country') is-invalid @enderror" name="country" value="{{ old('country') }}" required> -->

                                <select id="country" name="country" class="form-control @error('country') is-invalid @enderror" value="{{ old('country') }}" onchange="searchState(this.value); searchCity(this.value);" required>
                                    @if (isset($countries))
                                        @foreach ($countries as $country)
                                            <option value="{{ $country }}"> {{ $country }} </option>
                                        @endforeach
                                    @endif
                                </select> 

                                @error('country')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="state" class="col-md-4 col-form-label text-md-right">{{ __('State') }}</label>

                            <div class="col-md-6">
                                <!-- <input id="state" type="text" class="form-control @error('state') is-invalid @enderror" name="state" value="{{ old('state') }}" required autocomplete="state"> -->

                                <select id="state" name="state" class="form-control @error('state') is-invalid @enderror" value="{{ old('state') }}" required>
                                    
                                </select> 

                                @error('state')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="city" class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>

                            <div class="col-md-6">
                                <!-- <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autocomplete="city"> -->
                                <select id="city" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}" required>
                                    
                                </select> 
                                @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="documents" class="col-md-4 col-form-label text-md-right">{{ __('Additional Documentation') }}</label>

                            <div class="col-md-6">
                                <input id="documents[]" type="file" class="form-control @error('documents') is-invalid @enderror" name="documents[]" value="{{ old('documents') }}" multiple>

                                @error('documents')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</main>
<script>
    function searchState(value){
        
        var select = document.getElementById('state');
        for (i = select.length - 1; i >= 0; i--) {
            select.remove(i);
        }

        var raw = {"country": value};

        //console.log(raw);

        var requestOptions = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(raw),
            redirect: 'follow'
        };

        fetch("https://countriesnow.space/api/v0.1/countries/states", requestOptions)
            .then(response => response.json())
            .then(result => {
                //console.log(result.data.states);
                var option;
                result.data.states.forEach(state => {
                    option = document.createElement("option");
                    option.text = state.name;
                    option.value = state.name;
                    select.add(option);
                });
            })
            .catch(error => console.log('error', error));
    }

    function searchCity(country){
        
        var select = document.getElementById('city');
        for (i = select.length - 1; i >= 0; i--) {
            select.remove(i);
        }

        var raw = {"country": country};

        //console.log(raw);

        var requestOptions = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(raw),
            redirect: 'follow'
        };

        fetch("https://countriesnow.space/api/v0.1/countries/cities", requestOptions)
            .then(response => response.json())
            .then(result => {
                //console.log(result.data.states);
                var option;
                result.data.forEach(city => {
                    option = document.createElement("option");
                    option.text = city;
                    option.value = city;
                    select.add(option);
                });
            })
            .catch(error => console.log('error', error));
    }
</script>
@endsection
