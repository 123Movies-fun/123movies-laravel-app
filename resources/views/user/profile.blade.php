@extends('layouts.app')

@section('title', '123Movies.io Clone')

@section('content')

<div id="main" class="">
    <div class="container">
        <div class="pad"></div>
        <div class="main-content main-detail">
            <div id="bread">
                <ol class="breadcrumb">
                    <li><a href="/">Home</a>
                    </li>
                    <li>User</li>
                    <li class="active">Profile</li>
                </ol>
            </div>
            <div class="profiles-wrap">
                <div class="sidebar">
                    <div class="sidebar-menu">
                        <div class="sb-title"><i class="fa fa-navicon mr5"></i> Menu</div>
                        <ul>
                            <li class="active">
                                <a href="/user/profile"> <i class="fa fa-user mr5"></i> Profile </a>
                            </li>
                            <li class="">
                                <a href="/movies/favorites"> <i class="fa fa-heart mr5"></i> My movies </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="pp-main">
                    <div class="ppm-head">
                        <div class="ppmh-title"><i class="fa fa-user mr5"></i> Profile</div>
                    </div>
                    <div class="ppm-content user-content">
                       

                    <form action="/upload?_token={{ csrf_token() }}" method="post" class="avatar_dropzone">
                        <div class="dz-message" data-dz-message id="avatar_dropzone_message">
                            <div class="uct-avatar">
                                <img class="avatar" src="@php echo $user->Avatar() ? $user->Avatar() : '/images/default_avatar.jpg' @endphp" id="side_bar_my_avatar" style="cursor: pointer;">
                            </div>
                            <div style="background-color: white; border-radius: 25px; height: 40px; width: 40px; display: none;" id="side_bar_my_avatar_loading">
                                <i class="fa fa-spinner fa-spin" style='color: black; position: relative; top: 5px;'></i>
                            </div>
                        </div>
                        <div class="dz-preview dz-image-preview" id="preview-template">
                          <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                          <div class="dz-success-mark"></div>
                          <div class="dz-error-mark"></div>
                        </div>
                    </form>

                    <script type="text/javascript">
                    $(function(){
                        $(".avatar_dropzone").each(function() {
                            $(this).dropzone({
                                maxFilesize: 5,
                                dictResponseError: 'Server not Configured',
                                acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg",
                                addRemoveLinks: false, 
                                previewTemplate: document.getElementById('preview-template').innerHTML,
                                success: function(file, response){
                                    $("#side_bar_my_avatar").load( response.location, function() {
                                        $("#side_bar_my_avatar, .my_avatar").attr("src", response.location)
                                        setTimeout(function() {
                                            $("#side_bar_my_avatar_loading").hide();
                                            $("#side_bar_my_avatar").show();
                                        }, 200);
                                    });
                                },
                                init:function(){
                                  var self = this;
                                  // config
                                  self.options.addRemoveLinks = false;
                                  self.options.dictRemoveFile = "Delete";
                                  //New file added
                                  self.on("addedfile", function (file) {
                                    $("#side_bar_my_avatar_loading").show();
                                    $("#side_bar_my_avatar").hide();
                                    console.log('new file added ', file);
                                  });
                                  // Send file starts
                                  self.on("sending", function (file) {
                                    console.log('upload started', file);
                                    $('.meter').show();
                                  });
                                  
                                  // File upload Progress
                                  self.on("totaluploadprogress", function (progress) {
                                    console.log("progress ", progress);
                                    $('.roller').width(progress + '%');
                                  });


                                  self.on("queuecomplete", function (progress) {

                                    $('.meter').delay(999).slideUp(999);
                                  });
                                  
                                  // On removing file
                                  self.on("removedfile", function (file) {
                                    console.log(file);
                                  });
                                }
                            });

                        });
                    })
                    </script>
                    <div id="#dropzoneerror"></div>

                        <div class="uct-info" id="edit_pre_div">
                            <div class="block">
                                <label>Username:</label> {{\Auth::user()->name}}
                            </div>
                            <div class="block">
                                <label>Email:</label> {{\Auth::user()->email}} 
                            </div>
                            <div class="block">
                                <label>Password:</label> ********
                            </div>
                            <div class="mt20"> 
                                <a href="javascript: void(0);" class="btn btn-successful" id="edit_acct">Edit account info</a>
                            </div>
                            <script type="text/javascript">
                                $("#edit_acct").click(function() {

                                    $("#edit_pre_div").fadeOut("fast", function() {
                                        $("#edit_info").fadeIn("fast");
                                    });
                                });
                            </script>


                        </div>

                        <div id="edit_info" class="uct-info" style="display: none;">
                            <form>
                                <div class="block">
                                    <label>Username</label>
                                    <input type="text" class="form-control" value="{{\Auth::user()->name}}">
                                </div>
                                <div class="block">
                                    <label>Email</label>
                                    <input type="text" class="form-control" value="{{\Auth::user()->email}}">
                                </div>
 
                                <div class="block">

                                    <h5 style="margin-top: 10px; border-bottom: 1px solid #ededed; padding-bottom: 6px;">Change Password (optional)</h5>

                                    <input type="text" class="form-control" placeholder="Enter your new password">
                                </div>
                                <div class="block" style="margin-top: 10px;">
                                    <input type="text" class="form-control" placeholder="Confirm your new password">
                                </div>
                                <div class="block pull-right" style="margin-top: 10px;">
                                    <a href="javascript: void(0);" class="btn btn-successful" id="submit_edit_acct">Update</a>
                                </div>
                            </form>
                        </div>

                            <script type="text/javascript">
                                $("#submit_edit_acct").click(function() {
                                    var that = this;
                                    $(this).html("<i class='fa fa-spinner fa-spin'></i> Loading");
                                    $.ajax({
                                        url: "/user/udate",
                                        type: "post",
                                        success: function(data) {

                                            $(that).html("<i class='fa fa-check'> Success");
                                            setTimeout(function() {
                                                $(that).html("Update");
                                                $("#edit_pre_div").fadeOut("fast", function() {
                                                    $("#edit_info").fadeIn("fast");
                                                });
                                            }, 500);



                                        }
                                    })
                                });
                            </script>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
@endsection