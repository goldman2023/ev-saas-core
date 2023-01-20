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

window.objectHasProperty = function(object_var, property) {
    return object_var !== null &&
            object_var !== undefined &&
            typeof object_var === 'object' &&
            !Array.isArray(object_var) &&
            object_var.hasOwnProperty(property);
}

// WEF
window.WEF = {};
window.WEF.getMinValue = function(custom_properties) {
    return window.objectHasProperty(custom_properties, 'min_value') ? custom_properties.min_value : 0;
}
window.WEF.getMaxValue = function(custom_properties) {
    return window.objectHasProperty(custom_properties, 'max_value') ? custom_properties.max_value : 999999;
}
window.WEF.getMinRows = function(custom_properties) {
    return window.objectHasProperty(custom_properties, 'min_rows') ? custom_properties.min_rows : 0;
}
window.WEF.getMaxRows = function(custom_properties) {
    return window.objectHasProperty(custom_properties, 'max_rows') ? custom_properties.max_rows : 999;
}
window.WEF.getDateOptions = function(custom_properties) {
    let options = {
        mode: 'single',
        enableTime: false,
    };

    if(objectHasProperty(custom_properties, 'with_time') && custom_properties.with_time) {
        options.enableTime = true;
        options.dateFormat = 'd.m.Y H:i';
    } else {
        options.dateFormat = 'd.m.Y';
    }

    if(objectHasProperty(custom_properties, 'range') && custom_properties.range) {
        options.mode = 'range';
    }
    
    return options;
}
window.WEF.getTextareaRows = function(custom_properties) {
    return window.objectHasProperty(custom_properties, 'rows') ? custom_properties.rows : 4;
}