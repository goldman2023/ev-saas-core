@php
	$auth_user = auth()->user();
@endphp
<div class="hs-unfold mr-3">
	<a class="js-hs-unfold-invoker btn btn-icon btn-ghost-secondary rounded-circle"
        href="javascript:;"
		onclick="event.preventDefault(); markAllAsRead();"
        data-hs-unfold-options='{
            "target": "#notificationDropdown",
            "type": "css-animation"
        }'
        data-hs-unfold-target="#notificationDropdown"
        data-hs-unfold-invoker="">

        <i class="las la-bell la-2x text-white opacity-80"></i>
		@if(count($auth_user->unreadNotifications) > 0)
			<span class="btn-status btn-sm-status btn-status-danger"></span>
		@endif
    </a>
	<div id="notificationDropdown" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right" style="width: 25rem; animation-duration: 300ms;" data-hs-target-height="518.594" data-hs-unfold-content="" data-hs-unfold-content-animation-in="slideInUp" data-hs-unfold-content-animation-out="fadeOut">
		<!-- Header -->
		<div class="card-header"> <span class="card-title h4">Notifications</span>
		</div>
		<!-- End Header -->
		<!-- Nav -->
		<ul class="nav nav-tabs nav-justified" id="notificationTab" role="tablist">
			<li class="nav-item"> <a class="nav-link active" id="notificationNavOne-tab" data-toggle="tab" href="#notificationNavOne" role="tab" aria-controls="notificationNavOne" aria-selected="true">{{ translate('Messages') }}</a> </li>
			<li class="nav-item">
				<a class="nav-link" id="notificationNavTwo-tab" data-toggle="tab" href="#notificationNavTwo" role="tab" aria-controls="notificationNavTwo" aria-selected="false">
					@if (count($auth_user->unreadNotifications) > 0)
						{{ translate('Notifications (') . count($auth_user->unreadNotifications) .")" }}
					@else
						{{ translate('Notifications') }}
					@endif
				</a>
			</li>
		</ul>
		<!-- End Nav -->
		<!-- Body -->
		<div class="card-body-height">
			<!-- Tab Content -->
			<div class="tab-content" id="notificationTabContent">
				<div class="tab-pane fade active show" id="notificationNavOne" role="tabpanel" aria-labelledby="notificationNavOne-tab">

				</div>
				<div class="tab-pane fade" id="notificationNavTwo" role="tabpanel" aria-labelledby="notificationNavTwo-tab">
					@if(count($auth_user->notifications) > 0)
						<ul class="list-group list-group-flush navbar-card-list-group">
							@foreach ($auth_user->notifications as $notification)
								<x-notification.notification-item :notification="$notification"></x-notification.notification-item>
							@endforeach
						</ul>
					@else
						<p class="text-center mt-5">No notifications</p>
					@endif
				</div>
			</div>
			<!-- End Tab Content -->
		</div>
		<!-- End Body -->
		<!-- Card Footer -->
		@if(count($auth_user->notifications) > 0)
			<a class="card-footer text-center" href="{{ route('notifications.index') }}">
				{{ translate('View all notifications') }}
				<i class="tio-chevron-right"></i>
			</a>
		@endif
		<!-- End Card Footer -->
	</div>
</div>
