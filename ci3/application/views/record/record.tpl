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

{block name=bodytag} id="page-top" {/block}

{block name=body}

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">図鑑</h1>
    <p class="mb-4">現在登録中の図鑑一覧です。</p>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            {form_open('record/')}
            {form_dropdown('page_limit', $site_page_limit_array,$page_limit)}
            {form_hidden('name',$name)}
            <button type="submit" class="btn btn-primary">表示</button>
            {form_close()}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th style="white-space:nowrap;">名前（漢字）</th>
						<th style="white-space:nowrap;">名前（カタカナ）</th>
						<th style="white-space:nowrap;">Facebookアカウント</th>
						<th style="white-space:nowrap;">Twitterアカウント</th>
						<th style="white-space:nowrap;">属性</th>
						<th style="white-space:nowrap;">学びたいこと<br/>やってみたいこと</th>
						<th style="white-space:nowrap;">教えられること<br/>貢献できること</th>
						<th style="white-space:nowrap;">最も取り組みたい<br/>領域・分野</th>
						<th style="white-space:nowrap;">頑張りたいこと<br/>＆意気込み</th>
						<th style="white-space:nowrap;">保有する資格</th>
						<th style="white-space:nowrap;">所属団体/コミュニティ<br/>（会社以外）</th>
                        <th style="white-space:nowrap;">登録日時</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach from=$list item=item}
                        <tr>
                            <td>{$item.id|string_format:"%03d"}</td>
                            <td><a href="/record/detail/{$item.id|escape:'html'}/">{$item.name|escape:'html'}</a></td>
							<td>{$item.name_kana|escape:'html'}</td>
							<td style="white-space:nowrap;"><a href="https://www.facebook.com/{$item.facebook_account|escape:'html'}" target="_blank">https://www.facebook.com/{$item.facebook_account|escape:'html'}</a></td>
							<td style="white-space:nowrap;">
							{if $item.twitter_account != ""}
								<a href="https://twitter.com/{$item.twitter_account|escape:'html'}" target="_blank">https://twitter.com/{$item.twitter_account|escape:'html'}</a></td>
							{/if}
							<td style="white-space:nowrap;">{$array_attribute[$item.attribute]}</td>
							<td>{$item.study|escape:'html'}</td>
							<td>{$item.contribute|escape:'html'}</td>
							<td>{$item.most_area|escape:'html'}</td>
							<td>{$item.enthusiasm|escape:'html'}</td>
							<td>{$item.qualification|escape:'html'}</td>
                            <td>{$item.community|escape:'html'}</td>
							<td>{$item.created_at|escape:'html'}</td>
{*                            <td><a href="/record/picture/{$item.id|escape:'html'}/">{if $item.picture_file != ''}<button class="btn btn-primary">画像更新</button>{else}<button class="btn btn-success">画像登録</button>{/if}</a></td>*}
{*                            <td><a href="/record/vrm/{$item.id|escape:'html'}/">{if $item.vrm_file != ''}<button class="btn btn-primary">VRM更新</button>{else}<button class="btn btn-success">VRM登録</button>{/if}</a></td>*}
{*                            <td>{$item.popup_url}</td>*}

                        </tr>
                    {/foreach}
                    </tbody>
                </table>
            </div>
            <nav>
                <ul class="pagination pagination-sm">
                    {$page_link}
                </ul>
            </nav>
        </div>
    </div>
{/block}
