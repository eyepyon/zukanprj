{* Extend our master template *}
{extends file="master.tpl"}

{* This block is defined in the master.tpl template *}
{block name=title}図鑑プロジェクトって？{/block}

{block name=javascript}
{/block}

{block name=header}
<body>
{/block}

{block name=body}


<main>
    <setcion id="maintitle">
        <h2>図鑑プロジェクトとは？</h2>
    </setcion>

    <section class="guidecol">
        <article>
            <h3>図鑑プロジェクトはXXXのことです。</h3>
            <ol>
                <li>プロジェクトの情報をセットする。</li>
                <li>ファンディングをする。</li>
                <li>セットをする</li>
            </ol>
        </article>
        <article>
            <h3>設置情報</h3>
            <br />

        </article>
        <article>
            <h3>設置後対応</h3>
        </article>
        <article>
            <h3>情報登録について</h3>
        </article>
        <article>
            <h3>お問い合わせ</h3>

        </article>
    </section>


{/block}



{block name=footer}
{/block}

