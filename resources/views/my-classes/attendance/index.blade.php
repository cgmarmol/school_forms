@extends('layouts/main')

@section('title', 'ASCT Settings > Subjects')

@section('content-header')
<h1><i class="fa fa-calendar-check-o"></i> Attendance</h1>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
  <li><a href="{{ url('my-classes') }}"><i class="fa fa-th"></i> My Classes</a></li>
  <li>Attendance</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-filter"></i> Filters</h4>
      </div>
      <div class="box-body">
        <div class="form-group">
          <label for="academic_year">Academic Year</label>
          <input class="form-control" id="academic_year" name="academic_year">
          <span class="help-block"></span>
        </div>
        <div class="form-group">
          <label for="semester">Semester</label>
          <input class="form-control" id="semester" name="semester">
          <span class="help-block"></span>
        </div>
      </div>
      <div class="box-footer">
        <button type="button" class="btn btn-primary pull-right" id="search" name="search">Search</button>
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-body">
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
    $('body').on('click', '#search', function(e) {
      var academicYear = $('#academic_year').val();
      var semester = $('#semester').val();

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
          'url': '{{ url("api/sections") }}?token='+token+'&filters[academic_year]='+academicYear+'&filters[semester]='+semester+'&include=subject',
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
              var open = '<a href="{{ url("my-classes") }}/'+data.id+'/attendance" title="Attendance"><i class="fa fa-lg fa-calendar-check-o"></i></a>';
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
