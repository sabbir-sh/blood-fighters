@extends('backend.layouts.app')

@section('content')
    <div class="container">
        <h4 class="mb-3">
            {{ isset($product) ? 'Edit Product' : 'Create Product' }}
        </h4>

        <form method="POST" action="{{ isset($product)
        ? route('product.update', $product->id)
        : route('product.store') }}" enctype="multipart/form-data">

            @csrf
            @isset($product)
                @method('PATCH')
            @endisset

            <div class="mb-3">
                <label>Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $product->name ?? '') }}"
                    class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Slug</label>
                <input type="text" id="slug" name="slug" value="{{ old('slug', $product->slug ?? '') }}"
                    class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Short Description</label>
                <textarea name="short_description" rows="3"
                    class="form-control">{{ old('short_description', $product->short_description ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" rows="6"
                    class="form-control">{{ old('description', $product->description ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label>Slug</label>
                <input type="text" id="slug" name="slug" value="{{ old('slug', $product->slug ?? '') }}"
                    class="form-control" required>
                <small class="text-muted">
                    Auto generated from name, but you can edit it
                </small>
            </div>

            <div class="mb-3">
                <label>Price</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $product->price ?? '') }}"
                    class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Discount Price</label>
                <input type="number" step="0.01" name="discount_price"
                    value="{{ old('discount_price', $product->discount_price ?? '') }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Stock</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="1" {{ old('status', $product->status ?? '') == 1 ? 'selected' : '' }}>
                        Active
                    </option>
                    <option value="0" {{ old('status', $product->status ?? '') == 0 ? 'selected' : '' }}>
                        Inactive
                    </option>
                </select>
            </div>

            <div class="mb-3">
                <label>Thumbnail</label>
                <input type="file" name="thumbnail" class="form-control">

                @isset($product->thumbnail)
                    <img src="{{ asset('storage/' . $product->thumbnail) }}" width="80" class="mt-2">
                @endisset
            </div>

            <div class="mb-3">
                <label>Gallery Images</label>
                <input type="file" name="images[]" multiple class="form-control">

                @isset($product->images)
                    <div class="mt-2">
                        @foreach($product->images as $img)
                            <img src="{{ asset('storage/' . $img) }}" width="60">
                        @endforeach
                    </div>
                @endisset
            </div>

            <button class="btn btn-success">
                {{ isset($product) ? 'Update' : 'Save' }}
            </button>

            <a href="{{ route('product.list') }}" class="btn btn-secondary">
                Back
            </a>
        </form>
    </div>
@endsection