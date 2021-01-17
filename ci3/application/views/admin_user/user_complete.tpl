{* Extend our master template *}
{extends file="master.tpl"}

{* This block is defined in the master.tpl template *}
{block name=title}
利用者管理
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
	<br />
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					{if $id != 0}
						利用者情報編集完了画面
					{else}
						利用者登録完了画面
					{/if}
				</div>

				<!-- /.panel-heading -->
				<div class="panel-body">
					{if $id != 0}
						利用者情報編集が完了致しました<br/>
					{else}
						登録が完了致しました<br/>
					{/if}
					<br/>
					<a href="/user/"><button type="button" class="btn btn-default">利用者一覧画面</button></a>

				</div>
			</div>
		</div>
		<!-- /.row -->
	</div>
</div>
{/block}
