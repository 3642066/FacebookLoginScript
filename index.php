<?php
 include_once "fbaccess.php";
	?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>Facebook Login Demo | FosterZen</title>    
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
    </head>
<body>

<?php
	 function publish_info($uid,$name,$email,$fname,$mname,$lname,$gender,$dob,$fb_frnd,$education,$home_town,$location,$about_me,$interested_in,$relationship_status,$movies,$music,$tv,$books) 
	{
         echo '<div style="width:900px; margin-left:30px;">';
            echo '<b>User_id</b> :'.$uid.'<br />';
            echo '<b>First name </b>:'.$fname.'<br />';
			 echo '<b>Middle name</b> :'.$mname.'<br />';
			 echo '<b>Last name </b>:'.$lname.'<br />';
			 echo '<b>Full name</b> :'.$name.'<br />';
			 echo '<b>Email </b>:'.$email.'<br />';
			 echo '<b>DOB </b>:'.$dob.'<br />';
          echo '<b>Gender</b> :'.$gender.'<br />';
		   echo '<b>Facebook Friend count </b>:'.$fb_frnd.'<br />';
           echo '<b>Home Town </b>:'.$home_town.'<br />';
			 echo '<b>Current City </b>:'.$location.'<br />';
	         echo '<b>About Me</b> :'.$about_me.'<br />';
			 echo '<b>Interested In</b> :'.$interested_in.'<br />';
			  echo '<b>Relationship Status</b> :'.$relationship_status.'<br />';
			  
			  echo '<h3>School :</h3>';
			  foreach($education as $school)
							{
								echo $school['school']['name'].' | ';								
																
							}
	
			 echo '<h3>Movies :</h3>';
			  foreach($movies['data'] as $data)
							{
							    echo $name=$data['name'].' | ';	
							   
								 											
							}
							 echo '<h3>Music :</h3>';
							 foreach($music['data'] as $data)
							{
							     echo $name=$data['name'].' | ';	
							   
								 											
							}
							echo '<h3>T V Series :</h3>';
							foreach($tv['data'] as $data)
							{
							     echo $name=$data['name'].' | ';	
							 
								 											
							}
							echo '<h3>Books :</h3>';
			 foreach($books['data'] as $data)
							{
							     echo $name=$data['name'].' | ';	
							  
								 											
							}
							 echo '</div>';
        return 0;
    }
	function time_elapsed($time) {
	sscanf($time,"%u-%u-%uT%u:%u:%u+0000",$year,$month,$day,$hour,$min,$sec);
    $time_seconds = time() - ((int)substr(date('O'),0,3)*60*60) - mktime($hour,$min,$sec,$month,$day,$year);
    
    if($time_seconds < 1) return '0 seconds';
    
    $arr = array(12*30*24*60*60	=> 'year',
                30*24*60*60		=> 'month',
                24*60*60		=> 'day',
                60*60			=> 'hour',
                60				=> 'minute',
                1				=> 'second'
                );
    
    foreach($arr as $secs => $str){
        $d = $time_seconds / $secs;
        if($d >= 1){
            $r = floor($d);
            return $r . ' ' . $str . ($r > 1 ? 's' : '');
        }
    }
}
	
	function newsitem($profile_pic,$from,$to,$message,$picture,$name,$link,$caption,$description,$icon,$time,$comments,$likes)
	{
		if($to) $to_section = '<div class="to" >to</div><div class="news-friend-name"><strong><a>' . $to . '</a></strong></div><div class="clear"></div>';
		else $to_section = '';
				
		if($message) $message_section = '<div class="message">' . $message . '</div>';
		else $message_section = '';
			
		if($picture) $picture_section = '<div class="external-image"><img src="' . $picture . '"/></div><div class="news-external">';
		else $picture_section = '<div class="news-external" style="width: 410px;">';
		
		if(!$link) $link='#';
		
		if($name) $name_section = '<div class="news-title"><h3><a href="' . $link . '" target="_blank">' . $name . '</a></h3></div>';
		else $name_section = '';
		
		if($caption) $caption_section = '<div class="news-caption"><i>' . $caption . '</i></div>';
		else $caption_section = '';
		
		if($description) $description_section = '<div class="news-desc">' . $description . '</div>';
		else $description_section = '';
		
		if($icon) $icon_section = '<div class="news-icon" ><img src="' . $icon . '" /></div>';
		else $icon_section = '';
		
		$time_converted = time_elapsed($time);
		
		$news = '<div class="news">
						<div class="news-friend-thumb"><img src="' . $profile_pic . '"/></div>
						<div class="news-content">
							<div class="news-friend-name"><strong><a>'. $from . '</a></strong></div>'.$to_section.							
							'<div class="clear"></div>' . $message_section . $picture_section . $name_section . $caption_section . $description_section .
							'</div>
							<div class="clear"></div>
							<div class="comment-like">' . $icon_section . $time_converted . ' ago  ·  ' . $comments . ' comments  ·  ' . $likes . ' likes</div>
						</div>
					</div>';
			return $news;
	}
	
	
 if(!$user) {  ?>
<center><div><h1>Facebook Login Script</h1></div><br />
<h2>Written by Neel Kamal</h2>
<h3>Script will Pull following data from users profile : userid,name,fname,lname,gender,email,birthday,Education,public profile_pic ,Home Town, Current City ,friendlist, ineterested in, relationship status, movies watched , TV Series, Music, books, users newsfeed contents, tagged photos.</h3>
</center>
<div class="login-box">
<div id="f-connect-button"><a href="<?=$loginUrl?>"><img src="images/f-connect.png" alt="Connect to your Facebook Account"/></a><div>
This script will <b>NOT</b> post anything to your wall or like any page automatically.
</div>

 <?php } else { ?>
 <div class="profile-pic"><img src="https://graph.facebook.com/<?php echo($user); ?>/picture?type=large"/></div>
																	 
			<?php
				if(isset($user_info['bio'])) { $about=$user_info['bio'];} else { $about='No Description Found';}
					if(isset($movies)) { $movies=$movies;} else { $movies='No movie Found';}
		
																	 
 publish_info($user,$user_info['name'],$user_info['email'],$user_info['first_name'],$user_info['middle_name'],$user_info['last_name'],$user_info['gender'],$user_info['birthday'],count($friends_list['data']),$user_info['education'],$user_info['hometown']['name'],$user_info['location']['name'],$about,$user_info['interested_in'][0],$user_info['relationship_status'],$movies,$music,$tv,$books);
   } 
   // To print friend List uncomment the below lines
  /* foreach($friends_list['data'] as $frnd)	{
					echo '<div class="friend-list" ><div class="friend-thumb"><img src="https://graph.facebook.com/'. $frnd['id'] .'/picture"/></div><div class="friend-name" ><strong><a>' . $frnd['name'] . '</a></strong></div></div>';
					if(++$i > 10) break;
			}*/  
   
  ?>
  <div class="status-update" style="width:600px; margin-left:30px;">
					<h3>Update Status</h3>					
					<form name="" action="<?=$site_url?>" method="post">
					<textarea id="status" name="status"></textarea>
					<?php if(isset($statusUpdate)) echo'<div class="status-success-message" ><h4 style="padding-left:20px;padding-top:4px;">Status Updated Successfully.</h4></div>'; ?>
					<input id="post-button" type="image" name="submit" src="images/post.jpg" />
					</form>
  <center><h2>News Feed</h2></center>
  	<div class="news-feed" style="width:700px; margin-left:20px;">
					<h3>News Feed</h3>				
					<?php
					foreach($feed['data'] as $news)
					{
					$pro_pic = 'https://graph.facebook.com/'.$news['from']['id'].'/picture';				
					$from = $news['from']['name'];
					$time = $news['created_time'];
				
					if(isset($news['to']['data']['0']['name'])) $to = $news['to']['data']['0']['name'];
					else $to = NULL;
					
					if(isset($news['message'])) $message = $news['message'];
					else $message = NULL;
				
					if(isset($news['picture'])) $picture = $news['picture'];
					else $picture = NULL;
				
					if(isset($news['name'])) $name = $news['name'];
					else $name = NULL;
				
					if(isset($news['link'])) $link = $news['link'];
					else $link = NULL;
				
					if(isset($news['caption'])) $caption = $news['caption'];
					else $caption = NULL;
				
					if(isset($news['description'])) $description = $news['description'];
					else $description = NULL;
				
					if(isset($news['icon'])) $icon = $news['icon'];
					else $icon = NULL;
				
					if(isset($news['comments']['count'])) $comment_count = $news['comments']['count'];
					else $comment_count = 0;
				
					if(isset($news['likes']['count'])) $likes_count = $news['likes']['count'];
					else $likes_count = 0;
				
					if(($news['type']=='status' && isset($news['message'])) || 
					($news['type']=='link' && isset($news['link']) && isset($news['name'])) || 
					($news['type']=='photo' && isset($news['link']) && isset($news['name'])) || 
					($news['type']=='video' && isset($news['link']) && isset($news['name']))){
						echo(newsitem($pro_pic,$from,$to,$message,$picture,$name,$link,$caption,$description,$icon,$time,$comment_count,$likes_count));
					}
			
					}
					?>
				</div>
				
				
				
				<?php if(isset($photos['data']['0'])) { ?>
				<h3>Tagged Photos</h3>
				<div class="tagged-photos">
				<?php
				foreach($photos['data'] as $photo){
						echo '<div class="single-photo"><a href="' . $photo['source'] . '" ><img src="' . $photo['picture'] . '" /></a></div>';						
				}
				?>
				</div>
		<?php } ?>
  
  

