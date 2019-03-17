@extends('layouts/main')

@section('title', 'ASCT Settings > Subjects')

@section('content-header')
<h1><i class="fa fa-calendar"></i> Sections</h1>
<h4>A.Y.: {{ $academic_year }} Semester: {{ $semester }}</h2>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
  <li><a href="{{ url('/') }}"><i class="fa fa-cogs"></i> General Settings</a></li>
  <li><a href="{{ url('settings/enrollment-schedules') }}"><i class="fa fa-calendar"></i> Enrollment Schedules</a></li>
  <li>Sections</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="box box-primary">
      <!-- form start -->
      <form role="form">
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped" width="100%">
            <thead>
              <th>Section ID</th>
              <th>Section Name</th>
              <th>Subject Name</th>
              <th>Grade Level</th>
              <th>No. of Students</th>
              <th>&nbsp;</th>
              <th>&nbsp;</th>
            </thead>
            <tfoot>
              <th>Section ID</th>
              <th>Section Name</th>
              <th>Subject Title</th>
              <th>Grade Level</th>
              <th>No. of Students</th>
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
</div>
<div class="row">
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Add New Section</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form id="newSubjectForm" role="form">
        <div class="box-body">
          <div class="callout"></div>
          <div class="form-group">
            <label for="description">Section Name</label>
            <input type="text" class="form-control" id="academic_year" name="academic_year" placeholder="Enter curriculum description">
            <span class="help-block"></span>
          </div>
          <div class="form-group">
            <label for="description">Semester</label>
            <input type="text" class="form-control" id="semester" name="semester" placeholder="Enter curriculum description">
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
      'searching': false,
      'ajax': {
        'url': '{{ url("api/sections") }}?filters[academic_year]={{ $academic_year }}&filters[semester]={{ $semester }}&include=subject',
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
        { 'data': 'id' },
        { 'data': 'name' },
        { 'data': 'subject.data.title' },
        { 'data': 'subject.data.level' },
        { 'data': 'number_students' },
        {
          'data': null,
          'render': function(data, type, row) {
            var open = '<div class="form-group">'+
              '<div class="radio">'+
                '<label>'+
                  '<input type="radio" name="' + data.academic_year + "_" + data.semester + '_is_open" value="1" class="enrollment-schedule-is-open" ' + (data.is_open == 1 ? 'checked' : '') + '>'+
                  '&nbsp;Open' +
                '</label>'+
              '</div>&nbsp;&nbsp;'+
              '<div class="radio">'+
                '<label>'+
                  '<input type="radio" name="' + data.academic_year + "_" + data.semester + '_is_open" value="0" class="enrollment-schedule-is-open" ' + (data.is_open == 0 ? 'checked' : '') + '>'+
                  '&nbsp;Closed' +
                '</label>'+
              '</div>'+
            '</div>';

            return open;
          }
        },
        {
          'data': null,
          'render': function(data, type, row) {
            var open = '<a href="#" title="Sections / Subject Offerings"><i class="fa fa-lg fa-list-alt"></i></a>';
            return open;
          }
        }
      ]
    });

    $('.callout', '#newSubjectForm').hide();
    $('body').on('change', '#newSubjectForm input', function() {
      $(this).closest('.form-group').removeClass('has-error');
      $(this).closest('.form-group').find('.help-block').html('');
    });
    $('body').on('change', '.enrollment-schedule-is-open', function() {
      var isOpen = $(this).val();
      $.ajax({
        type: 'PATCH',
        url: '{{ url("api/enrollment-schedules/2020-2021_2") }}',
        success: function(r) {

        }
      });
    });

    $('#newSubjectForm').submit(function(e) {
      e.preventDefault();
      var ref = this;
      var data = $(ref).serialize();

      $.post('{{ url("api/enrollment-schedules") }}', data, function(r) {
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
