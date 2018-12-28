@extends('layouts/main')

@section('title', 'ASCT Settings > Subjects')

@section('content-header')
<h1><i class="fa fa-list"></i> Subjects</h1>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
  <li><a href="{{ url('/') }}"><i class="fa fa-cogs"></i> General Settings</a></li>
  <li>Subjects</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Subject Masterlist</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form role="form">
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <th>Code</th>
              <th>Title</th>
              <th>Description</th>
            </thead>
            <tfoot>
              <th>Code</th>
              <th>Title</th>
              <th>Description</th>
            </tfoot>
          </table>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        </div>
      </form>
    </div>
  </div>
  <div class="col-md-4">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Add New Subject</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form id="newSubjectForm" role="form">
        <div class="box-body">
          <div class="callout"></div>
          <div class="form-group">
            <label for="code">Code</label>
            <input type="text" class="form-control" id="code" name="code" placeholder="Enter subject code">
            <span class="help-block"></span>
          </div>
          <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter subject title">
            <span class="help-block"></span>
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" id="description" name="description" placeholder="Enter subject description">
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
    var subjectsMasterList = $('#example1').DataTable({
      'processing': true,
      'serverSide': true,
      'ajax': '{{ url("api/subjects") }}',
      'columns': [
        { 'data': 'code' },
        { 'data': 'title' },
        { 'data': 'description' }
      ]
    });

    $('.callout', '#newSubjectForm').hide();
    $('body').on('change', '#newSubjectForm input', function() {
      $(this).closest('.form-group').removeClass('has-error');
      $(this).closest('.form-group').find('.help-block').html('');
    });

    $('#newSubjectForm').submit(function(e) {
      e.preventDefault();
      var ref = this;
      var data = $(ref).serialize();

      $.post('{{ url("api/subjects") }}', data, function(r) {
        $('.callout', ref).addClass('callout-success').show().fadeOut(3000).text('Successfully registered new subject.');
        ref.reset();
        subjectsMasterList.draw();
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
