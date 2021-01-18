{* Extend our master template *}
{extends file="master.tpl"}

{* This block is defined in the master.tpl template *}
{block name=title}
    利用者管理
{/block}

{block name=header}
    {include file="navi_header.tpl"}
{/block}
{block name=side}
    {include file="navi_side.tpl"}
{/block}

{block name=body}
    <!-- Page Content -->
    <div id="page-wrapper">
        <br/>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        利用者一覧
                    </div>
                </div>
            </div>

            <div class="col-lg-12">

                <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">検索条件（結果閲覧）
                                    ▼</a>
                            </h4>
                        </div>
                        {if $form_admin_name!=""||$form_admin_login!=""||$account_status!=""}
                        <div id="collapseOne" class="panel-collapse collapse in">
                            {else}
                            <div id="collapseOne" class="panel-collapse collapse">
                                {/if}
                                <div class="panel-body">
                                    {if $page>=1}
                                        {form_open(sprintf('user/page/%s/',$page))}
                                    {else}
                                        {form_open('user/')}
                                    {/if}
                                    ログインID：<input name="form_admin_login" type="text" value="{$form_admin_login|escape:'html'}"/><br/>
                                    <br/>
                                    名前：<input name="form_admin_name" type="text" value="{$form_admin_name|escape:'html'}" /><br/>
                                    <br/>
                                    アカウント状態：{form_dropdown('account_status', $wi2_account_status_array,$account_status)}
                                    <br/>
                                    <br/>

                                    <button type="submit" class="btn btn-primary btn-lg">検索</button>

                                    {form_close()}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <a href="/user/edit/">
                            <button type="button" class="btn btn-default">＋ 新規登録</button>
                        </a>
                    </div>
                    <br/>
                    <br/>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        {form_open('user/')}
                        {form_dropdown('page_limit', $site_page_limit_array,$page_limit)}
                        {*{form_hidden('isp_code',$isp_code)}*}
                        {*{form_hidden('id_status',$id_status)}*}
                        {*{form_hidden('rs_date',$rs_date)}*}
                        {*{form_hidden('re_date',$re_date)}*}
                        <button type="submit" class="btn btn-primary">表示</button>
                        {form_close()}
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>ログインID</th>
                                    <th>名前</th>
                                    {*<th>ユーザー<br/>管理権限</th>*}
                                    <th>有効・無効</th>
                                    <th>登録日時</th>
                                    <th>更新日時</th>

                                    <th>編集</th>
                                </tr>
                                </thead>
                                <tbody>
                                {foreach from=$list item=item}
                                    <tr>
                                        <td>{$item.admin_id}</td>
                                        <td>
                                            {$item.admin_login|escape:'html'}
                                        </td>
                                        <td>
                                            {$item.admin_name|escape:'html'}
                                        </td>
                                        {*<td class="center">*}
                                        {*{if $item.account_type == 1}<i class="fa fa-check"></i>{else}-{/if}*}
                                        {*</td>*}
                                        <td class="center">
                                            {if $item.account_status == 1}有効{else}無効{/if}
                                        </td>
                                        <td>
                                            {$item.regist_datetime|escape:'html'}
                                        </td>
                                        <td>
                                            {$item.update_datetime|escape:'html'}
                                        </td>
                                        <td class="center">
                                            <a href="/user/edit/{$item.admin_id}/">
                                                {if $button_on}
                                                    <button type="button" class="btn btn-outline btn-danger">編集</button>
                                                {else}
                                                    編集
                                                {/if}
                                            </a>
                                        </td>
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
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
    </div>
{/block}
