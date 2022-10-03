<tr>
<td class="header">
<h4 style="display: inline-block;">
@if (!empty(get_tenant_setting('site_logo')))
{{-- <img src="{{ Storage::url(get_tenant_setting('site_logo')->file_name) }}" class="logo" alt="{{ get_tenant_setting('site_name') }}"height="50px"> --}}
{{ get_tenant_setting('site_name') }}
@else
{{ $slot }}
@endif
</h4>
</td>
</tr>
