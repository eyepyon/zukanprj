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
    <h1 class="h3 mb-4 text-gray-800">図鑑</h1>

    <div class="text-center">
        <p class="lead text-gray-800 mb-5">登録が完了しました</p>
        <a href="/record/" class="btn btn-primary btn-lg">図鑑一覧</a>
    </div>


{/block}
