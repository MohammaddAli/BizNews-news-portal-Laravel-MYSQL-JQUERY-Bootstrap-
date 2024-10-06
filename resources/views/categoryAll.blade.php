@include('assets.header');

<!-- News With Sidebar Start -->
<div class="container-fluid mt-5 pt-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">

                <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <h4 class="m-0 text-uppercase font-weight-bold">Category: {{ $category->name }}</h4>
                            <!-- <a class="text-secondary font-weight-medium text-decoration-none" href="./$category">View All</a> -->
                            <a class="text-secondary font-weight-medium text-decoration-none"
                                href="{{ route('categoryAll', $category->id) }}">View All</a>
                        </div>
                    </div>
                    @foreach ($category->articles as $article)
                        <div class="col-lg-6">
                            <div class="position-relative mb-3">
                                <img class="img-fluid w-100" src="{{ $article->articleImage->url_main }}"
                                    style="object-fit: cover;">
                                <div class="bg-white border border-top-0 p-4">
                                    <div class="mb-2">
                                        <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                            href="">{{ $category->name }}</a>
                                        <a class="text-body"
                                            href=""><small>{{ $article->created_at }}</small></a>
                                    </div>
                                    <a class="h4 d-block mb-3 text-secondary text-uppercase font-weight-bold"
                                        href="">{{ substr($article->title, 0, 70) }}</a>
                                    <p class="m-0">{{ substr($article->body, 0, 100) }}</p>
                                </div>
                                <div class="d-flex justify-content-between bg-white border border-top-0 p-4">
                                    <div class="d-flex align-items-center">
                                        <img class="rounded-circle mr-2" src="{{ $article->employee->image }}"
                                            width="25" height="25" alt="">
                                        <small>{{ $article->employee->name }}</small>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <small class="ml-3"><i class="far fa-eye mr-2"></i>12345</small>
                                        <small class="ml-3"><i class="far fa-comment mr-2"></i>123</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>


            @include('assets.footer');
