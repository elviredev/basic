@extends('home.home_master')
@section('home')

  <div class="breadcrumb-wrapper light-bg">
    <div class="container">

      <div class="breadcrumb-content">
        <h1 class="breadcrumb-title pb-0">{{ $category->category_name }}</h1>
        <div class="breadcrumb-menu-wrapper">
          <div class="breadcrumb-menu-wrap">
            <div class="breadcrumb-menu">
              <ul>
                <li><a href="index.html">Home</a></li>
                <li><img src="{{ asset('frontend/assets/images/blog/right-arrow.svg') }}" alt="right-arrow"></li>
                <li aria-current="page">Blog</li>
              </ul>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  <!-- End breadcrumb -->

  <div class="lonyo-section-padding9 overflow-hidden">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">

          @foreach($postsCategory as $item)
            <div class="lonyo-blog-wrap" data-aos="fade-up" data-aos-duration="500">
              <div class="lonyo-blog-thumb">
                <img src="{{ asset($item->image) }}" alt="">
              </div>
              <div class="lonyo-blog-meta">
                <ul>
                  <li>
                    <a href="{{ url('blog/details/' . $item->slug) }}"><img src="{{ asset('frontend/assets/images/blog/date.svg') }}" alt="">
                      {{ $item->created_at->format('M d, Y') }}
                    </a>
                  </li>
                </ul>
              </div>
              <div class="lonyo-blog-content">
                <h2><a href="{{ url('blog/details/' . $item->slug) }}">{{ $item->title }}</a></h2>
                <p>{!! Str::limit($item->description, 150, '...') !!}</p>
              </div>
              <div class="lonyo-blog-btn">
                <a href="{{ url('blog/details/' . $item->slug) }}" class="lonyo-default-btn blog-btn">continue reading</a>
              </div>
            </div>
          @endforeach

            <div class="lonyo-pagination center">
              {{-- Bouton "Précédent" --}}
              @if($postsCategory->onFirstPage())
                <a class="pagi-btn btn2 disabled" aria-disabled="true" >
                  <svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.75 0.75L6 6L0.75 11.25" stroke="#001A3D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </a>
              @else
                <a class="pagi-btn btn2" href="{{ $postsCategory->previousPageUrl() }}" >
                  <svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.75 0.75L6 6L0.75 11.25" stroke="#001A3D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </a>
              @endif

              {{-- Numéros de pages --}}
              <ul>
                @foreach($postsCategory->getUrlRange(1, $postsCategory->lastPage()) as $page => $url)
                  <li>
                    <a class="{{ $page == $postsCategory->currentPage() ? 'current' : '' }}" href="{{ $url }}">
                      {{ $page }}
                    </a>
                  </li>
                @endforeach
              </ul>

              {{-- Bouton "Suivant" --}}
              @if($postsCategory->hasMorePages())
                <a class="pagi-btn" href="{{ $postsCategory->nextPageUrl() }}">
                  <svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.75 0.75L6 6L0.75 11.25" stroke="#001A3D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </a>
              @else
                <a class="pagi-btn disabled" aria-disabled="true" >
                  <svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.75 0.75L6 6L0.75 11.25" stroke="#001A3D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </a>
              @endif

            </div>
        </div>

        <div class="col-lg-4">
          <div class="lonyo-blog-sidebar" data-aos="fade-left" data-aos-duration="700">
            <div class="lonyo-blog-widgets">
              <form action="#">
                <div class="lonyo-search-box">
                  <input type="search" placeholder="Type keyword here">
                  <button id="lonyo-search-btn" type="button"><i class="ri-search-line"></i></button>
                </div>
              </form>
            </div>
            <div class="lonyo-blog-widgets">
              <h4>Categories:</h4>
              <div class="lonyo-blog-categorie">
                <ul>
                  @foreach($categories as $category)
                    <li>
                      <a href="{{ url('blog/category/' . $category->id) }}">{{ $category->category_name }}
                        <span>({{ $category->posts_count }})</span>
                      </a>
                    </li>
                  @endforeach
                </ul>
              </div>
            </div>

            <div class="lonyo-blog-widgets">
              <h4>Recent Posts</h4>

              @foreach($recentsPost as $recent)
                <a class="lonyo-blog-recent-post-item" href="{{ url('blog/details/' . $recent->slug) }}">
                  <div class="lonyo-blog-recent-post-thumb">
                    <img src="{{ asset($recent->image) }}" alt="" style="width: 150px; height: 120px;">
                  </div>
                  <div class="lonyo-blog-recent-post-data">
                    <ul>
                      <li><img src="{{ asset('frontend/assets/images/blog/date.svg') }}" alt="">J
                        {{ $recent->created_at->format('M d, Y') }}
                      </li>
                    </ul>
                    <div>
                      <h4>{{ $recent->title }}</h4>
                    </div>
                  </div>
                </a>
              @endforeach

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end blog -->

  <div class="lonyo-content-shape">
    <img src="{{ asset('frontend/assets/images/shape/shape2.svg') }}" alt="">
  </div>

  @include('home.home_layout.cta')
  <!-- end cta -->

@endsection

