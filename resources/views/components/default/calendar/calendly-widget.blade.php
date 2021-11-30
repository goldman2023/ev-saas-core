<div id="calendly-reservation" class="calendly-inline-widget" style="overflow: hidden; width:100%;height:580px;"
    data-auto-load="false">
</div>

<script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js"></script>

<script>
    @guest
    var prefill = {

    }

        @else
        var prefill = {
            name: '{{ auth()->user()->name }}',
            email: '{{ auth()->user()->email }}'
        }

        @endguest

        Calendly.initInlineWidget({
 url: 'https://calendly.com/eim-solutions/new-project-inquries?hide_event_type_details=1',
 parentElement: document.getElementById('calendly-reservation'),
 prefill: prefill,
 utm: {}
});
</script>
