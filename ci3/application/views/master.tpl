{header('X-FRAME-OPTIONS: DENY')}{header("X-Content-Type-Options: SAMEORIGIN")}
{* ↑フレームセットの一部として表示される事を禁止 *}{* ↑XSS対策 *}
<!DOCTYPE html>
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="Expires" content="-1" />
<title>{block name=title}{/block} | ShukinPAY</title>
{block name=javascript}{/block}
<!-- Custom fonts for this template-->
<link href="{$base_url}vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

<!-- Custom styles for this template-->
<link href="{$base_url}css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body {block name=bodytag}{/block}>

<div id="wrapper">

{block name=side}{/block}
<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
	<!-- Main Content -->
	<div id="content">
	{block name=header}{/block}
		<!-- Begin Page Content -->
		<div class="container-fluid">
{block name=body}{/block}
		</div>
		<!-- /.container-fluid -->
	</div>
	<!-- End of Main Content -->


	<!-- Footer -->
	<footer class="sticky-footer bg-white">
		<div class="container my-auto">
			<div class="copyright text-center my-auto">
				<span>Copyright &copy; ShukinPAY 2019</span>
			</div>
		</div>
	</footer>
	<!-- End of Footer -->

</div>
	<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Bootstrap core JavaScript-->
<script src="{$base_url}vendor/jquery/jquery.min.js"></script>
<script src="{$base_url}vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="{$base_url}vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="{$base_url}js/sb-admin-2.min.js"></script>

<script type="text/javascript">
$('.confirm_delete').click(function() {
	if (!confirm('削除してよろしいですか？')) {
		return false;
	}
});

$('.confirm_regist').click(function() {
	if (!confirm('登録してよろしいですか？')) {
		return false;
	}
});

$('.confirm_update').click(function() {
	if (!confirm('更新してよろしいですか？')) {
		return false;
	}
});

$('.search_click').click(function() {
	$('#search').submit();
});

</script>
{literal}
{/literal}

</body>

</html>
