@include('assets.header')
<!-- Breaking News Start -->
<div class="container-fluid mt-5 mb-3 pt-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="d-flex justify-content-between">
                    <div class="section-title border-right-0 mb-0" style="width: 180px;">
                        <h4 class="m-0 text-uppercase font-weight-bold">Trending</h4>
                    </div>
                    <div class="owl-carousel tranding-carousel position-relative d-inline-flex align-items-center bg-white border border-left-0"
                        style="width: calc(100% - 180px); padding-right: 100px;">
                        @foreach ($trendingNews as $singleTrendingNews)
                            <div class="text-truncate"><a class="text-secondary text-uppercase font-weight-semi-bold"
                                    href="">{{ $singleTrendingNews->title }}</a></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breaking News End -->

<!-- News With Sidebar Start -->
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- News Detail Start -->
                <div class="position-relative mb-3">
                    <img class="img-fluid w-100" src="{{ $singleNews->articleImage->url_main }}"
                        style="object-fit: cover;">

                    <div class="bg-white border border-top-0 p-4">
                        <div class="mb-3">
                            <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                href="">{{ $singleNews->category->name }}</a>
                            <a class="text-body" href="">{{ $singleNews->createt_at }}</a>
                        </div>
                        <h1 class="mb-3 text-secondary text-uppercase font-weight-bold">{{ $singleNews->title }}</h1>
                        <p>{!! $firstPart !!}</p>
                        <img class="img-fluid w-50 float-left mr-4 mb-2"
                            src="{{ $singleNews->articleImage->url_sub1 }}">
                        <p>{!! $secondPart !!}</p>
                        <img class="img-fluid w-50 float-right mr-4 mb-2"
                            src="{{ $singleNews->articleImage->url_sub2 }}">
                        <!-- style="overflow-x: hidden; height: 1%;" -->
                        <p>{!! $thirdPart !!}</p>
                    </div>

                    <div class="d-flex justify-content-between bg-white border border-top-0 p-4">
                        <div class="d-flex align-items-center">
                            <img class="rounded-circle mr-2" src="{{ $singleNews->employee->image }}" width="25"
                                height="25" alt="">
                            <span>{{ $singleNews->employee->name }}</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="ml-3"><i class="far fa-eye mr-2"></i>{{ $viewsCount }}</span>
                            <span class="ml-3"><i class="far fa-comment mr-2"></i>{{ $allComments->count() }}</span>
                        </div>
                    </div>
                </div>
                <!-- News Detail End -->


                <!-- Comment List Start -->
                <div class="mb-3">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">{{ $allComments->count() }}
                            {{ $allComments->count() === 1 ? 'Comment' : 'Comments' }}</h4>
                    </div>
                    <div class="bg-white border border-top-0 p-4" id="comment-list">
                        <!-- <?php print_r($allComments); ?> -->
                        @if ($allComments != '0')
                            @foreach ($allComments as $comment)
                                <div class="media mb-4">
                                    <img src="{{ $comment->userImage }}" alt="Image" class="img-fluid mr-3 mt-1"
                                        style="width: 45px;">
                                    <div class="media-body">
                                        <h6><a class="text-secondary font-weight-bold"
                                                href="">{{ $comment->userName }}</a>
                                            <small><i>{{ $comment->created_at }}</i></small>
                                        </h6>
                                        <input type="hidden" name="commentId" class="commentId"
                                            value="{{ $comment->commentId }}">
                                        <p> {{ $comment->message }} </p>
                                        @if (Auth::user())
                                            <button type="button" class="btn btn-sm btn-outline-secondary reply"
                                                data-toggle="modal" data-target="#exampleModal">Reply</button>
                                        @endif
                                        <div class="replyDiv">
                                            @php
                                                if (count($allcommentReplies)) {
                                                    $commentReliesArr = [];
                                                    // if (!empty($commentReliesArr)) {
                                                    foreach ($allcommentReplies as $onecommentReply) {
                                                        if ($onecommentReply->comments_id == $comment->commentId) {
                                                            // var_dump($onecommentReply->message);

                                                            $commentReliesArr[] = $onecommentReply;
                                                        }
                                                    }
                                                    // }
                                                }
                                            @endphp
                                            @if (!empty($commentReliesArr))
                                                {{-- {{var_dump($commentReliesArr)}} --}}
                                                @foreach ($commentReliesArr as $commentRelies)
                                                    {{ $commentRelies->messages }}
                                                    {{-- <p>{{ isset($commentRelies->messages) ? $commentRelies->message : '' }}</p> --}}
                                                    <p>{{ $commentRelies->message }}</p>
                                                @endforeach
                                            @endif
                                            {{-- @endif --}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <!-- Comment List End -->

                <!-- Comment Form Start -->
                @if (Auth::user())
                    <div class="mb-3">
                        <div class="section-title mb-0">
                            <h4 class="m-0 text-uppercase font-weight-bold">Leave a comment</h4>
                        </div>
                        <div class="bg-white border border-top-0 p-4">
                            {{-- action="single.php" method="POST" --}}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form>
                                @csrf
                                <div class="form-group">
                                    <label for="message">Message *</label>
                                    <textarea name="comment" id="comment" cols="30" rows="5" class="form-control"></textarea>
                                    <input type="hidden" name="singleNewsId" id="singleNewsId"
                                        value="{{ $singleNews->id }}">
                                </div>
                                <div class="form-group mb-0">
                                    <input type="submit" name="submit" id="submit" value="Leave a comment"
                                        class="btn btn-primary font-weight-semi-bold py-2 px-3">
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
                <!-- Comment Form End -->
            </div>

            <div class="col-lg-4">
                <!-- Social Follow Start -->
                <div class="mb-3">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">Follow Us</h4>
                    </div>
                    <div class="bg-white border border-top-0 p-3">
                        <a href="" class="d-block w-100 text-white text-decoration-none mb-3"
                            style="background: #39569E;">
                            <i class="fab fa-facebook-f text-center py-4 mr-3"
                                style="width: 65px; background: rgba(0, 0, 0, .2);"></i>
                            <span class="font-weight-medium">12,345 Fans</span>
                        </a>
                        <a href="" class="d-block w-100 text-white text-decoration-none mb-3"
                            style="background: #52AAF4;">
                            <i class="fab fa-twitter text-center py-4 mr-3"
                                style="width: 65px; background: rgba(0, 0, 0, .2);"></i>
                            <span class="font-weight-medium">12,345 Followers</span>
                        </a>
                        <a href="" class="d-block w-100 text-white text-decoration-none mb-3"
                            style="background: #0185AE;">
                            <i class="fab fa-linkedin-in text-center py-4 mr-3"
                                style="width: 65px; background: rgba(0, 0, 0, .2);"></i>
                            <span class="font-weight-medium">12,345 Connects</span>
                        </a>
                        <a href="" class="d-block w-100 text-white text-decoration-none mb-3"
                            style="background: #C8359D;">
                            <i class="fab fa-instagram text-center py-4 mr-3"
                                style="width: 65px; background: rgba(0, 0, 0, .2);"></i>
                            <span class="font-weight-medium">12,345 Followers</span>
                        </a>
                        <a href="" class="d-block w-100 text-white text-decoration-none mb-3"
                            style="background: #DC472E;">
                            <i class="fab fa-youtube text-center py-4 mr-3"
                                style="width: 65px; background: rgba(0, 0, 0, .2);"></i>
                            <span class="font-weight-medium">12,345 Subscribers</span>
                        </a>
                        <a href="" class="d-block w-100 text-white text-decoration-none"
                            style="background: #055570;">
                            <i class="fab fa-vimeo-v text-center py-4 mr-3"
                                style="width: 65px; background: rgba(0, 0, 0, .2);"></i>
                            <span class="font-weight-medium">12,345 Followers</span>
                        </a>
                    </div>
                </div>
                <!-- Social Follow End -->

                <!-- Ads Start -->
                <div class="mb-3">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">Advertisement</h4>
                    </div>
                    <div class="bg-white text-center border border-top-0 p-3">
                        <a href=""><img class="img-fluid" src="./design_assets/front/img/news-800x500-2.jpg"
                                alt=""></a>
                    </div>
                </div>
                <!-- Ads End -->

                <!-- Popular News Start -->
                <div class="mb-3">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">Trending News</h4>
                    </div>
                    <div class="bg-white border border-top-0 p-3">
                        @foreach ($trendingNews as $singleTrendingNews)
                            <div class="d-flex align-items-center bg-white mb-3" style="height: 110px;">
                                <img class="img-fluid w-100" src="{{ $singleTrendingNews->url_main }}"
                                    alt="" style="object-fit: cover;">
                                <div
                                    class="w-100 h-100 px-3 d-flex flex-column justify-content-center border border-left-0">
                                    <div class="mb-2">
                                        <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2"
                                            href="">{{ $singleTrendingNews->categoryName }}</a>
                                        <a class="text-body"
                                            href=""><small>{{ $singleTrendingNews->articles_created_at }}</small></a>
                                    </div>
                                    <a class="h6 m-0 text-secondary text-uppercase font-weight-bold" href=""
                                        style="overflow: hidden;">{{ $singleTrendingNews->title }}</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Popular News End -->

                <!-- Newsletter Start -->
                <div class="mb-3">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">Newsletter</h4>
                    </div>
                    <div class="bg-white text-center border border-top-0 p-3">
                        <p>Aliqu justo et labore at eirmod justo sea erat diam dolor diam vero kasd
                        </p>
                        <div class="input-group mb-2" style="width: 100%;">
                            <input type="text" class="form-control form-control-lg" placeholder="Your Email">
                            <div class="input-group-append">
                                <button class="btn btn-primary font-weight-bold px-3">Sign
                                    Up</button>
                            </div>
                        </div>
                        <small>Lorem ipsum dolor sit amet elit</small>
                    </div>
                </div>
                <!-- Newsletter End -->

                <!-- Tags Start -->
                <div class="mb-3">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">Tags</h4>
                    </div>
                    <div class="bg-white border border-top-0 p-3">
                        <div class="d-flex flex-wrap m-n1">
                            <a href="" class="btn btn-sm btn-outline-secondary m-1">Politics</a>
                            <a href="" class="btn btn-sm btn-outline-secondary m-1">Business</a>
                            <a href="" class="btn btn-sm btn-outline-secondary m-1">Corporate</a>
                            <a href="" class="btn btn-sm btn-outline-secondary m-1">Business</a>
                            <a href="" class="btn btn-sm btn-outline-secondary m-1">Health</a>
                            <a href="" class="btn btn-sm btn-outline-secondary m-1">Education</a>
                            <a href="" class="btn btn-sm btn-outline-secondary m-1">Science</a>
                            <a href="" class="btn btn-sm btn-outline-secondary m-1">Business</a>
                            <a href="" class="btn btn-sm btn-outline-secondary m-1">Foods</a>
                            <a href="" class="btn btn-sm btn-outline-secondary m-1">Travel</a>
                        </div>
                    </div>
                </div>
                <!-- Tags End -->
            </div>
        </div>
    </div>
</div>
<!-- News With Sidebar End -->


<!-- Footer Start -->
<div class="container-fluid bg-dark pt-5 px-sm-3 px-md-5 mt-5">
    <div class="row py-4">
        <div class="col-lg-3 col-md-6 mb-5">
            <h5 class="mb-4 text-white text-uppercase font-weight-bold">Get In Touch</h5>
            <p class="font-weight-medium"><i class="fa fa-map-marker-alt mr-2"></i>123 Street, New York,
                USA</p>
            <p class="font-weight-medium"><i class="fa fa-phone-alt mr-2"></i>+012 345 67890</p>
            <p class="font-weight-medium"><i class="fa fa-envelope mr-2"></i>info@example.com</p>
            <h6 class="mt-4 mb-3 text-white text-uppercase font-weight-bold">Follow Us</h6>
            <div class="d-flex justify-content-start">
                <a class="btn btn-lg btn-secondary btn-lg-square mr-2" href="#"><i
                        class="fab fa-twitter"></i></a>
                <a class="btn btn-lg btn-secondary btn-lg-square mr-2" href="#"><i
                        class="fab fa-facebook-f"></i></a>
                <a class="btn btn-lg btn-secondary btn-lg-square mr-2" href="#"><i
                        class="fab fa-linkedin-in"></i></a>
                <a class="btn btn-lg btn-secondary btn-lg-square mr-2" href="#"><i
                        class="fab fa-instagram"></i></a>
                <a class="btn btn-lg btn-secondary btn-lg-square" href="#"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-5">
            <h5 class="mb-4 text-white text-uppercase font-weight-bold">Popular News</h5>
            <div class="mb-3">
                <div class="mb-2">
                    <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2"
                        href="">Business</a>
                    <a class="text-body" href=""><small>Jan 01, 2045</small></a>
                </div>
                <a class="small text-body text-uppercase font-weight-medium" href="">Lorem ipsum
                    dolor sit amet
                    elit. Proin vitae porta diam...</a>
            </div>
            <div class="mb-3">
                <div class="mb-2">
                    <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2"
                        href="">Business</a>
                    <a class="text-body" href=""><small>Jan 01, 2045</small></a>
                </div>
                <a class="small text-body text-uppercase font-weight-medium" href="">Lorem ipsum
                    dolor sit amet
                    elit. Proin vitae porta diam...</a>
            </div>
            <div class="">
                <div class="mb-2">
                    <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2"
                        href="">Business</a>
                    <a class="text-body" href=""><small>Jan 01, 2045</small></a>
                </div>
                <a class="small text-body text-uppercase font-weight-medium" href="">Lorem ipsum
                    dolor sit amet
                    elit. Proin vitae porta diam...</a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-5">
            <h5 class="mb-4 text-white text-uppercase font-weight-bold">Categories</h5>
            <div class="m-n1">
                {{-- @foreach ($allCategories as $category)
                    <a href="./category_view_all.php?id=<?php echo $category['id']; ?>"
                        class="btn btn-sm btn-secondary m-1"><?php echo $category['name']; ?> </a>
                @endforeach --}}
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-5">
            <h5 class="mb-4 text-white text-uppercase font-weight-bold">Flickr Photos</h5>
            <div class="row">
                <div class="col-4 mb-3">
                    <a href=""><img class="w-100" src="./design_assets/front/img/news-110x110-1.jpg"
                            alt=""></a>
                </div>
                <div class="col-4 mb-3">
                    <a href=""><img class="w-100" src="./design_assets/front/img/news-110x110-2.jpg"
                            alt=""></a>
                </div>
                <div class="col-4 mb-3">
                    <a href=""><img class="w-100" src="./design_assets/front/img/news-110x110-3.jpg"
                            alt=""></a>
                </div>
                <div class="col-4 mb-3">
                    <a href=""><img class="w-100" src="./design_assets/front/img/news-110x110-4.jpg"
                            alt=""></a>
                </div>
                <div class="col-4 mb-3">
                    <a href=""><img class="w-100" src="./design_assets/front/img/news-110x110-5.jpg"
                            alt=""></a>
                </div>
                <div class="col-4 mb-3">
                    <a href=""><img class="w-100" src="./design_assets/front/img/news-110x110-1.jpg"
                            alt=""></a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid py-4 px-sm-3 px-md-5" style="background: #111111;">
    <p class="m-0 text-center">&copy; <a href="#">Your Site Name</a>. All Rights Reserved.

        <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
        Design by <a href="https://htmlcodex.com">HTML Codex</a>
    </p>
</div>
<!-- Footer End -->

<!-- Back to Top -->
<a href="#" class="btn btn-primary btn-square back-to-top"><i class="fa fa-arrow-up"></i></a>


<!-- JavaScript Libraries -->
<!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="./design_assets/front/lib/easing/easing.min.js"></script>
<script src="./design_assets/front/lib/owlcarousel/owl.carousel.min.js"></script>
<!-- bootstrap CDN-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<!-- Template Javascript -->
<script src="./design_assets/front/js/main.js"></script>
<script>
    const exampleModal = document.getElementById('exampleModal')
    if (exampleModal) {
        exampleModal.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            const button = event.relatedTarget
            // Extract info from data-bs-* attributes
            const recipient = button.getAttribute('data-bs-whatever')
            // If necessary, you could initiate an Ajax request here
            // and then do the updating in a callback.

            // Update the modal's content.
            const modalTitle = exampleModal.querySelector('.modal-title')
            const modalBodyInput = exampleModal.querySelector('.modal-body input')

            modalTitle.textContent = `New message to ${recipient}`
            modalBodyInput.value = recipient
        })
    }

    $(document).ready(function() {

        $("#submit").on("click", function(event) {
            event.preventDefault();
            let comment = $("#comment").val();
            let singleNewsId = $('#singleNewsId').val();

            $.ajax({
                method: "POST",
                url: "{{ route('comments.store') }}",
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content')
                },
                data: {
                    comment: comment,
                    singleNewsId: singleNewsId
                },
                success: function(response) {
                    console.log(response);
                    $("#comment").val("");
                    let comment = response;
                    // newComments.forEach(comment => {
                    $("#comment-list").append(`<div class="media mb-4">
                        <img src="./user_avatar/${comment.userImage}" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                        <div class="media-body">
                            <h6><a class="text-secondary font-weight-bold" href="">${comment.userName}</a> <small><i>${comment.created_at}</i></small></h6>
                            <p>${comment.message}</p>
                            <?php if (isset($_SESSION["email"])) { ?><button class="btn btn-sm btn-outline-secondary reply";">Reply</button> <?php } ?>
                        </div>
                    </div>`)
                    // });
                },
                error: function() {
                    alert("An error occurred while submitting the comment.");
                }
            });
        });

        $("#comment-list").on("click", ".reply", function(e) {
            e.preventDefault();
            if ($(e.target).hasClass("reply")) {
                // Find the closest ancestor with the class 'media-body' from the clicked button
                let mediaBody = $(e.target).closest('.media-body');

                let commentId = mediaBody.find(".commentId").val();
                // console.log(commentId);
                $('.replyDiv').html("");
                if (mediaBody.length > 0) {
                    // Find the specific replyDiv within the current mediaBody
                    mediaBody.find('.replyDiv').html(`<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New reply</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Message:</label>
            <textarea name="replyInput" class="form-control replyInput" id="message-text"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary submitReply" data-dismiss="modal">Submit reply</button>
      </div>
    </div>
  </div>
</div>`);
                }

                mediaBody.find(".submitReply").on("click", function(e) {
                    console.log('commentId=', commentId);
                    let replyMessage = $(".replyInput").val();
                    console.log(replyMessage);
                    $.ajax({
                        method: "POST",
                        url: "{{ route('commentReply.store') }}",
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]').getAttribute('content')
                        },
                        data: {
                            commentId: commentId,
                            replyMessage: replyMessage
                        },
                        success: function(response) {
                            console.log("AJAX Response:", response);
                            mediaBody.find('.replyDiv').append(
                                `<p>${response.message}</p>`);
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error:", error);
                            alert(
                                "An error occurred while submitting the comment.."
                            );
                        }
                    });
                });
            }
        });

    });
</script>
</body>

</html>
