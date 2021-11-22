@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title-wrap bar-teal">
                    <h4 class="card-title" id="horz-layout-colored-controls">Charity</h4>
                </div>
            </div>
            <div class="card-body px-4">

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="label-control" for="vendor_no">Title </label>
                                <input type="text" id="title" class="form-control border-primary  @error('title') is-invalid @enderror" value={{$record->charity->title}} name="title" placeholder="Enter Title" readonly>
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
                                <textarea type="text" id="description"  class="form-control border-primary @error('description') is-invalid @enderror" name="description" placeholder="Enter Description" readonly>{{$record->charity->description}}</textarea>
                            </div>

                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label class="label-control" for="vendor_no">Tagline </label>
                                <input type="text" class="form-control border-primary" value ={{$record->charity->tagline}} readonly>
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="label-control" for="vendor_no">Teacher </label>
                                <input type="text" class="form-control border-primary" value ={{$record->charity->teacher->name}} readonly>
                            </div>

                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label class="label-control" for="vendor_no">Classroom </label>
                                <input type="text" class="form-control border-primary" value ={{$record->charity->classroom->title}} readonly>
                            </div>

                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label class="label-control" for="vendor_no">Target </label>
                                <input type="text" class="form-control border-primary" value ={{$record->actual_target}} readonly>
                            </div>

                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label class="label-control" for="vendor_no">Donations </label>
                                <input type="text" class="form-control border-primary" value ={{$record->current_target}} readonly>
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="label-control" for="vendor_no">Starting Date </label>
                                <input type="text" class="form-control border-primary" value ={{$record->starting_date}} readonly>
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="label-control" for="vendor_no">Ending Date </label>
                                <input type="text" class="form-control border-primary" value ={{$record->ending_date}} readonly>
                            </div>

                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label class="label-control" for="vendor_no">Students </label>
                                <input type="text" class="form-control border-primary" value ={{$record->student_count}} readonly>
                            </div>

                        </div>


                        <div class="col-6">
                            <div class="form-group">
                                <label class="label-control" for="vendor_no">Status </label>
                                <input type="text" class="form-control border-primary" value ={{($record->charity->active ==1 ? 'YES ' : $record->charity->active ==0) ? 'NO' : 'Completed'}} readonly>
                            </div>

                        </div>


                        <div class="col-lg-4 col-md-6 col-sm-12" id="imageShow">
                            <img src="{{ asset("storage/{$record->charity->image}") }}" class="img-thumbnail cursor-pointer" style="width:30%; height:50%;">

                        </div>
                    </div>
                    <div class="form-actions right">
                    <a href="{{route('charities.index')}}">
                        <button type="button" class="btn btn-danger mr-1">
                             Back
                        </button>
                        </a>
                    </div>
            </div>
        </div>
    </div>
</div>

@endsection
