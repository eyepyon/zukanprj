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
				{$passLimitError}
				<div class="panel-body">
					{validation_errors()}
					{form_open('password/')}
					<div class="form-group">
						<label>現在のパスワード：　</label>
						<input class="form-control" type="password" name="pass_old"  placeholder="現在のパスワード">
					</div>

					<div class="form-group">
						<label>新しいパスワード：　</label>
						<input class="form-control" type="password" name="pass1" placeholder="新しいパスワード">
					</div>

					<div class="form-group">
						<label>新しいパスワード(確認用)：　</label>
						<input class="form-control" type="password" name="pass2" placeholder="新しいパスワード(確認用)">
					</div>

					{form_submit('submit', '確認する','class="btn btn-default"')}

					{form_close()}

				</div>
			</div>
		</div>
	</div>
</div>


{/block}
