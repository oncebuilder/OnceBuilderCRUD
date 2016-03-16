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

class once extends core{
	function bulk_action(){
		// used varibles
		$obj['errors'] =  array();
		$obj['error'] = 0 ;
				
		if($this->once_permission_check()){
			if($this->once_csrf_token_check($this->data['csrf_token'])){
				// Prepare statements to star selected id.
				$stmt1 = $this->pdo->prepare("UPDATE edit_users SET stars = 1 WHERE id=:id");
				
				// Prepare statements to unstar selected id.
				$stmt2 = $this->pdo->prepare("UPDATE edit_users SET stars = 0 WHERE id=:id");
				
				// Prepare statements to delete selected id.
				$stmt3 = $this->pdo->prepare("DELETE FROM edit_users WHERE id=:id");
					
				// Loop bulk items and make action
				foreach ($this->data['ids'] as $position => $item){
					$obj['pages'][]=$position;
					// Check action type then do it
					if($this->data['action']=='star'){
						$stmt1->bindParam(':id', $position, PDO::PARAM_INT);
						$stmt1->execute();
					}else if($this->data['action']=='unstar'){
						$stmt2->bindParam(':id', $position, PDO::PARAM_INT);
						$stmt2->execute();
					}else if($this->data['action']=='delete' && $position!=1){
						$stmt3->bindParam(':id', $position, PDO::PARAM_INT);
						$stmt3->execute();
					}
				}
				$obj['status']='ok';
			}else{
				$obj['errors'][]='CSFR token invalid!';
				$obj['error']++;
			}
		}else{
			$obj['errors'][]='You don\'t have permission!';
			$obj['error']++;
		}
		
		// Return depends on type
		if($this->data['ajax']){
			// Print JSON object
			echo json_encode($obj);
		}else{
			// Return JSON object
			return $obj;
		}
	}
	function set_limit(){
		// Update page limit with once
		$this->once_page_limit('users');
		$obj['status']='ok';
		
		// Return depends on type
		if($this->data['ajax']){
			// Print JSON object
			echo json_encode($obj);
		}else{
			// Return JSON object
			return $obj;
		}
	}
	function get_user_informations(){
		// Prepare statements to get user information.
		$stmt = $this->pdo->prepare("SELECT * FROM edit_users_informations WHERE user_id=:user_id LIMIT 1");
		$stmt->bindParam(':user_id', $this->data['id'], PDO::PARAM_STR, 50);
		$stmt->execute();

		$obj['item'] = $stmt->fetch(PDO::FETCH_ASSOC);

		// Check if snippet exist.
		if($obj['item']){
			return $obj;
		}else{
			return false;
		}
	}
	function get_user_socials(){
		// Prepare statements to get user information.
		$stmt = $this->pdo->prepare("SELECT * FROM edit_users_socials WHERE user_id=:user_id LIMIT 1");
		$stmt->bindParam(':user_id', $this->data['id'], PDO::PARAM_STR, 50);
		$stmt->execute();

		$obj['item'] = $stmt->fetch(PDO::FETCH_ASSOC);

		// Check if snippet exist.
		if($obj['item']){
			return $obj;
		}else{
			return false;
		}
	}
	

	function item_delete(){
		// used varibles
		$obj['errors'] =  array();
		$obj['error'] = 0 ;
				
		if($this->once_permission_check()){
			if($this->once_csrf_token_check($this->data['csrf_token'])){
				if($this->data['id']!=1){
					// Use once to delete item
					$obj=$this->once_delete_item('users');
					
					if($obj['result']){
						// Set status ok
						$obj['status']='ok';
					}
				}else{
					$obj['errors'][]='You can\'t delete creator!';
					$obj['error']++;
				}
			}else{
				$obj['errors'][]='CSFR token invalid!';
				$obj['error']++;
			}
		}else{
			$obj['errors'][]='You don\'t have permission!';
			$obj['error']++;
		}
		
		// Return depends on type
		if($this->data['ajax']){
			// Print JSON object
			echo json_encode($obj);
		}else{
			// Return JSON object
			return $obj;
		}
	}
	function item_edit(){
		// used varibles
		$obj['errors'] =  array();
		$obj['error'] = 0 ;
		
		if($this->once_permission_check()){
			if($this->once_csrf_token_check($this->data['csrf_token'])){
				// Check if user exist
				$stmt = $this->pdo->prepare("SELECT * FROM edit_users WHERE id=:id LIMIT 1");
				$stmt->bindParam(':id', $this->data['id'], PDO::PARAM_INT);
				$stmt->execute();
				
				// Get count of returned records
				$obj['count']=$stmt->rowCount();
				if($obj['count']){
					$obj['item']=$stmt->fetch(PDO::FETCH_ASSOC);

					if($this->data['password']!='')
					$sql="password=:password,";
					else $sql = '';
					
					$stmt = $this->pdo->prepare("UPDATE edit_users SET login=:login, $sql username=:username, type_id=:type_id, email=:email, referer_id=:referer_id WHERE id=:id LIMIT 1");
					$stmt->bindParam(':id', $this->data['id'], PDO::PARAM_INT);
					$stmt->bindParam(':login', $this->data['login'], PDO::PARAM_STR, 255);
					
					if($this->data['password']!='')
					$stmt->bindParam(':password', md5($this->data['password']), PDO::PARAM_STR, 32);
				
					$stmt->bindParam(':username', $this->data['username'], PDO::PARAM_STR, 16);
					$stmt->bindParam(':type_id', $this->data['type_id'], PDO::PARAM_INT);
					$stmt->bindParam(':email', $this->data['email'], PDO::PARAM_STR, 32);
					$stmt->bindParam(':referer_id', $this->data['referer_id'], PDO::PARAM_INT);
					$stmt->execute();
					
					if($stmt->rowCount()){
						// Set status ok
						$obj['status']='ok';
					}else{
						$obj['errors'][]='Cant save';
						$obj['error']++;
					}
				}else{
					$obj['errors'][]='user not exist';
					$obj['error']++;
				}
			}else{
				$obj['errors'][]='CSFR token invalid!';
				$obj['error']++;
			}
		}
		
		// Return depends on type
		if($this->data['ajax']){
			// Print JSON object
			echo json_encode($obj);
		}else{
			// Return JSON object
			return $obj;
		}
	}
	function item_edit_contact(){
		// used varibles
		$obj['errors'] =  array();
		$obj['error'] = 0 ;
				
		if($this->once_permission_check()){
			if($this->once_csrf_token_check($this->data['csrf_token'])){
				// Check if user exist
				$stmt = $this->pdo->prepare("SELECT * FROM edit_users WHERE id=:id LIMIT 1");
				$stmt->bindParam(':id', $this->data['id'], PDO::PARAM_INT);
				$stmt->execute();
				
				// Get count of returned records
				$obj['count']=$stmt->rowCount();
				if($obj['count']){
					$obj['item']=$stmt->fetch(PDO::FETCH_ASSOC);

					// Prepare statements to get user information.
					$stmt = $this->pdo->prepare("SELECT * FROM edit_users_informations WHERE user_id=:user_id LIMIT 1");
					$stmt->bindParam(':user_id', $this->data['id'], PDO::PARAM_INT);
					$stmt->execute();

					$obj['item'] = $stmt->fetch(PDO::FETCH_ASSOC);

					// Check if snippet exist.
					if($obj['item']){
						// Prepare statements to update user information.
						$stmt = $this->pdo->prepare("
							UPDATE edit_users_informations SET firstname=:firstname, lastname=:lastname, email=:email, website=:website, company=:company, address=:address, address2=:address2, city=:city, phone=:phone, zip=:zip, province=:province, country=:country
							WHERE user_id=:user_id LIMIT 1");
						
						$stmt->bindParam(':user_id', $this->data['id'], PDO::PARAM_INT);
						$stmt->bindParam(':firstname', $this->data['firstname'], PDO::PARAM_STR, 50);
						$stmt->bindParam(':lastname', $this->data['lastname'], PDO::PARAM_STR, 50);
						$stmt->bindParam(':email', $this->data['email'], PDO::PARAM_STR, 50);
						$stmt->bindParam(':website', $this->data['website'], PDO::PARAM_STR, 2000);
						$stmt->bindParam(':company', $this->data['company'], PDO::PARAM_STR, 100);
						$stmt->bindParam(':address', $this->data['address'], PDO::PARAM_STR, 100);
						$stmt->bindParam(':address2', $this->data['address2'], PDO::PARAM_STR, 100);
						$stmt->bindParam(':city', $this->data['city'], PDO::PARAM_STR, 100);
						$stmt->bindParam(':phone', $this->data['phone'], PDO::PARAM_STR, 15);
						$stmt->bindParam(':zip', $this->data['zip'], PDO::PARAM_STR, 10);
						$stmt->bindParam(':province', $this->data['province'], PDO::PARAM_STR, 100);
						$stmt->bindParam(':country', $this->data['country'], PDO::PARAM_STR, 100);
						$stmt->execute();
						
						if($stmt->rowCount()){
							// Set status ok
							$obj['status']='ok';
						}else{
							$obj['errors'][]='Cant save';
							$obj['error']++;
						}
					}else{
						// Prepare statements to insert user information.
						$stmt = $this->pdo->prepare("
							INSERT INTO edit_users_informations (id, user_id, firstname, lastname, email, website, company, address, address2, city, phone, zip, province, country) 
							VALUES ('', :user_id, :firstname, :lastname, :email, :website, :company, :address, :address2, :city, :phone, :zip, :province, :country)
						");
						
						$stmt->bindParam(':user_id', $this->data['id'], PDO::PARAM_INT);
						$stmt->bindParam(':firstname', $this->data['firstname'], PDO::PARAM_STR, 50);
						$stmt->bindParam(':lastname', $this->data['lastname'], PDO::PARAM_STR, 50);
						$stmt->bindParam(':email', $this->data['email'], PDO::PARAM_STR, 254);
						$stmt->bindParam(':website', $this->data['website'], PDO::PARAM_STR, 2000);
						$stmt->bindParam(':company', $this->data['company'], PDO::PARAM_STR, 100);
						$stmt->bindParam(':address', $this->data['address'], PDO::PARAM_STR, 100);
						$stmt->bindParam(':address2', $this->data['address2'], PDO::PARAM_STR, 100);
						$stmt->bindParam(':city', $this->data['city'], PDO::PARAM_STR, 100);
						$stmt->bindParam(':phone', $this->data['phone'], PDO::PARAM_STR, 15);
						$stmt->bindParam(':zip', $this->data['zip'], PDO::PARAM_STR, 10);
						$stmt->bindParam(':province', $this->data['province'], PDO::PARAM_STR, 100);
						$stmt->bindParam(':country', $this->data['country'], PDO::PARAM_STR, 100);
						$stmt->execute();
						
						if($stmt->rowCount()){
						// Set status ok
							$obj['status']='ok';
						}else{
							$obj['errors'][]='Cant insert';
							$obj['error']++;
						}
					}
				}else{
					$obj['errors'][]='user not exist';
					$obj['error']++;
				}
			}else{
				$obj['errors'][]='CSFR token invalid!';
				$obj['error']++;
			}
		}
		
		// Return depends on type
		if($this->data['ajax']){
			// Print JSON object
			echo json_encode($obj);
		}else{
			// Return JSON object
			return $obj;
		}
	}
	function item_edit_social(){
		// used varibles
		$obj['errors'] =  array();
		$obj['error'] = 0 ;
				
		if($this->once_permission_check()){
			if($this->once_csrf_token_check($this->data['csrf_token'])){
				// Check if user exist
				$stmt = $this->pdo->prepare("SELECT * FROM edit_users WHERE id=:id LIMIT 1");
				$stmt->bindParam(':id', $this->data['id'], PDO::PARAM_INT);
				$stmt->execute();
				
				// Get count of returned records
				$obj['count']=$stmt->rowCount();
				if($obj['count']){
					$obj['item']=$stmt->fetch(PDO::FETCH_ASSOC);

					// Prepare statements to get user information.
					$stmt = $this->pdo->prepare("SELECT * FROM edit_users_socials WHERE user_id=:user_id LIMIT 1");
					$stmt->bindParam(':user_id', $this->data['id'], PDO::PARAM_INT);
					$stmt->execute();

					$obj['item'] = $stmt->fetch(PDO::FETCH_ASSOC);

					// Check if snippet exist.
					if($obj['item']){
						// Prepare statements to update user socials.
						$stmt = $this->pdo->prepare("
							UPDATE edit_users_socials SET facebook=:facebook, twitter=:twitter, youtube=:youtube, linkedin=:linkedin, dribbble=:dribbble, github=:github, google=:google, behance=:behance, codepen=:codepen 
							WHERE user_id=:user_id LIMIT 1");
						
						$stmt->bindParam(':user_id', $this->data['id'], PDO::PARAM_INT);
						$stmt->bindParam(':facebook', $this->data['facebook'], PDO::PARAM_STR, 50);
						$stmt->bindParam(':twitter', $this->data['twitter'], PDO::PARAM_STR, 50);
						$stmt->bindParam(':youtube', $this->data['youtube'], PDO::PARAM_STR, 2000);
						$stmt->bindParam(':linkedin', $this->data['linkedin'], PDO::PARAM_STR, 100);
						$stmt->bindParam(':dribbble', $this->data['dribbble'], PDO::PARAM_STR, 100);
						$stmt->bindParam(':github', $this->data['github'], PDO::PARAM_STR, 100);
						$stmt->bindParam(':google', $this->data['google'], PDO::PARAM_STR, 100);
						$stmt->bindParam(':behance', $this->data['behance'], PDO::PARAM_STR, 100);
						$stmt->bindParam(':codepen', $this->data['codepen'], PDO::PARAM_STR, 100);
						$stmt->execute();
						
						if($stmt->rowCount()){
							// Set status ok
							$obj['status']='ok';
						}else{
							$obj['errors'][]='Cant save';
							$obj['error']++;
						}
					}else{
						// Prepare statements to insert user social.
						$stmt = $this->pdo->prepare("
							INSERT INTO edit_users_socials (id, user_id, facebook, twitter, youtube, linkedin, dribbble, github, google, behance, codepen) 
							VALUES ('', :user_id, :facebook, :twitter, :youtube, :linkedin, :dribbble, :github, :google, :behance, :codepen)
						");
						
						$stmt->bindParam(':user_id', $this->data['id'], PDO::PARAM_INT);
						$stmt->bindParam(':facebook', $this->data['facebook'], PDO::PARAM_STR, 50);
						$stmt->bindParam(':twitter', $this->data['twitter'], PDO::PARAM_STR, 50);
						$stmt->bindParam(':youtube', $this->data['youtube'], PDO::PARAM_STR, 2000);
						$stmt->bindParam(':linkedin', $this->data['linkedin'], PDO::PARAM_STR, 100);
						$stmt->bindParam(':dribbble', $this->data['dribbble'], PDO::PARAM_STR, 100);
						$stmt->bindParam(':github', $this->data['github'], PDO::PARAM_STR, 100);
						$stmt->bindParam(':google', $this->data['google'], PDO::PARAM_STR, 100);
						$stmt->bindParam(':behance', $this->data['behance'], PDO::PARAM_STR, 100);
						$stmt->bindParam(':codepen', $this->data['codepen'], PDO::PARAM_STR, 100);
						$stmt->execute();
						
						if($stmt->rowCount()){
						// Set status ok
							$obj['status']='ok';
						}else{
							$obj['errors'][]='Cant insert';
							$obj['error']++;
						}
					}
				}else{
					$obj['errors'][]='user not exist';
					$obj['error']++;
				}
			}else{
				$obj['errors'][]='CSFR token invalid!';
				$obj['error']++;
			}
		}
		
		// Return depends on type
		if($this->data['ajax']){
			// Print JSON object
			echo json_encode($obj);
		}else{
			// Return JSON object
			return $obj;
		}
	}
	function item_new(){
		// used varibles
		$obj['errors'] =  array();
		$obj['error'] = 0 ;
				
		if($this->once_permission_check()){
			if($this->once_csrf_token_check($this->data['csrf_token'])){
				// Prepare statements to get selected id.
				$stmt = $this->pdo->prepare("INSERT INTO edit_users (id, type_id, data) VALUES('', '".$this->data['type_id']."', NOW())");
				$stmt->execute();
				
				// Get item object
				$obj['item']=array(
					"id" => $this->pdo->lastInsertId(),
					"type_id" => 0
				);
				
				if($obj['item']['id']){
					// Set status ok
					$obj['status']='ok';
				}else{
					// Return error if item not created
					$obj['errors'][]='can\'t insert item to: users';
					$obj['error']++;
				}
			}else{
				$obj['errors'][]='CSFR token invalid!';
				$obj['error']++;
			}
		}else{
			$obj['errors'][]='You don\'t have permission!';
			$obj['error']++;
		}
		
		// Return depends on type
		if($this->data['ajax']){
			// Print JSON object
			echo json_encode($obj);
		}else{
			// Return JSON object
			return $obj;
		}
	}
	function item_star(){
		// used varibles
		$obj['errors'] =  array();
		$obj['error'] = 0 ;
				
		if($this->once_permission_check()){
			if($this->once_csrf_token_check($this->data['csrf_token'])){
				// Prepare statements to get all layers
				$stmt = $this->pdo->prepare("SELECT * FROM edit_users WHERE id=:id LIMIT 1");
				$stmt->bindParam(':id', $this->data['id'], PDO::PARAM_INT);
				$stmt->execute();
				
				if($stmt->rowCount()){
					$row=$stmt->fetch(PDO::FETCH_ASSOC);
					// Check if its stars/unstars then unstar/star
					if($row['stars']==1){
						$stmt = $this->pdo->prepare("UPDATE edit_users SET stars=0 WHERE id=:id LIMIT 1");
						$stmt->bindParam(':id', $this->data['id'], PDO::PARAM_INT);
						$stmt->execute();
					}else{
						$stmt = $this->pdo->prepare("UPDATE edit_users SET stars=1 WHERE id=:id LIMIT 1");
						$stmt->bindParam(':id', $this->data['id'], PDO::PARAM_INT);
						$stmt->execute();
					}
					$obj['status']='ok';
				}else{
					$obj['errors'][]='Page not exist';
					$obj['error']++;
				}
			}else{
				$obj['errors'][]='CSFR token invalid';
				$obj['error']++;
			}
		}else{
			$obj['errors'][]='You don\'t have permission';
			$obj['error']++;
		}
		// Return depends on type
		if($this->data['ajax']){
			// Print JSON object
			echo json_encode($obj);
		}else{
			// Return JSON object
			return $obj;
		}
	}
	
	function upload_image(){
		// used varibles
		$obj['errors'] =  array();
		$obj['error'] = 0 ;
				
		if($this->once_csrf_token_check($this->data['csrf_token'])){
			// Prepare statements to get selected user
			$stmt = $this->pdo->prepare("SELECT * FROM edit_users WHERE id=:id LIMIT 1");
			$stmt->bindParam(':id', $this->data['user_id'], PDO::PARAM_INT);
			$stmt->execute();
			
			// Get count of returned records
			$obj['count']=$stmt->rowCount();
			if($obj['count']){
				if(!$this->data["image"]["error"]){
					//extract extension
					$image_extensions_allowed = array('jpg', 'jpeg', 'png', 'gif');
					$extension = strtolower(substr($this->data["image"]['name'], strrpos($this->data["image"]['name'], '.') + 1));
					
					// Check extension
					if(in_array($extension, $image_extensions_allowed)){
						$image_mimes_allowed = array("image/gif","image/png","image/jpeg","image/pjpeg");
						$imageinfo = getimagesize($this->data["image"]['tmp_name']);
							
						// Check mime
						if(isset($imageinfo) && in_array($imageinfo['mime'], $image_mimes_allowed)){
							// Check size up to 1MB
							if($this->data["image"]["size"]<= 1000000) {
								// Make dirs and generate files
								@mkdir("../uploads");
								@mkdir("../uploads/".$this->data['id']."");
								chmod("../uploads/".$this->data['id']."", 0777);
									
								// Move uploaded file to upload dir
								move_uploaded_file($this->data["image"]["tmp_name"],'../uploads/'.$this->data['id'].'/photo.png');
								
								// Resize image
								$this->once_image_resize('../uploads/'.$this->data['id'].'/photo.png',170,170);

								// Set fields to update
								$obj['item']=array(
									"id" => $this->data['id']
								);
								
								$obj['status']='ok';
							}else{
								$obj['errors'][]='We only accept images up to 1MB';
								$obj['error']++;
							}
						}else{
							$obj['errors'][]='We only accept GIF and JPEG images';
							$obj['error']++;
						}
					}else{
						$obj['errors'][]='Extension not allowed';
						$obj['error']++;
					}
				}else{
					$obj['errors'][]='Upload error';
					$obj['error']++;
				}
			}else{
				$obj['errors'][]='User not exist';
				$obj['error']++;
			}
		}else{
			$obj['errors'][]='CSFR token invalid!';
			$obj['error']++;
		}

		// Return depends on type
		if($this->data['ajax']){
			// Print JSON object
			echo json_encode($obj);
		}else{
			// Return JSON object
			return $obj;
		}
	}
}
?>