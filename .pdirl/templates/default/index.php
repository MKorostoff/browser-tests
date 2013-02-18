<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang='en' xml:lang='en' xmlns='http://www.w3.org/1999/xhtml'>
<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title><?php echo _('Directory listing for '), host(), $_SERVER['REQUEST_URI']; ?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo templateDirectory();?>/style.css" />
	</head>
<body>
	<div id="headerwrap">
		<div id="header">
			<h1><?printBreadcrumb();?></h1>
			<form action="<?php echo scriptPath();?>" method="get">
			<?php // adds the current directory "&directory=blubb/blabl" to the url ?>
			<input type="hidden" name="directory" value="<?php echo currentDirectory();?>" />
			<ul>
				<?php // simple history-back js-command ?>
				<li><a href="javascript:history.back()" onclick="history.back()"><?php imgTagIcon('back', 'Back');?></a></li>
				
				<?php if(currentDirectory() != './'): # If this folder is not the folder where pdirl is?>
				
					<li><a href="<?php echo goParent()?>"><?imgTagIcon('parent', 'Parent Directory')?></a></li>
					<li><a href="<?php echo scriptDirectory(); ?>"><?imgTagIcon('home', 'Home Directory')?></a></li>
					
				<?php else: ?>
				
					<li><?imgTagIcon('parent-disabled', 'Parent');?></li>
					<li><?imgTagIcon('home-disabled', 'Home Directory');?></li>
					
				<?php endif; ?>
				
				<li><a href="<?php echo $_SERVER['REQUEST_URI']?>"><?imgTagIcon('reload', 'Reload');?></a></li>
				<li style="color: #0C4F5F">|</li>
				<li>
					<?imgTagIcon('search', 'Search...')?>
					<input name="gosearch" id="search" type="text" value="<?php echo searchInput()?>" onclick=" if(this.value == '<?php echo _('Search...')?>') { this.value = ''; }" /></li>
			</ul>
			</form>
			<div style="clear:left;"></div>
		</div>
	</div>
	<div id="contentwrap">
		<?php if ($elements): ?>
			<table>
				<thead>
					<tr>
						<td <?php if ($hideMTime) echo 'colspan="2"'; ?>><!--<a href="?sortorder=<?php echo sortOrder(true);?>&sortkey=name">-->
<!--						<?php //if(sortOrder() == "SORT_DESC" && sortKey() == "name"): ?><span style="float: right;">v</span><?php //endif; ?>-->
						<?php echo _('Name');?><!--</a>--></td>
						<?php if (!$hideMTime): ?>
							<td><?php echo _('Last modification')?></td>
						<?php endif; ?>
						<td><?php echo _('Size');?></td>
					</tr>
				</thead>
				<tbody>
					<?php foreach($elements as $element): ?>
						<tr>
							<td class="name" 
							<?php 
							if(!$element['readable']){ 
								echo 'colspan="3"';
							} elseif ($element['countonly']) {
								echo 'colspan="2"';
							} ?> title="<?php echo filetypeInfo($element['type']);?>">
								<img src="<?php echo iconDirectory();?>/<?php echo $element['type'];?>.png" alt="<?php echo _('Directory');?>" />
								<?php if(!$element['readable']) { echo imgTagIcon('locked', 'not accessible');} ?>
								<a href="<?php echo $element['urlpath'] ?>" id="<?php echo $element['name'];?>">
									<?php echo $element['name'];?>
								</a>
								<?php if(searchTag() && $element['location']): ?>
									<small><a href="<?php echo urlPath($element['locationurl']);?>">
										<?php echo $element['location'];?>
									</a></small>
								<?php endif; ?>
							</td>
							<?php if($element['readable']): ?>
								<?php if($element['countonly']): ?>
									<td class="size">
										<?php printf(_('%s elements'), $element['numberofelements']); ?>
									</td>
								<?php else: ?>
									<td class="mtime">
										<?php echo $element['mtimer'];?>
									</td>
									<td class="size">
										<?php echo $element['sizer']['number'].' '.$element['sizer']['unit'];?>
									</td>
								<?php endif; ?>
							<?php endif; ?>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php $totalSize = sizeReadable(totalSize()); ?>
			<?php $term = (searchTag())? _('Found %s element(s) totalling %s %s in size.') : _('This directory contains %s element(s) totalling %s %s in size.');?>
			<div id="footer">
				<p><?php echo sprintf($term, numberOfElements(), $totalSize['number'], $totalSize['unit']);?></p>
				<p><small>powered by <a href="http://pdirl.newroots.de/">pdirl - PHP Directory Listing</a>.</small></p>
			</div>
		<?php else: ?>
			<div id="nothing">
				<?php if(searchTag()): ?>
					<p><?php echo _('No search result.');?></p>
				<?php else: ?>
					<p><?php echo _('This directory contains no files.');?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</body>
</html>