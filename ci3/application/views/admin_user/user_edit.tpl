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
	<br/>

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					利用者{if $id>0}情報編集{else}登録{/if}
				</div>

				<!-- /.panel-heading -->
				<div class="panel-body">
					{validation_errors()}

					{if $id>0}
					{form_open("user/edit/$id")}
					{else}
					{form_open('user/edit/')}
					<input type="hidden" name="account_status" value="{$smarty.const.STATUS_FLAG_ON}">
					{/if}

					<div class="form-group">
<!--						<label>ID：　{if $id>0}{$id}{else}新規作成{/if}</label>-->
					</div>

					<div class="form-group">
						<label>名前：　</label>
						{if $id>0}
							<input class="form-control" placeholder="名前" type="text" name="form_admin_name"
								   value="{set_value('form_admin_name',$user.admin_name)|escape:'html'}"/>
						{else}
						<input class="form-control" placeholder="名前" type="text" name="form_admin_name"
						       value="{set_value('form_admin_name',$form_admin_name)|escape:'html'}"/>
						{/if}
					</div>

					<div class="form-group">
						<label>ログインID：　</label>
						{if $id>0}
						{$user.admin_login|escape:'html'}
						<input class="form-control" placeholder="ログインID" type="hidden" name="form_admin_login"
						       value="{set_value('form_admin_login',$user.admin_login)|escape:'html'}"/>
						{else}
						<input class="form-control" placeholder="ログインID" type="text" name="form_admin_login"
						       value="{set_value('form_admin_login',$form_admin_login)|escape:'html'}"/>
						{/if}

					</div>


					<div class="form-group">
						<label>パスワード：　半角英数字・記号　8～32文字以内</label>
						<input class="form-control" type="password" name="pass1"
						       {if $back_button== "1"}
						value="{$user.pass1|escape:'html'}"
						{/if}
						placeholder="パスワード{if $id>0}(更新しない場合は空白にしておいてください){/if}">
					</div>

					<div class="form-group">
						<label>パスワード(確認用)：　半角英数字・記号　8～32文字以内</label>
						<input class="form-control" type="password" name="pass2"
						       {if $back_button== "1"}
						value="{$user.pass2|escape:'html'}"
						{/if}
						placeholder="パスワード(確認用)">
					</div>

					<div class="form-group">
						<label>アカウント種別：　</label>
						<label class="radio-inline">
							<input type="radio" name="account_type" id="optionsRadiosInline1"
							       value="{$smarty.const.USER_PERMISSION_READONLY}" {if $user.account_type !=$smarty.const.USER_PERMISSION_ADMIN} checked{/if}>
							{$smarty.const.TEXT_USER_PERMISSION_READONLY}
						</label>
						<label class="radio-inline">
							<input type="radio" name="account_type" id="optionsRadiosInline2"
							       value="{$smarty.const.USER_PERMISSION_ADMIN}" {if $user.account_type == $smarty.const.USER_PERMISSION_ADMIN } checked{/if}>
							{$smarty.const.TEXT_USER_PERMISSION_ADMIN}
						</label>
					</div>

					{if $id>0}
					<div class="form-group">
						<label>アカウント状態：　</label>
						<label class="radio-inline">
							<input type="radio" name="account_status" id="optionsRadiosInline1"
							       value="{$smarty.const.STATUS_FLAG_ON}" {if $user.account_status } checked{/if}>有効
						</label>
						<label class="radio-inline">
							<input type="radio" name="account_status" id="optionsRadiosInline2"
							       value="{$smarty.const.STATUS_FLAG_OFF}" {if !$user.account_status } checked{/if}>無効
						</label>
					</div>
					{/if}

					<button type="submit" class="btn btn-default">確認</button>
					{form_close()}
				</div>
			</div>
		</div>
		<!-- /.row -->
	</div>
</div>
{/block}
