{* Extend our master template *}
{extends file="master.tpl"}

{* This block is defined in the master.tpl template *}
{block name=title}
ログイン
{/block}

{block name=header}
{/block}
{block name=side}
{/block}

{block name=bodytag} class="bg-gradient-primary" {/block}

{block name=body}
<div class="container">

	<!-- Outer Row -->
	<div class="row justify-content-center">

		<div class="col-xl-10 col-lg-12 col-md-9">

			<div class="card o-hidden border-0 shadow-lg my-5">
				<div class="card-body p-0">
					<!-- Nested Row within Card Body -->
					<div class="row">
						<div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
						<div class="col-lg-6">
							<div class="p-5">
								<div class="text-center">
									<h1 class="h4 text-gray-900 mb-4">ShukinPAY</h1>
								</div>
									<a href="{$login_url}" class="btn btn-facebook btn-user btn-block">
										<i class="fab fa-facebook fa-fw"></i> Login with Facebook
									</a>
								<hr />
								<div class="text-center">
									<a class="small" href="/info/kiyaku/">Terms of Use</a>
								</div>
								<div class="text-center">
									<a class="small" href="/info/privacy/">Privacy Policy</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>

	</div>


</div>
{/block}
