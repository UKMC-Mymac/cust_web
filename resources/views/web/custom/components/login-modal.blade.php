<div id="login-form" class="popup-login-register mfp-hide">
	<div class="th-login-form">
		<h3 class="box-title mb-30">{{ __('auth_login_title') }}</h3>
		<form action="{{ url('/admin/login') }}" method="POST">
			@csrf
			<div class="row">
				<div class="form-group col-12">
					<label>{{ __('field_email') }}</label>
					<input
						type="email"
						class="form-control @error('email') is-invalid @enderror"
						name="email"
						value="{{ old('email') }}"
						required
						autofocus
					/>
					@error('email')
						<small class="text-danger d-block mt-1">{{ $message }}</small>
					@enderror
				</div>
				<div class="form-group col-12">
					<label>{{ __('field_password') }}</label>
					<input
						type="password"
						class="form-control @error('password') is-invalid @enderror"
						name="password"
						required
					/>
					@error('password')
						<small class="text-danger d-block mt-1">{{ $message }}</small>
					@enderror
				</div>
				<div class="form-group col-12">
					<div class="form-check">
						<input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
						<label class="form-check-label" for="remember">
							{{ __('field_remember') }}
						</label>
					</div>
				</div>
				<div class="form-btn mb-20 col-12">
					<button type="submit" class="th-btn btn-fw th-radius2">{{ __('field_login') }}</button>
				</div>
			</div>
		</form>
	</div>
</div>