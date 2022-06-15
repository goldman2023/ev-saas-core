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

    let saveURL = "{{ route('api.dashboard.we-quiz.create') }}";

    function saveSurveyJson(url, json, saveNo, callback) {
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                // 'Accept': 'application/json',
                "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({
                'user_id': {{ auth()->user()->id }},
                'quiz_json': json,
            }),
        })
        .then(response => response.json())
        .then(data => {
            if(data.error !== undefined) {
                alert(data.error.message);
                return;
            }

            if(data.id !== undefined && !saveURL.endsWith(data.id)) {
                saveURL += '/'+data.id;
            }
        });
    }


    const creatorOptions = {
        showLogicTab: false,
        isAutoSave: true,
        haveCommercialLicense: true,
    };
    const creator = new SurveyCreator.SurveyCreator(creatorOptions);

    creator.saveSurveyFunc = (saveNo, callback) => {
        callback(saveNo, true);

        saveSurveyJson(
            saveURL,
            creator.JSON,
            saveNo,
            callback
        );
    };


    document.addEventListener("DOMContentLoaded", function() {
        creator.render("surveyCreator");
    });
</script>
@endpush
