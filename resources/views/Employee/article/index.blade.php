@include('Employee.assets.header')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <a href="{{ route('employee.articles.create') }}" class="btn btn-success">Add new single news</a>
        <!-- Default box -->
        <div class="card">
            <div class="card-body">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All news</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#ID</th>
                                    <th>title</th>
                                    <th>body</th>
                                    <th>images</th>
                                    <th class="text-right">Update</th>
                                    <th class="text-right">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($articles as $article)
                                    <tr>
                                        <td>{{ $article->id }}</td>
                                        <td>{!! $article->title !!}</td>
                                        <td>{!! $article->body !!}</td>
                                        <td>
                                            <img class="mw-100 mb-3" src="{{ $article->articleImage->url_main }}"
                                                alt="Main image">
                                            <img class="mw-100 mb-3" src="{{ $article->articleImage->url_sub1 }}"
                                                alt="Sub image1">
                                            <img class="mw-100" src="{{ $article->articleImage->url_sub2 }}"
                                                alt="Sub image2">
                                        </td>
                                        <td class="text-right"> <a
                                                href="{{ route('employee.articles.edit', $article->id) }}"
                                                class="btn btn-primary">update</a></td>
                                        <td>
                                            <form action="{{ route('employee.articles.destroy', $article->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="submit" value="delete" class="btn btn-primary">
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div>
                            {{ $articles->links() }}
                        </div>
                    </div>
                    <!-- /.card-body -->

                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@include('Employee.assets.footer')
