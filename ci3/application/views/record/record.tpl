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
            {form_dropdown('page_limit', $page_limit_array,$page_limit)}
            {form_hidden('record_name',$record_name)}
            <button type="submit" class="btn btn-primary">表示</button>
            {form_close()}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>登録日時</th>
                        <th>画像</th>
                        <th>VRM</th>
                        <th>QR</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach from=$list item=item}
                        <tr>
                        {if $item.lat != ''}
                            <td rowspan="2">{$item.record_id|escape:'html'}</td>
                        {else}
                            <td>{$item.record_id|escape:'html'}</td>
                        {/if}
                            <td><a href="/record/detail/{$item.record_id|escape:'html'}/">{$item.record_name|escape:'html'}</a></td>
                            <td>{$item.regist_datetime|escape:'html'}</td>
                            <td><a href="/record/picture/{$item.record_id|escape:'html'}/">{if $item.picture_file != ''}<button class="btn btn-primary">画像更新</button>{else}<button class="btn btn-success">画像登録</button>{/if}</a></td>
                            <td><a href="/record/vrm/{$item.record_id|escape:'html'}/">{if $item.vrm_file != ''}<button class="btn btn-primary">VRM更新</button>{else}<button class="btn btn-success">VRM登録</button>{/if}</a></td>
                            <td>{$item.popup_url}</td>

                        </tr>
                        {if $item.lat != ''}
                        <tr>
                            <td colspan="4">
                                <iframe src="/record/vr/?lat={$item.lat|escape:'html'}&lng={$item.lng|escape:'html'}" width='740' height='120'></iframe>
                            </td>
                        </tr>
                        {/if}
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
