 <!-- Countdown -->
 <div class="js-countdown row" data-hs-countdown-options='{
   "endDate": "{{ $date }}"
 }'>
     <div class="col-3">
         <span class="js-cd-days font-size-3 text-primary font-weight-bold mb-0"></span>
         <span class="h5 d-block mb-0">
             {{ translate('Days') }}
         </span>
     </div>
     <div class="col-3">
         <span class="js-cd-hours font-size-3 text-primary font-weight-bold mb-0"></span>
         <span class="h5 d-block mb-0">
             {{ translate('Hours') }}
         </span>
     </div>
     <div class="col-3">
         <span class="js-cd-minutes font-size-3 text-primary font-weight-bold mb-0"></span>
         <span class="h5 d-block mb-0">
            {{ translate('Mins') }}
         </span>
     </div>
     <div class="col-3">
         <span class="js-cd-seconds font-size-3 text-primary font-weight-bold mb-0"></span>
         <span class="h5 d-block mb-0">
            {{ translate('Sec') }}
         </span>
     </div>
 </div>
 <!-- End Countdown -->

 @push('footer_scripts')

     <script>
         $(document).on('ready', function() {
             // INITIALIZATION OF FORM VALIDATION
             // =======================================================


             // INITIALIZATION OF COUNTDOWNS
             // =======================================================
             $('.js-countdown').each(function() {
                 var countdown = $.HSCore.components.HSCountdown.init($(this));
             });
         });
     </script>
 @endpush
