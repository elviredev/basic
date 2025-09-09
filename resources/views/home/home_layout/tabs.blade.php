@php
  $tabs = \App\Models\Tab::findOrFail(1);
@endphp

<div class="lonyo-section-padding4 position-relative">
  <div class="container">
    <div class="row">
      <div class="col-lg-5 order-lg-2">
        <div class="lonyo-content-thumb" data-aos="fade-up" data-aos-duration="700">
          <img src="{{ asset($tabs->image) }}" alt="image tabs section">
        </div>
      </div>
      <div class="col-lg-7 d-flex align-items-center">
        <div class="lonyo-default-content pr-50" data-aos="fade-right" data-aos-duration="700">
          <h2>{{ $tabs->title }}</h2>
          <p class="data">{{ $tabs->description }}</p>
          <div class="mt-50">
            <ul class="tabs">
              <li class="active-tab">
                <img src="{{ asset('frontend/assets/images/v1/tv.svg') }}" alt="">
                <h4>{{ $tabs->tab_one_title }}</h4>
              </li>
              <li>
                <img src="{{ asset('frontend/assets/images/v1/alerm.svg') }}" alt="">
                <h4>{{ $tabs->tab_two_title }}</h4>
              </li>
            </ul>
            <ul class="tabs-content">
              <li>{{ $tabs->tab_one_content }}</li>
              <li>{{ $tabs->tab_two_content }}</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="lonyo-content-shape2"></div>
</div>
<div class="lonyo-content-shape3">
  <img src="{{ asset('frontend/assets/images/shape/shape2.svg') }}" alt="">
</div>
