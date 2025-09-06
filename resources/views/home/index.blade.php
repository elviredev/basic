@extends('home.home_master')
@section('home')

  @include('home.home_layout.hero')
  <!-- end hero -->

  @include('home.home_layout.features')
  <!-- end content -->

  @include('home.home_layout.clarifies')
  <!-- end content -->

  @include('home.home_layout.get_all')
  <!-- end content -->

  @include('home.home_layout.video')
  <!-- end video -->

  @include('home.home_layout.review')
  <!-- end review -->

  @include('home.home_layout.faq')
  <!-- end faq -->

  @include('home.home_layout.cta')
  <!-- end cta -->

@endsection
