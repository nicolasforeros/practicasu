@extends('layouts.app')

@section('content')
<main class="py-4">
    
<div class="container card">
    <div class="row">
        <a href="{{ route('company.internship_offer.index',$company) }}" class="btn btn-primary ml-2 mt-2">{{ $company->name }}'s Internship Offers</a>
    </div>
    <div class="row justify-content-center">    
        <h1 class="mt-2">Applications for {{ $offer->position }}</h1>
    </div>

    @if ( $offer->vacancies == 0)
        <div class="alert alert-success">
            <ul>
                <li>All vacancies for this offer already accepted</li>
            </ul>
        </div>
    @endif
    
    <div class="row justify-content-center">
        <table class="table col-11">
        
            <thead>
                <tr class="font-weight-bold">
                    <td>Id</td>
                    <td>Student name</td>
                    <td>Student email</td>
                    <td>State</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $application)
                    <tr>
                        <td>{{$application->id}}</td>
                        <td>{{$application->user->name}}</td>
                        <td>{{$application->user->email}}</td>
                        <td>{{$application->state}}</td>
                        <td>
                        @if($offer->vacancies>0)
                            <form method="POST" action="{{ route('company.internship_offer.application.update',[$company,$offer,$application]) }}">
                            @method('PUT')
                            @csrf
                                <input type="hidden" id="state" name="state" value="{{ $states[1] }}">
                                <button type="submit" class="btn btn-primary" {{ $application->state == $states[1] ? 'disabled' : '' }}>
                                <!-- <i class="bi bi-eye-fill"></i> -->
                                    Accept
                                </button>
                            </form>
                        @endif
                            <form method="POST" action="{{ route('company.internship_offer.application.update',[$company,$offer,$application]) }}">
                            @method('PUT')
                            @csrf
                                <input type="hidden" id="state" name="state" value="{{ $states[2] }}">
                                <button type="submit" class="btn btn-danger" {{ $application->state == $states[2] ? 'disabled' : '' }}>
                                <!-- <i class="bi bi-eye-fill"></i> -->
                                    Reject
                                </button>
                            </form>

                        
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $applications->links() }}
    </div>
</div>

</main>

<script>
</script>
@endsection
