@include('Employee.assets.header')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    @if ($errors->hasAny())
        @foreach ($errors as $error)
            <h4>{{ $error }}</h4>
        @endforeach
    @endif
    <form action="{{ route('employee.article-images.update', $articleImages->id) }}" method="post"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Update the images</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <img class="mw-100 mb-3" src="{{ $articleImages->url_main }}" alt="Main image">
                            <div class="form-control">
                                <label for="exampleInputEmail1">update the main cover</label>
                                <input type="file" name="mainCover" id="exampleInputEmail1">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img class="mw-100 mb-3" src="{{ $articleImages->url_sub1 }}" alt="Sub image1">
                            <div class="form-control">
                                <label for="exampleInputEmail1">update the first sub cover</label>
                                <input type="file" name="firstSubCover" id="exampleInputEmail1">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img class="mw-100" src="{{ $articleImages->url_sub2 }}" alt="Sub image2">
                            <div class="form-control">
                                <label for="exampleInputEmail1">update the second sub cover</label>
                                <input type="file" name="secondSubCover" id="exampleInputEmail1">
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-body">
            <button type="submit" name="update" class="btn btn-primary">Update</button>
        </div>
    </form>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@include('Employee.assets.footer')
