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
              <h5 class="card-title mb-0">All Messages</h5>
            </div><!-- end card header -->

            <div class="card-body">
              <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap ">
                <thead>
                <tr>
                  <th>Sl</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Message</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($messages as $key => $item)
                  <tr>
                    <td >{{ $key+1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ Str::limit($item->message, 50, '...') }}</td>
                    <td>
                      <a href="{{ route('delete.message', $item->id) }}" class="btn btn-danger btn-sm" id="delete">Delete</a>
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

