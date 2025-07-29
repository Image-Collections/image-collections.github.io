<?php /**  * @copyright	Copyright (C) 2011 JoomlaThemes.co - All Rights Reserved. **/
defined( '_JEXEC' ) or die( 'Restricted access' );
define( 'YOURBASEPATH', dirname(__FILE__) );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
<jdoc:include type="head" />
<?php require(YOURBASEPATH . DS . "functions.php"); ?>
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/styles.css" type="text/css" />

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-Q60RJLK50L"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-Q60RJLK50L');
</script>

</head>
<body class="background">
<div id="main">
<div id="header-w">
    	<div id="header">

							<?php if($this->countModules('logo or top')) : ?>
							<table border=0 style="style=margin:0px;padding:0px;width:100%;text-align:center;">
							<tr style="margin:0px;padding:0px;width:100%;text-align:center;">
								<td style="width:33%;text-align:left;">
								<?php if($this->countModules('logo')) : ?>
									<jdoc:include type="modules" name="logo" />
								<?php else: ?>
									<h1><?php echo $mainframe->getCfg('sitename') ;?></h1>
								<?php endif; ?>
								</td>
								<td style="width:33%">
								<?php if($this->countModules('logo')) : ?>
									<jdoc:include type="modules" name="logo" />
								<?php endif; ?>
								</td>
								<td style="width:33%;text-align:right;">
								<?php if($this->countModules('logo')) : ?>
									<jdoc:include type="modules" name="logo" />
								<?php endif; ?>
								</td>
							</tr>
							</table>
							<?php endif; ?>

		</div>        
</div>
	<div id="wrapper">
        	<?php if ($this->countModules('menu')) : ?>
        	<div id="navr"><div id="navl"><div id="nav">
		    	<jdoc:include type="modules" name="menu" style="none" />
			</div></div></div>
        	<?php endif; ?>    
        <?php if ($this->countModules('slideshow')) : ?>   
	    <div id="slide-w"><div id="slide">
                    <jdoc:include type="modules" name="slideshow"  style="none"/>                   
        </div></div>
        <?php endif; ?>    
 		<div id="main-content">
        <?php if ($this->countModules('breadcrumb')) : ?>
        	<jdoc:include type="modules" name="breadcrumb"  style="none"/>
        <?php endif; ?>
  		<div id="message">
		    <jdoc:include type="message" />
		</div>
					<?php if ($this->countModules('user1 or user2 or user3')) : ?>
                    <div id="mods1" class="spacer<?php echo $mainmod1_width; ?>">
                        <jdoc:include type="modules" name="user1" style="jaw" />
                        <jdoc:include type="modules" name="user2" style="jaw" />
                        <jdoc:include type="modules" name="user3" style="jaw" /> 
                    </div>
                    <?php endif; ?>        
        <div class="full">
                    <div id="comp">                           
                    <div id="comp_<?php echo $compwidth ?>">
                    <div id="comp-i">
                        <jdoc:include type="component" />
                    </div>
                    </div>
                    <?php if ($this->countModules('left')) : ?>
                    <div id="leftbar-w">
                    <div id="sidebar">
                        <jdoc:include type="modules" name="left" style="jaw" />
                    </div>
                    </div>
                    <?php endif; ?>                      
                    </div>
                    <?php if ($this->countModules('right')) : ?>
                    <div id="rightbar-w">
                    <div id="sidebar">
                        <jdoc:include type="modules" name="right" style="jaw" />
                    </div>
                    </div>
                    <?php endif; ?>
		<div class="clr"></div>
        </div>     
        </div>     
        <div class="bot1"><div class="bot2"><div class="bot3"></div></div></div>
        <div class="shadow2"></div>
  </div>
</div>
		<?php if ($this->countModules('user4 or user5 or user6')) : ?>
		<div id="mods2" class="spacer<?php echo $mainmod2_width; ?>">
			<jdoc:include type="modules" name="user4" style="jaw" />
			<jdoc:include type="modules" name="user5" style="jaw" />
			<jdoc:include type="modules" name="user6" style="jaw" />
		</div>
		<?php endif; ?>   
<?php if ($this->countModules('user7 or user8 or user9 or user10')) : ?>
<div id="footer">
	<div class="footer-pad">
    	<div class="top1"><div class="top2"><div class="top3"></div></div></div>
		<div id="mods3" class="spacer<?php echo $mainmod3_width; ?>">
			<jdoc:include type="modules" name="user7" style="jaw" />
			<jdoc:include type="modules" name="user8" style="jaw" />
			<jdoc:include type="modules" name="user9" style="jaw" />
            <jdoc:include type="modules" name="user10" style="jaw" />
		</div>
        <div class="bot1"><div class="bot2"><div class="bot3"></div></div></div> 
  </div>    
</div>        
<?php endif; ?>
<div id="bottom">
        <?php if ($this->countModules('copyright')) : ?>
            <div class="copy">
                <jdoc:include type="modules" name="copyright"/>
            </div>
        <?php endif; ?>
</div>
</body>
</html>
