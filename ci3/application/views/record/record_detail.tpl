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
		{else} background: url("https://dev.zukan.cloud/img/pic1.jpg{$salt_wd}");
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
							<h1 class="h4 text-gray-900 mb-4">図鑑詳細</h1>
						</div>

						<div class="form-group">
							名前（漢字）
							<p>{$record.name|escape:'html'}</p>
						</div>

						<div class="form-group">
							名前（カタカナ）
							<p>{$record.name_kana|escape:'html'}</p>
						</div>

						<div class="form-group">
							Facebookアカウント
							<p><a href="https://www.facebook.com/{$record.facebook_account|escape:'html'}/"
								  target="_blank">https://www.facebook.com/{$record.facebook_account|escape:'html'}/</a>
							</p>
						</div>

						<div class="form-group">
							Twitterアカウント
							<p><a href="https://twitter.com/{$record.twitter_account|escape:'html'}" target="_blank">https://twitter.com/{$record.twitter_account|escape:'html'}</a>
							</p>
						</div>

						<div class="form-group">
							属性
							<p>
								{if $record.attribute == 1}
									社会人
								{elseif $record.attribute == 2}
									学生
								{/if}
							</p>
						</div>

						<div class="form-group">
							学びたいことやってみたいこと
							<p>{$record.study|nl2br}</p>
						</div>

						<div class="form-group">
							教えられること貢献できること
							<p>{$record.contribute|nl2br}</p>
						</div>

						<div class="form-group">
							最も取り組みたい領域・分野
							<p>{$record.most_area|nl2br}</p>
						</div>

						<div class="form-group">
							頑張りたいこと＆意気込み
							<p>{$record.enthusiasm|nl2br}</p>
						</div>

						<div class="form-group">
							保有する資格
							<p>{$record.qualification|nl2br}</p>
						</div>

						<div class="form-group">
							所属団体/コミュニティ（会社以外）
							<p>{$record.community|nl2br}</p>
						</div>

{*						<div class="form-group">*}
{*							詳細*}
{*							<p>{$record.detail|nl2br}</p>*}
{*						</div>*}

						<div class="form-group">
							登録日時
							<p>{$record.created_at|nl2br}</p>
						</div>

						<div class="form-group">
							更新日時
							<p>{$record.updated_at|nl2br}</p>
						</div>

						<hr/>
						<hr/>

						{if $record.user_id == $user_id}
							<a href="/record/edit/{$id}/" class="btn btn-primary btn-user btn-block">
								<i class="fas fa-fw fa-cog"></i> 情報更新
							</a>
							<br/>
{*							{if $record.picture_file != ""}*}
{*								<a href="/record/picture/{$id}/" class="btn btn-primary btn-user btn-block">*}
{*									<i class="fas fa-camera fa-fw"></i> 画像更新*}
{*								</a>*}
{*							{else}*}
{*								<a href="/record/picture/{$id}/" class="btn btn-success btn-user btn-block">*}
{*									<i class="fas fa-camera fa-fw"></i> 画像追加*}
{*								</a>*}
{*							{/if}*}
{*							<br/>*}
{*							{if $record.vrm_file != ""}*}
{*								<a href="/record/vrm/{$id}/" class="btn btn-primary btn-user btn-block">*}
{*									<i class="fas fa-map fa-fw"></i> VRMファイル更新*}
{*								</a>*}
{*							{else}*}
{*								<a href="/record/vrm/{$id}/" class="btn btn-success btn-user btn-block">*}
{*									<i class="fas fa-map fa-fw"></i> VRMファイル追加*}
{*								</a>*}
{*							{/if}*}
						{/if}

					</div>
				</div>
			</div>
		</div>
	</div>
	{if count($goal_list)>0}
		<table class="table table-bordered" width="100%" cellspacing="0">
			<tr>
				<th>達成日時</th>
				<th>TX Hash</th>
				<th>xem</th>
			</tr>
			{foreach from=$goal_list item=item}
				<tr>
					<td>{$item.created_at }</td>
					<td>
						{if $item.tx_hash != ''}
							<a href='http://explorer.nemchina.com//#/s_tx?hash={$item.tx_hash}'
							   target="_blank">{$item.tx_hash}</a>
						{/if}
					</td>
					<td>{$item.amount}</td>
				</tr>
			{/foreach}
		</table>
	{/if}



{/block}
