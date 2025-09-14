@extends('admin.admin_master')
@section('admin')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <div class="content">

    <!-- Start Content-->
    <div class="container-xxl">

      <!-- Start Row -->
      <div class="row py-4">
        <div class="col-12 ">
          <div class="card">

            <div class="card-body">

              <div class="tab-pane pt-4" id="profile_setting" role="tabpanel">
                <div class="row">
                  <div class="row">
                    <div class="col-lg-8 col-xl-8 mx-auto">
                      <div class="card border mb-0">

                        <div class="card-header">
                          <div class="row align-items-center">
                            <div class="col">
                              <h4 class="card-title mb-0">Edit Blog Post</h4>
                            </div><!--end col-->
                          </div>
                        </div>

                        <!--Form -->
                        <form action="{{ route('update.blog.post') }}" method="POST" enctype="multipart/form-data">
                          @csrf

                          <input type="hidden" name="id" value="{{ $post->id }}">

                          <div class="card-body">

                            <div class="form-group mb-3 row">
                              <label class="form-label">Category</label>
                              <div class="col-lg-6 col-xl-6">
                                <select class="form-select" name="category_id" id="example-select">
                                  <option selected="">Select Category</option>
                                  @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $category->id === $post->category_id ? "selected" : "" }}>
                                      {{ $category->category_name }}
                                    </option>
                                  @endforeach
                                </select>
                              </div>
                            </div>

                            <div class="form-group mb-3 row">
                              <label class="form-label">Title</label>
                              <div class="col-lg-6 col-xl-6">
                                <input class="form-control" type="text" name="title" value="{{ $post->title }}" >
                              </div>
                            </div>

                            <div class="form-group mb-3 row">
                              <label class="form-label">Description</label>
                              <div class="col-lg-12 col-xl-12">
                                <textarea name="description" id="description" style="display: none"></textarea>

                                <div id="quill-editor" style="height: 200px;">
                                  {!! $post->description !!}
                                </div>
                              </div>
                            </div>

                            <div class="form-group mb-3 row">
                              <label class="form-label">Post Image</label>
                              <div class="col-lg-12 col-xl-12">
                                <input class="form-control" type="file" name="image" id="image">
                              </div>
                            </div>

                            <div class="form-group mb-3 row">
                              <div class="col-lg-12 col-xl-12">
                                <img
                                  id="showImage"
                                  src="{{ asset($post->image) }}"
                                  class="video-prevu-image img-thumbnail float-start"
                                  alt="image blog post"
                                >
                              </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Save Changes</button>

                          </div><!--end card-body-->
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>


    </div>
  </div>

  <script>
    document.querySelector('form').onsubmit = function() {
      const description = document.querySelector('#description');
      description.value = quill.root.innerHTML;
    }
  </script>

  <script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function () {
      const imageInput = document.getElementById("image");
      const showImage = document.getElementById("showImage");

      let currentObjectURL = null; // pour stocker l'URL temporaire

      imageInput.addEventListener("change", function (e) {
        const file = e.target.files[0]; // premier fichier sélectionné

        if (file) {
          // Si une URL précédente existe, on la libère
          if (currentObjectURL) {
            URL.revokeObjectURL(currentObjectURL);
          }

          // Création d'une nouvelle URL temporaire
          currentObjectURL = URL.createObjectURL(file);

          // Mise à jour de l'image
          showImage.src = currentObjectURL;
        }
      });
    });
  </script>

@endsection





