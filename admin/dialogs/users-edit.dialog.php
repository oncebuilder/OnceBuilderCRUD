<?php
/*
 * Version: 1.0, 31.05.2012
 * by Adam Wysocki, goldpaid777@gmail.com
 *
 * Copyright (c) 2012 Adam Wysocki
 *
 *	This is core connector class
 *
*/

# SET DATA -------------------
$once->set_data(array(
	"id" => intval($_GET['id'])
));

# GET DATA -------------------
$data=$once->once_select_item('users');

# GET DATA -------------------
$types=$once->type_get('users');
foreach($types['items'] as $key => $val){
	$types_a[$types['items'][$key]['id']]=$types['items'][$key]['name'];
}

# GET DATA -------------------
$informations=$once->get_user_informations();

# GET DATA -------------------
$socials=$once->get_user_socials();

if(!isset($_GET['nomodal'])){
echo '
<div id="user-data" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-id="'.$_GET['id'].'">';
}
?>
	<div class="container">
		<div class="modal-dialog" style="width: 100%;">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><i class="fa fa-files-o"></i> Edit user
						<button class="btn btn-default btn-sm pull-right item-delete" style="margin-right: 30px;" type="button"><i class="fa fa-trash-o"></i> Delete</button>
					</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<!-- Tabs -->
							<ul class="nav nav-tabs">
								<li role="presentation" class="active"><a href="#edit_profile" aria-controls="edit_profile" role="tab" data-toggle="tab">Account profile</a></li>
								<li role="presentation"><a href="#edit_contact" aria-controls="edit_contact" role="tab" data-toggle="tab">Contact information</a></li>
								<li role="presentation"><a href="#edit_social" aria-controls="edit_social" role="tab" data-toggle="tab">Social information</a></li>
							</ul>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="tab-content">
								<div class="tab-pane active" id="edit_profile">
									<div class="row margin">
										<div class="col-md-12">
											<form id="editForm" action="ajax.php?c=users&o=item_edit&id=<?php echo $_GET['id'];?>" method="post">
												<div class="row">
													<div class="col-md-9">
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label for="login">Login</label>
																	<input type="text" value="<?php echo $data['item']['login'];?>" class="form-control" name="login" placeholder="Enter login">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="password">Password</label>
																	<input type="text" value="" class="form-control" name="password" placeholder="Enter password">
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label for="username">Username</label>
																	<input type="text" value="<?php echo $data['item']['username'];?>" class="form-control" name="username" placeholder="Enter username">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="type_id">Type</label>
																	<select class="form-control" name="type_id">
																		<option value="-1" <?php echo ($data['item']['type_id']==-1?'selected':'');?>>Not actived</option>
																		<option value="-2" <?php echo ($data['item']['type_id']==-2?'selected':'');?>>Banned</option>
																		<option value="0" <?php echo ($data['item']['type_id']==0?'selected':'');?>>User</option>
																		<?php
																			if($types['items']){
																				foreach($types['items'] as $key => $val){
																					echo '<option value="'.$types['items'][$key]['id'].'" '.($types['items'][$key]['id']==$data['item']['type_id']?'selected':'').'>'.$types['items'][$key]['name'].'</option>';
																				}
																			}
																			if(!isset($types_a[$data['item']['type_id']])){
																				if($data['item']['type_id']!=-1 && $data['item']['type_id']!=-2 && $data['item']['type_id']!=0){
																					echo '<option value="'.$data['item']['type_id'].'" selected>Unknown</option>';
																				}
																			}
																		?>
																	</select>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label for="email">E-mail</label>
																	<input type="text" value="<?php echo $data['item']['email'];?>" class="form-control" name="email" placeholder="Enter email">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="referer">Referer ID</label>
																	<input type="text" value="<?php echo $data['item']['referer_id'];?>" class="form-control" name="referer_id" placeholder="Enter referer ID">
																</div>
															</div>
														</div>
													</div>
													<div class="col-md-3">
														<div class="row">
															<div class="col-md-12">
																<label for="title">Photo</label>
															</div>
														</div>
														<div class="row">
															<div class="col-md-12">
																<div class="thumbnail">
																	<div class="caption">
																		<h4>Edit photo</h4>
																		<p>&nbsp;</p>
																		<p>
																			<a href="#" class="label label-default item-photo" title="Change photo">Change photo</a>
																		</p>
																	</div>
																	<img id="item-photo" src="/uploads/<?php echo $_GET['id'];?>/photo.png?<?php echo time();?>" onerror="this.src='img/photo.png'">
																</div>
															</div>
														</div>
													</div>
												</div>
												<input type="submit" class="hidden">
											</form>
										</div>
									</div>
								</div>
								<div class="tab-pane" id="edit_contact">
									<div class="row margin">
										<form id="informationForm" method="post">
											<div class="col-md-6">
												<div class="form-group">
													<label for="firstname">First name</label>
													<input id="firstname" class="form-control" type="text" value="<?php echo $informations['item']['firstname'];?>" name="firstname" tabindex="1" placeholder="First name">
												</div>
												<div class="form-group">
													<label for="email">E-mail</label>
													<input id="email" class="form-control" type="text" value="<?php echo $informations['item']['email'];?>" name="email" tabindex="3" placeholder="E-mail">
												</div>
												<div class="form-group">
													<label for="company">Company name</label>
													<input id="company" class="form-control" type="text" value="<?php echo $informations['item']['company'];?>" name="company" tabindex="5" placeholder="Company name">
												</div>
												<div class="form-group">
													<label for="address2">Address 2</label>
													<input id="address2" class="form-control" type="text" value="<?php echo $informations['item']['address2'];?>" name="address2" tabindex="7" placeholder="Address 2">
												</div>
												<div class="form-group">
													<label for="phone">Phone</label>
													<input id="phone" class="form-control" type="text" value="<?php echo $informations['item']['phone'];?>" name="phone" tabindex="9" placeholder="Phone">
												</div>
												<div class="form-group">
													<label for="province">State / province</label>
													<input id="province" class="form-control" type="text" value="<?php echo $informations['item']['province'];?>" name="province" tabindex="11" placeholder="State / province">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="lastname">Last name</label>
													<input id="lastname" class="form-control" type="text" value="<?php echo $informations['item']['lastname'];?>" name="lastname" tabindex="2" placeholder="Last name">
												</div>
												<div class="form-group">
													<label for="website">Website url</label>
													<input id="website" class="form-control" type="text" value="<?php echo $informations['item']['website'];?>" name="website" tabindex="4" placeholder="Website url">
												</div>
												<div class="form-group">
													<label for="address">Address</label>
													<input id="address" class="form-control" type="text" value="<?php echo $informations['item']['address'];?>" name="address" tabindex="6" placeholder="Address">
												</div>
												<div class="form-group">
													<label for="city">City</label>
														<input id="city" class="form-control" type="text" value="<?php echo $informations['item']['city'];?>" name="city" tabindex="8" placeholder="City">
												</div>
												<div class="form-group">
													<label for="zip">Zip / postal code</label>
													<input id="zip" class="form-control" type="text" value="<?php echo $informations['item']['zip'];?>" name="zip" tabindex="10" placeholder="Zip / postal code">
												</div>
												<div class="form-group">
													<label for="country">Country</label>
													<input id="country" class="form-control" type="text" value="<?php echo $informations['item']['country'];?>" name="country" tabindex="12" placeholder="Country">
												</div>
											</div>
											<input type="submit" class="hidden">
										</form>
									</div>
								</div>
								<div class="tab-pane" id="edit_social">
									<div class="row margin">
										<form id="socialForm" method="post">
											<div class="col-md-12">
												<div class="form-group">
													<label for="facebook">Facebook</label>
													<input id="facebook" class="form-control" type="text" value="<?php echo $socials['item']['facebook'];?>" name="facebook" tabindex="1" placeholder="Facebook">
												</div>
												<div class="form-group">
													<label for="twitter">Twitter</label>
													<input id="twitter" class="form-control" type="text" value="<?php echo $socials['item']['twitter'];?>" name="twitter" tabindex="3" placeholder="Twitter">
												</div>
												<div class="form-group">
													<label for="youtube">Youtube</label>
													<input id="youtube" class="form-control" type="text" value="<?php echo $socials['item']['youtube'];?>" name="youtube" tabindex="3" placeholder="Youtube">
												</div>
												<div class="form-group">
													<label for="linkedin">Linkedin</label>
													<input id="linkedin" class="form-control" type="text" value="<?php echo $socials['item']['linkedin'];?>" name="linkedin" tabindex="5" placeholder="Linkedin">
												</div>
												<div class="form-group">
													<label for="dribbble">Dribbble</label>
													<input id="dribbble" class="form-control" type="text" value="<?php echo $socials['item']['dribbble'];?>" name="dribbble" tabindex="7" placeholder="Dribbble">
												</div>
												<div class="form-group">
													<label for="github">GitHub</label>
													<input id="github" class="form-control" type="text" value="<?php echo $socials['item']['github'];?>" name="github" tabindex="9" placeholder="GitHub">
												</div>
												<div class="form-group">
													<label for="google">Google+</label>
													<input id="google" class="form-control" type="text" value="<?php echo $socials['item']['google'];?>" name="google" tabindex="11" placeholder="Google+">
												</div>
												<div class="form-group">
													<label for="behance">Behance</label>
													<input id="behance" class="form-control" type="text" value="<?php echo $socials['item']['behance'];?>" name="behance" tabindex="11" placeholder="Behance">
												</div>
												<div class="form-group">
													<label for="codepen">CodePen</label>
													<input id="codepen" class="form-control" type="text" value="<?php echo $socials['item']['codepen'];?>" name="codepen" tabindex="11" placeholder="CodePen">
												</div>
											</div>
											<input type="submit" class="hidden">
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer clearfix">
					<button class="btn btn-primary pull-left item-save" type="submit"><i class="fa fa-check"></i> Save</button>
					<button type="button" class="btn btn-danger item-close" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
				</div>
			</div><!-- /.modal-content -->
		</div>
	</div><!-- /.modal -->
<?php
if(!isset($_GET['nomodal'])){
	echo '
	</div>';
}
?>
<script type="text/javascript">
	$(document).ready(function () {
		// Initialize actions
		once.users.actions.editInit($(this));
	});
</script>