<aside class="main-sidebar">
    <section class="sidebar">
	<ul class="sidebar-menu">
        <li class="{{ (Route::current()->uri() == 'owner/dashboard') ? 'active' : ''  }}"><a href="{{ url('owner/dashboard') }}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li>
		

    </ul>
    </section>
</aside>