@php
  $video = \App\Models\VideoSection::findOrFail(1);
@endphp

<div class="lonyo-section-padding bg-heading position-relative sectionn">
  <div class="container">
    <div class="row">
      <div class="col-lg-5">
        <div class="lonyo-video-thumb">
          <img src="{{ asset($video->image) }}" alt="image video">
          <a class="play-btn video-init" href="{{ $video->youtube }}">
            <img src="{{ asset('frontend/assets/images/v1/play-icon.svg') }}" alt="">
            <div class="waves wave-1"></div>
            <div class="waves wave-2"></div>
            <div class="waves wave-3"></div>
          </a>
        </div>
      </div>
      <div class="col-lg-7 d-flex align-items-center">
        <div class="lonyo-default-content lonyo-video-section pl-50" data-aos="fade-up" data-aos-duration="500">
          <h2>{{ $video->title }}</h2>
          <p>{{ $video->description }}</p>
          <div class="mt-50" data-aos="fade-up" data-aos-duration="700">
            <a class="lonyo-default-btn video-btn" href="{{ $video->link }}">Contact With Us</a>
          </div>
        </div>
      </div>
    </div>

    {{-- Process Section --}}
    @php
      // récupère tous les Process dont l’id est 1, 2 ou 3,
      // puis retourne une collection indexée par id au lieu de par un simple index numérique.
      // [1 => Process { id: 1, ... },  2 => Process { id: 2, ... }, 3 => Process { id: 3, ... }]
      // au lieu de  [0 => Process { id: 1, ... },  1 => Process { id: 2, ... }, 2 => Process { id: 3, ... }]
      $processes = \App\Models\Process::whereIn('id', [1,2,3])->get()->keyBy('id');
    @endphp
    <div class="row">

      @foreach($processes as $process)
        <div class="col-xl-4 col-md-6">
          <div class="lonyo-process-wrap" data-aos="fade-up" data-aos-duration="500">
            <div class="lonyo-process-number">
              <img src="{{ asset('frontend/assets/images/v1/n' .$process->id. '.svg') }}" alt="">
            </div>
            <div class="lonyo-process-title">
              <h4>{{ $process->title }}</h4>
            </div>
            <div class="lonyo-process-data">
              <p>{{ $process->description }}</p>
            </div>
          </div>
        </div>
      @endforeach

      <div class="border-bottom" data-aos="fade-up" data-aos-duration="500"></div>
    </div>
  </div>
</div>
<div class="lonyo-content-shape1">
  <img src="{{ asset('frontend/assets/images/shape/shape3.svg') }}" alt="">
</div>
