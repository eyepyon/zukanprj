{* Extend our master template *}
{extends file="master.tpl"}

{* This block is defined in the master.tpl template *}
{block name=title}ログアウト{/block}

{block name=side}
{include file="navi_side.tpl"}
{/block}
{block name=header}
{include file="navi_header.tpl"}
{/block}

{block name=bodytag} id="page-top" {/block}

{block name=body}

	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800">ログアウト</h1>

	<div class="text-center">
		<p class="lead text-gray-800 mb-5">ログアウトしますか？</p>
		<a href="/logout/bye/" class="btn btn-warning btn-lg">ログアウト</a>
	</div>

{/block}
