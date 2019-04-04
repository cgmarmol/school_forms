@extends('layouts/main')

@section('title', 'Enroll')

@section('content-header')
<h1><i class="fa fa-list"></i> Add Subjects</h1>
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
        <h3 class="box-title">
          <span class="student-LRN"></span>
          <span class="student-last_name"></span>,
          <span class="student-first_name"></span>
          <span class="student-middle_name"></span>
        </h3>
      </div>
      <!-- /.box-header -->

      <div class="box-body">
        <div class="form-group">
          <table id="enrolledSectionsTable" class="table table-bordered table-striped">
            <thead>
              <th>Section ID</th>
              <th>Section Name</th>
              <th>Subject Name</th>
              <th>No. of Students</th>
              <th>&nbsp;</th>
            </thead>
            <tfoot>
              <th>Section ID</th>
              <th>Section Name</th>
              <th>Subject Name</th>
              <th>No. of Students</th>
              <th>&nbsp;</th>
            </tfoot>
          </table>
        </div>
      </div>
      <!-- /.box-body -->

      <div class="box-footer">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Available Subject Offerings</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table id="availableSectionsTable" class="table table-bordered table-striped">
          <thead>
            <th>Section ID</th>
            <th>Section Name</th>
            <th>Subject Name</th>
            <th>Grade Level</th>
            <th>No. of Students</th>
            <th>&nbsp;</th>
          </thead>
          <tfoot>
            <th>Section ID</th>
            <th>Section Name</th>
            <th>Subject Name</th>
            <th>Grade Level</th>
            <th>No. of Students</th>
            <th>&nbsp;</th>
          </tfoot>
        </table>
      </div>
      <!-- /.box-body -->

      <div class="box-footer">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
      </div>
      <!-- /.box-footer -->
    </div>
  </div>
</div>
@endsection

@section('custom-scripts')
<script type="text/javascript">
  $(function() {
    var availableSectionsTable = $('#availableSectionsTable').DataTable({
      'ordering': false,
      'processing': true,
      'responsive': true,
      'serverSide': true,
      'searching': false,
      'ajax': {
        'url': '{{ url("api/sections") }}?token='+token+'&filters[academic_year]={{ $academic_year }}&filters[semester]={{ $semester }}&filters[student_id]={{ $studentId }}&include=subject',
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
            var open = '<button class="enroll-student btn btn-primary btn-block" ' +
              'data-section_id="'+data.id+'">Enroll</button>';
            return open;
          }
        }
      ]
    });
    var enrolledSectionsTable = $('#enrolledSectionsTable').DataTable({
      'ordering': false,
      'processing': true,
      'responsive': true,
      'serverSide': true,
      'searching': false,
      'paging': false,
      'ajax': {
        'url': '{{ url("api/students/".$studentId) }}?token='+token+'&include=sections.subject&filters[academic_year]={{ $academic_year }}&filters[semester]={{ $semester }}',
        'dataSrc': function(json) {
          json.recordsTotal = json.recordsFiltered = json.student.sections.data.length;
          return json.student.sections.data;
        }
      },
      'columns': [
        { 'data': 'id' },
        { 'data': 'name' },
        { 'data': 'subject.data.title' },
        { 'data': 'number_students' },
        {
          'data': null,
          'render': function(data, type, row) {
            var open = '<button class="leave-student btn btn-danger btn-block" ' +
              'data-section_id="'+data.id+'">Leave</button>';
            return open;
          }
        }
      ]
    });
    $.get('{{ url("api/students/".$studentId) }}?token='+token, function(r) {
      $('.student-LRN').text(r.student.LRN);
      $('.student-last_name').text(r.student.last_name);
      $('.student-first_name').text(r.student.first_name);
      $('.student-middle_name').text(r.student.middle_name);
    });
    $('body').on('click', '#availableSectionsTable .enroll-student', function() {
      var sectionId = $(this).data('section_id');
      var studentId = '{{ $studentId }}';

      $.post('{{ url("api/sections") }}/'+sectionId+'/students?token='+token, { student_id: studentId }, function(r) {
        availableSectionsTable.draw();
        enrolledSectionsTable.draw();
      });
    });
    $('body').on('click', '#enrolledSectionsTable .leave-student', function() {
      var sectionId = $(this).data('section_id');
      var studentId = '{{ $studentId }}';

      $.ajax({
        'url': '{{ url("api/sections") }}/'+sectionId+'/students/'+studentId+'?token='+token,
        'method': 'DELETE',
        'success': function(r) {
          availableSectionsTable.draw();
          enrolledSectionsTable.draw();
        }
      });
    });

  });
</script>
@endsection
