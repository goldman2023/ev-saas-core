<!DOCTYPE html>
<html lang="lt">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    {{-- This is the only tailwind which actually works... --}}
    {{-- <link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> --}}
    <style>
        * {
          font-family: DejaVu Sans !important;
        }
        .w-full {
            width: 100%;
        }
        .strong {
            font-weight: 700;
        }

        .center {
            text-align: center
        }
        .page-break {
            page-break-after: always;
        }

        .text-center {
            text-align: center;
            width: 100%;
        }

        .table {
            border-collapse: collapse;
        }

        .table, .table td, .table th {
            border: 1px solid black;
        }

        .table td {
            padding: 5px;
        }
    </style>

    @stack('styles')
</head>

<body style="position: relative;">

    @yield('content')
</body>

{{-- Extra styles --}}
<style>
    /* ! tailwindcss v3.2.4 | MIT License | https://tailwindcss.com */

    /*
    1. Prevent padding and border from affecting element width. (https://github.com/mozdevs/cssremedy/issues/4)
    2. Allow adding a border to an element by just adding a border-width. (https://github.com/tailwindcss/tailwindcss/pull/116)
    */

    *,
    ::before,
    ::after {
    box-sizing: border-box;
    /* 1 */
    border-width: 0;
    /* 2 */
    border-style: solid;
    /* 2 */
    border-color: #e5e7eb;
    /* 2 */
    }

    ::before,
    ::after {
    --tw-content: '';
    }

    /*
    1. Use a consistent sensible line-height in all browsers.
    2. Prevent adjustments of font size after orientation changes in iOS.
    3. Use a more readable tab size.
    4. Use the user's configured `sans` font-family by default.
    5. Use the user's configured `sans` font-feature-settings by default.
    */

    html {
    line-height: 1.5;
    /* 1 */
    -webkit-text-size-adjust: 100%;
    /* 2 */
    -moz-tab-size: 4;
    /* 3 */
    tab-size: 4;
    /* 3 */
    font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
    /* 4 */
    font-feature-settings: normal;
    /* 5 */
    }

    /*
    1. Remove the margin in all browsers.
    2. Inherit line-height from `html` so users can set them as a class directly on the `html` element.
    */

    body {
    margin: 0;
    /* 1 */
    line-height: inherit;
    /* 2 */
    }

    /*
    1. Add the correct height in Firefox.
    2. Correct the inheritance of border color in Firefox. (https://bugzilla.mozilla.org/show_bug.cgi?id=190655)
    3. Ensure horizontal rules are visible by default.
    */

    hr {
    height: 0;
    /* 1 */
    color: inherit;
    /* 2 */
    border-top-width: 1px;
    /* 3 */
    }

    /*
    Add the correct text decoration in Chrome, Edge, and Safari.
    */

    abbr:where([title]) {
    -webkit-text-decoration: underline dotted;
            text-decoration: underline dotted;
    }

    /*
    Remove the default font size and weight for headings.
    */

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
    font-size: inherit;
    font-weight: inherit;
    }

    /*
    Reset links to optimize for opt-in styling instead of opt-out.
    */

    a {
    color: inherit;
    text-decoration: inherit;
    }

    /*
    Add the correct font weight in Edge and Safari.
    */

    b,
    strong {
    font-weight: bolder;
    }

    /*
    1. Use the user's configured `mono` font family by default.
    2. Correct the odd `em` font sizing in all browsers.
    */

    code,
    kbd,
    samp,
    pre {
    font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
    /* 1 */
    font-size: 1em;
    /* 2 */
    }

    /*
    Add the correct font size in all browsers.
    */

    small {
    font-size: 80%;
    }

    /*
    Prevent `sub` and `sup` elements from affecting the line height in all browsers.
    */

    sub,
    sup {
    font-size: 75%;
    line-height: 0;
    position: relative;
    vertical-align: baseline;
    }

    sub {
    bottom: -0.25em;
    }

    sup {
    top: -0.5em;
    }

    /*
    1. Remove text indentation from table contents in Chrome and Safari. (https://bugs.chromium.org/p/chromium/issues/detail?id=999088, https://bugs.webkit.org/show_bug.cgi?id=201297)
    2. Correct table border color inheritance in all Chrome and Safari. (https://bugs.chromium.org/p/chromium/issues/detail?id=935729, https://bugs.webkit.org/show_bug.cgi?id=195016)
    3. Remove gaps between table borders by default.
    */

    table {
    text-indent: 0;
    /* 1 */
    border-color: inherit;
    /* 2 */
    border-collapse: collapse;
    /* 3 */
    }

    /*
    1. Change the font styles in all browsers.
    2. Remove the margin in Firefox and Safari.
    3. Remove default padding in all browsers.
    */

    button,
    input,
    optgroup,
    select,
    textarea {
    font-family: inherit;
    /* 1 */
    font-size: 100%;
    /* 1 */
    font-weight: inherit;
    /* 1 */
    line-height: inherit;
    /* 1 */
    color: inherit;
    /* 1 */
    margin: 0;
    /* 2 */
    padding: 0;
    /* 3 */
    }

    /*
    Remove the inheritance of text transform in Edge and Firefox.
    */

    button,
    select {
    text-transform: none;
    }

    /*
    1. Correct the inability to style clickable types in iOS and Safari.
    2. Remove default button styles.
    */

    button,
    [type='button'],
    [type='reset'],
    [type='submit'] {
    -webkit-appearance: button;
    /* 1 */
    background-color: transparent;
    /* 2 */
    background-image: none;
    /* 2 */
    }

    /*
    Use the modern Firefox focus style for all focusable elements.
    */

    :-moz-focusring {
    outline: auto;
    }

    /*
    Remove the additional `:invalid` styles in Firefox. (https://github.com/mozilla/gecko-dev/blob/2f9eacd9d3d995c937b4251a5557d95d494c9be1/layout/style/res/forms.css#L728-L737)
    */

    :-moz-ui-invalid {
    box-shadow: none;
    }

    /*
    Add the correct vertical alignment in Chrome and Firefox.
    */

    progress {
    vertical-align: baseline;
    }

    /*
    Correct the cursor style of increment and decrement buttons in Safari.
    */

    ::-webkit-inner-spin-button,
    ::-webkit-outer-spin-button {
    height: auto;
    }

    /*
    1. Correct the odd appearance in Chrome and Safari.
    2. Correct the outline style in Safari.
    */

    [type='search'] {
    -webkit-appearance: textfield;
    /* 1 */
    outline-offset: -2px;
    /* 2 */
    }

    /*
    Remove the inner padding in Chrome and Safari on macOS.
    */

    ::-webkit-search-decoration {
    -webkit-appearance: none;
    }

    /*
    1. Correct the inability to style clickable types in iOS and Safari.
    2. Change font properties to `inherit` in Safari.
    */

    ::-webkit-file-upload-button {
    -webkit-appearance: button;
    /* 1 */
    font: inherit;
    /* 2 */
    }

    /*
    Add the correct display in Chrome and Safari.
    */

    summary {
    display: list-item;
    }

    /*
    Removes the default spacing and border for appropriate elements.
    */

    blockquote,
    dl,
    dd,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    hr,
    figure,
    p,
    pre {
    margin: 0;
    }

    fieldset {
    margin: 0;
    padding: 0;
    }

    legend {
    padding: 0;
    }

    ol,
    ul,
    menu {
    list-style: none;
    margin: 0;
    padding: 0;
    }

    /*
    Prevent resizing textareas horizontally by default.
    */

    textarea {
    resize: vertical;
    }

    /*
    1. Reset the default placeholder opacity in Firefox. (https://github.com/tailwindlabs/tailwindcss/issues/3300)
    2. Set the default placeholder color to the user's configured gray 400 color.
    */

    input::placeholder,
    textarea::placeholder {
    opacity: 1;
    /* 1 */
    color: #9ca3af;
    /* 2 */
    }

    /*
    Set the default cursor for buttons.
    */

    button,
    [role="button"] {
    cursor: pointer;
    }

    /*
    Make sure disabled buttons don't get the pointer cursor.
    */

    :disabled {
    cursor: default;
    }

    /*
    1. Make replaced elements `display: block` by default. (https://github.com/mozdevs/cssremedy/issues/14)
    2. Add `vertical-align: middle` to align replaced elements more sensibly by default. (https://github.com/jensimmons/cssremedy/issues/14#issuecomment-634934210)
    This can trigger a poorly considered lint error in some tools but is included by design.
    */

    img,
    svg,
    video,
    canvas,
    audio,
    iframe,
    embed,
    object {
    display: block;
    /* 1 */
    vertical-align: middle;
    /* 2 */
    }

    /*
    Constrain images and videos to the parent width and preserve their intrinsic aspect ratio. (https://github.com/mozdevs/cssremedy/issues/14)
    */

    img,
    video {
    max-width: 100%;
    height: auto;
    }

    /* Make elements with the HTML hidden attribute stay hidden by default */

    [hidden] {
    display: none;
    }

    *, ::before, ::after {
    --tw-border-spacing-x: 0;
    --tw-border-spacing-y: 0;
    --tw-translate-x: 0;
    --tw-translate-y: 0;
    --tw-rotate: 0;
    --tw-skew-x: 0;
    --tw-skew-y: 0;
    --tw-scale-x: 1;
    --tw-scale-y: 1;
    --tw-pan-x:  ;
    --tw-pan-y:  ;
    --tw-pinch-zoom:  ;
    --tw-scroll-snap-strictness: proximity;
    --tw-ordinal:  ;
    --tw-slashed-zero:  ;
    --tw-numeric-figure:  ;
    --tw-numeric-spacing:  ;
    --tw-numeric-fraction:  ;
    --tw-ring-inset:  ;
    --tw-ring-offset-width: 0px;
    --tw-ring-offset-color: #fff;
    --tw-ring-color: rgb(59 130 246 / 0.5);
    --tw-ring-offset-shadow: 0 0 #0000;
    --tw-ring-shadow: 0 0 #0000;
    --tw-shadow: 0 0 #0000;
    --tw-shadow-colored: 0 0 #0000;
    --tw-blur:  ;
    --tw-brightness:  ;
    --tw-contrast:  ;
    --tw-grayscale:  ;
    --tw-hue-rotate:  ;
    --tw-invert:  ;
    --tw-saturate:  ;
    --tw-sepia:  ;
    --tw-drop-shadow:  ;
    --tw-backdrop-blur:  ;
    --tw-backdrop-brightness:  ;
    --tw-backdrop-contrast:  ;
    --tw-backdrop-grayscale:  ;
    --tw-backdrop-hue-rotate:  ;
    --tw-backdrop-invert:  ;
    --tw-backdrop-opacity:  ;
    --tw-backdrop-saturate:  ;
    --tw-backdrop-sepia:  ;
    }

    ::-webkit-backdrop {
    --tw-border-spacing-x: 0;
    --tw-border-spacing-y: 0;
    --tw-translate-x: 0;
    --tw-translate-y: 0;
    --tw-rotate: 0;
    --tw-skew-x: 0;
    --tw-skew-y: 0;
    --tw-scale-x: 1;
    --tw-scale-y: 1;
    --tw-pan-x:  ;
    --tw-pan-y:  ;
    --tw-pinch-zoom:  ;
    --tw-scroll-snap-strictness: proximity;
    --tw-ordinal:  ;
    --tw-slashed-zero:  ;
    --tw-numeric-figure:  ;
    --tw-numeric-spacing:  ;
    --tw-numeric-fraction:  ;
    --tw-ring-inset:  ;
    --tw-ring-offset-width: 0px;
    --tw-ring-offset-color: #fff;
    --tw-ring-color: rgb(59 130 246 / 0.5);
    --tw-ring-offset-shadow: 0 0 #0000;
    --tw-ring-shadow: 0 0 #0000;
    --tw-shadow: 0 0 #0000;
    --tw-shadow-colored: 0 0 #0000;
    --tw-blur:  ;
    --tw-brightness:  ;
    --tw-contrast:  ;
    --tw-grayscale:  ;
    --tw-hue-rotate:  ;
    --tw-invert:  ;
    --tw-saturate:  ;
    --tw-sepia:  ;
    --tw-drop-shadow:  ;
    --tw-backdrop-blur:  ;
    --tw-backdrop-brightness:  ;
    --tw-backdrop-contrast:  ;
    --tw-backdrop-grayscale:  ;
    --tw-backdrop-hue-rotate:  ;
    --tw-backdrop-invert:  ;
    --tw-backdrop-opacity:  ;
    --tw-backdrop-saturate:  ;
    --tw-backdrop-sepia:  ;
    }

    ::backdrop {
    --tw-border-spacing-x: 0;
    --tw-border-spacing-y: 0;
    --tw-translate-x: 0;
    --tw-translate-y: 0;
    --tw-rotate: 0;
    --tw-skew-x: 0;
    --tw-skew-y: 0;
    --tw-scale-x: 1;
    --tw-scale-y: 1;
    --tw-pan-x:  ;
    --tw-pan-y:  ;
    --tw-pinch-zoom:  ;
    --tw-scroll-snap-strictness: proximity;
    --tw-ordinal:  ;
    --tw-slashed-zero:  ;
    --tw-numeric-figure:  ;
    --tw-numeric-spacing:  ;
    --tw-numeric-fraction:  ;
    --tw-ring-inset:  ;
    --tw-ring-offset-width: 0px;
    --tw-ring-offset-color: #fff;
    --tw-ring-color: rgb(59 130 246 / 0.5);
    --tw-ring-offset-shadow: 0 0 #0000;
    --tw-ring-shadow: 0 0 #0000;
    --tw-shadow: 0 0 #0000;
    --tw-shadow-colored: 0 0 #0000;
    --tw-blur:  ;
    --tw-brightness:  ;
    --tw-contrast:  ;
    --tw-grayscale:  ;
    --tw-hue-rotate:  ;
    --tw-invert:  ;
    --tw-saturate:  ;
    --tw-sepia:  ;
    --tw-drop-shadow:  ;
    --tw-backdrop-blur:  ;
    --tw-backdrop-brightness:  ;
    --tw-backdrop-contrast:  ;
    --tw-backdrop-grayscale:  ;
    --tw-backdrop-hue-rotate:  ;
    --tw-backdrop-invert:  ;
    --tw-backdrop-opacity:  ;
    --tw-backdrop-saturate:  ;
    --tw-backdrop-sepia:  ;
    }

    .static {
    position: static;
    }

    .absolute {
    position: absolute;
    }

    .relative {
    position: relative;
    }

    .top-\[80px\] {
    top: 80px;
    }

    .left-\[-80px\] {
    left: -80px;
    }

    .col-span-2 {
    grid-column: span 2 / span 2;
    }

    .mb-1 {
    margin-bottom: 0.25rem;
    }

    .mb-2 {
    margin-bottom: 0.5rem;
    }

    .flex {
    display: flex;
    }

    .grid {
    display: grid;
    }

    .h-24 {
    height: 6rem;
    }

    .w-full {
    width: 100%;
    }

    .-rotate-90 {
    --tw-rotate: -90deg;
    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
    }

    .grid-cols-3 {
    grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    .justify-end {
    justify-content: flex-end;
    }

    .gap-9 {
    gap: 2.25rem;
    }

    .rounded {
    border-radius: 0.25rem;
    }

    .border {
    border-width: 1px;
    }

    .border-gray-700 {
    --tw-border-opacity: 1;
    border-color: rgb(55 65 81 / var(--tw-border-opacity));
    }

    .p-2 {
    padding: 0.5rem;
    }

    .px-9 {
    padding-left: 2.25rem;
    padding-right: 2.25rem;
    }

    .text-center {
    text-align: center;
    }

    .text-right {
    text-align: right;
    }

    .text-2xl {
    font-size: 1.5rem;
    line-height: 2rem;
    }

    .text-xl {
    font-size: 1.25rem;
    line-height: 1.75rem;
    }

    .font-bold {
    font-weight: 700;
    }

    .font-medium {
    font-weight: 500;
    }

    .text-red-500 {
    --tw-text-opacity: 1;
    color: rgb(239 68 68 / var(--tw-text-opacity));
    }

    .underline {
    -webkit-text-decoration-line: underline;
            text-decoration-line: underline;
    }

    .mb-1 {
    margin-bottom: 0.25rem;
    }

    .flex {
    display: flex;
    }

    .table {
    display: table;
    }

    .w-full {
    width: 100%;
    }

    .table-auto {
    table-layout: auto;
    }

    .list-disc {
    list-style-type: disc;
    }

    .flex-row {
    flex-direction: row;
    }

    .gap-x-2 {
    column-gap: 0.5rem;
    }

    .rounded-md {
    border-radius: 0.375rem;
    }

    .border {
    border-width: 1px;
    }

    .border-gray-200 {
    --tw-border-opacity: 1;
    border-color: rgb(229 231 235 / var(--tw-border-opacity));
    }

    .py-3 {
    padding-top: 0.75rem;
    padding-bottom: 0.75rem;
    }

    .py-0\.5 {
    padding-top: 0.125rem;
    padding-bottom: 0.125rem;
    }

    .px-2 {
    padding-left: 0.5rem;
    padding-right: 0.5rem;
    }

    .py-0 {
    padding-top: 0px;
    padding-bottom: 0px;
    }

    .pr-3 {
    padding-right: 0.75rem;
    }

    .pb-4 {
    padding-bottom: 1rem;
    }

    .pb-3 {
    padding-bottom: 0.75rem;
    }

    .pl-5 {
    padding-left: 1.25rem;
    }

    .pb-6 {
    padding-bottom: 1.5rem;
    }

    .pb-10 {
    padding-bottom: 2.5rem;
    }

    .pb-8 {
    padding-bottom: 2rem;
    }

    .text-center {
    text-align: center;
    }

    .text-xl {
        font-size: 1.25rem;
        line-height: 1.75rem;
    }

    .text-lg {
        font-size: 1.125rem;
        line-height: 1.75rem;
    }

    .text-sm {
    font-size: 0.875rem;
    line-height: 1.25rem;
    }

    .text-xs {
    font-size: 0.75rem;
    line-height: 1rem;
    }

    .font-bold {
    font-weight: 700;
    }

    .text-gray-800 {
    --tw-text-opacity: 1;
    color: rgb(31 41 55 / var(--tw-text-opacity));
    }

    .pr-2 {
        padding-right: 0.5rem;
    }

    .p-3 {
        padding: 0.75rem;
    }

    .pl-2 {
        padding-left: 0.5rem;
    }

    .min-h-60 {
        min-height: 60px;
    }

    .text-left {
        text-align: left;
    }

    .table-border, .table-border th, .table-border td {
        border: 1px solid black;
    }
    .h-12 {
        height: 3rem;
    }
    .border-gray-300 {
        --tw-border-opacity: 1;
        border-color: rgb(209 213 219 / var(--tw-border-opacity));
    }
    .border-gray-400 {
        border-color: #9ca3af;
    }

</style>

</html>