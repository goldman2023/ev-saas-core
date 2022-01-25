@extends('frontend.layouts.' . $globalLayout)


@section('content')
<div class="container">
    <div class="row space-1">
        <div class="col-12">
            <h1>{{  translate('Knowledge Base')}}</h1>
        </div>
    </div>
    <div class="border-bottom space-2 space-lg-1 space-top-0 mt-0">
      <div class="row">
          @for($i = 0; $i < 6; $i++)
        <div class="col-lg-6 mb-3 mb-lg-5">
            <x-default.knowledge-base.article-card></x-default.knowledge-base.article-card>
        </div>

        @endfor


      </div>




      <div class="text-center mt-3 mt-md-9">
        <a class="btn btn-primary transition-3d-hover" href="listing.html">See all Topics</a>
      </div>
    </div>
  </div>
@endsection
