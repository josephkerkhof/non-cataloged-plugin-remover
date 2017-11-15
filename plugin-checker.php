<?php

function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }

    }

    return rmdir($dir);
}

$supported_plugins = [
    "404-to-301",
    "acf-field-date-time-picker",
    "advanced-custom-fields",
    "akismet",
    "blog-copier",
    "bu-navigation",
    "bu-section-editing",
    "calculated-fields-form",
    "constant-contact-forms",
    "custom-facebook-feed",
    "custom-javascript-editor",
    "duplicate-post",
    "duracelltomi-google-tag-manager",
    "easy-pricing-tables",
    "easy-twitter-feed-widget",
    "elegant-themes-updater",
    "enable-media-replace",
    "enhanced-media-library",
    "ewww-image-optimizer",
    "flipping-cards",
    "font-awesome-shortcodes",
    "gravityforms",
    "gravity-forms-salesforce",
    "gs-logo-slider",
    "hubspot-tracking-code",
    "instagram-feed",
    "js_composer",
    "json-content-importer",
    "post-expirator",
    "preserved-html-editor-markup-plus",
    "shibboleth-username-override-only",
    "soliloquy-lite",
    "tablepress",
    "the-events-calendar",
    "uwm-simple-301-redirects",
    "uwo-utilities",
    "wordpress-importer",
    "wordpress-seo",
    "wp-cerber",
    "wp-private-content-plus",
    "wp-simple-anchors-links",
    "wp-super-cache",
    "eltdf-cpt",
    "facetwp",
    "json-api",
    "jsoncontentimporterpro3"
];

$current_plugins = scandir("wp-content/plugins/");
$unsupported_plugins = array();

for($i=0; $i<count($current_plugins); $i++){
    if(in_array($current_plugins[$i], $supported_plugins) || 
        !strcmp($current_plugins[$i], "index.php") || 
        !strcmp($current_plugins[$i], ".") ||
        !strcmp($current_plugins[$i], "..")) {
        continue;
    }else {
        array_push($unsupported_plugins, $current_plugins[$i]); // adds unsupported plugin to the list
    }
}

if(count($unsupported_plugins)>0) {
    for($i=0; $i<count($unsupported_plugins); $i++){
        $directory_to_remove = "wp-content/plugins/" . $unsupported_plugins[$i];

        if (!is_dir($directory_to_remove)) {
            echo $directory_to_remove . " is not a valid directory\n";
            echo "Operation terminating.";
        }

        echo "Removing " . $unsupported_plugins[$i] . " from " . $directory_to_remove;
        deleteDirectory($directory_to_remove);
    }
}else {
    echo "There are no plugins to remove. Please remember to delete me.";
}




?>