@extends('layouts/main')

@section('title', 'ASCT Settings > Subjects')

@section('content-header')
<h1><i class="fa fa-users"></i> User Accounts</h1>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
  <li><a href="{{ url('/') }}"><i class="fa fa-cogs"></i> General Settings</a></li>
  <li>User Accounts</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="box box-primary">
      <!-- form start -->
      <form role="form">
        <div class="box-body">
          <table id="usersTable" class="table table-bordered table-striped" width="100%">
            <thead>
              <th>Last Name</th>
              <th>First Name</th>
              <th>Middle Name</th>
              <th>Gender</th>
              <th>Email</th>
              <th>&nbsp;</th>
              <th>&nbsp;</th>
            </thead>
            <tfoot>
              <th>Last Name</th>
              <th>First Name</th>
              <th>Middle Name</th>
              <th>Gender</th>
              <th>Email</th>
              <th>&nbsp;</th>
              <th>&nbsp;</th>
            </tfoot>
          </table>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">

        </div>
      </form>
    </div>
  </div>
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-user-plus"></i> Create New User</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form id="newUserForm" role="form">
        <div class="box-body">
          <div class="callout"></div>
          <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter last name">
            <span class="help-block"></span>
          </div>
          <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name">
            <span class="help-block"></span>
          </div>
          <div class="form-group">
            <label for="first_name">Middle Name</label>
            <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Enter middle name">
            <span class="help-block"></span>
          </div>
          <div class="form-group">
            <label for="gender">Gender</label>
            <select class="form-control" id="gender" name="gender">
              <option value="M">Male</option>
              <option value="F">Female</option>
            </select>
            <span class="help-block"></span>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Enter email">
            <span class="help-block"></span>
          </div>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('custom-scripts')
<script type="text/javascript">
$(function() {
  var usersMasterList = $('#usersTable').DataTable({
    'ordering': false,
    'processing': true,
    'responsive': true,
    'serverSide': true,
    'searching': false,
    'ajax': {
      'url': '{{ url("api/users") }}?token='+token,
      'data': function(d) {
        return $.extend({}, d, {
          'page': d.start / d.length + 1
        });
      },
      'dataSrc': function(json) {
        json.start = (json.meta.pagination.current_page-1) * json.meta.pagination.per_page;
        json.length = json.meta.pagination.per_page;
        json.recordsTotal = json.recordsFiltered = json.meta.pagination.total;
        return json.data;
      }
    },
    'columns': [
      { 'data': 'last_name' },
      { 'data': 'first_name' },
      { 'data': 'middle_name' },
      { 'data': 'gender' },
      { 'data': 'email' },
      {
        'data': null,
        'render': function(data, type, row) {
          return '';
        }
      },
      {
        'data': null,
        'render': function(data, type, row) {
          return '';
        }
      }
    ]
  });

  $('.callout', '#newUserForm').hide();
  $('body').on('change', '#newUserForm input', function() {
    $(this).closest('.form-group').removeClass('has-error');
    $(this).closest('.form-group').find('.help-block').html('');
  });

  $('#newUserForm').submit(function(e) {
    e.preventDefault();
    var ref = this;
    var data = $(ref).serialize();

    $.post('{{ url("api/users") }}?token='+token, data, function(r) {
      $('.callout', ref).addClass('callout-success').show().fadeOut(3000).text('Successfully created new user.');
      ref.reset();
      usersMasterList.draw();
    }).fail(function(r) {
      if(r.responseJSON !== undefined) {
        var responseJSON = r.responseJSON;
        if(responseJSON.status_code === 422) {
          var errors = responseJSON.errors;
          if(errors !== undefined) {
            $.each(errors, function(key, value) {
              var errorMessage = value[0];
              $('#'+key, ref).closest('.form-group').addClass('has-error');
              $('#'+key, ref).closest('.form-group').find('.help-block').html(errorMessage);
            });
          }
        }
      }
    });
  });

});
</script>
@endsection
