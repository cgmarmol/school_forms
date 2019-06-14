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
              <th></th>
              <th>LRN</th>
              <th>Last Name</th>
              <th>First Name</th>
              <th>M.I.</th>
              <th>Late</th>
              <th>Absent</th>
            </thead>
            <tfoot>
              <th></th>
              <th>LRN</th>
              <th>Last Name</th>
              <th>First Name</th>
              <th>M.I.</th>
              <th>Late</th>
              <th>Absent</th>
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

    function format ( data ) {

      var attendances = data.attendances.data;

      var attendanceSheet = '<table class="table table-bordered table-striped">';

      var ctr = 0;
      for(i in attendances) {
        if(ctr==0) {
          attendanceSheet += '<tr>';
        }
        var date = attendances[i].date;
        var code = attendances[i].code;
        var btnClass = 'btn btn-sm ';
        if(code == 'P') {
          btnClass += 'btn-success';
        } else if(code == 'L') {
          btnClass +=  'btn-warning';
        } else if(code == 'A') {
          btnClass += 'btn-danger';
        } else {
          btnClass = '';
        }

        attendanceSheet += '<td><span class="' + btnClass + '">' + code + '</span> ' + date + '</td>';
        if(ctr==5) {
          attendanceSheet += '</tr>';
        }
        ctr = ++ctr == 5 ? 0 : ctr;
      }

      if(ctr > 0 && 5 - ctr > 0) {
        for(i = 0; i < 5 - ctr; i++) {
          attendanceSheet += '<td></td>';
        }
        attendanceSheet += '</tr>';
      }

      attendanceSheet += '</table>';
      return attendanceSheet;
  }


    var subjectsMasterList = $('#example1').DataTable({
      'ordering': false,
      'processing': true,
      'responsive': true,
      'serverSide': true,
      'searching': false,
      'ajax': {
        'url': '{{ url("api/sections/".$section_id) }}/students?include=attendances&token='+token,
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
        {
            "className":      'details-control',
            "orderable":      false,
            "data":           null,
            "defaultContent": '<i class="fa fa-angle-right"></i>'
        },
        { 'data': 'LRN' },
        { 'data': 'last_name' },
        { 'data': 'first_name' },
        { 'data': 'middle_name' },
        { 'data': 'lates' },
        { 'data': 'absences' }
      ]
    });

    $('#example1 tbody').on('click', 'td.details-control', function () {
        var target = $(this);
        var tr = $(this).closest('tr');
        var row = subjectsMasterList.row( tr );

        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
            target.html('<i class="fa fa-angle-right"></i>');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
            target.html('<i class="fa fa-angle-down"></i>');
        }
    } );

  });
</script>
@endsection
