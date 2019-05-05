@extends('layouts/main')

@section('title', 'ASCT Settings > Subjects')

@section('content-header')
<h1><i class="fa fa-calendar"></i> Enrollment Schedules</h1>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
  <li><a href="{{ url('/') }}"><i class="fa fa-cogs"></i> General Settings</a></li>
  <li>Enrollment Schedules</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="box box-primary">
      <!-- form start -->
      <form role="form">
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped" width="100%">
            <thead>
              <th>Academic Year</th>
              <th>Semester</th>
              <th>&nbsp;</th>
              <th>&nbsp;</th>
            </thead>
            <tfoot>
              <th>Academic Year</th>
              <th>Semester</th>
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
  <div class="col-md-4">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Add New Enrollment Schedule</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form id="newSubjectForm" role="form">
        <div class="box-body">
          <div class="callout"></div>
          <div class="form-group">
            <label for="description">Academic Year</label>
            <input type="text" class="form-control" id="academic_year" name="academic_year" placeholder="Enter academic year">
            <span class="help-block"></span>
          </div>
          <div class="form-group">
            <label for="description">Semester</label>
            <input type="text" class="form-control" id="semester" name="semester" placeholder="Enter semester">
            <span class="help-block"></span>
          </div>
          <div class="form-group">
            <label for="description">Duration</label>
            <input type="text" class="form-control" id="duration" name="duration" placeholder="Enter duration">
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
      'ajax': '{{ url("api/enrollment-schedules") }}?token='+token,
      'columns': [
        { 'data': 'academic_year' },
        { 'data': 'semester' },
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
            var open = '<a href="{{url("settings/sections")}}/'+data.academic_year+'/'+data.semester+'" title="Sections / Subject Offerings"><i class="fa fa-lg fa-list-alt"></i></a>';
            return open;
          }
        }
      ]
    });

    $('#duration').daterangepicker();

    $('.callout', '#newSubjectForm').hide();
    $('body').on('change', '#newSubjectForm input', function() {
      $(this).closest('.form-group').removeClass('has-error');
      $(this).closest('.form-group').find('.help-block').html('');
    });
    $('body').on('change', '.enrollment-schedule-is-open', function() {
      var enrollmentSchedule = $(this).attr('name');
      var isOpen = $(this).val();
      $.ajax({
        type: 'PATCH',
        url: '{{ url("api/enrollment-schedules") }}/'+enrollmentSchedule+'?token='+token,
        success: function(r) {
          console.log(r);
        }
      });
    });

    $('#newSubjectForm').submit(function(e) {
      e.preventDefault();
      var ref = this;
      var data = $(ref).serialize();

      $.post('{{ url("api/enrollment-schedules") }}?token='+token, data, function(r) {
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
