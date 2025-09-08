@extends('admin.admin_master')
@section('admin')

<div class="content">

  <!-- Start Content-->
  <div class="container-xxl">

    <!-- Datatables  -->
    <div class="row py-4">
      <div class="col-12">
        <div class="card">

          <div class="card-header">
            <h5 class="card-title mb-0">All Reviews</h5>
          </div><!-- end card header -->

          <div class="card-body">
            <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap ">
              <thead>
              <tr>
                <th>Sl</th>
                <th>Name</th>
                <th>Position</th>
                <th>Image</th>
                <th>Message</th>
                <th>Actions</th>
              </tr>
              </thead>
              <tbody>
              @foreach($reviews as $key => $item)
                <tr>
                  <td >{{ $key+1 }}</td>
                  <td>{{ $item->name }}</td>
                  <td>{{ $item->position }}</td>
                  <td>
                    <img src="{{ asset($item->image) }}" style="width: 70px; height: 70px;" alt="image">
                  </td>
                  <td>{{ \Illuminate\Support\Str::limit($item->message, 50, '...') }}</td>
                  <td>
                    <a href="{{ route('edit.review', $item->id) }}" class="btn btn-success btn-sm">Edit</a>
                    <a href="{{ route('delete.review', $item->id) }}" class="btn btn-danger btn-sm" id="delete">Delete</a>
                  </td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>


  </div>

</div>

@endsection
