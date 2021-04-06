@extends('layouts.app')

@section('content')
<main class="py-4">
    
<div class="container card">
    <div class="row">
        <a href="{{ route('company.index',) }}" class="btn btn-primary ml-2 mt-2">Companies</a>
    </div>
    <div class="row justify-content-center">    
        <h1 class="mt-2">{{ $company->name }}'s Internship Offers</h1>
    </div>
    @can('create offer')
        <div class="row justify-content-center">
            <a href="{{ route('company.internship_offer.create',$company) }}" class="btn btn-primary mb-3">New Internship Offer</a>
        </div>
    @endcan
    <div class="row justify-content-center">
        <table class="table col-11">
        
            <thead>
                <tr class="font-weight-bold">
                    <td>Id</td>
                    <td>Position</td>
                    <td>Duration (months)</td>
                    <td>Type</td>
                    <td>Vacancies</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody>
                @foreach($offers as $offer)
                    <tr>
                        <td>{{$offer->id}}</td>
                        <td>{{$offer->position}}</td>
                        <td>{{$offer->duration_months}}</td>
                        <td>{{$offer->type}}</td>
                        <td>{{$offer->vacancies}}</td>
                        <td>
                            <a href="{{ route('company.internship_offer.show',[$company,$offer]) }}" class="btn btn-primary">
                                <!-- <i class="bi bi-eye-fill"></i> -->
                                Show Details
                            </a>
                            @can('edit offer')  
                                <a href="{{ route('company.internship_offer.edit',[$company,$offer]) }}" class="btn btn-primary">Edit</a>
                            @endif
                            @can('delete offer')
                                <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#deleteModal" data-company="{{ $company }}" data-offer="{{ $offer }}">Delete</button>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $offers->links() }}

        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">An internship offer is going to be deleted</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        
                        <form id="formDelete" action="" data-action="{{ route('company.internship_offer.destroy', [$company, 0]) }}" method="POST">
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

        var recipient = button.data('offer'); // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).

        action = $('#formDelete').attr('data-action').slice(0,-1);

        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)

        $('#formDelete').attr('action',action+ recipient.id);
        modal.find('.modal-title').text('The offer ' + recipient.position + ' is going to be deleted')
    })
</script>
@endsection
