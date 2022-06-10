@extends('frontend.layouts.user_panel')

@section('page_title', translate('Add new Quiz'))

@push('head_scripts')
<style>
    .we-user-panel__container {
        padding: 0 !important;
    }
    </style>
@endpush

@section('panel_content')
    <section>
        <div id="surveyCreator" style="height: 100vh;"></div>
    </section>
@endsection

@push('footer_scripts')
<script type="text/javascript" src="https://unpkg.com/knockout/build/output/knockout-latest.js"></script>

<!-- SurveyJS resources -->
<link href="https://unpkg.com/survey-core/defaultV2.min.css" type="text/css" rel="stylesheet">
<script src="https://unpkg.com/survey-core/survey.core.min.js"></script>
<script src="https://unpkg.com/survey-knockout-ui/survey-knockout-ui.min.js"></script>

<!-- Survey Creator resources -->
<link href="https://unpkg.com/survey-creator-core/survey-creator-core.min.css" type="text/css" rel="stylesheet">
<script src="https://unpkg.com/survey-creator-core/survey-creator-core.min.js"></script>
<script src="https://unpkg.com/survey-creator-knockout/survey-creator-knockout.min.js"></script>

<script>
    /* Documentation can be found here: https://surveyjs.io/Documentation/Survey-Creator?id=get-started-knockout-jquery */
    const creatorOptions = {
        showLogicTab: false,
        isAutoSave: false,
        haveCommercialLicense: true
    };

    const creator = new SurveyCreator.SurveyCreator(creatorOptions);

    document.addEventListener("DOMContentLoaded", function() {
        creator.render("surveyCreator");
    });
</script>
@endpush


