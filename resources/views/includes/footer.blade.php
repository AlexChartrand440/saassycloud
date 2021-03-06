<div class="row pt-3">
    <div class="col-md-6">

    </div>
    <div class="col-md-6 clearfix">
        @if (Auth::guest())
        <a href="/login" class="text-muted float-right display-block">Login</a>
        @else
            <a href="#" class="text-muted float-right display-block" onclick="event.preventDefault();document.getElementById('logout-form-footer').submit();">Logout</a>

            <form id="logout-form-footer" action="{{ route('logout') }}" method="POST"
                  style="display: none;">
                {{ csrf_field() }}
            </form>
        @endif
    </div>
</div>
        <div class="row pt-5 pl-3">
            <div class="col-md-4">
                <h2 class="text-white"><strong class="font-weight-bold">SaaS</strong>sy Cloud <small class="text-muted font-weight-light">Warp ahead<super class="">&reg;</super></small></h2>
                <h6 class="text-white font-weight-light">Magic software
                    <span class="text-muted font-weight-light">for magic plumbers</h6>
                <button type="button" class="btn btn-light float-left mt-auto" data-toggle="modal" data-target="#explanationModal">
                    Show Info Modal
                </button>
                    <div class="pushBottom smallPrint d-none d-md-block">
                        <a href="/" class="text-muted">Home</a> |
                        <a href="/about" class="text-white">About</a> |
                        <a href="/privacy" class="text-muted">Privacy Policy</a> |
                        <a href="/terms" class="text-muted">Terms of Use</a>
                    </div>
            </div>
            <div class="col-md-4">

            </div>
            <div class="col-md-4 mt-5 pt-5">
                <h6 class="text-white text-right">Made with Lots of <i class="fa fa-heart text-pink"></i> &amp; <i class="fa fa-coffee text-brown"></i>
                    <br>in Charm City</h6>
                <p class="text-right font-weight-light pt-3 pb-0 mb-0 text-white finePrint">
                    Helping save princesses since 1985
                </p>
                <p class="text-right font-weight-light pt-0 pb-3 my-0 text-muted finePrint textGroup">
                    Copyright &copy; 2017 Nobody Inc. No rights reserved.
                </p>

            </div>
        </div>
    </div>
</footer>
<script src="{{ mix('/js/manifest.js') }} "></script>
<script src="{{ mix('/js/vendor.js') }} "></script>
<script src="{{ mix('/js/app.js') }} "></script>