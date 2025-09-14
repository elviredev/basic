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
                              <h4 class="card-title mb-0">Add Blog Post</h4>
                            </div><!--end col-->
                          </div>
                        </div>

                        <!--Form -->
                        <form action="{{ route('store.blog.post') }}" method="POST" enctype="multipart/form-data">
                          @csrf

                          <div class="card-body">

                            <div class="form-group mb-3 row">
                              <label class="form-label">Category</label>
                              <div class="col-lg-6 col-xl-6">
                                <select class="form-select @error('category_id') is-invalid @enderror" name="category_id" id="example-select">
                                  <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>Select Category</option>
                                  @foreach($categories as $category)
                                    <option
                                      value="{{ $category->id }}"
                                      {{ old('category_id') == $category->id ? 'selected' : '' }}
                                    >
                                      {{ $category->category_name }}
                                    </option>
                                  @endforeach
                                </select>
                                @error('category_id')
                                <div class="invalid-feedback">
                                  {{ $message }}
                                </div>
                                @enderror
                              </div>
                            </div>

                            <div class="form-group mb-3 row">
                              <label class="form-label">Title</label>
                              <div class="col-lg-6 col-xl-6">
                                <input
                                  class="form-control @error('title') is-invalid @enderror"
                                  type="text"
                                  name="title"
                                  value="{{ old('title') }}"
                                >
                                @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                              </div>
                            </div>

                            <div class="form-group mb-3 row">
                              <label class="form-label">Description</label>
                              <div class="col-lg-12 col-xl-12">
                                <textarea name="description" id="description" style="display: none">{{ old('description') }}</textarea>

                                <div id="quill-editor-post" style="height: 200px;"></div>
                                @error('description')
                                <small class="text-danger mt-2">
                                  {{ $message }}
                                </small>
                                @enderror
                              </div>
                            </div>

                            <div class="form-group mb-3 row">
                              <label class="form-label">Post Image</label>
                              <div class="col-lg-12 col-xl-12">
                                <input class="form-control @error('image') is-invalid @enderror" type="file" name="image" id="image">
                                @error('image')
                                <small class="text-danger d-block mt-2">{{ $message }}</small>
                                @enderror
                              </div>
                            </div>

                            <div class="form-group mb-3 row">
                              <div class="col-lg-12 col-xl-12">
                                <img
                                  id="showImage"
                                  src="{{ url('upload/no_image.jpg') }}"
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
    document.addEventListener("DOMContentLoaded", function () {
      const quill = new Quill("#quill-editor-post", {
        theme: "snow"
      });

      // Remplir Quill avec l'ancienne valeur si validation échouée
      const oldDescription = {!! json_encode(old('description')) !!};
      if (oldDescription) {
        quill.root.innerHTML = oldDescription;
      }

      // Synchroniser avec textarea avant submit
      const form = document.querySelector("form");
      form.addEventListener("submit", function () {
        let content = quill.root.innerHTML.trim();

        // Nettoyer le contenu vide de Quill
        if (content === "<p><br></p>" || content === "") {
          content = "";
        }

        document.querySelector("#description").value = content;
      });
    });
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




