@extends('layouts.headlessFrame')

@section('content')
    <section class="bg-white">
        <div class="container-fluid">
            <div class="row bg-white" style="min-height: 700px;">
                <div class="col-md-5 bg-white p-3">
                    <a class="navbar-brand  text-dark p-3" href="/"><strong class="font-weight-bold">SaaS</strong>sy Cloud</a>
                    <h2 class="text-dark roboFont font-weight-bold text-center px-5 pt-5">World 1-1</h2>
                    <form action="/signup/setup" method="POST" class="text-dark m-5 p-5" novalidate>
                        {{ csrf_field() }}
                        <fieldset class="form-group">
                            <label for="worldName">Build Your World</label>
                            <div class="input-group">
                                <input type="text" class="form-control{{ $errors->has('worldName') ? ' is-invalid' : '' }}" id="worldName" name="worldName" placeholder="worldname">
                                <div class="input-group-addon bg-mb text-white">.saassycloud.com</div>
                            </div>
                            @if ($errors->has('worldName'))
                                <small class="form-text text-danger">
                                    <strong>{{ $errors->first('worldName') }}</strong>
                                </small>
                            @else
                                <small id="passwordHelpBlock" class="form-text text-muted">
                                    Claim your unique site for powering up
                                </small>
                            @endif
                        </fieldset>

                        <button class="btn btn-success" role="submit">World 1-2 <i class="fa fa-right-arrow"></i></button>
                    </form>
                </div>
                <div class="col-md-7 bg-white world-billboard" id="world-1-1-billboard">
                    <div class="img d-block"></div>
                </div>
            </div>
        </div>
    </section>
@endsection