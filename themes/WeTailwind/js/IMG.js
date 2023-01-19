window.WE.IMG = {
    getStorageBaseURL: function() {
        return document.querySelector('meta[name="storage-base-url"]').getAttribute('content');
    },
    isIMGProxyEnabled: function() {
        return window.WE.IMG.getIMGProxyData()['enabled'];
    },
    getIMGProxyData: function() {
        try {
            return JSON.parse(document.querySelector('script#img-proxy-data').innerHTML);
        } catch(error) {
            return {};
        }
    },
    constructIMGProxyUrl: function($path, $options = {}, $default_options_target = 'thumbnail') {
        let $data = window.WE.IMG.getIMGProxyData();

        let $template = $data['url_template'];
        $options = {
            ...$data['default_options'][ Object.keys($data['default_options']).indexOf($default_options_target) !== -1 ? $default_options_target : 'thumbnail'],
            ...$options
        };

        if($template.length > 0) {
            return $template.replace('%w%', $options['w'] || '0')
                            .replace('%h%', $options['h'] || '0')
                            .replace('%url%', $path);
        }

        return null;
    },
    url: function($path, $options = {}, $default_options_target = 'thumbnail') {
        if(window.WE.IMG.isIMGProxyEnabled()) {
            return window.WE.IMG.constructIMGProxyUrl(this.getStorageBaseURL() + $path, $options, $default_options_target);
        } else {
            return this.getStorageBaseURL() + $path;
        }
    },

};
