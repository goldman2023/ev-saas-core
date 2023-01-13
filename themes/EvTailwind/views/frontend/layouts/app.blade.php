<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>@yield('meta_title', get_site_name() .' | '.get_tenant_setting('site_motto'))</title>
    <meta name="description" content="@yield('meta_description', get_setting('meta_description') )" />
    {{--
    <meta name="keywords" content="@yield('meta_keywords', get_setting('meta_keywords') )"> --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index, follow">
    <link rel='canonical' href='@yield(' canonical_link', url()->current() )' />
    {{-- <link rel="preload" as="script" href="{{ static_asset('/bp-assets/tailwind-play/tailwind.js') }}" /> --}}


    @yield('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Favicon --}}
    <link rel="icon" href="{{ get_favicon() }}" sizes="32x32" />
    <link rel="icon" href="{{ get_favicon() }}" sizes="192x192" />
    <link rel="apple-touch-icon" href="{{ get_favicon() }}" />
    <meta name="msapplication-TileImage" content="{{ get_favicon() }}" />
    {{ seo()->render() }}

    {{--
    SITE NAME:
    To Use Site name globaly, use helper function get_site_name() - it's an alias fo get_setting('site_name')
    --}}


    <meta name="file-base-url" content="{{ getStorageBaseURL() }}">
    <meta name="file-bucket-url" content="{{ getStorageBaseURL() }}">
    <meta name="storage-base-url" content="{{ getStorageBaseURL() }}">

    <script id="img-proxy-data" type="application/json">
        @json(\IMG::getIMGProxyData())
    </script>

    {{-- TailwindCSS --}}
    {{-- <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script> --}}
    {{-- <script src="{{ static_asset('/bp-assets/tailwind-play/tailwind.js') }}"></script> --}}
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

.container {
  width: 100%;
}

@media (min-width: 640px) {
  .container {
    max-width: 640px;
  }
}

@media (min-width: 768px) {
  .container {
    max-width: 768px;
  }
}

@media (min-width: 1024px) {
  .container {
    max-width: 1024px;
  }
}

@media (min-width: 1280px) {
  .container {
    max-width: 1280px;
  }
}

@media (min-width: 1536px) {
  .container {
    max-width: 1536px;
  }
}

.sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border-width: 0;
}

.pointer-events-none {
  pointer-events: none;
}

.visible {
  visibility: visible;
}

.invisible {
  visibility: hidden;
}

.fixed {
  position: fixed;
}

.absolute {
  position: absolute;
}

.relative {
  position: relative;
}

.inset-0 {
  top: 0px;
  right: 0px;
  bottom: 0px;
  left: 0px;
}

.inset-x-0 {
  left: 0px;
  right: 0px;
}

.top-0 {
  top: 0px;
}

.bottom-0 {
  bottom: 0px;
}

.left-0 {
  left: 0px;
}

.right-0 {
  right: 0px;
}

.top-12 {
  top: 3rem;
}

.left-1\/2 {
  left: 50%;
}

.top-24 {
  top: 6rem;
}

.isolate {
  isolation: isolate;
}

.z-50 {
  z-index: 50;
}

.z-10 {
  z-index: 10;
}

.z-\[20\] {
  z-index: 20;
}

.z-\[2\] {
  z-index: 2;
}

.z-\[-1\] {
  z-index: -1;
}

.z-\[1010\] {
  z-index: 1010;
}

.z-\[10001\] {
  z-index: 10001;
}

.z-\[9999\] {
  z-index: 9999;
}

.z-\[101\] {
  z-index: 101;
}

.col-span-12 {
  grid-column: span 12 / span 12;
}

.col-span-1 {
  grid-column: span 1 / span 1;
}

.-m-3 {
  margin: -0.75rem;
}

.my-0 {
  margin-top: 0px;
  margin-bottom: 0px;
}

.mx-auto {
  margin-left: auto;
  margin-right: auto;
}

.-my-2 {
  margin-top: -0.5rem;
  margin-bottom: -0.5rem;
}

.-mr-2 {
  margin-right: -0.5rem;
}

.mt-6 {
  margin-top: 1.5rem;
}

.mb-6 {
  margin-bottom: 1.5rem;
}

.mb-3 {
  margin-bottom: 0.75rem;
}

.mr-0 {
  margin-right: 0px;
}

.mr-2\.5 {
  margin-right: 0.625rem;
}

.mr-2 {
  margin-right: 0.5rem;
}

.mb-10 {
  margin-bottom: 2.5rem;
}

.mb-\[15px\] {
  margin-bottom: 15px;
}

.mb-2 {
  margin-bottom: 0.5rem;
}

.mb-5 {
  margin-bottom: 1.25rem;
}

.mb-2\.5 {
  margin-bottom: 0.625rem;
}

.mb-4 {
  margin-bottom: 1rem;
}

.mb-8 {
  margin-bottom: 2rem;
}

.mt-4 {
  margin-top: 1rem;
}

.mt-8 {
  margin-top: 2rem;
}

.mt-3 {
  margin-top: 0.75rem;
}

.ml-3 {
  margin-left: 0.75rem;
}

.mb-1 {
  margin-bottom: 0.25rem;
}

.mb-0 {
  margin-bottom: 0px;
}

.mt-1 {
  margin-top: 0.25rem;
}

.ml-1 {
  margin-left: 0.25rem;
}

.mt-2 {
  margin-top: 0.5rem;
}

.block {
  display: block;
}

.inline-block {
  display: inline-block;
}

.inline {
  display: inline;
}

.flex {
  display: flex;
}

.inline-flex {
  display: inline-flex;
}

.table {
  display: table;
}

.flow-root {
  display: flow-root;
}

.grid {
  display: grid;
}

.contents {
  display: contents;
}

.hidden {
  display: none;
}

.aspect-square {
  aspect-ratio: 1 / 1;
}

.aspect-\[350\/130\] {
  aspect-ratio: 350/130;
}

.h-5 {
  height: 1.25rem;
}

.h-8 {
  height: 2rem;
}

.h-6 {
  height: 1.5rem;
}

.h-4 {
  height: 1rem;
}

.h-full {
  height: 100%;
}

.h-auto {
  height: auto;
}

.h-\[300px\] {
  height: 300px;
}

.h-\[100\%\] {
  height: 100%;
}

.h-\[32px\] {
  height: 32px;
}

.h-\[16px\] {
  height: 16px;
}

.h-12 {
  height: 3rem;
}

.min-h-screen {
  min-height: 100vh;
}

.w-full {
  width: 100%;
}

.w-5 {
  width: 1.25rem;
}

.w-\[1280px\] {
  width: 1280px;
}

.w-auto {
  width: auto;
}

.w-6 {
  width: 1.5rem;
}

.w-8 {
  width: 2rem;
}

.w-4 {
  width: 1rem;
}

.w-\[700px\] {
  width: 700px;
}

.w-\[32px\] {
  width: 32px;
}

.w-\[16px\] {
  width: 16px;
}

.w-12 {
  width: 3rem;
}

.min-w-0 {
  min-width: 0px;
}

.max-w-\[100\%\] {
  max-width: 100%;
}

.max-w-6xl {
  max-width: 72rem;
}

.max-w-4xl {
  max-width: 56rem;
}

.\!max-w-\[90\%\] {
  max-width: 90% !important;
}

.max-w-md {
  max-width: 28rem;
}

.flex-1 {
  flex: 1 1 0%;
}

.flex-shrink-0 {
  flex-shrink: 0;
}

.flex-grow {
  flex-grow: 1;
}

.grow {
  flex-grow: 1;
}

.origin-top-right {
  transform-origin: top right;
}

.translate-y-4 {
  --tw-translate-y: 1rem;
  transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
}

.translate-y-0 {
  --tw-translate-y: 0px;
  transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
}

.translate-x-\[-50\%\] {
  --tw-translate-x: -50%;
  transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
}

.scale-95 {
  --tw-scale-x: .95;
  --tw-scale-y: .95;
  transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
}

.scale-100 {
  --tw-scale-x: 1;
  --tw-scale-y: 1;
  transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
}

.transform {
  transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.animate-spin {
  animation: spin 1s linear infinite;
}

.cursor-pointer {
  cursor: pointer;
}

.select-none {
  -webkit-user-select: none;
          user-select: none;
}

.list-disc {
  list-style-type: disc;
}

.grid-cols-12 {
  grid-template-columns: repeat(12, minmax(0, 1fr));
}

.grid-cols-1 {
  grid-template-columns: repeat(1, minmax(0, 1fr));
}

.grid-cols-2 {
  grid-template-columns: repeat(2, minmax(0, 1fr));
}

.flex-row {
  flex-direction: row;
}

.flex-col {
  flex-direction: column;
}

.flex-wrap {
  flex-wrap: wrap;
}

.items-start {
  align-items: flex-start;
}

.items-end {
  align-items: flex-end;
}

.items-center {
  align-items: center;
}

.justify-start {
  justify-content: flex-start;
}

.justify-end {
  justify-content: flex-end;
}

.justify-center {
  justify-content: center;
}

.justify-between {
  justify-content: space-between;
}

.gap-7 {
  gap: 1.75rem;
}

.gap-8 {
  gap: 2rem;
}

.gap-y-8 {
  row-gap: 2rem;
}

.space-x-\[32px\] > :not([hidden]) ~ :not([hidden]) {
  --tw-space-x-reverse: 0;
  margin-right: calc(32px * var(--tw-space-x-reverse));
  margin-left: calc(32px * calc(1 - var(--tw-space-x-reverse)));
}

.space-y-6 > :not([hidden]) ~ :not([hidden]) {
  --tw-space-y-reverse: 0;
  margin-top: calc(1.5rem * calc(1 - var(--tw-space-y-reverse)));
  margin-bottom: calc(1.5rem * var(--tw-space-y-reverse));
}

.space-x-3 > :not([hidden]) ~ :not([hidden]) {
  --tw-space-x-reverse: 0;
  margin-right: calc(0.75rem * var(--tw-space-x-reverse));
  margin-left: calc(0.75rem * calc(1 - var(--tw-space-x-reverse)));
}

.space-x-2 > :not([hidden]) ~ :not([hidden]) {
  --tw-space-x-reverse: 0;
  margin-right: calc(0.5rem * var(--tw-space-x-reverse));
  margin-left: calc(0.5rem * calc(1 - var(--tw-space-x-reverse)));
}

.space-y-4 > :not([hidden]) ~ :not([hidden]) {
  --tw-space-y-reverse: 0;
  margin-top: calc(1rem * calc(1 - var(--tw-space-y-reverse)));
  margin-bottom: calc(1rem * var(--tw-space-y-reverse));
}

.space-x-6 > :not([hidden]) ~ :not([hidden]) {
  --tw-space-x-reverse: 0;
  margin-right: calc(1.5rem * var(--tw-space-x-reverse));
  margin-left: calc(1.5rem * calc(1 - var(--tw-space-x-reverse)));
}

.space-y-1 > :not([hidden]) ~ :not([hidden]) {
  --tw-space-y-reverse: 0;
  margin-top: calc(0.25rem * calc(1 - var(--tw-space-y-reverse)));
  margin-bottom: calc(0.25rem * var(--tw-space-y-reverse));
}

.divide-y-2 > :not([hidden]) ~ :not([hidden]) {
  --tw-divide-y-reverse: 0;
  border-top-width: calc(2px * calc(1 - var(--tw-divide-y-reverse)));
  border-bottom-width: calc(2px * var(--tw-divide-y-reverse));
}

.divide-gray-50 > :not([hidden]) ~ :not([hidden]) {
  --tw-divide-opacity: 1;
  border-color: rgb(249 250 251 / var(--tw-divide-opacity));
}

.overflow-hidden {
  overflow: hidden;
}

.overflow-y-auto {
  overflow-y: auto;
}

.whitespace-nowrap {
  white-space: nowrap;
}

.rounded-md {
  border-radius: 0.375rem;
}

.rounded-full {
  border-radius: 9999px;
}

.rounded {
  border-radius: 0.25rem;
}

.rounded-lg {
  border-radius: 0.5rem;
}

.rounded-\[6px\] {
  border-radius: 6px;
}

.\!rounded {
  border-radius: 0.25rem !important;
}

.rounded-t-md {
  border-top-left-radius: 0.375rem;
  border-top-right-radius: 0.375rem;
}

.border {
  border-width: 1px;
}

.border-b {
  border-bottom-width: 1px;
}

.border-t {
  border-top-width: 1px;
}

.border-l-4 {
  border-left-width: 4px;
}

.border-transparent {
  border-color: transparent;
}

.border-gray-400 {
  --tw-border-opacity: 1;
  border-color: rgb(156 163 175 / var(--tw-border-opacity));
}

.border-gray-300 {
  --tw-border-opacity: 1;
  border-color: rgb(209 213 219 / var(--tw-border-opacity));
}

.border-gray-200 {
  --tw-border-opacity: 1;
  border-color: rgb(229 231 235 / var(--tw-border-opacity));
}

.border-gray-600 {
  --tw-border-opacity: 1;
  border-color: rgb(75 85 99 / var(--tw-border-opacity));
}

.border-yellow-400 {
  --tw-border-opacity: 1;
  border-color: rgb(250 204 21 / var(--tw-border-opacity));
}

.bg-gray-500 {
  --tw-bg-opacity: 1;
  background-color: rgb(107 114 128 / var(--tw-bg-opacity));
}

.bg-white {
  --tw-bg-opacity: 1;
  background-color: rgb(255 255 255 / var(--tw-bg-opacity));
}

.bg-transparent {
  background-color: transparent;
}

.bg-gray-900 {
  --tw-bg-opacity: 1;
  background-color: rgb(17 24 39 / var(--tw-bg-opacity));
}

.bg-\[\#f5f5f5\] {
  --tw-bg-opacity: 1;
  background-color: rgb(245 245 245 / var(--tw-bg-opacity));
}

.bg-blue-500 {
  --tw-bg-opacity: 1;
  background-color: rgb(59 130 246 / var(--tw-bg-opacity));
}

.bg-\[\#1DA1F2\] {
  --tw-bg-opacity: 1;
  background-color: rgb(29 161 242 / var(--tw-bg-opacity));
}

.bg-\[\#F5F5F5\] {
  --tw-bg-opacity: 1;
  background-color: rgb(245 245 245 / var(--tw-bg-opacity));
}

.bg-\[\#303030\] {
  --tw-bg-opacity: 1;
  background-color: rgb(48 48 48 / var(--tw-bg-opacity));
}

.bg-yellow-50 {
  --tw-bg-opacity: 1;
  background-color: rgb(254 252 232 / var(--tw-bg-opacity));
}

.bg-green-100 {
  --tw-bg-opacity: 1;
  background-color: rgb(220 252 231 / var(--tw-bg-opacity));
}

.bg-orange-100 {
  --tw-bg-opacity: 1;
  background-color: rgb(255 237 213 / var(--tw-bg-opacity));
}

.bg-blue-100 {
  --tw-bg-opacity: 1;
  background-color: rgb(219 234 254 / var(--tw-bg-opacity));
}

.bg-red-100 {
  --tw-bg-opacity: 1;
  background-color: rgb(254 226 226 / var(--tw-bg-opacity));
}

.bg-red-50 {
  --tw-bg-opacity: 1;
  background-color: rgb(254 242 242 / var(--tw-bg-opacity));
}

.bg-opacity-75 {
  --tw-bg-opacity: 0.75;
}

.fill-current {
  fill: currentColor;
}

.object-contain {
  object-fit: contain;
}

.object-cover {
  object-fit: cover;
}

.p-2 {
  padding: 0.5rem;
}

.p-3 {
  padding: 0.75rem;
}

.p-4 {
  padding: 1rem;
}

.px-4 {
  padding-left: 1rem;
  padding-right: 1rem;
}

.py-2 {
  padding-top: 0.5rem;
  padding-bottom: 0.5rem;
}

.px-2\.5 {
  padding-left: 0.625rem;
  padding-right: 0.625rem;
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

.px-5 {
  padding-left: 1.25rem;
  padding-right: 1.25rem;
}

.py-6 {
  padding-top: 1.5rem;
  padding-bottom: 1.5rem;
}

.px-\[19px\] {
  padding-left: 19px;
  padding-right: 19px;
}

.py-\[9px\] {
  padding-top: 9px;
  padding-bottom: 9px;
}

.px-8 {
  padding-left: 2rem;
  padding-right: 2rem;
}

.py-\[40px\] {
  padding-top: 40px;
  padding-bottom: 40px;
}

.px-6 {
  padding-left: 1.5rem;
  padding-right: 1.5rem;
}

.py-3 {
  padding-top: 0.75rem;
  padding-bottom: 0.75rem;
}

.py-12 {
  padding-top: 3rem;
  padding-bottom: 3rem;
}

.pt-5 {
  padding-top: 1.25rem;
}

.pb-12 {
  padding-bottom: 3rem;
}

.pb-6 {
  padding-bottom: 1.5rem;
}

.pt-\[40px\] {
  padding-top: 40px;
}

.pb-\[40px\] {
  padding-bottom: 40px;
}

.pt-\[30px\] {
  padding-top: 30px;
}

.pb-\[30px\] {
  padding-bottom: 30px;
}

.pb-5 {
  padding-bottom: 1.25rem;
}

.pt-10 {
  padding-top: 2.5rem;
}

.pb-4 {
  padding-bottom: 1rem;
}

.pt-8 {
  padding-top: 2rem;
}

.pb-2 {
  padding-bottom: 0.5rem;
}

.pt-4 {
  padding-top: 1rem;
}

.pb-20 {
  padding-bottom: 5rem;
}

.pl-5 {
  padding-left: 1.25rem;
}

.text-left {
  text-align: left;
}

.text-center {
  text-align: center;
}

.text-right {
  text-align: right;
}

.align-bottom {
  vertical-align: bottom;
}

.font-sans {
  font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
}

.text-sm {
  font-size: 0.875rem;
  line-height: 1.25rem;
}

.text-xs {
  font-size: 0.75rem;
  line-height: 1rem;
}

.text-base {
  font-size: 1rem;
  line-height: 1.5rem;
}

.text-4xl {
  font-size: 2.25rem;
  line-height: 2.5rem;
}

.text-\[28px\] {
  font-size: 28px;
}

.text-lg {
  font-size: 1.125rem;
  line-height: 1.75rem;
}

.font-medium {
  font-weight: 500;
}

.font-semibold {
  font-weight: 600;
}

.font-extrabold {
  font-weight: 800;
}

.font-black {
  font-weight: 900;
}

.font-bold {
  font-weight: 700;
}

.uppercase {
  text-transform: uppercase;
}

.leading-\[28px\] {
  line-height: 28px;
}

.leading-none {
  line-height: 1;
}

.leading-6 {
  line-height: 1.5rem;
}

.tracking-tight {
  letter-spacing: -0.025em;
}

.tracking-wider {
  letter-spacing: 0.05em;
}

.text-white {
  --tw-text-opacity: 1;
  color: rgb(255 255 255 / var(--tw-text-opacity));
}

.text-gray-500 {
  --tw-text-opacity: 1;
  color: rgb(107 114 128 / var(--tw-text-opacity));
}

.text-gray-600 {
  --tw-text-opacity: 1;
  color: rgb(75 85 99 / var(--tw-text-opacity));
}

.text-gray-400 {
  --tw-text-opacity: 1;
  color: rgb(156 163 175 / var(--tw-text-opacity));
}

.text-gray-900 {
  --tw-text-opacity: 1;
  color: rgb(17 24 39 / var(--tw-text-opacity));
}

.text-gray-700 {
  --tw-text-opacity: 1;
  color: rgb(55 65 81 / var(--tw-text-opacity));
}

.text-gray-300 {
  --tw-text-opacity: 1;
  color: rgb(209 213 219 / var(--tw-text-opacity));
}

.text-yellow-400 {
  --tw-text-opacity: 1;
  color: rgb(250 204 21 / var(--tw-text-opacity));
}

.text-yellow-700 {
  --tw-text-opacity: 1;
  color: rgb(161 98 7 / var(--tw-text-opacity));
}

.text-sky-600 {
  --tw-text-opacity: 1;
  color: rgb(2 132 199 / var(--tw-text-opacity));
}

.text-green-600 {
  --tw-text-opacity: 1;
  color: rgb(22 163 74 / var(--tw-text-opacity));
}

.text-orange-600 {
  --tw-text-opacity: 1;
  color: rgb(234 88 12 / var(--tw-text-opacity));
}

.text-blue-600 {
  --tw-text-opacity: 1;
  color: rgb(37 99 235 / var(--tw-text-opacity));
}

.text-red-600 {
  --tw-text-opacity: 1;
  color: rgb(220 38 38 / var(--tw-text-opacity));
}

.text-red-400 {
  --tw-text-opacity: 1;
  color: rgb(248 113 113 / var(--tw-text-opacity));
}

.text-red-800 {
  --tw-text-opacity: 1;
  color: rgb(153 27 27 / var(--tw-text-opacity));
}

.text-red-700 {
  --tw-text-opacity: 1;
  color: rgb(185 28 28 / var(--tw-text-opacity));
}

.text-green-400 {
  --tw-text-opacity: 1;
  color: rgb(74 222 128 / var(--tw-text-opacity));
}

.text-green-800 {
  --tw-text-opacity: 1;
  color: rgb(22 101 52 / var(--tw-text-opacity));
}

.underline {
  -webkit-text-decoration-line: underline;
          text-decoration-line: underline;
}

.antialiased {
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

.opacity-0 {
  opacity: 0;
}

.opacity-100 {
  opacity: 1;
}

.opacity-30 {
  opacity: 0.3;
}

.opacity-70 {
  opacity: 0.7;
}

.shadow-sm {
  --tw-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
  --tw-shadow-colored: 0 1px 2px 0 var(--tw-shadow-color);
  box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
}

.shadow {
  --tw-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
  --tw-shadow-colored: 0 1px 3px 0 var(--tw-shadow-color), 0 1px 2px -1px var(--tw-shadow-color);
  box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
}

.shadow-lg {
  --tw-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
  --tw-shadow-colored: 0 10px 15px -3px var(--tw-shadow-color), 0 4px 6px -4px var(--tw-shadow-color);
  box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
}

.shadow-xl {
  --tw-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
  --tw-shadow-colored: 0 20px 25px -5px var(--tw-shadow-color), 0 8px 10px -6px var(--tw-shadow-color);
  box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
}

.ring-1 {
  --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
  --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) var(--tw-ring-color);
  box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
}

.ring-black {
  --tw-ring-opacity: 1;
  --tw-ring-color: rgb(0 0 0 / var(--tw-ring-opacity));
}

.ring-opacity-5 {
  --tw-ring-opacity: 0.05;
}

.filter {
  filter: var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);
}

.transition {
  transition-property: color, background-color, border-color, fill, stroke, opacity, box-shadow, transform, filter, -webkit-text-decoration-color, -webkit-backdrop-filter;
  transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
  transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter, -webkit-text-decoration-color, -webkit-backdrop-filter;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 150ms;
}

.transition-opacity {
  transition-property: opacity;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 150ms;
}

.transition-all {
  transition-property: all;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 150ms;
}

.duration-200 {
  transition-duration: 200ms;
}

.duration-100 {
  transition-duration: 100ms;
}

.duration-500 {
  transition-duration: 500ms;
}

.duration-300 {
  transition-duration: 300ms;
}

.duration-150 {
  transition-duration: 150ms;
}

.ease-out {
  transition-timing-function: cubic-bezier(0, 0, 0.2, 1);
}

.ease-in {
  transition-timing-function: cubic-bezier(0.4, 0, 1, 1);
}

.hover\:bg-gray-700:hover {
  --tw-bg-opacity: 1;
  background-color: rgb(55 65 81 / var(--tw-bg-opacity));
}

.hover\:bg-white:hover {
  --tw-bg-opacity: 1;
  background-color: rgb(255 255 255 / var(--tw-bg-opacity));
}

.hover\:bg-gray-100:hover {
  --tw-bg-opacity: 1;
  background-color: rgb(243 244 246 / var(--tw-bg-opacity));
}

.hover\:bg-gray-50:hover {
  --tw-bg-opacity: 1;
  background-color: rgb(249 250 251 / var(--tw-bg-opacity));
}

.hover\:bg-blue-900:hover {
  --tw-bg-opacity: 1;
  background-color: rgb(30 58 138 / var(--tw-bg-opacity));
}

.hover\:bg-blue-700:hover {
  --tw-bg-opacity: 1;
  background-color: rgb(29 78 216 / var(--tw-bg-opacity));
}

.hover\:bg-\[\#657934\]:hover {
  --tw-bg-opacity: 1;
  background-color: rgb(101 121 52 / var(--tw-bg-opacity));
}

.hover\:text-white:hover {
  --tw-text-opacity: 1;
  color: rgb(255 255 255 / var(--tw-text-opacity));
}

.hover\:text-gray-500:hover {
  --tw-text-opacity: 1;
  color: rgb(107 114 128 / var(--tw-text-opacity));
}

.hover\:text-gray-900:hover {
  --tw-text-opacity: 1;
  color: rgb(17 24 39 / var(--tw-text-opacity));
}

.hover\:text-gray-300:hover {
  --tw-text-opacity: 1;
  color: rgb(209 213 219 / var(--tw-text-opacity));
}

.hover\:text-yellow-600:hover {
  --tw-text-opacity: 1;
  color: rgb(202 138 4 / var(--tw-text-opacity));
}

.hover\:shadow-lg:hover {
  --tw-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
  --tw-shadow-colored: 0 10px 15px -3px var(--tw-shadow-color), 0 4px 6px -4px var(--tw-shadow-color);
  box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
}

.focus\:border-indigo-500:focus {
  --tw-border-opacity: 1;
  border-color: rgb(99 102 241 / var(--tw-border-opacity));
}

.focus\:outline-none:focus {
  outline: 2px solid transparent;
  outline-offset: 2px;
}

.focus\:ring-2:focus {
  --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
  --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color);
  box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
}

.focus\:ring-inset:focus {
  --tw-ring-inset: inset;
}

.focus\:ring-indigo-500:focus {
  --tw-ring-opacity: 1;
  --tw-ring-color: rgb(99 102 241 / var(--tw-ring-opacity));
}

.focus\:ring-offset-2:focus {
  --tw-ring-offset-width: 2px;
}

@media (min-width: 640px) {
  .sm\:my-auto {
    margin-top: auto;
    margin-bottom: auto;
  }

  .sm\:my-8 {
    margin-top: 2rem;
    margin-bottom: 2rem;
  }

  .sm\:mb-0 {
    margin-bottom: 0px;
  }

  .sm\:mr-10 {
    margin-right: 2.5rem;
  }

  .sm\:mt-0 {
    margin-top: 0px;
  }

  .sm\:ml-3 {
    margin-left: 0.75rem;
  }

  .sm\:mt-5 {
    margin-top: 1.25rem;
  }

  .sm\:block {
    display: block;
  }

  .sm\:inline-block {
    display: inline-block;
  }

  .sm\:flex {
    display: flex;
  }

  .sm\:hidden {
    display: none;
  }

  .sm\:h-10 {
    height: 2.5rem;
  }

  .sm\:h-screen {
    height: 100vh;
  }

  .sm\:w-full {
    width: 100%;
  }

  .sm\:\!max-w-2xl {
    max-width: 42rem !important;
  }

  .sm\:max-w-md {
    max-width: 28rem;
  }

  .sm\:max-w-sm {
    max-width: 24rem;
  }

  .sm\:flex-shrink-0 {
    flex-shrink: 0;
  }

  .sm\:translate-y-0 {
    --tw-translate-y: 0px;
    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
  }

  .sm\:scale-95 {
    --tw-scale-x: .95;
    --tw-scale-y: .95;
    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
  }

  .sm\:scale-100 {
    --tw-scale-x: 1;
    --tw-scale-y: 1;
    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
  }

  .sm\:grid-cols-3 {
    grid-template-columns: repeat(3, minmax(0, 1fr));
  }

  .sm\:flex-row {
    flex-direction: row;
  }

  .sm\:flex-col {
    flex-direction: column;
  }

  .sm\:justify-center {
    justify-content: center;
  }

  .sm\:gap-8 {
    gap: 2rem;
  }

  .sm\:p-0 {
    padding: 0px;
  }

  .sm\:p-6 {
    padding: 1.5rem;
  }

  .sm\:px-6 {
    padding-left: 1.5rem;
    padding-right: 1.5rem;
  }

  .sm\:px-5 {
    padding-left: 1.25rem;
    padding-right: 1.25rem;
  }

  .sm\:px-4 {
    padding-left: 1rem;
    padding-right: 1rem;
  }

  .sm\:py-\[50px\] {
    padding-top: 50px;
    padding-bottom: 50px;
  }

  .sm\:pt-6 {
    padding-top: 1.5rem;
  }

  .sm\:pt-\[60px\] {
    padding-top: 60px;
  }

  .sm\:pb-\[60px\] {
    padding-bottom: 60px;
  }

  .sm\:pt-\[50px\] {
    padding-top: 50px;
  }

  .sm\:pb-\[50px\] {
    padding-bottom: 50px;
  }

  .sm\:align-middle {
    vertical-align: middle;
  }

  .sm\:text-sm {
    font-size: 0.875rem;
    line-height: 1.25rem;
  }
}

@media (min-width: 768px) {
  .md\:order-2 {
    order: 2;
  }

  .md\:order-1 {
    order: 1;
  }

  .md\:mt-8 {
    margin-top: 2rem;
  }

  .md\:mt-0 {
    margin-top: 0px;
  }

  .md\:flex {
    display: flex;
  }

  .md\:hidden {
    display: none;
  }

  .md\:h-\[inherit\] {
    height: inherit;
  }

  .md\:w-\[inherit\] {
    width: inherit;
  }

  .md\:flex-1 {
    flex: 1 1 0%;
  }

  .md\:items-center {
    align-items: center;
  }

  .md\:justify-start {
    justify-content: flex-start;
  }

  .md\:justify-center {
    justify-content: center;
  }

  .md\:justify-between {
    justify-content: space-between;
  }

  .md\:space-x-10 > :not([hidden]) ~ :not([hidden]) {
    --tw-space-x-reverse: 0;
    margin-right: calc(2.5rem * var(--tw-space-x-reverse));
    margin-left: calc(2.5rem * calc(1 - var(--tw-space-x-reverse)));
  }

  .md\:py-\[80px\] {
    padding-top: 80px;
    padding-bottom: 80px;
  }

  .md\:py-4 {
    padding-top: 1rem;
    padding-bottom: 1rem;
  }

  .md\:px-10 {
    padding-left: 2.5rem;
    padding-right: 2.5rem;
  }

  .md\:text-\[48px\] {
    font-size: 48px;
  }

  .md\:text-lg {
    font-size: 1.125rem;
    line-height: 1.75rem;
  }

  .md\:leading-\[48px\] {
    line-height: 48px;
  }
}

@media (min-width: 1024px) {
  .lg\:col-span-3 {
    grid-column: span 3 / span 3;
  }

  .lg\:col-span-2 {
    grid-column: span 2 / span 2;
  }

  .lg\:grid {
    display: grid;
  }

  .lg\:w-0 {
    width: 0px;
  }

  .lg\:flex-1 {
    flex: 1 1 0%;
  }

  .lg\:grid-cols-3 {
    grid-template-columns: repeat(3, minmax(0, 1fr));
  }

  .lg\:grid-cols-5 {
    grid-template-columns: repeat(5, minmax(0, 1fr));
  }

  .lg\:gap-8 {
    gap: 2rem;
  }

  .lg\:px-0 {
    padding-left: 0px;
    padding-right: 0px;
  }

  .lg\:py-16 {
    padding-top: 4rem;
    padding-bottom: 4rem;
  }

  .lg\:px-8 {
    padding-left: 2rem;
    padding-right: 2rem;
  }

  .lg\:pt-\[60px\] {
    padding-top: 60px;
  }

  .lg\:pb-\[30px\] {
    padding-bottom: 30px;
  }

  .lg\:pt-\[80px\] {
    padding-top: 80px;
  }

  .lg\:pb-\[80px\] {
    padding-bottom: 80px;
  }
}

        </style>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css', 'themes/EvTailwind') }}">
    @include('frontend.layouts.global-partials.all')
    @livewireStyles

    @stack('head_scripts')
</head>

<body class="relative font-sans antialiased {{ Route::currentRouteName() }}" x-data="{
}" @keydown.escape="$dispatch('main-navigation-dropdown-hide');">

    @include('frontend.layouts.global-partials.global-integrations-body')

    <div class="min-h-screen">
        {{-- <x-system.promo-banner></x-system.promo-banner> --}}
        {{-- <x-system.promo-banner-bottom></x-system.promo-banner-bottom> --}}

        <x-tailwind-ui.headers.header></x-tailwind-ui.headers.header>

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>

        <x-tailwind-ui.footers.footer>
        </x-tailwind-ui.footers.footer>
    </div>

    <x-default.footers.app-bar>
    </x-default.footers.app-bar>


    <!-- Carts -->
    <livewire:cart.cart template="flyout-cart" />
    <!-- Wishlist -->
    {{-- TODO: Refactor this for unified structure, preffered in separate folder --}}
    <livewire:flyout.wishlist />


    @guest
    <x-panels.flyout-auth></x-panels.flyout-auth>
    @endguest

    @auth
    <x-panels.flyout-profile></x-panels.flyout-profile>
    <div>
        <livewire:we-media-library />
        <livewire:we-media-editor />
    </div>
    @endauth

    @if(get_tenant_setting('chat_feature', false))
    @auth
    <x-default.chat.widget-chat></x-default.chat.widget-chat>
    @endauth
    @endif


    <x-system.info-modal></x-system.info-modal>
    <x-system.validation-errors-toast timeout="5000"></x-system.validation-errors-toast>
    <x-ev.toast id="global-toast" position="bottom-center" class="text-white text-18" :timeout="4000"></x-ev.toast>


    <script src="{{ mix('js/app.min.js', 'themes/EvTailwind') }}" defer></script>
    <script src="{{ mix('js/alpine.js', 'themes/EvTailwind') }}" defer></script>

    <!-- Scripts -->
    @livewireScripts
    <!-- Scripts -->

    @yield('script')

    @stack('footer_scripts')

    {{-- <x-integrations.mix-panel></x-integrations.mix-panel> --}}
    {{-- <x-integrations.open-replay></x-integrations.open-replay> --}}
</body>

</html>
