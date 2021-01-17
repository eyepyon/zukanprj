{* Extend our master template *}
{extends file="master.tpl"}

{* This block is defined in the master.tpl template *}
{block name=title}
パスワード変更
{/block}

{block name=header}
{include file="navi_header.tpl"}
{/block}
{block name=side}
{include file="navi_side.tpl"}
{/block}

{block name=body}

<div id="page-wrapper">
	<br/>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					パスワード変更
				</div>
				<div class="panel-body">
					<p>パスワードを更新します</p>
					{validation_errors()}
					{form_open('password/complete/')}
					<div class="form-group">
						<label>現在のパスワード：　</label>
						************
						{form_hidden('pass_old',$pass_old)}
					</div>

					<div class="form-group">
						<label>新しいパスワード：　</label>
						{$pass1}
						{form_hidden('pass1',$pass1)}
					</div>

					{form_submit('submit', '更新する','class="confirm_update"')}

					{form_close()}

				</div>
			</div>
		</div>
	</div>
</div>


{/block}
