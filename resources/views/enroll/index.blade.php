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
      <div class="box-header with-border">
        <h3 class="box-title">Add New Curriculum</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form id="newSubjectForm" role="form">
        <div class="box-body">
          <div class="callout"></div>
          <div class="form-group">
            <label for="code">Enrollment Schedule</label>
            <select class="form-control" id="course_code" name="course_code">
              @foreach($openEnrollmentSchedules as $openEnrollmentSchedule)
              <option value="{{$openEnrollmentSchedule->academic_year}}/{{$openEnrollmentSchedule->semester}}">
                Academic Year: {{$openEnrollmentSchedule->academic_year}}
                Semester: {{$openEnrollmentSchedule->semester}}</option>
              @endforeach
            </select>
            <span class="help-block"></span>
          </div>
          <div class="form-group">
            <label for="description">Student</label>
            <div class="radio">
              <label>
                <input type="radio" name="optionsRadios" id="newStudent" checked>
                Old Student
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" name="optionsRadios" id="oldStudent">
                New Student
              </label>
            </div>

            <select class="form-control" id="student_id" name="student_id">

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
    $('#student_id').select2({
      ajax: {
        url: '{{ url("api/students") }}',
        dataType: 'json',
        minimumInputLength: 2,
        processResults: function (data) {
          return {
            results: $.map(data.students, function(student) {
              return {
                id: student.LRN,
                text: student.LRN + ' ' + student.last_name + ', ' + student.first_name
              }
            })
          }
        }
      }
    });
  });
</script>
@endsection
