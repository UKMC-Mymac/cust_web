
<div class="{{ $breadcrumbThemeClass ?? 'non-hero2' }}">
	<style>
		.non-hero2 .breadcumb-wrapper .breadcumb-content .breadcumb-title {
			color: var(--smoke-color);
		}
		.breadcumb-wrapper .breadcumb-content {
			padding: 110px 0 40px !important;
		}
		@media (min-width: 576px) {
			.breadcumb-wrapper .breadcumb-content {
				padding: 130px 0 50px !important;
			}
		}
		@media (min-width: 992px) {
			.breadcumb-wrapper .breadcumb-content {
				padding: 210px 0 70px !important;
			}
		}
		@media (min-width: 1200px) {
			.breadcumb-wrapper .breadcumb-content {
				padding: 220px 0 80px !important;
			}
		}
	</style>
	<div class="breadcumb-wrapper position-relative" data-bg-src="/dist/images/background/breadcumbg.png">
		<div class="container-fluid th-container4">
			<div class="row">
				<div class="col">
					<div class="breadcumb-content d-flex flex-column align-items-center">
						<h1 class="breadcumb-title">{{ \Illuminate\Support\Str::limit($title ?? 'Page', 90) }}</h1>
						<ul class="breadcumb-menu">
							<li><a href="{{ route('home') }}">Home</a></li>
							@foreach($breadcrumbs ?? [] as $breadcrumb)
								@if(!$loop->last)
									<li><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a></li>
								@else
									<li>{{ \Illuminate\Support\Str::limit($breadcrumb['label'], 90) }}</li>
								@endif
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>