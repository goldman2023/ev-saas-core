import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';
import intersect from '@alpinejs/intersect';
import collapse from '@alpinejs/collapse'

try {
    /* eXtend Alpine and start it */
    Alpine.plugin(persist);
    Alpine.plugin(intersect);
    Alpine.plugin(collapse);
    window.Alpine = Alpine;
    Alpine.start();
} catch (e) {}
