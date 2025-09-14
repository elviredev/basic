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
              <h5 class="card-title mb-0">All Blog Posts</h5>
            </div><!-- end card header -->

            <div class="card-body">
              <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap ">
                <thead>
                <tr>
                  <th>Sl</th>
                  <th>Category</th>
                  <th>Title</th>
                  <th>Image</th>
                  <th>Description</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($posts as $key => $item)
                  <tr>
                    <td >{{ $key+1 }}</td>
                    <td>{{ $item['blog']['category_name'] }}</td>
                    <td>{{ $item->title }}</td>
                    <td>
                      <img src="{{ asset($item->image) }}" style="width: 60px; height: 40px;" alt="image">
                    </td>
                    <td>{!! \Illuminate\Support\Str::limit($item->description, 50, '...') !!}</td>
                    <td>
                      <a href="{{ route('edit.blog.post', $item->id) }}" class="btn btn-success btn-sm">Edit</a>
                      <a href="{{ route('delete.blog.post', $item->id) }}" class="btn btn-danger btn-sm" id="delete">Delete</a>
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

