{* Extend our master template *}
{extends file="master.tpl"}

{* This block is defined in the master.tpl template *}
{block name=title}図鑑{/block}

{block name=javascript}
	<style type="text/css">
		.bg-detail-image {
		{if $id > 0 && $record.picture_file != ''} background: url("https://dev.zukan.cloud/files/{$record.picture_file}{$salt_wd}");
		{else} background: url("{$base_url}/img/pic2.jpg{$salt_wd}");
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
								<h1 class="h4 text-gray-900 mb-4">図鑑登録内容確認</h1>
							{/if}
						</div>
						{form_open("record/action/$id")}
						<div class="form-group">
							名前（漢字）
							<p>{$name|escape:'html'}</p>
							<input type="hidden" name="name" value="{$name|escape:'html'}">
						</div>

						<div class="form-group">
							名前（カタカナ）
							<p>{$name_kana|nl2br}</p>
							<input type="hidden" name="name_kana" value="{$name_kana|escape:'html'}">
						</div>

						<div class="form-group">
							Facebookアカウント
							<p><a href="https://www.facebook.com/{$facebook_account|nl2br}/" target="_blank">https://www.facebook.com/{$facebook_account|nl2br}/</a></p>
							<input type="hidden" name="facebook_account" value="{$facebook_account|escape:'html'}">
						</div>

						<div class="form-group">
							Twitterアカウント
							<p>
							{if $twitter_account != ""}
								<a href="https://twitter.com/{$twitter_account|nl2br}" target="_blank">https://twitter.com/{$twitter_account|nl2br}</a>
							{/if}
							</p>
							<input type="hidden" name="twitter_account" value="{$twitter_account|escape:'html'}">
						</div>

						<div class="form-group">
							属性
							<p>
							{if $attribute == 1}
								社会人
							{elseif $attribute == 2}
								学生
							{/if}
							</p>
							<input type="hidden" name="attribute" value="{$attribute|escape:'html'}">
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

						<div class="form-group">
							保有する資格
							<p>{$qualification|nl2br}</p>
							<input type="hidden" name="qualification" value="{$qualification|escape:'html'}">
						</div>

						<div class="form-group">
							所属団体/コミュニティ（会社以外
							<p>{$community|nl2br}</p>
							<input type="hidden" name="community" value="{$community|escape:'html'}">
						</div>

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
