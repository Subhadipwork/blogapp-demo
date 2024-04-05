@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <h1 class="text-center">All Blog Posts</h1>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($blogs as $blog)
                    <tr id="blogRow{{ $blog->id }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $blog->title }}</td>
                        <td>{!! $blog->content !!}</td>
                        <td>
                            <label class="switch">
                                <input type="checkbox" class="status" data-id="{{ $blog->id }}" {{ $blog->status == 1 ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>

                        </td>
                        <td>
                            <button class="btn btn-danger remove" data-url="{{ route('blogs.delete', $blog->id) }}" data-id="{{ $blog->id }}">Delete</button>
                            <a href="{{ route('blogs.edit', $blog->id) }}" class="btn btn-success">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<script>
    $('.remove').click(function(event) {
        event.preventDefault();


        var id = $(this).data('id');
        var url = $(this).data('url');
        if (!id) {
            alert('Id not found');
            return false;
        }
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(data) {
                        if (data.status == true) {

                            $(event.target).closest("tr").fadeOut('slow', function() {
                                $(this).remove();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                'Something went wrong while deleting.',
                                'error'
                            );
                        }
                    },
                    error: function(data) {
                        console.log(data);
                        Swal.fire(
                            'Error!',
                            'Something went wrong while deleting.',
                            'error'
                        );
                    }
                });
            }
        });
    });
</script>
<script>
    $('.status').change(function() {
        var id = $(this).data('id');
        var status = $(this).prop('checked');
        $.ajax({
            url: "{{ route('blogs.change-status') }}",
            type: "POST",
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                if (data.status == true) {

                    toastr.success(data.message);

                }
            },
            error: function(data) {
                console.log(data);
                toastr.error(data.message);
            }
        })
    })
</script>
@endpush