@extends('layouts/main')

@section('title', 'Enroll')

@section('content-header')
<h1><i class="fa fa-user-plus"></i> Sections Masterlist</h1>
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
      <div class="box-body">
        <div class="form-group">
          <label for="code">Enrollment Schedule</label>
          <select class="form-control" id="enrollment_schedule" name="enrollment_schedule">
          </select>
          <span class="help-block"></span>
        </div>
        <div id="sections-placeholder">
        </div>
        <table class="table table-bordered table-striped" id="sections-template" style="display: none;">
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
    </div>
  </div>
</div>
@endsection

@section('custom-scripts')
<script type="text/javascript">
  $(function() {
    $('#enrollment_schedule').select2({
      placeholder: 'Select enrollment schedule',
      ajax: {
        url: '{{ url("api/active-enrollment-schedules") }}',
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

    $('body').on('change', '#enrollment_schedule', function(e) {
      var enrollmentSchedule = $(this).val().split('_');
      var academicYear = enrollmentSchedule[0];
      var semester = enrollmentSchedule[1];

      var template = $('#sections-template').clone();
      template.attr('id', 'availableSectionsTable');
      template.show();
      $('#sections-placeholder').html(template);

      var availableSectionsTable = $('#availableSectionsTable').DataTable({
        'ordering': false,
        'processing': true,
        'responsive': true,
        'serverSide': true,
        'searching': false,
        'ajax': {
          'url': '{{ url("api/sections") }}?filters[academic_year]='+academicYear+'&filters[semester]='+semester+'&include=subject',
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
              var open = '<a href="###"><i class="fa fa-lg fa-list"></i></a>';
              return open;
            }
          }
        ]
      });
      availableSectionsTable.draw();
    });
  });
</script>
@endsection
