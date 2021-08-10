@extends('frontend.layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <h1>
                    Heading 1
                </h1>

                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum nec mauris dui. Fusce egestas
                    velit ut dui dictum tincidunt. Curabitur et bibendum mauris. Suspendisse eu lorem placerat, finibus
                    risus eget, dictum odio. Cras ac consequat sapien, nec consectetur mi. Duis ullamcorper ex metus, et
                    elementum ante mattis id. Duis eget turpis non purus porta tempus. Vivamus quis fermentum ligula.
                    Aenean sagittis eget nisi et porta. Aliquam erat volutpat.
                </p>

                <h2>
                    Heading 2
                </h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum nec mauris dui. Fusce egestas
                    velit ut dui dictum tincidunt. Curabitur et bibendum mauris. Suspendisse eu lorem placerat, finibus
                    risus eget, dictum odio. Cras ac consequat sapien, nec consectetur mi. Duis ullamcorper ex metus, et
                    elementum ante mattis id. Duis eget turpis non purus porta tempus. Vivamus quis fermentum ligula.
                    Aenean sagittis eget nisi et porta. Aliquam erat volutpat.
                </p>

                <a href="#" class="btn btn-primary">
                    Button
                </a>

                <h3>
                    Heading 3
                </h3>

                <h4> Heading 4</h4>
                <h5> Heading 5</h5>
                <h6> Heading 6</h6>
            </div>
        </div>
    </div>

    <div class="section section-notifications" id="notifications">
        <div class="container">
            <div class="space"></div>
            <h3>Notifications</h3>
            <div class="alert alert-primary alert-with-icon">
                <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="tim-icons icon-simple-remove"></i>
                </button>
                <span data-notify="icon" class="tim-icons icon-coins"></span>
                <span>
              <b> Congrats! - </b> This is a regular notification made with ".alert-primary"</span>
            </div>
            <div class="alert alert-info alert-with-icon">
                <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="tim-icons icon-simple-remove"></i>
                </button>
                <span data-notify="icon" class="tim-icons icon-trophy"></span>
                <span>
              <b> Heads up! - </b> This is a regular notification made with ".alert-info"</span>
            </div>
            <div class="alert alert-success alert-with-icon">
                <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="tim-icons icon-simple-remove"></i>
                </button>
                <span data-notify="icon" class="tim-icons icon-bell-55"></span>
                <span>
              <b> Well done! - </b> This is a regular notification made with ".alert-success"</span>
            </div>
            <div class="alert alert-warning alert-with-icon">
                <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="tim-icons icon-simple-remove"></i>
                </button>
                <span data-notify="icon" class="tim-icons icon-bulb-63"></span>
                <span>
              <b> Warning! - </b> This is a regular notification made with ".alert-warning"</span>
            </div>
            <div class="alert alert-danger alert-with-icon">
                <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="tim-icons icon-simple-remove"></i>
                </button>
                <span data-notify="icon" class="tim-icons icon-support-17"></span>
                <span>
              <b> Oh snap! - </b> This is a regular notification made with ".alert-danger"</span>
            </div>

            <!-- Promo banner Component           -->
            <div class="b2b-component space-2">

                <h1 class="b2b-component__heading">Promo Banner Component</h1>
                @php
                    $button_text = "Try it out";
                    $image_source = "assets/img/img1.jpg";
                    $heading = "Register to B2BWood";
                    $body= "Building brands people can't live without is how our clients grow.";
                @endphp
                <x-promo-banner :heading="$heading" :body="$body" :buttonText="$button_text"
                                :imageSource="$image_source"></x-promo-banner>

            </div>
            <!-- END Promo banner Component -->

            <!-- Categories List Component -->
            <div class="b2b-component space-2">
                <div class="col-12">
                    <h1 class="b2b-component__heading">Categories List Component (News Page)</h1>
                    @php
                        $categories = App\Models\Category::all();
                    @endphp
                    <x-category-list :categories="$categories"></x-category-list>
                </div>
            </div>

            <!-- END Categories List Component -->

            @include('frontend.styleguide.components.news-card')
        </div>
    </div>
@endsection
