@php
if(!isset($dynamic_count)) {
    $dynamic_count = 0;

} else {
    $dynamic_count++;
}
@endphp

<div class="hs-unfold">
    <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary rounded-circle" href="javascript:;" data-hs-unfold-options="{
         &quot;target&quot;: &quot;#teamsDropdown1&quot;,
         &quot;type&quot;: &quot;css-animation&quot;
       }" data-hs-unfold-target="#teamsDropdown{{ $dynamic_count }}" data-hs-unfold-invoker="">
      <i class="tio-more-vertical"></i>
    </a>

    <div id="teamsDropdown{{ $dynamic_count }}"

    class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right hs-unfold-content-initialized hs-unfold-css-animation animated hs-unfold-reverse-y hs-unfold-hidden" data-hs-unfold-content-animation-in="slideInUp" data-hs-unfold-content-animation-out="fadeOut" style="animation-duration: 300ms;">
      <button class="dropdown-item" wire:click.prevent="editLabel()">{{ translate('Edit Label') }}</button>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item text-danger" href="#">Delete</a>
    </div>
  </div>
