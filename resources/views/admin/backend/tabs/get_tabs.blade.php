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
                              <h4 class="card-title mb-0">Edit Tabs Section</h4>
                            </div><!--end col-->
                          </div>
                        </div>

                        <!--Form -->
                        <form action="{{ route('update.tabs') }}" method="POST" enctype="multipart/form-data">
                          @csrf

                          <input type="hidden" name="id" value="{{ $tabs->id }}">

                          <div class="card-body">

                            <div class="form-group mb-3 row">
                              <label class="form-label">Title</label>
                              <div class="col-lg-12 col-xl-12">
                                <input class="form-control" type="text" name="title" value="{{ $tabs->title }}" >
                              </div>
                            </div>

                            <div class="form-group mb-3 row">
                              <label class="form-label">Description</label>
                              <div class="col-lg-12 col-xl-12">
                                <textarea name="description" class="form-control">{{ $tabs->description }}</textarea>
                              </div>
                            </div>

                            <div class="form-group mb-3 row">
                              <label class="form-label">Tab One Title</label>
                              <div class="col-lg-12 col-xl-12">
                                <input class="form-control" type="text" name="tab_one_title" value="{{ $tabs->tab_one_title }}" >
                              </div>
                            </div>

                            <div class="form-group mb-3 row">
                              <label class="form-label">Tab One Content</label>
                              <div class="col-lg-12 col-xl-12">
                                <textarea name="tab_one_content" class="form-control">{{ $tabs->tab_one_content }}</textarea>
                              </div>
                            </div>

                            <div class="form-group mb-3 row">
                              <label class="form-label">Tab Two Title</label>
                              <div class="col-lg-12 col-xl-12">
                                <input class="form-control" type="text" name="tab_two_title" value="{{ $tabs->tab_two_title }}" >
                              </div>
                            </div>

                            <div class="form-group mb-3 row">
                              <label class="form-label">Tab Two Content</label>
                              <div class="col-lg-12 col-xl-12">
                                <textarea name="tab_two_content" class="form-control">{{ $tabs->tab_two_content }}</textarea>
                              </div>
                            </div>

                            <div class="form-group mb-3 row">
                              <label class="form-label">Tabs Section Photo</label>
                              <div class="col-lg-12 col-xl-12">
                                <input class="form-control" type="file" name="image" id="image">
                              </div>
                            </div>

                            <div class="form-group mb-3 row">
                              <div class="col-lg-12 col-xl-12">
                                <img
                                  id="showImage"
                                  src="{{ asset($tabs->image) }}"
                                  class="hero-prevu-image img-thumbnail float-start"
                                  alt="image tool section"
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




