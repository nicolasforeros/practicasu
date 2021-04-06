@extends('layouts.app')

@section('content')
<main class="py-4">
    
<div class="container card">
    <div class="row">
        <a href="{{ route('home') }}" class="btn btn-primary ml-2 mt-2">Home</a>
    </div>
    <div class="row justify-content-center">    
        <h1 class="mt-2">Companies Dashboard</h1>
    </div>
    @can('create company')
        <div class="row justify-content-center">
            <a href="{{route('company.create')}}" class="btn btn-primary mb-3">New Company</a>
        </div>
    @endcan
    <div class="row justify-content-center">
        <table class="table col-11">
        
            <thead>
                <tr class="font-weight-bold">
                    <td>Id</td>
                    <td>Name</td>
                    <td>Sector</td>
                    <td>Country</td>
                    <td>Situation</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody>
                @foreach($companies as $company)
                    <tr>
                        <td>{{$company->id}}</td>
                        <td>{{$company->name}}</td>
                        <td>{{$company->sector}}</td>
                        <td>{{$company->country}}</td>
                        <td>{{$company->situation}}</td>
                        <td>
                            <a href="{{ route('company.internship_offer.index',$company) }}" class="btn btn-primary">
                                <!-- <i class="bi bi-eye-fill"></i> -->
                                Offers
                            </a>
                            <a href="{{ route('company.show',$company) }}" class="btn btn-primary">
                                <!-- <i class="bi bi-eye-fill"></i> -->
                                Show Details
                            </a>
                            @auth
                                @if(auth()->user()->can('edit company situation') || auth()->user()->can('edit company'))  
                                    <a href="{{ route('company.edit',$company) }}" class="btn btn-primary">Edit</a>
                                @endif
                            @endauth
                            
                            @can('delete company')
                                <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#deleteModal" data-company="{{ $company }}">Delete</button>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $companies->links() }}

        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">A company is going to be deleted</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <form id="formDelete" action="" data-action="{{ route('company.destroy',0) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-primary">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</main>

<script>
    $('#deleteModal').on('show.bs.modal', function (event) {
        console.log("hola");
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('company') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).

        action = $('#formDelete').attr('data-action').slice(0,-1);

        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)

        $('#formDelete').attr('action',action+recipient.id);
        modal.find('.modal-title').text('The company ' + recipient.name + ' is going to be deleted')
    })
</script>
@endsection
