@extends('home.home_master')
@section('home')

  @include('home.home_layout.hero')
  <!-- end hero -->

  @include('home.home_layout.features')
  <!-- end content -->

  @include('home.home_layout.tool_quality')
  <!-- end content -->

  @include('home.home_layout.tabs')

  <div class="lonyo-content-shape3">
    <img src="{{ asset('frontend/assets/images/shape/shape2.svg') }}" alt="">
  </div>
  <!-- end content -->

  @include('home.home_layout.video')

  <div class="lonyo-content-shape1">
    <img src="{{ asset('frontend/assets/images/shape/shape3.svg') }}" alt="">
  </div>
  <!-- end video -->

  @include('home.home_layout.review')
  <!-- end review -->

  @include('home.home_layout.faq')

  <div class="lonyo-content-shape3">
    <img src="{{ asset('frontend/assets/images/shape/shape2.svg') }}" alt="">
  </div>
  <!-- end faq -->

  @include('home.home_layout.cta')
  <!-- end cta -->

@endsection
