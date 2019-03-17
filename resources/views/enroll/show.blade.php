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
  @foreach($sections as $section)
  <div class="col-md-4">
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3>{{count($section->students)}}</h3>

        <p>
          Section: {{$section->name}} <br>
          Subject: {{$section->subject->title}} <br>
          Level: Grade {{$section->subject->level}}
        </p>
      </div>
      <div class="icon">
        <i class="fa fa-list-alt"></i>
      </div>
      <a href="{{ url('enroll') }}" class="small-box-footer">Enroll now <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  @endforeach
</div>
@endsection
