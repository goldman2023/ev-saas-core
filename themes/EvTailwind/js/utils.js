window.WE.utils = {
    formatSizeUnits($bytes) {
        if ($bytes >= 1073741824) {
            $bytes = (new Intl.NumberFormat().format($bytes / 1073741824)) + ' GB';
        } else if ($bytes >= 1048576) {
            $bytes = (new Intl.NumberFormat().format($bytes / 1048576)) + ' MB';
        } else if ($bytes >= 1024) {
            $bytes = (new Intl.NumberFormat().format($bytes / 1024)) + ' KB';
        } else if ($bytes > 1) {
            $bytes = $bytes + ' bytes';
        } else if ($bytes == 1) {
            $bytes = $bytes + ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    },
};

window.deep_copy = function(target) {
    return JSON.parse(JSON.stringify(target));
};