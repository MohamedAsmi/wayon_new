<nav class="navbar navbar-expand-lg navbar-light list-bacground border rounded-3 p-3">
	<ul class="list-inline">
		<li class="list-inline-item p-2">
			<a class="text-color {{ (request()->is('owner/profile')) ? 'secondary-text-color font-weight-700' : '' }} text-color-hover" href="{{ url('owner/profile') }}">
				{{trans('messages.sidenav.edit_profile')}}
			</a>
		</li>

		<li class="list-inline-item p-2">
			<a class="text-color {{ (request()->is('owner/profile/media')) ? 'secondary-text-color font-weight-700' : '' }} text-color-hover" href="{{ url('owner/profile/media') }}">
				{{trans('messages.sidenav.photo')}}
			</a>
		</li>

		<li class="list-inline-item p-2">
			<a class="text-color {{ (request()->is('owner/edit-verification')) ? 'secondary-text-color font-weight-700' : '' }} text-color-hover" href="{{ url('owner/edit-verification') }}">
				{{trans('messages.sidenav.verification')}}
			</a>
		</li>

		<li class="list-inline-item p-2">
			<a class="text-color {{ (request()->is('owner/security')) ? 'secondary-text-color font-weight-700' : '' }}   text-color-hover" href="{{ url('owner/security') }}">
				{{trans('messages.account_sidenav.security')}}  

			</a>
		</li>
	</ul>
</nav>