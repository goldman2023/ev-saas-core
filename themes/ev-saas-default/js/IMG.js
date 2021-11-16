window.EV.IMG = {
    isIMGProxyEnabled: function() {
        return window.EV.IMG.getIMGProxyData()['enabled'];
    },
    getIMGProxyData: function() {
        try {
            return JSON.parse($('script#img-proxy-data').html());
        } catch(error) {
            return {};
        }
    },
    constructIMGProxyUrl: function($path, $options = {}, $default_options_target = 'thumbnail') {
        let $data = window.EV.IMG.getIMGProxyData();

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
        if(window.EV.IMG.isIMGProxyEnabled()) {
            return window.EV.IMG.constructIMGProxyUrl(window.AIZ.data.storageBaseUrl + $path, $options, $default_options_target);
        } else {
            return window.AIZ.data.storageBaseUrl + $path;
        }
    },

};
