@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title-wrap bar-teal">
                    <h4 class="card-title" id="horz-layout-colored-controls">Edit Subject</h4>
                </div>
            </div>
            <div class="card-body px-4">
                <form class="form" id="goalForm" action="{{route('subjects.update' ,$record->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="label-control" for="vendor_no">Title </label>
                                <input type="text" id="title" class="form-control border-primary  @error('title') is-invalid @enderror" value={{$record->title}} name="title" placeholder="Enter Title">
                            </div>
                            @if($errors->first('title'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="label-control" for="vendor_no">Description </label>
                                <textarea type="text" id="description"  class="form-control border-primary @error('description') is-invalid @enderror" name="description" placeholder="Enter Description">{{$record->description}}</textarea>
                            </div>
                            @if($errors->first('description'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label class="label-control" for="vendor_no">Status </label>
                                <select name="status" id="status" class="form-control form-control-sm" required>
                                    <option value="1" {{$record->active == 1 ? 'selected' : ""}}>Active</option>
                                    <option value="0" {{$record->active == 0 ? 'selected' : ""}}>In-Active</option>
                                </select>
                            </div>
                            @if($errors->first('status'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $errors->first('status') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-6" id="goalImage" style="display: none">
                            <div class="form-group">
                                <label class="label-control">Image</label>
                                <input type="file" name="image" id="image" class="form-control border-primary" >

                            </div>
                            @if($errors->first('image'))
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $errors->first('image') }}</strong>
                            </span>
                        @endif
                        </div>

                        <div class="col-6">
                            <input type="hidden" name="imageRemove" id="imageRemove" value=0>
                            <div class="col-lg-4 col-md-6 col-sm-12" id="imageShow">
                                <img src="{{ asset("storage/{$record->image}") }}" class="img-thumbnail cursor-pointer" style="width:50%; height:50%;">
                                <button class="btn btn-danger" id="removeImage"> <i class="ft-trash font-sm-1 right"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions right">
                    <a href="{{route('subjects.index')}}">
                        <button type="button" class="btn btn-danger mr-1">
                            <i class="icon-back"></i> Cancel
                        </button>
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="icon-note"></i> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('afterScript')
<script>
    $('#status').select2()
    $('#removeImage').click(function(){
        $('#imageRemove').val(1);
        $('#imageShow').remove();
        $('#goalImage').show();

    });
</script>
@endsection
