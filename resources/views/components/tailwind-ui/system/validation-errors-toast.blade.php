<div class="fixed z-[101] rounded-md  p-4  top-12 left-1/2 translate-x-[-50%] " x-data="{
        show: false,
        id: 'validation-error-toast',
        errors: {},
        countErrors() {
          if(this.errors === undefined || this.errors === null) {
            this.errors = {};
          }

          let count = 0;
          for(const field in this.errors) {
            try {
              count += this.errors[field].length;
            } catch(err) {}
          }

          return count;
        }
    }"
    x-init="$watch('show', function(value) { value ? setTimeout(() => show = false, {{ $timeout }}) : ''; })"
    @validation-errors.window="
        if($event.detail.id === id && $event.detail.hasOwnProperty('errors') && $event.detail.errors !== null && Object.keys($event.detail.errors).length > 0) {
            errors = $event.detail.errors;
            console.log($event.detail.errors);
            show = true;
        }"
    @click.outside="show = false"
    x-show="show"
    x-cloak>
    
    <div class="relative inline-block align-bottom bg-red-50 rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full sm:p-6"
            x-on:click.outside="show = false"
            x-show="show"
            x-transition:enter="ease-out duration-150"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-out duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
        
            <div class="w-full">
              <div class="flex">
                <div class="flex-shrink-0">
                  @svg('heroicon-s-x', ['class' => 'h-5 w-5 text-red-400'])
                </div>
                <div class="ml-3">
                  <h3 class="text-sm font-medium text-red-800">There were <strong x-text="countErrors()"></strong> errors with your submission</h3>
                  <div class="mt-2 text-sm text-red-700">
                    <ul role="list" class="list-disc pl-5 space-y-1">
                      <template x-for="field_errors in errors">
                        <template x-for="error in field_errors">
                          <li x-text="error">Your password must be at least 8 characters</li>
                        </template>
                      </template>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

      </div>

  </div>
  