@extends('layouts.app')

@section('content')
<div class="container">
    @include('alert/alert')
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <a href="{{ url('app') }}">Dashboard</a> / User
        </div>
        <div class="panel-body">
            <a href="{{ url('/app/users/create') }}" class="btn btn-success btn-md pull-right"><i class="fa fa-user-plus" aria-hidden="true"></i> Add New User</a></h5>
            {{ csrf_field() }}
            <table class="table table-condensed table-striped" style="padding-top: 5px;padding-bottom: 5px;" id="dataTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Role</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Delete User</h4>
            </div>
            <div class="modal-body">
                Are you sure to delete this user #<span id="displayUserId"></span> ?
                <input type="hidden" name="id" id="selectedUserId" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="deleteTicket">Delete</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ url('css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="/css/font-awesome.min.css">
@endsection

@section('script')
    <script type="text/javascript" src="{{ url('js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            //set csrf-token for every ajax request
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //load ticket table 
            $('#dataTable').DataTable(
                {   
                    "paging": true,
                    "ordering":   false,
                    "searching":   false,
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ url('app/users/getDataTable') }}",
                        "type": "POST"
                    },
                    "columns": [
                        { "data": "id" },
                        { "data": "name" },
                        { "data": "role" },
                        { "data": "created_at" },
                        { "data": "updated_at" },
                        { "width": "1%", "mRender": function ( data, type, row ) {
                                return '<a href="{{ url('app/users') }}/'+row.id+'/edit" class="btn btn-primary btn-xs" role="button"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <a href="#1" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal" role="button" id="deleteModal"><i class="fa fa-times" aria-hidden="true"></i></a><input type="hidden" name="id" id="row'+row.id+'">';
                            }
                        }
                    ]
                }
            );

            //set selected ticket id for modal usage
            $(document).on('click', '#deleteModal', function() {
                $('#selectedUserId').val($(this).parent().siblings(":first").text());
                $('#displayUserId').text($(this).parent().siblings(":first").text());
            });

            //delete selected ticket 
            $(document).on('click', '#deleteTicket', function() {
                $.ajax({
                    url: '{{ url('/app/users') }}' + '/' + $('#selectedUserId').val(),
                    type: 'POST',
                    data: { '_method': 'DELETE' },
                    success: function( msg ) {
                        if ( msg.status === 'success' ) {

                            var id = $('#selectedUserId').val();

                            //close modal
                            $('#myModal').modal('toggle');

                            //fade out selected ticket row
                            $('#row' + id).closest('tr').fadeOut('slow');

                        }
                    },
                    error: function( data ) {
                        if ( data.status === 'error' ) {
                            alert('Cannot delete the user');
                        }
                    }
                });
            });

        });
    </script>
@endsection