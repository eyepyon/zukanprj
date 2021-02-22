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
			<span>図鑑</span>
		</a>
		<div id="collapsePrj" class="collapse{$show_menu.record}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<h6 class="collapse-header">図鑑データ</h6>
				<a class="collapse-item" href="https://docs.google.com/spreadsheets/d/1X9lEQIp0m_JUuV6y0Ke7MxqoM8bGfvAXkNCcxHeiTJA/edit?usp=sharing" target="_blank">図鑑シート</a>
				<a class="collapse-item" href="/record/">図鑑一覧</a>

				<a class="collapse-item" href="https://docs.google.com/forms/d/1env4FhWBz_o45nPfI7F8ZmaqBzlEV4xMaabQk3TGfzI/" target="_blank">フォーム</a>
				<a class="collapse-item" href="/record/edit/">応募フォーム</a>
				{if $loggedIn}
				<a class="collapse-item" href="/record/edit/">新規作成</a>
				{/if}
			</div>
		</div>
	</li>

	<li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
			<i class="fas fa-fw fa-cog"></i>
			<span>管理機能</span>
		</a>
		<div id="collapseTwo" class="collapse{$show_menu.user}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
				<h6 class="collapse-header">管理者:</h6>
				{if $loggedIn}
					<a class="collapse-item" href="https://docs.google.com/spreadsheets/d/1pzcOR8zRkDJJLkKkPO4wz_Q8HbYoiBOgaDLfV_CWbvU/edit?usp=sharing" target="_blank">フィードバック一覧</a>
					<a class="collapse-item" href="https://docs.google.com/forms/d/e/1FAIpQLSfGwoaA1mJ64HEOUcp34cvTsq4cwxVO_BKA8fz58AyZm2ngYA/viewform?usp=sf_link" target="_blank">フィードバック投稿</a>

					<a class="collapse-item" href="https://track.webanalytics.marketing/" target="_blank">Analytics</a>
					<a class="collapse-item" href="/phpMyAdmin/" target="_blank">phpMyAdmin</a>

					<a class="collapse-item" href="https://join.slack.com/t/w1610259168-euf770481/shared_invite/zt-kn6ek0xy-kO45wYrYUc7bsbLscucu_g" target="_blank">通知テスト用Slack</a>

					<a class="collapse-item" href="/record/open/">フォーム表示設定</a>
					<a class="collapse-item" href="/user/profile/">管理者設定</a>
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
