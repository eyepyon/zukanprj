{* Extend our master template *}
{extends file="master.tpl"}

{* This block is defined in the master.tpl template *}
{block name=title}図鑑{/block}

{block name=javascript}
	<style type="text/css">
		.bg-detail-image {
		{if $id > 0 && $record.picture_file != ''} background: url("https://dev.zukan.cloud/files/{$record.picture_file}{$salt_wd}");
		{else} background: url("https://dev.zukan.cloud/img/pic2.jpg{$salt_wd}");
		{/if} background-position: center;
			background-size: cover;
		}
	</style>
{/block}

{block name=side}
	{include file="navi_side.tpl"}
{/block}
{block name=header}
	{include file="navi_header.tpl"}
{/block}

{block name=bodytag} id="page-top" {/block}

{block name=body}
	<div class="card o-hidden border-0 shadow-lg my-5">
		<div class="card-body p-0">
			<!-- Nested Row within Card Body -->
			<div class="row">
				<div class="col-lg-5 d-none d-lg-block bg-detail-image"></div>
				<div class="col-lg-7">
					<div class="p-5">
						<div class="text-center">
							{if $id > 0}
								<h1 class="h4 text-gray-900 mb-4">図鑑更新内容確認</h1>
							{else}
								<h1 class="h4 text-gray-900 mb-4">図鑑作成内容確認</h1>
							{/if}
						</div>
						{form_open("record/action/$id")}
						<div class="form-group">
							図鑑名
							<p>{$name|escape:'html'}</p>
							<input type="hidden" name="name" value="{$name|escape:'html'}">
						</div>

						<div class="form-group">
							図鑑詳細
							<p>{$detail|nl2br}</p>
							<input type="hidden" name="detail" value="{$detail|escape:'html'}">
						</div>

						<div class="form-group">
							Facebook
							<p>https://www.facebook.com/{$facebook_account|nl2br}/</p>
							<input type="hidden" name="facebook_account" value="{$facebook_account|escape:'html'}">
						</div>

						<div class="form-group">
							Twitter
							<p>{https://twitter.com/$twitter_account|nl2br}</p>
							<input type="hidden" name="twitter_account" value="{$twitter_account|escape:'html'}">
						</div>

						<div class="form-group">
							保有する資格
							<p>{$qualification|nl2br}</p>
							<input type="hidden" name="qualification" value="{$qualification|escape:'html'}">
						</div>

						<div class="form-group">
							名前（カタカナ）
							<p>{$name_kana|nl2br}</p>
							<input type="hidden" name="name_kana" value="{$name_kana|escape:'html'}">
						</div>

						<div class="form-group">
							所属団体/コミュニティ（会社以外
							<p>{$community|nl2br}</p>
							<input type="hidden" name="community" value="{$community|escape:'html'}">
						</div>

						<div class="form-group">
							保有する資格
							<p>{$qualification|nl2br}</p>
							<input type="hidden" name="qualification" value="{$qualification|escape:'html'}">
						</div>

						<div class="form-group">
							学びたいことやってみたいこと
							<p>{$study|nl2br}</p>
							<input type="hidden" name="study" value="{$study|escape:'html'}">
						</div>

						<div class="form-group">
							教えられること貢献できること
							<p>{$contribute|nl2br}</p>
							<input type="hidden" name="contribute" value="{$contribute|escape:'html'}">
						</div>

						<div class="form-group">
							最も取り組みたい領域・分野
							<p>{$most_area|nl2br}</p>
							<input type="hidden" name="most_area" value="{$most_area|escape:'html'}">
						</div>

						<div class="form-group">
							頑張りたいこと＆意気込み
							<p>{$enthusiasm|nl2br}</p>
							<input type="hidden" name="enthusiasm" value="{$enthusiasm|escape:'html'}">
						</div>

						{*<div class="form-group row">*}
						{*<div class="col-sm-6 mb-3 mb-sm-0">*}
						{*受付開始日:*}
						{*{$start_date|escape:'html'}*}
						{*<input type="hidden" name="start_date" value="{$start_date|escape:'html'}">*}
						{*</div>*}
						{*<div class="col-sm-6">*}
						{*受付終了日:*}
						{*{$end_date|escape:'html'}*}
						{*<input type="hidden" name="end_date" value="{$end_date|escape:'html'}">*}
						{*</div>*}
						{*</div>*}

						{*<div class="form-group row">*}
						{*<div class="col-sm-6 mb-3 mb-sm-0">*}
						{*実行可能額:*}
						{*{$amount|escape:'html'}xem / 1回*}
						{*<input type="hidden" name="amount" value="{$amount|escape:'html'}">*}
						{*</div>*}
						{*<div class="col-sm-6">*}
						{*</div>*}
						{*</div>*}

						{if $id > 0}
							<button type="submit" class="btn btn-primary btn-user btn-block confirm_update">更新</button>
						{else}
							<button type="submit" class="btn btn-primary btn-user btn-block confirm_regist">登録</button>
						{/if}

						{form_close()}
					</div>
				</div>
			</div>
		</div>
	</div>
{/block}
