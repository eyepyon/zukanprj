{* Extend our master template *}
{extends file="master.tpl"}

{* This block is defined in the master.tpl template *}
{block name=title}ご利用ガイド{/block}

{block name=javascript}
{/block}

{block name=header}
<body>
{/block}

{block name=body}

<main>
    <setcion id="maintitle">
        <h2>ご利用ガイド</h2>
    </setcion>

    <section class="guidecol">
        <article>
            <h3>参加するには3つの方法があります</h3>
            <ol>
                <li>プロジェクトに参加し運用する。</li>
                <li>興味あるプロジェクトにサポートする</li>
            </ol>
        </article>
        <article>
            <h3>プロジェクトの運用方法</h3>
            プロジェクトとは？のメニューをご確認下さい。<br />
        </article>
        <article>
            <h3>プロジェクトのサポート方法</h3>
            プロジェクトに記載しましょう。<br />
            後からキャンセルできませんのでご注意ください。<br />
        </article>
        <article>
            <h3>サポート後の情報を受取る</h3>
            送られてきます。<br />
            取得可能になります。<br />
            自動的に生成されます。
        </article>
    </section>
    <!--/guidecol/-->

    {/block}



{block name=footer}
{/block}

