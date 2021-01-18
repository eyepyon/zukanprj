{* Extend our master template *}
{extends file="master.tpl"}

{* This block is defined in the master.tpl template *}
{block name=title}アップロード失敗{/block}

{block name=header}
    {include file="navi_header.tpl"}
{/block}
{block name=side}
    {include file="navi_side.tpl"}
{/block}

{block name=body}

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">アップロードエラー</h1>

    <div class="text-center">
        <p class="lead text-gray-800 mb-5">アップロードが失敗しました</p>
        <a href="/record/" class="btn btn-primary btn-lg">図鑑一覧</a>
    </div>

{/block}
