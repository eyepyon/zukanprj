{* Extend our master template *}
{extends file="master.tpl"}

{* This block is defined in the master.tpl template *}
{block name=title}画像アップロード{/block}

{block name=javascript}
<link rel="stylesheet" href="/dist/css/drop.css" />
<link rel="stylesheet" href="/dist/css/dropify.min.css" />
{/block}

{block name=header}
{include file="navi_header.tpl"}
{/block}
{block name=side}
{include file="navi_side.tpl"}
{/block}

{block name=body}
<!-- Page Content -->
<div id="page-wrapper">
	<br/>

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					画像アップロード
				</div>
			</div>
		</div>

		<div class="col-lg-12">

			<!-- /.panel-heading -->
			<div class="panel-body">

				{form_open_multipart("/roid/picture_upload/$record_id")}
				<input type="file" id="input-file-now" name="image" class="dropify"/>
				<br/>
				<input type="submit" value="アップロード" class="btn btn-lg btn-primary btn-block"/>
				{form_close()}
			</div>
		</div>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="/dist/js/dropify.min.js"></script>
	<script>
		{literal}
			// Basic
			$('.dropify').dropify();

		// Used events
		var drEvent = $('#input-file-events').dropify();

		drEvent.on('dropify.beforeClear', function(event, element){
			return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
		});

		drEvent.on('dropify.afterClear', function(event, element){
			alert('File deleted');
		});

		drEvent.on('dropify.errors', function(event, element){
			console.log('Has Errors');
		});
		{/literal}
	</script>
{/block}
