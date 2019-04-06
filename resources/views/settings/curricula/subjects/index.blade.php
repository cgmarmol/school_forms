@extends('layouts/main')

@section('title', 'ASCT Settings > Subjects')

@section('content-header')
<h1><i class="fa fa-list"></i> {{ $curriculum->description }} Subjects</h1>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
  <li><a href="{{ url('/') }}"><i class="fa fa-cogs"></i> General Settings</a></li>
  <li><a href="{{ url('settings/curricula') }}">Curricula</a></li>
  <li>Curriculum Subjects</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Curriculum Subjects</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form role="form">
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped" width="100%">
            <thead>
              <th>Grade Level</th>
              <th>Default Semester</th>
              <th>Subject Code</th>
              <th>Subject Title</th>
              <th>Subject Description</th>
              <th>&nbsp;</th>
            </thead>
            <tfoot>
              <th>Grade Level</th>
              <th>Default Semester</th>
              <th>Subject Code</th>
              <th>Subject Title</th>
              <th>Subject Description</th>
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
  <div class="col-md-4">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Add Subject to Curriculum</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form id="newSubjectForm" role="form">
        <div class="box-body">
          <div class="callout"></div>
          <div class="form-group">
            <label for="code">Grade Level</label>
            <select class="form-control" id="subject_level" name="subject_level">
              <option>Grade 11</option>
              <option>Grade 12</option>
            </select>
          </div>
          <div class="form-group">
            <label for="code">Default Semester</label>
            <input type="text" class="form-control" id="default_semester" name="default_semester" placeholder="Enter default semester">
            <span class="help-block"></span>
          </div>
          <div class="form-group">
            <label for="code">Code</label>
            <input type="text" class="form-control" id="subject_code" name="subject_code" placeholder="Enter subject code">
            <span class="help-block"></span>
          </div>
          <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="subject_title" name="subject_title" placeholder="Enter subject title">
            <span class="help-block"></span>
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" id="subject_description" name="subject_description" placeholder="Enter subject description">
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
      'ordering': false,
      'processing': true,
      'responsive': true,
      'serverSide': true,
      'ajax': '{{ url("api/curricula/".$curriculum->id."/subjects") }}?token='+token,
      'columns': [
        { 'data': 'level' },
        { 'data': 'default_semester' },
        { 'data': 'code' },
        { 'data': 'title' },
        { 'data': 'description' },
        {
          'data': null,
          'render': function(data, type, row) {
            var deleteSubject = '<a href="#"><i class="fa fa-lg fa-trash"></i></a>';

            return deleteSubject;
          }
        }
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

      $.post('{{ url("api/curricula/".$curriculum->id."/subjects") }}?token='+token, data, function(r) {
        $('.callout', ref).addClass('callout-success').show().fadeOut(3000).text('Successfully registered new curriculum.');
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
