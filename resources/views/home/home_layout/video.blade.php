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
              <h4
                class="editable-title"
                contenteditable="{{ auth()->check() ? 'true' : 'false' }}"
                data-id="{{ $process->id }}"
              >
                {{ $process->title }}
              </h4>
            </div>
            <div class="lonyo-process-data">
              <p
                class="editable-description"
                contenteditable="{{ auth()->check() ? 'true' : 'false' }}"
                data-id="{{ $process->id }}"
              >
                {{ $process->description }}
              </p>
            </div>
          </div>
        </div>
      @endforeach

      <div class="border-bottom" data-aos="fade-up" data-aos-duration="500"></div>
    </div>
  </div>
</div>


{{-- CSRF Token --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
  document.addEventListener("DOMContentLoaded", function() {

    function saveChanges(element) {
      let processId = element.dataset.id;
      let field = element.classList.contains("editable-title") ? "title" : "description";
      let newValue = element.innerText.trim();

      fetch(`/update-process-data/${processId}`, {
        method: "POST",
        headers: {
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ [field]: newValue }),
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            console.log(`${field} updated successfully!`);
          }
        })
        .catch(error => console.error("Error:", error));
    }

    // Auto save on Enter Key
    document.addEventListener("keydown", function(e) {
      if (e.key === "Enter") {
        e.preventDefault();
        saveChanges(e.target);
      }
    })

    // Auto save on losing focus
    document.querySelectorAll(".editable-title, .editable-description").forEach((el) => {
      el.addEventListener("blur", function() {
        saveChanges(el);
      });
    })

  })
</script>
