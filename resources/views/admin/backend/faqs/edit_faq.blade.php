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
                    <div class="col-lg-12 col-xl-12">
                      <div class="card border mb-0">

                        <div class="card-header">
                          <div class="row align-items-center">
                            <div class="col">
                              <h4 class="card-title mb-0">Edit FAQ</h4>
                            </div><!--end col-->
                          </div>
                        </div>

                        <!--Form -->
                        <form action="{{ route('update.faq') }}" method="POST">
                          @csrf

                          <input type="hidden" name="id" value="{{ $faq->id }}">

                          <div class="card-body">

                            <div class="form-group mb-3 row">
                              <label class="form-label">Title</label>
                              <div class="col-lg-12 col-xl-12">
                                <input class="form-control" type="text" name="title" value="{{ $faq->title }}" >
                              </div>
                            </div>

                            <div class="form-group mb-3 row">
                              <label class="form-label">Description</label>
                              <div class="col-lg-12 col-xl-12">
                                <textarea name="description" class="form-control">{{ $faq->description }}</textarea>
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



@endsection


