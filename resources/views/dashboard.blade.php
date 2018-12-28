@extends('layouts/main')

@section('title', 'Dashboard')

@section('content-header')
<h1><i class="fa fa-dashboard"></i> Dashboard</h1>
@endsection

@section('content')
<div class="row">
  <div class="col-md-4">
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3>44</h3>

        <p>Enroll Student (A.Y. 2018-2019)</p>
      </div>
      <div class="icon">
        <i class="fa fa-user-plus"></i>
      </div>
      <a href="{{ url('enroll') }}" class="small-box-footer">Enroll now <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-md-4">
    <div class="small-box bg-green">
      <div class="inner">
        <h3>{{ App\Models\Student::all()->count() }}</h3>

        <p>Students Masterlist</p>
      </div>
      <div class="icon">
        <i class="fa fa-list-alt"></i>
      </div>
      <a href="#" class="small-box-footer">View masterlist <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
</div>
@endsection
