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
      <!-- form start -->
      <form role="form">
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped" width="100%">
            <thead>
              <th>LRN</th>
              <th>Last Name</th>
              <th>First Name</th>
              <th>M.I.</th>
            </thead>
            <tfoot>
              <th>LRN</th>
              <th>Last Name</th>
              <th>First Name</th>
              <th>M.I.</th>
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
        'url': '{{ url("api/sections/".$section_id) }}/students?token='+token,
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
        { 'data': 'LRN' },
        { 'data': 'last_name' },
        { 'data': 'first_name' },
        { 'data': 'middle_name' }
      ]
    });
    
  });
</script>
@endsection
