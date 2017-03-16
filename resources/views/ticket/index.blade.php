@extends('layouts.app')

@section('content')
<div class="container">
    <ticket :message="message"></ticket>
    @include('alert/alert')
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <a href="{{ url('app') }}">Dashboard</a> / Ticket
            <a href="{{ url('/app/ticket/create') }}" class="btn btn-success btn-sm panel-heading-btn pull-right"><i class="fa fa-plus" aria-hidden="true"></i> Create New Ticket</a>
        </div>
        <div class="panel-body">
            <div class="btn-group pull-right" data-toggle="buttons">
              <label class="btn btn-default active btn-z" v-on:click="selectOption('all')">
                <input type="radio" name="options" id="option1 toggle" autocomplete="off" checked value="all"> All
              </label>
              <label class="btn btn-default btn-z" v-on:click="selectOption('open')">
                <input type="radio" name="options" id="option2 toggle" autocomplete="off" value="open"> Open
              </label>
              <label class="btn btn-default btn-z" v-on:click="selectOption('close')">
                <input type="radio" name="options" id="option3 toggle" autocomplete="off" value="close"> Closed
              </label>
              <label class="btn btn-default btn-z" v-on:click="selectOption('assigned')">
                <input type="radio" name="options" id="option4 toggle" autocomplete="off" value="assigned"> Assigned
              </label>
            </div>
            {{ csrf_field() }}
            <table class="table" id="dataTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Subject</th>
                        <th>Created by</th>
                        <th>Assigned to</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Created at</th>
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
                <h4 class="modal-title" id="myModalLabel">Delete Ticket</h4>
            </div>
            <div class="modal-body">
                Are you sure to delete the ticket #<span id="displayTicketId"></span> ?
                <input type="hidden" name="id" id="selectedTicketId" value="">
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
@endsection

@section('script')
    {{-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script> --}}
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

            var list = "all";

            $(".btn-z").on("click", function(){
               list = $(this).find("input[name=options]").val();
            });

            function getList() {return list}

            //load ticket table 
            var table = $('#dataTable').DataTable(
                {   
                    "paging": true,
                    "ordering":   false,
                    "searching":   false,
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ url('app/ticket/getDataTable') }}",
                        "type": "POST",
                        "data": function (d) { 
                            d.list = getList();
                        },
                    },
                    "columns": [
                        { "data": "id" },
                        {"mRender": function ( data, type, row ) {
                                return '<a href="{{ url('app/ticket') }}/'+row.id+'">'+row.subject+'</a>';
                            }
                        },
                        { "data": "created_by" },
                        { "data": "assigned_to" },
                        { "data": "status" },
                        { "data": "priority" },
                        { "data": "created_at" },
                        { "width": "7%", "mRender": function ( data, type, row ) {
                                return '<a href="{{ url('app/ticket') }}/'+row.id+'/edit" class="btn btn-primary btn-xs" role="button"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <a href="#1" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal" role="button" id="deleteModal"><i class="fa fa-times" aria-hidden="true"></i></a><input type="hidden" name="id" id="row'+row.id+'">';
                            }
                        }
                    ]
                }
            );

            $(".btn-z").on("click", function(){
                table.ajax.reload();
            });

            //set selected ticket id for modal usage
            $(document).on('click', '#deleteModal', function() {
                $('#selectedTicketId').val($(this).parent().siblings(":first").text());
                $('#displayTicketId').text($(this).parent().siblings(":first").text());
            });

            //delete selected ticket 
            $(document).on('click', '#deleteTicket', function() {
                $.ajax({
                    url: '{{ url('/app/ticket') }}' + '/' + $('#selectedTicketId').val(),
                    type: 'POST',
                    data: { '_method': 'DELETE' },
                    success: function( msg ) {
                        if ( msg.status === 'success' ) {

                            var id = $('#selectedTicketId').val();

                            //close modal
                            $('#myModal').modal('toggle');

                            //fade out selected ticket row
                            $('#row' + id).closest('tr').fadeOut('slow');

                        }
                    },
                    error: function( data ) {
                        if ( data.status === 'error' ) {
                            alert('Cannot delete the ticket');
                        }
                    }
                });
            });
        });
    </script>
@endsection