<?php
		global $CFG,$PAGE,$DB,$USER;
		require_once('config.php'); 
		require_once($CFG->libdir.'/filelib.php');
		
		$name = isset($_GET['username'])?$_GET['username']:'';
		$password = isset($_GET['password'])?$_GET['password']:'';
		$urlstr = isset($_GET['urlstr'])?$_GET['urlstr']:'';
		
		$sqlForUserExitsOrNot = "select * from {user} where username='$name'";
		$result_sqlForUserExitsOrNot = $DB->get_record_sql($sqlForUserExitsOrNot);
		$dbusername = $result_sqlForUserExitsOrNot->username;
		$error=1;
		//print_r(isset($_GET['username']));
		
		if(isset($_GET['username']) &&  isset($_GET['password']))
		{
			
			if($name !='' && $password !='')
			{
				
				if($dbusername == $name)
				{
					if (isloggedin()) 
					{
						redirect($CFG->wwwroot."/".$urlstr);
					}
					else
					{
						if(isset($name) && isset($password) && $name !='' && $password !=''){
							$user = authenticate_user_login($name, $password);
							if(isset($user) && $user !='' && !empty($user))
							{
								if(complete_user_login($user))
								{	
									redirect($CFG->wwwroot."/".$urlstr);
									//redirect("http://localhost/moodle/".$urlstr);
								} 
								else 
								{
									echo "Please <a href='login/index.php'>login</a>";
								}
							}
							else{
								$error=0;
							}
						}
					}
				}
				else
				{
					$error =0;
				}
			}
			else
			{
				
				$error =0;
			}
		}
		else
		{
			
			$error =2;
		}
		
		echo $OUTPUT->header();
?>
<?php if($error==0){
	
		redirect($CFG->wwwroot."/login/index.php?error=0");
	?>
	<?php } ?>
	
	
<?php if($error==2){
	
	?>
	 <div>
		<h5 style="color:red;text-align:center"> <?php echo "Parameters is not valid."; ?> </h5>
	</div> 
	<?php } ?>
	
<?php 	echo $OUTPUT->footer(); ?>