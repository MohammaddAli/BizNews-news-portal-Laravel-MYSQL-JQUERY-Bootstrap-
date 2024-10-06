@include('Employee.assets.header')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Single news images</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Blank Page</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add single images</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('employee.article-images.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-control">
                            <label for="exampleInputEmail1">Add the main cover</label>
                            <input type="file" name="mainCover" id="exampleInputEmail1">
                        </div>
                        @error('mainCover')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-control">
                            <label for="exampleInputEmail1">Add the first sub cover</label>
                            <input type="file" name="firstSubCover" id="exampleInputEmail1">
                        </div>
                        @error('firstSubCover')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-control">
                            <label for="exampleInputEmail1">Add the second sub cover</label>
                            <input type="file" name="secondSubCover" id="exampleInputEmail1">
                        </div>
                        @error('secondSubCover')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="card-body">
                            <div class="form-control">
                                <label for="exampleInputEmail1" class="ml-3">Choose the single news title</label>
                                <select name="singleNewsTitle" id="exampleInputEmail1">
                                    @foreach ($articles as $article)
                                        <option value="{{ $article->id }}">{{ $article->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @error('singleNewsTitle')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <!-- /.card-body -->
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@include('Employee.assets.footer')
