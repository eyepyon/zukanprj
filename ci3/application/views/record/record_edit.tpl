{* Extend our master template *}
{extends file="master.tpl"}

{* This block is defined in the master.tpl template *}
{block name=title}図鑑{/block}

{block name=side}
	{include file="navi_side.tpl"}
{/block}
{block name=header}
	{include file="navi_header.tpl"}
{/block}

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
								<h1 class="h4 text-gray-900 mb-4">図鑑更新</h1>
							{else}
								<h1 class="h4 text-gray-900 mb-4">図鑑登録</h1>
							{/if}
						</div>
						{$validation_errors}

						{form_open("record/edit/$id")}

						<div class="form-group">
							名前（漢字） ※
							<input type="text" name="name"
								   value="{set_value('name',$name)|escape:'html'}"
								   class="form-control form-control-user" placeholder="名前（漢字）を入れてください" required>
						</div>

						<div class="form-group">
							名前（カタカナ） ※
							<input type="text" name="name_kana"
								   value="{set_value('name_kana',$name_kana)|escape:'html'}"
								   class="form-control form-control-user" placeholder="名前（カタカナ）を入れてください" required>
						</div>

						<div class="form-group">
							Facebookアカウント ※
						</div>
						<div class="form-group row">
							<div class="col-sm-6 mb-3 mb-sm-0"  style="text-align: right">
								https://www.facebook.com/
							</div>
							<div class="col-sm-6">
								<input type="text" name="facebook_account"
									   value="{set_value('facebook_account',$facebook_account)|escape:'html'}"
									   class="form-control form-control-user" placeholder="Facebookアカウントを入れてください"
									   required>
							</div>
						</div>

						<div class="form-group">
							Twitterアカウント
						</div>
						<div class="form-group row">
							<div class="col-sm-6 mb-3 mb-sm-0" style="text-align: right">
							https://twitter.com/
							</div>
							<div class="col-sm-6">
							<input type="text" name="twitter_account"
													   value="{set_value('twitter_account',$twitter_account)|escape:'html'}"
													   class="form-control form-control-user" placeholder="Twitterアカウントを入れてください"
													   required>
							</div>
						</div>

{*						<div class="form-group">*}
{*							メールアドレス*}
{*							<input type="text" name="email" value="{set_value('email',$name)|escape:'html'}"*}
{*								   class="form-control form-control-user" placeholder="メールアドレス" required>*}
{*						</div>*}

						<div class="form-group">
							属性 ※
						</div>
						<div class="form-group">
							<div class="custom-control custom-checkbox small">
								<input type="radio" name="attribute" value="1" class="custom-control-input"/>
								<label class="custom-control-label" for="customCheck">社会人</label>
							</div>
						</div>
						<div class="form-group">
							<div class="custom-control custom-checkbox small">
								<input type="radio" name="attribute" value="2" class="custom-control-input"/>
								<label class="custom-control-label" for="customCheck">学生</label>
							</div>
						</div>

						<div class="form-group">
							学びたいことやってみたいこと
							<textarea name="study" class="form-control form-control-user"
									  placeholder="学びたいことやってみたいこと">{$study|escape:'html'}</textarea>
						</div>

						<div class="form-group">
							教えられること貢献できること
							<textarea name="contribute" class="form-control form-control-user"
									  placeholder="教えられること貢献できること">{$contribute|escape:'html'}</textarea>
						</div>

						<div class="form-group">
							最も取り組みたい領域・分野
							<textarea name="most_area" class="form-control form-control-user"
									  placeholder="最も取り組みたい領域・分野">{$most_area|escape:'html'}</textarea>
						</div>

						<div class="form-group">
							頑張りたいこと＆意気込み
							<textarea name="enthusiasm" class="form-control form-control-user"
									  placeholder="頑張りたいこと＆意気込み">{$enthusiasm|escape:'html'}</textarea>
						</div>

						<div class="form-group">
							保有する資格
							<textarea name="qualification" class="form-control form-control-user"
									  placeholder="保有する資格">{$qualification|escape:'html'}</textarea>
						</div>

						<div class="form-group">
							所属団体/コミュニティ（会社以外）
							<textarea name="community" class="form-control form-control-user"
									  placeholder="所属団体/コミュニティ（会社以外）">{$community|escape:'html'}</textarea>
						</div>


						<input type="hidden" name="mode" value="edit">
						<button type="submit" class="btn btn-primary btn-user btn-block">確認</button>

						{form_close()}
						<hr>
						<div class="text-center">
							<a class="small" href="/info/about/">図鑑って？</a>
						</div>
						<div class="text-center">
							<a class="small" href="/info/howto/">図鑑運用マニュアル</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
{/block}
