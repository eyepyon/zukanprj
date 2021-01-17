<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

	<!-- Sidebar - Brand -->
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="/top/">
		<div class="sidebar-brand-icon rotate-n-15">
			<i class="fas fa-laugh-wink"></i>
		</div>
		<div class="sidebar-brand-text mx-3">Zukan</div>
	</a>

	<!-- Divider -->
	<hr class="sidebar-divider my-0">

	<!-- Nav Item - Dashboard -->
	<li class="nav-item active">
		<a class="nav-link" href="/top/">
			<i class="fas fa-fw fa-tachometer-alt"></i>
			<span>Dashboard</span></a>
	</li>

	<!-- Divider -->
	<hr class="sidebar-divider">

	<!-- Heading -->
	<div class="sidebar-heading">
		Interface
	</div>

	<!-- Nav Item - Pages Collapse Menu -->
	<li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePrj" aria-expanded="true" aria-controls="collapsePrj">
			<i class="fas fa-fw fa-cog"></i>
			<span>ロイド</span>
		</a>
		<div id="collapsePrj" class="collapse{$show_menu.roid}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<h6 class="collapse-header">Roid:</h6>
				<a class="collapse-item" href="/roid/">ロイド一覧</a>
				{if $loggedIn}
				<a class="collapse-item" href="/roid/edit/">新規作成</a>
				{/if}
			</div>
		</div>
	</li>

	<!-- Nav Item - Pages Collapse Menu -->
	<li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePrj" aria-expanded="true" aria-controls="collapsePrj">
			<i class="fas fa-fw fa-cog"></i>
			<span>通貨</span>
		</a>
		<div id="collapsePrj" class="collapse{$show_menu.currency}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<h6 class="collapse-header">Currency:</h6>
				<a class="collapse-item" href="/currency/">通貨一覧</a>
				{if $loggedIn}
					<a class="collapse-item" href="/currency/edit/">新規作成</a>
				{/if}
			</div>
		</div>
	</li>

	<li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
			<i class="fas fa-fw fa-cog"></i>
			<span>ユーザ設定</span>
		</a>
		<div id="collapseTwo" class="collapse{$show_menu.user}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<h6 class="collapse-header">USER:</h6>
				{if $loggedIn}
				<a class="collapse-item" href="/wallet/">MYウォレット</a>
				<a class="collapse-item" href="/user/profile/">プロフィール</a>
				{/if}
			</div>
		</div>
	</li>

	<!-- Divider -->
	<hr class="sidebar-divider d-none d-md-block">

	<!-- Sidebar Toggler (Sidebar) -->
	<div class="text-center d-none d-md-inline">
		<button class="rounded-circle border-0" id="sidebarToggle"></button>
	</div>
</ul>
