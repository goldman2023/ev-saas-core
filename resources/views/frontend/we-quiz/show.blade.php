<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ translate('Quiz Solving') }}</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>


    <link href="https://unpkg.com/survey-jquery@1.9.33/modern.css" type="text/css" rel="stylesheet" />
    <script src="https://unpkg.com/survey-jquery@1.9.33/survey.jquery.min.js"></script>
</head>

<body>
    <div id="surveyContainer"></div>

    <script>
        Survey.StylesManager.applyTheme("modern");

        var surveyJSON = {!! $quiz->quiz_json !!};

        var survey = new Survey.Model(surveyJSON);

        function sendDataToServer(survey) {
            //send Ajax request to your web server
            alert("The results are: " + JSON.stringify(survey.data));
        }
        $("#surveyContainer").Survey({
            model: survey,
            onComplete: sendDataToServer
        });

        var myloc = Survey.surveyLocalization.locales["localename"];
        myloc.completingSurvey=  {{ translate('You completed the quiz!') }}
    </script>
</body>

</html>
