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
					利用者{if $id>0}情報編集{else}登録{/if}確認画面
				</div>

				<!-- /.panel-heading -->
				<div class="panel-body">
					{form_open("user/complete/$id")}
						<div class="form-group">
							{if $id > 0}
							<input type="hidden" name="id" value="{$id}">
							{/if}
						</div>

					<div class="form-group">
							<label>名前：　</label>
							{$form_admin_name|escape:'html'}
							<input type="hidden" name="form_admin_name" value="{$form_admin_name|escape:'html'}">
						</div>

					<div class="form-group">
						<label>ログインID：　</label>
						{$form_admin_login|escape:'html'}
						<input type="hidden" name="form_admin_login" value="{$form_admin_login|escape:'html'}">
					</div>

					<div class="form-group">
							<label>パスワード：　</label>
							{if $pass1 == ""}
							更新しない
							{else}
							{$pass1|escape:'html'}
							<input type="hidden" name="pass1" value="{$pass1|escape:'html'}">
							{/if}
						</div>

						<div class="form-group">
							<label>アカウント種別：　</label>
							{if $account_type == $smarty.const.USER_PERMISSION_ADMIN}
							<input type="hidden" name="account_type" value="{$smarty.const.USER_PERMISSION_ADMIN}">{$smarty.const.TEXT_USER_PERMISSION_ADMIN}
							{else}
							<input type="hidden" name="account_type" value="{$smarty.const.USER_PERMISSION_READONLY}">{$smarty.const.TEXT_USER_PERMISSION_READONLY}
							{/if}
						</div>

					<div class="form-group">
						<label>アカウント状態：　</label>
						{if $account_status == $smarty.const.STATUS_FLAG_ON}
						<input type="hidden" name="account_status" value="{$smarty.const.STATUS_FLAG_ON}">{$smarty.const.TEXT_STATUS_FLAG_ON}
						{else}
						<input type="hidden" name="account_status" value="{$smarty.const.STATUS_FLAG_OFF}">{$smarty.const.TEXT_STATUS_FLAG_OFF}
						{/if}
					</div>

						{if $id>0}
						<button type="submit" class="btn btn-default confirm_update">変更する</button>
						{else}
						<button type="submit" class="btn btn-default confirm_regist">登録する</button>
						{/if}

					{form_close()}
					{form_open("user/edit/$id")}
					{form_hidden("back_button","1")}
					{if $id > 0}
					<input type="hidden" name="id" value="{$id}">
					{/if}
					<input type="hidden" name="form_admin_name" value="{$form_admin_name|escape:'html'}">
					<input type="hidden" name="form_admin_login" value="{$form_admin_login|escape:'html'}">
					{if $pass1 == ""}
					{else}
					<input type="hidden" name="pass1" value="{$pass1|escape:'html'}">
					<input type="hidden" name="pass2" value="{$pass2|escape:'html'}">
					{/if}
					{if $account_type == 1}
					<input type="hidden" name="account_type" value="1">
					{else}
					<input type="hidden" name="account_type" value="0">
					{/if}
					{if $account_status == 1}
					<input type="hidden" name="account_status" value="1">
					{else}
					<input type="hidden" name="account_status" value="0">
					{/if}
					<button type="submit" class="btn btn-default">戻る</button>
					{form_close()}

				</div>
			</div>
		</div>
		<!-- /.row -->
	</div>
</div>
{/block}
