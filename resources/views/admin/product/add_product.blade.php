@extends('layouts.dashboard')
@section('content')
@can('product_permission')
<div class="card">
    <div class="card-header">
        <h3>Add New Product</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <select name="category_id" class="form-control category_id">
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-6">
                    <select name="subcategory_id" class="form-control subcategory">
                        <option value="">Select Sub Category</option>
                        @foreach ($subcategories as $subcategory)
                            <option value="{{ $subcategory->id }}">{{ $subcategory->subcategory_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-6">
                    <div class="my-3">
                        <label for="" class="form-label">Product Name</label>
                        <input type="text" name="product_name" class="form-control">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="my-3">
                        <label for="" class="form-label">Product Price</label>
                        <input type="number" name="price" class="form-control">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="my-3">
                        <label for="" class="form-label">Product Discount</label>
                        <input type="number" name="discount" class="form-control">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="my-3">
                        <label for="" class="form-label">Product Brand</label>
                        <input type="text" name="brand" class="form-control">
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="my-3">
                        <label for="" class="form-label">Short Description</label>
                        <textarea name="short_desp" class="form-control"></textarea>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="my-3">
                        <label for="" class="form-label">Long Description</label>
                        <textarea id="summernote" name="long_desp" class="form-control"></textarea>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="my-3">
                        <label for="" class="form-label">Additional Information</label>
                        <textarea id="additional" name="additional" class="form-control"></textarea>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="my-3">
                        <label for="" class="form-label">Preview</label>
                        <input type="file" name="preview" class="form-control">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="my-3">
                        <label for="" class="form-label">Thumnbail</label>
                        <input multiple type="file" name="thumbnail[]" class="form-control">
                    </div>
                </div>
                <div class="col-lg-6 m-auto">
                    <div class="my-3">
                        <button type="submit" class="btn btn-danger w-100">Add Product</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@else
<h3>You Have No Access To visit View Page</h3>
@endcan
@endsection
@section('footer_script')
<script>
    $(document).ready(function() {
        $('#summernote').summernote();
        $('#additional').summernote();
    });
</script>
<script>
    $('.category_id').change(function(){
        var category_id = $(this).val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: '/getSubcategory',
            data:{'category_id':category_id},
            success: function(data) {
               $('.subcategory').html(data);
            }
        });
    });
</script>
@endsection

