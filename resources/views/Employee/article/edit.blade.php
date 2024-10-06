@include('Employee.assets.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Single news</h1>
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
                <h3 class="card-title">Update single news</h3>
                @if ($errors->hasAny())
                    @foreach ($errors as $error)
                        <h4>{{ $error }}</h4>
                    @endforeach
                @endif
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
                <form action="{{ route('employee.articles.update', $articles->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    {{-- <input type="hidden" name="faq_id" value="{{$faq->id}}"> --}}
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">update Title</label>
                            <input type="text" name="title" value="{!! $articles->title !!}" class="form-control"
                                id="exampleInputEmail1>
                        </div>
                        <div class="
                                form-group">
                            <label for="exampleInputEmail1">update body</label>
                            <textarea id="summernote" name="body" value="{!! $articles->body !!}" class="form-control" id="exampleInputEmail1"></textarea>
                        </div>
                        <div class=" form-group">
                            <label for="exampleInputEmail1">Is feature</label>
                            <input type="checkbox" name="isFeature" id="exampleInputEmail1">
                        </div>
                        <div class="form-control">
                            <label for="exampleInputEmail1" class="ml-3">Choose category</label>
                            <select name="category" id="exampleInputEmail1">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <label for="exampleInputEmail1" class="ml-3">Choose imployee</label>
                            <select name="employee" id="exampleInputEmail1">
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>"> --}}
                    </div>
                    <!-- /.card-body -->
                    <div class="card-body">
                        <button type="submit" name="submit" class="btn btn-primary">Update</button>
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
