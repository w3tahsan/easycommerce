@extends('layouts.dashboard')

@section('content')
<div class="row">
        <div class="col-lg-8 m-auto">
        <form action="{{ route('checked.delete') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header">
                <h3>Trash Category List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>
                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" class="custom-control-input" id="checkAll">
                                <label class="custom-control-label" for="checkAll">Checkbox All</label>
                            </div>
                        </th>
                        <th>SL</th>
                        <th>Category Name</th>
                        <th>Category Image</th>
                        <th>Action</th>
                    </tr>
                    @forelse ($categories as $sl=>$category)
                    <tr>
                        <td>
                            <div class="custom-control custom-checkbox mb-3">
                                <input name="category_id[]" type="checkbox" class="custom-control-input input" id="customCheckBox{{ $category->id }}" value="{{ $category->id }}">
                                <label class="custom-control-label" for="customCheckBox{{ $category->id }}"></label>
                            </div>
                        </td>
                        <td>{{ $sl+1 }}</td>
                        <td>{{ $category->category_name }}</td>
                        <td><img width="62" src="{{ asset('uploads/category') }}/{{ $category->category_image }}" alt=""></td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('category.restore', $category->id) }}" class="btn btn-success shadow btn-xs sharp mr-1"><i class="fa fa-undo"></i></a>
                                <a data-link="{{ route('permanent.delete', $category->id) }}" class="btn btn-danger shadow btn-xs sharp del"><i class="fa fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Trash Not Available</td>
                    </tr>
                    @endforelse
                </table>
                <button type="submit" class="btn btn-danger">Delete checked</button>
                <button type="submit" class="btn btn-info">Restore checked</button>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection

@section('footer_script')
<script>
    $("#checkAll").click(function(){
        $('.input:checkbox').not(this).prop('checked', this.checked);
    });
</script>

{{-- @if (session('success'))
<script>
    Swal.fire({
    position: 'center',
    icon: 'success',
    title: '{{ session('success') }}',
    showConfirmButton: false,
    timer: 1500
    })
</script>
@endif --}}

<script>
    $('.del').click(function(){
        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
        if (result.isConfirmed) {
            var link = $(this).attr('data-link');
            window.location.href = link;
        }
        })
    });
</script>

@if (session('success'))
<script>
    Swal.fire(
      'Deleted!',
      '{{ session('success') }}',
      'success'
    )
</script>
@endif
@endsection
