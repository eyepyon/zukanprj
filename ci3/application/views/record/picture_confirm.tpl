{* Extend our master template *}
{extends file="master.tpl"}

{* This block is defined in the master.tpl template *}
{block name=title}アップロード確認{/block}

{block name=header}
    {include file="navi_header.tpl"}
{/block}
{block name=side}
    {include file="navi_side.tpl"}
{/block}

{block name=body}
    <!-- Page Content -->

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">アップロード確認</h1>

    <div class="text-center">
        <img src="/files/{$file_name}"/><br />

        <p class="lead text-gray-800 mb-5">こちらをアップします。よろしいですか？</p>

        {form_open("/record/picture_action/$record_id")}
        <input type="hidden" name="file_name" value="{$file_name}"/>
        <br/>
        <input type="submit" value="アップロード" class="btn btn-lg btn-primary btn-block"/>
        {form_close()}

    </div>

{/block}
