import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';
import intersect from '@alpinejs/intersect';
import collapse from '@alpinejs/collapse'

try {
    /* eXtend Alpine and start it */
    Alpine.plugin(persist);
    Alpine.plugin(intersect);
    Alpine.plugin(collapse);

    // Custom Magic Functions
    Alpine.magic('scrollToErrors', () => {
        /*
         * errors: key -> array pair (key is name of the field in alpine/livewire/form-control-element
         * duration: number of milliseconds of transition
         * callback: a function to be called after animation is complete
         */
        return (errors, duration = 800, callback = null) => {
            Alpine.nextTick(() => {
                try {
                    if(errors !== undefined && Object.keys(errors).length > 0)  {
                        let $target_el = $('[name=\''+Object.keys(errors)[0]+'\']');
                        $('html').animate({ // html,body - fires callback twice...
                            scrollTop: $target_el.parent().offset().top
                        }, duration, function() {
                            if (callback instanceof Function)
                                callback();
                        });
                    }
                } catch(error) {}
            });
        };
    });


    window.Alpine = Alpine;
    Alpine.start();
} catch (e) {}
