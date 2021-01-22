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
{if $id > 0 && $record.picture_file != ''}
    background: url("https://dev.zukan.cloud/files/{$record.picture_file}{$salt_wd}");
{else}
    background: url("https://dev.zukan.cloud/img/pic1.jpg{$salt_wd}");
{/if}
    background-position: center;
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
                            図鑑名
                            <p>{$record.name|escape:'html'}</p>
                        </div>

                        <div class="form-group">
                            図鑑詳細
                            <p>{$record.record_detail|nl2br}</p>
                        </div>

                        {*<div class="form-group row">*}
                            {*<div class="col-sm-6 mb-3 mb-sm-0">*}
                                {*受付開始日*}
                                {*<p>{$record.start_date|escape:'html'}</p>*}
                            {*</div>*}
                            {*<div class="col-sm-6">*}
                                {*受付終了日*}
                                {*<p>{$record.end_date|escape:'html'}</p>*}
                            {*</div>*}
                        {*</div>*}

                        {*<div class="form-group">*}
                            {*実行可能額*}
                            {*<p>{$record.amount|escape:'html'}xem / 1回</p>*}
                        {*</div>*}

                        <hr/>

                        <div class="form-group">
                            <h5>Balance: {$walletData.account.balance/1000000|string_format:'%.6f'}Xem</h5>
                            <p>QR;<br />
                                <img src="https://api.qrserver.com/v1/create-qr-code/?data={$wallet_json}&size=300x300" alt="QRコード" />
                            </p>
                            <p>CODE:<br />
                                {$wallet_address}
                            </p>
                            <p>
                                <a href="http://explorer.nemchina.com//#/s_account?account={$wallet_address}" target="_blank">エクスプローラー</a>
                            </p>
                        </div>

                        <hr/>

                        {if $record.user_id == $user_id}
                        <a href="/record/edit/{$id}/" class="btn btn-primary btn-user btn-block">
                            <i class="fas fa-fw fa-cog"></i> 情報更新
                        </a>
                        <br/>
                        {if $record.picture_file != ""}
                        <a href="/record/picture/{$id}/" class="btn btn-primary btn-user btn-block">
                            <i class="fas fa-camera fa-fw"></i> 画像更新
                        </a>
                            {else}
                            <a href="/record/picture/{$id}/" class="btn btn-success btn-user btn-block">
                                <i class="fas fa-camera fa-fw"></i> 画像追加
                            </a>
                        {/if}
                        <br/>
                        {if $record.vrm_file != ""}
                        <a href="/record/vrm/{$id}/" class="btn btn-primary btn-user btn-block">
                            <i class="fas fa-map fa-fw"></i> VRMファイル更新
                        </a>
                        {else}
                            <a href="/record/vrm/{$id}/" class="btn btn-success btn-user btn-block">
                                <i class="fas fa-map fa-fw"></i> VRMファイル追加
                            </a>
                        {/if}
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
                            <a href='http://explorer.nemchina.com//#/s_tx?hash={$item.tx_hash}' target="_blank">{$item.tx_hash}</a>
                        {/if}
                    </td>
                    <td>{$item.amount}</td>
                </tr>
            {/foreach}
        </table>
    {/if}



{/block}
