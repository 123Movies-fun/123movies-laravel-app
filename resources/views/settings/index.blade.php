@extends('layouts.app')

@section('content')
<div class="container-fluid full-width-container about">
	<!-- Title -->
	<h1 class="section-title" id="services">
		<span><i class="fa fa-gear"></i> Account Settings</span>
	</h1><!-- End Title -->

	<div class="page-content profile-edit section-custom">
		<div class="pmd-card pmd-z-depth">
			<div class="pmd-card-body">
				<div class="row">
					<div data-provides="fileinput" class="fileinput fileinput-new col-lg-3">
						<div data-trigger="fileinput" class="fileinput-preview thumbnail img-circle img-responsive" style="line-height: 136px;">
							<img src="{{$user->avatar()}}" class="my_avatar">
						</div>
						<div class="action-button"> 
							<span class="btn btn-default btn-raised btn-file ripple-effect">
								
								<span class="fileinput-exists"><i class="material-icons md-light pmd-xs">mode_edit</i></span>
								
								<form action="/upload?_token={{ csrf_token() }}" method="post" class="avatar_dropzone">
									<div class="dz-message" data-dz-message class="my_avatar">
										<span class="fileinput-new"><i class="material-icons md-light pmd-xs">add</i></span>
										<div style="background-color: white; border-radius: 25px; height: 40px; width: 40px; display: none;" class="my_avatar_loading">
											<i class="fa fa-spinner fa-spin" style='color: black; position: relative; top: 5px;'></i>
										</div>
									</div>
									<div class="dz-preview dz-image-preview" id="preview-template">
									  <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
									  <div class="dz-success-mark"></div>
									  <div class="dz-error-mark"></div>
									</div>
								</form>

							</span> 
							<a data-dismiss="fileinput" class="btn btn-default btn-raised btn-file ripple-effect fileinput-exists" href="javascript:void(0);"><i class="material-icons md-light pmd-xs">close</i></a>
						</div>
					</div>
					
					<div class="col-lg-9 custom-col-9">
						<h3 class="heading">Personal Information</h3>
						<div class="row">
							<form class="form-horizontal" id="settings_email_form">
							  <fieldset>
									<div class="form-group prousername pmd-textfield">
									  <label class="control-label col-sm-3">Username</label>
									  <div class="col-sm-9">
										<p class="form-control-static"><strong>{{$user->name}}</strong></p>
									  </div>
									</div>
									<div class="form-group pmd-textfield pmd-textfield-floating-label-completed">
									  <label class="col-sm-3 control-label" for="u_fname">Email</label>
									  <div class="col-sm-9">
										  <input class="form-control empty" value="{{$user->email}}" id="inputEmail" placeholder="" type="email"><span class="pmd-textfield-focused"></span>
									  </div>
									</div>
									<div class="form-group btns margin-bot-30">
									  <div class="col-sm-9 col-sm-offset-3">
										<button type="submit" class="btn btn-primary pmd-ripple-effect" id="settings_email_update_btn">Update</button>
									  </div>
									</div>
							  </fieldset>
							</form>
						</div>
						<h3 class="heading">Change Password</h3>
						<div class="row">	
							<form class="form-horizontal" id="settings_password_form">
							  <fieldset>
								<div class="form-group pmd-textfield pmd-textfield-floating-label-completed">
									<label class="control-label col-sm-3" for="u_password">Current Password</label>
									<div class="col-sm-9">
										<input class="form-control empty" name="current_password" id="current_password" value="" type="password"><span class="pmd-textfield-focused"></span>
									</div>
								</div>
								<div class="form-group pmd-textfield pmd-textfield-floating-label-completed">
									<label class="control-label col-sm-3" for="u_password">New Password</label>
									<div class="col-sm-9">
										<input class="form-control empty" id="new_password" name="new_password" value="" type="password"><span class="pmd-textfield-focused"></span>
									</div>
								</div>
								<div class="form-group pmd-textfield">
									<label class="control-label col-sm-3" for="u_password"></label>
									<div class="col-sm-9">
										<input class="form-control empty" id="" value="" name="confirm_password" id="confirm_password" type="password"><span class="pmd-textfield-focused"></span>
										<span class="help-text">Repeat password</span>
									</div>
								</div>
								<div class="form-group btns">
								  <div class="col-sm-9 col-sm-offset-3">
									<button type="submit" class="btn btn-primary pmd-ripple-effect" id="settings_password_update_btn">Update</button>
								  </div>
								</div>
							  </fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="#dropzoneerror"></div>

<script type="text/javascript">
	$("#settings_email_form").submit(function() {
		var theBtn = $(this).find("#settings_email_update_btn");
		theBtn.html("<i class='fa fa-spin fa-spinner'></i> Loading").attr("disabled", true).addClass("disabled");
		$.ajax({
			url: "/settings/email",
			type: "POST",
			data: { "email": $("#inputEmail").val() },
			success: function(res) {
				if(res.errors) {
					notyError(res.errors[0]);
				} else {
					theBtn.html("Success!").removeAttr("disabled").removeClass("disabled").addClass("btn-success").removeClass("btn-primary");
				}
				setTimeout(function() {	
					theBtn.html("Update").removeAttr("disabled").removeClass("disabled").removeClass("btn-success").addClass("btn-primary");
				}, 1000);
			}
		})
		return false;
	});


	$("#settings_password_form").submit(function() {
		var theBtn = $(this).find("#settings_password_update_btn");
		theBtn.html("<i class='fa fa-spin fa-spinner'></i> Loading").attr("disabled", true).addClass("disabled");
		$.ajax({
			url: "/settings/password",
			type: "POST",
			data: $(this).serialize(),
			success: function(res) {
				if(res.errors) {
					notyError(res.errors[0]);
				} else {
					theBtn.html("Success!").removeAttr("disabled").removeClass("disabled").addClass("btn-success").removeClass("btn-primary");
				}
				setTimeout(function() {
					$("#settings_password_form input").val("");
					theBtn.html("Update").removeAttr("disabled").removeClass("disabled").removeClass("btn-success").addClass("btn-primary");
				}, 1000);
			}
		})
		return false;
	});
</script>
@endsection