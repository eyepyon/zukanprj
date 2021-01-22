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
		{if $record_id > 0 && $record.picture_file != ''} background: url("https://dev.zukan.cloud/files/{$record.picture_file}{$salt_wd}");
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
							{if $record_id > 0}
								<h1 class="h4 text-gray-900 mb-4">図鑑更新</h1>
							{else}
								<h1 class="h4 text-gray-900 mb-4">図鑑作成</h1>
							{/if}
						</div>
						{form_open("record/edit/$record_id")}

						<div class="form-group">
							名前（漢字）
							<input type="text" name="record_name"
								   value="{set_value('record_name',$record_name)|escape:'html'}"
								   class="form-control form-control-user" placeholder="図鑑名" required>
						</div>

						<div class="form-group">
							Facebookアカウント
							https://www.facebook.com/<input type="text" name="record_name"
															value="{set_value('record_name',$record_name)|escape:'html'}"
															class="form-control form-control-user" placeholder="図鑑名"
															required>
						</div>

						<div class="form-group">
							Twitterアカウント
							https://twitter.com/<input type="text" name="record_name"
													   value="{set_value('record_name',$record_name)|escape:'html'}"
													   class="form-control form-control-user" placeholder="図鑑名"
													   required>
						</div>

						<div class="form-group">
							メールアドレス
							<input type="text" name="email" value="{set_value('email',$record_name)|escape:'html'}"
								   class="form-control form-control-user" placeholder="メールアドレス" required>
						</div>

						<div class="form-group">
							属性
							<input type="text" name="record_name"
								   value="{set_value('record_name',$record_name)|escape:'html'}"
								   class="form-control form-control-user" placeholder="属性" required>
						</div>

						<div class="form-group">
							名前（カタカナ）
							<input type="text" name="name_kana"
								   value="{set_value('name_kana',$name_kana)|escape:'html'}"
								   class="form-control form-control-user" placeholder="名前（カタカナ）" required>
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

						<div class="form-group">
							学びたいことやってみたいこと
							<textarea name="record_detail" class="form-control form-control-user"
									  placeholder="学びたいことやってみたいこと">{$record_detail|escape:'html'}</textarea>
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


						{*<div class="form-group row">*}
						{*<div class="col-sm-6 mb-3 mb-sm-0">*}
						{*受付開始日*}
						{*<input type="date" name="start_date" value="{set_value('start_date',$start_date)|escape:'html'}" class="form-control form-control-lg" placeholder="受付開始日" required>*}
						{*</div>*}
						{*<div class="col-sm-6">*}
						{*受付終了日*}
						{*<input type="date" name="end_date" value="{set_value('end_date',$end_date)|escape:'html'}" class="form-control form-control-lg" placeholder="受付終了日" required>*}
						{*</div>*}
						{*</div>*}

						{*<div class="form-group row">*}
						{*<div class="col-sm-6 mb-3 mb-sm-0">*}
						{*<input type="number" name="amount" value="{set_value('amount',$amount)|escape:'html'}" class="form-control form-control-user" placeholder="実行可能額" required>*}
						{*</div>*}
						{*<div class="col-sm-6">*}
						{*xem / 1回*}
						{*</div>*}
						{*</div>*}

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
