<!-- Footer -->
<footer class="footer pt-3 text-center text-lg-start bg-light text-muted mt-5">
    <!-- Section: Links  -->
    <section class="">
        <div class="container text-center text-md-start mt-5">
            <!-- Grid row -->
            <div class="row mt-3">
                <!-- Grid column -->
                <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                    <!-- Content -->
                    <h6 class="fw-bold mb-4"><a href="{{ asset('/') }}" class="text-reset text-decoration-none footer-link">晴 re 着</a></h6>
                    <p>
                        Here you can use rows and columns to organize your footer content. Lorem ipsum
                        dolor sit amet, consectetur adipisicing elit.
                    </p>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                    <!-- Links -->
                    <!-- <h6 class="text-uppercase fw-bold mb-4">
                            Useful links
                        </h6> -->
                    <!-- スタイリストログイン時新規登録は非表示 -->
                    <p>
                        @if (!session('stylist'))
                            <a href="{{ asset('/stylist_user/signup') }}" class="text-reset text-decoration-none footer-link">スタイリスト新規登録</a>                            
                        @endif
                    </p>
                    <p>
                        <a href="{{ asset('/faq') }}" class="text-reset text-decoration-none footer-link">よくあるご質問</a>
                    </p>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-4">
                        Contact
                    </h6>
                    <p>
                        <i class="bi bi-envelope"></i>
                        info@example.com
                    </p>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row -->
        </div>
    </section>
    <!-- Section: Links  -->

    <!-- Copyright -->
    <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
        © 2021 Copyright:ttttt...
    </div>
    <!-- Copyright -->
</footer>
<!-- Footer -->