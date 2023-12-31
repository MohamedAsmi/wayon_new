<div class="col-lg-2 p-0 border-right d-none d-lg-block overflow-hidden mt-m-30">
	<div class="main-panel mt-5 h-100">
		<div class="mt-2">
			<ul class="list-group list-group-flush pl-3">
				<a class="text-color font-weight-500 mt-1" href="{{ url('owner/dashboard') }}">
					<li class="list-group-item vbg-default-hover pl-25 border-0 text-15 p-4  {{ (request()->is('dashboard')) ? 'active-sidebar' : '' }}">
						<i class="fa fa-tachometer-alt mr-3 text-18 align-middle"></i>
						{{trans('messages.header.dashboard')}}
					</li>
				</a>

				<a class="text-color font-weight-500 mt-1" href="{{ url('owner/dashboard') }}">
                    <li class="list-group-item vbg-default-hover pl-25 border-0 text-15 p-4 d-flex align-items-center justify-content-between">
                        <div class="item">
                            <i class="fas fa-inbox mr-3 text-18 align-middle"></i>
                            {{trans('messages.header.inbox')}}
                        </div>
                       
                    </li>
                </a>

				<a class="text-color font-weight-500 mt-1" href="{{ url('owner/properties') }}">
					<li class="list-group-item vbg-default-hover pl-25 border-0 text-15 p-4  {{ (request()->is('properties')) ? 'active-sidebar' : '' }}">
						<i class="far fa-list-alt mr-3 text-18 align-middle"></i>
						{{trans('messages.header.your_listing')}}
					</li>
				</a>

				<a class="text-color font-weight-500 mt-1" href="{{ url('owner/payout-list') }}">
					<li class="list-group-item vbg-default-hover pl-25  border-0 text-15 p-4 {{ (request()->is('owner/payout-list' ) || request()->is('owner/payout')) ? 'active-sidebar' : '' }}">
						<i class="far fa-credit-card mr-3 text-18 align-middle"></i>
						{{trans('messages.sidenav.payouts')}}
					</li>
				</a>
				<a class="text-color font-weight-500 mt-1" href="{{ url('owner/my-bookings') }}">
					<li class="list-group-item vbg-default-hover pl-25 border-0 text-15 p-4  {{ (request()->is('my-bookings')) ? 'active-sidebar' : '' }}">
						<i class="fa fa-bookmark mr-3 text-18 align-middle" aria-hidden="true"></i>
						{{trans('messages.booking_my.booking')}}
					</li>
				</a>
                

				
				{{-- <a class="text-color font-weight-500 mt-1" href="{{ url('owner/transaction-history') }}">
					<li class="list-group-item vbg-default-hover pl-25  border-0 text-15 p-4  {{ (request()->is('owner/transaction-history')) ? 'active-sidebar' : '' }}">
						<i class="fas fa-money-check-alt mr-3 text-16 align-middle"></i>
						{{trans('messages.account_transaction.transaction')}}
					</li>
				</a> --}}

				<a class="text-color font-weight-500 mt-1" href="{{ url('owner/profile') }}">
					<li class="list-group-item vbg-default-hover pl-25  border-0 text-15 p-4 {{ (request()->is('owner/profile') || request()->is('owner/profile/media') || request()->is('owner/edit-verification') || request()->is('owner/security')) ? 'active-sidebar' : '' }}">
						<i class="far fa-user-circle mr-3 text-18 align-middle"></i>
						{{trans('messages.utility.profile')}}
					</li>
				</a>

				<a class="text-color font-weight-500" data-toggle="collapse" href="#collapseReviews" role="button" aria-expanded="true" aria-controls="collapseReviews" id="reviewIcon">
					<li class="list-group-item vbg-default-hover pl-25 border-0 text-15 p-4 ">

						<div class="d-flex justify-content-between">
							<div>
								<span>
									<i class="fas fa-user-edit mr-3 text-18"></i>
									{{trans('messages.sidenav.reviews')}}
								</span>
							</div>
							<div>
								<span class="text-right pr-4">
									
									<i class="fas fa-angle-down" id="reviewArrow"></i>
									
								
								</span>
							</div>
						</div>

					</li>
				</a>

				<div class="collapse " id="collapseReviews">
					<ul class="pl-5">
					

						<a class="text-color font-weight-500" href="">
								Review For You
							</li>
						</a>
					</ul>
				</div>

				<a class="text-color font-weight-500 mt-1" href="{{ url('logout') }}">
					<li class="list-group-item vbg-default-hover pl-25 border-0 text-15 p-4">
						<i class="fas fa-sign-out-alt mr-3 text-18 align-middle"></i>
						{{trans('messages.header.logout')}}
					</li>
				</a>
			</ul>
		</div>
	</div>
</div>

