    <!-- Left Dark Bar Start -->
    <div id="leftside">
	<!-- Start User Echo -->
<div id="welcome"> &nbsp &nbsp Hello: &nbsp
  <?php
  
  $sql="SELECT `name` FROM `users` WHERE username='$_SESSION[myusername]'";
  $result=mysql_query($sql);

echo mysql_result($result, 0, 'name');
?></div>
	<!-- End User Echo -->
    	<div class="user">
        	<a href="../"><img src="img/logo.png" width="120" height="120" class="hoverimg" alt="Avatar" /></a>
			</div>

	<!-- Start Navagation -->
             <ul id="nav">
        	<li>
                <ul class="navigation">
                    <li class="heading selected">Welcome</li>
                </ul>			 <li>
			 <ul class="navigation">
                    <li><a href="admin.php" title="Update">Home</a></li>
                </ul>
            <li>
                <a class="expanded heading">Configure</a>
                 <ul class="navigation">
                    <li><a href="beer_main.php" title="beer-list">Beer List</a></li>
					<li><a href="tap_list.php" title="tap-list">Tap List</a></li>
					<li><a href="personalize.php" title="personalize">Personalize</a></li>
                </ul>
            </li>
			 <li>
                <a class="expanded heading">Analytics</a>
                 <ul class="navigation">
                    <li><a href="#" target="" title="temperature">Temperature Monitoring</a>Coming soon</li>
                    <li><a href="#" title="GPT">Gallons Per Tap</a>Coming soon</li>
                    <li><a href="#" title="rank">Beer Rank</a>Coming soon</li>
                </ul>
            </li>
			            <li>
                <a class="expanded heading">Other Help</a>
                 <ul class="navigation">
					<li><a href="#" title="faq">F.A.Q</a></li>
					<li><a href="report_bug.php" title="faq">Report Bug</a></li>
					<li><a href="feedback.php" title="faq">FeedBack</a></li>					
                </ul>
            </li>          
        </ul>
    </div>
	<!-- End Navagation -->
    <!-- Left Dark Bar End --> 
