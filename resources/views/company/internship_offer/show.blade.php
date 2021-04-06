@extends('layouts.app')

@section('content')
<main class="py-4">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card">
                <div class="card-header font-weight-bold">{{ __('Internship Offer') }}</div>

                <div class="card-body">
                    <form>
                        <div class="form-group row">
                            <label for="position" class="col-md-4 col-form-label text-md-right">{{ __('Position') }}</label>

                            <div class="col-md-6">
                                <input id="position" type="text" class="form-control" name="position" value="{{ old('position',$offer->position) }}" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="duration" class="col-md-4 col-form-label text-md-right">{{ __('Duration (months)') }}</label>

                            <div class="col-md-6">
                                <input id="duration" type="number" class="form-control" name="duration" value="{{ old('duration',$offer->duration_months) }}" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('Type') }}</label>

                            <div class="col-md-6">
                                <input id="type" type="text" class="form-control" name="type" value="{{ old('type',$offer->type) }}" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="schedule" class="col-md-4 col-form-label text-md-right">{{ __('Schedule') }}</label>

                            <div class="col-md-6">
                                <input id="schedule" type="text" class="form-control" name="schedule" value="{{ old('schedule',$offer->schedule) }}" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="contact_phone" class="col-md-4 col-form-label text-md-right">{{ __('Contact Phone') }}</label>

                            <div class="col-md-6">
                                <input id="contact_phone" type="tel" class="form-control" name="contact_phone" value="{{ old('contact_phone',$offer->contact_phone) }}" disabled>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="contact_email" class="col-md-4 col-form-label text-md-right">{{ __('Contact Email') }}</label>

                            <div class="col-md-6">
                                <input id="contact_email" type="email" class="form-control" name="contact_email" value="{{ old('contact_email',$offer->contact_email) }}" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="vacancies" class="col-md-4 col-form-label text-md-right">{{ __('Vacancies') }}</label>

                            <div class="col-md-6">
                                <input id="vacancies" type="number" class="form-control" name="vacancies" value="{{ old('vacancies',$offer->vacancies) }}" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="observation" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <textarea id="observation" type="text" class="form-control disabled_editor" name="description" readonly>
                                    {{ old('description', $offer->description) }}
                                </textarea>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <a href="{{ URL::previous() }}" class="btn btn-primary">
                                    {{ __('Back') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</main>
@endsection
