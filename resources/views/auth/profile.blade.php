@extends('admin.layouts.app')
@section('content')
<section id="dom">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title-wrap">
                        <h4 class="card-title">Update Profile</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="px-3">
                        <form action="{{route('profile')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">
                                @foreach ($errors->all() as $error)
                                    <p class="text-danger">{{ $error }}</p>
                                @endforeach
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Full Name</label>
                                            <input id="name" name="name" class="form-control border-primary" type="text" value="{{old('name', $user->name)}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input id="email" name="" disabled='true' class="form-control border-primary" type="email" value="{{ $user->email }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-actions left">
                                            <button type="submit" id="submit" class="btn btn-raised btn-success">
                                                <i class="icon-note"></i> Update Profile
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
