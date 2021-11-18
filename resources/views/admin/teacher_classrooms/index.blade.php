@extends('admin.layouts.app')

@section('content')
<section id="dom">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <p class="mb-0">Classrooms</p>
                </div>
                <div class="card-body pt-3">
                    <table class="table table-striped table-bordered" id="dTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('afterScript')
<script>
    var table = $('#dTable').DataTable({
        processing: true,
        serverSide: true,
        ajax:
        {
            url: '{{ route("classrooms.teacher.getList") }}',
            type: "POST",
            data:{ _token: "{{csrf_token()}}"},
            dataType: "JSON",
            error: function (reason) {
                return true;
            }
        },
        columns: [
            { data: 'serial'},
            { data: 'title' },
            { data: 'description' },
            { data: 'active', render:function (data, type, full, meta) {
                                return full.active   ? `<i class="fa fa-dot-circle-o success font-medium-1 mr-1"></i> Active`
                                                        : `<i class="fa fa-dot-circle-o danger font-medium-1 mr-1"></i> InActive`;  }
            },
            { data: 'created_at' },
            { data: 'actions', render:function (data, type, full, meta) {
                                return `<a href="/classrooms/${full.id}" class="showStatus primary p-0 mr-2 success" title="View">
                                            <i class="ft-eye font-medium-3"></i>
                                        </a>`; }
            }
        ],
        order: [0 , 'desc'],
        columnDefs: [
            { width: "10%", "targets": [-1, 0] },
            { orderable: false, targets: [-1] }
        ],
    });
</script>
@endsection
