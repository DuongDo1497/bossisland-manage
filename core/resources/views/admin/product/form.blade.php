@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.product.store', @$product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <div class="image-upload">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview" style="background-image: url({{ getImage(getFilePath('product') . '/' . @$product->image, getFileSize('product')) }})">
                                                    <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                                <label for="profilePicUpload1" class="bg--success">@lang('Upload Image')</label>
                                                <small class="mt-2">@lang('Supported files'): <b>@lang('jpeg'), @lang('jpg').</b> @lang('Image will be resized into 400x400px') </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8 col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group ">
                                            <label>@lang('Name')</label>
                                            <input type="text" name="name" class="form-control" value="{{ old('name', @$product->name) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group ">
                                            <label class="form-label">@lang('Category')</label>
                                            <select name="category" class="form-control " required>
                                                <option value="" selected disabled>@lang('Select One')</option>
                                                @foreach ($categories as $category)
                                                    <option @selected($category->id == @$product->category_id) value="{{ $category->id }}">{{ __($category->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class=" col-sm-6">
                                        <div class="form-group">
                                            <label>@lang('Brand')</label>
                                            <select name="brand" class="form-control" required>
                                                <option value="" selected disabled>@lang('Select One')</option>
                                                @foreach ($brands as $brand)
                                                    <option @selected($brand->id == @$product->brand_id) value="{{ $brand->id }}">{{ __($brand->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group ">
                                            <label class="form-label">@lang('SKU')</label>
                                            <input type="text" class="form-control " name="sku" value="{{ old('sku', @$product->sku) }}" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>@lang('Unit(UoM)')</label>
                                            <select name="unit" class="form-control " required>
                                                <option value="" selected disabled>@lang('Select One')</option>
                                                @foreach ($units as $unit)
                                                    <option @selected($unit->id == @$product->unit_id) value="{{ $unit->id }}">{{ __($unit->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>@lang('Alert Quantity')</label>
                                            <input type="number" name="alert_quantity" class="form-control" value="{{ old('alert_quantity', @$product->alert_quantity) }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>@lang('Note')</label>
                                            <textarea name="note" class="form-control">{{ old('note', @$product->note) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-back route="{{ route('admin.product.index') }}" />
@endpush
