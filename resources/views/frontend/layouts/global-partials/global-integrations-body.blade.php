{{-- Google Tags Manager Integration --}}
@if(get_tenant_setting('google_tag_manager_enabled') && !empty($gtm = get_tenant_setting('google_tag_manager_id')))
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $gtm }}"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
@endif
{{-- Google Tags Manager Integration --}}