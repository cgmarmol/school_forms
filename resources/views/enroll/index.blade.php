@extends('layouts/main')

@section('title', 'Enroll')

@section('content-header')
<h1><i class="fa fa-user-plus"></i> Enroll Student</h1>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
  <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  <li>Enroll</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="box box-primary">
      <!-- form start -->
      <form id="enrollStudentForm" role="form">
        <div class="box-body">
          <div class="callout"></div>
          <div class="form-group">
            <label for="code">Enrollment Schedule</label>
            <select class="form-control" id="enrollment_schedule" name="enrollment_schedule">
            </select>
            <span class="help-block"></span>
          </div>
          <div class="form-group">
            <label for="description">Student</label>
            <div class="radio">
              <label>
                <input type="radio" name="student_type" id="newStudent" value="old" checked>
                Old Student
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" name="student_type" id="oldStudent" value="new">
                New Student
              </label>
            </div>
            <select class="form-control" name="student_id" id="student_id">
            </select>
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
    $('.callout', '#enrollStudentForm').hide();
    $('#enrollment_schedule').select2({
      placeholder: 'Select enrollment schedule',
      ajax: {
        url: '{{ url("api/active-enrollment-schedules") }}?token='+token,
        dataType: 'json',
        processResults: function (data) {
          return {
            results: $.map(data['enrollment-schedules'], function(schedule) {
              return {
                id: schedule.academic_year + '_' + schedule.semester,
                text: schedule.semester + ' Semester, A.Y.   ' + schedule.academic_year
              }
            })
          }
        }
      }
    });
    $('#student_id').select2({
      placeholder: 'Enter LRN, first name, or last name',
      ajax: {
        url: '{{ url("api/students") }}?token='+token,
        dataType: 'json',
        minimumInputLength: 2,
        processResults: function (data) {
          return {
            results: $.map(data.students, function(student) {
              return {
                id: student.id,
                text: student.LRN + ' ' + student.last_name + ', ' + student.first_name
              }
            })
          }
        }
      }
    });
    $('#enrollStudentForm').submit(function(e) {
      e.preventDefault();
      var ref = this;
      var data = $(ref).serialize();

      $('.form-group').removeClass('has-error');
      $('.help-block').html('');

      $.post('{{ url("api/students") }}?token='+token, data, function(r) {
        $('.callout', ref).addClass('callout-success').show().fadeOut(3000).text('Successfully registered new curriculum.');
        ref.reset();
        location.href = location.href + "/" + r.meta.academic_year + "/" + r.meta.semester + "/" + r.student.id;
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
