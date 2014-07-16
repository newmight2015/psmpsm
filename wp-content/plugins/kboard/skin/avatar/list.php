<div id="kboard-avatar-list">
	<!-- 검색폼 시작 -->
	<!--<div class="kboard-header">
		<form id="kboard-search-form" method="get" action="<?php echo $url->set('mod', 'list')->toString()?>">
			<?php echo $url->set('category1', '')->set('category2', '')->set('pageid', '1')->set('target', '')->set('keyword', '')->set('mod', 'list')->toInput()?>
			
			<?php if($board->use_category == 'yes'):?>
			<div class="kboard-category">
				<?php if($board->initCategory1()):?>
					<select name="category1" onchange="jQuery('#kboard-search-form').submit();">
						<option value=""><?php echo __('All', 'kboard')?></option>
						<?php while($board->hasNextCategory()):?>
						<option value="<?php echo $board->currentCategory()?>"<?php if($_GET['category1'] == $board->currentCategory()):?> selected="selected"<?php endif?>><?php echo $board->currentCategory()?></option>
						<?php endwhile?>
					</select>
				<?php endif?>
				
				<?php if($board->initCategory2()):?>
					<select name="category2" onchange="jQuery('#kboard-search-form').submit();">
						<option value=""><?php echo __('All', 'kboard')?></option>
						<?php while($board->hasNextCategory()):?>
						<option value="<?php echo $board->currentCategory()?>"<?php if($_GET['category2'] == $board->currentCategory()):?> selected="selected"<?php endif?>><?php echo $board->currentCategory()?></option>
						<?php endwhile?>
					</select>
				<?php endif?>
			</div>
			<?php endif?>
			
			<div class="kboard-search">
				<select name="target">
					<option value=""><?php echo __('All', 'kboard')?></option>
					<option value="title"<?php if($_GET['target'] == 'title'):?> selected="selected"<?php endif?>><?php echo __('Title', 'kboard')?></option>
					<option value="content"<?php if($_GET['target'] == 'content'):?> selected="selected"<?php endif?>><?php echo __('Content', 'kboard')?></option>
					<option value="member_display"<?php if($_GET['target'] == 'member_display'):?> selected="selected"<?php endif?>><?php echo __('Author', 'kboard')?></option>
				</select>
				<input type="text" name="keyword" value="<?php echo $_GET['keyword']?>">
				<button type="submit" class="kboard-avatar-button-small"><?php echo __('Search', 'kboard')?></button>
			</div>
		</form>
	</div>-->
	<!-- 검색폼 끝 -->
	<!-- 리스트 시작 -->
	<div class="kboard-list">
		<table>
			<thead>
				<tr>
					<td class="kboard-list-uid"><img style="height:100%; width:99%"src="http://ancle.thecakehouse.co.kr/wp-content/uploads/2014/07/게시판-헤더11.png"></td>
					<td class="kboard-list-title"><img style="height:100%; width:99.5%" src="http://ancle.thecakehouse.co.kr/wp-content/uploads/2014/07/게시판-헤더2.png"></td>
					<td class="kboard-list-user"><img style="height:100%; width:99%" src="http://ancle.thecakehouse.co.kr/wp-content/uploads/2014/07/게시판-헤더3.png"></td>
					<td class="kboard-list-date"><img style="height:100%; width:99%" src="http://ancle.thecakehouse.co.kr/wp-content/uploads/2014/07/게시판-헤더4.png"></td>
					<td class="kboard-list-view"><img style="height:100%; width:99%" src="http://ancle.thecakehouse.co.kr/wp-content/uploads/2014/07/게시판-헤더5.png"></td>
				</tr>
			</thead>
			<tbody>
				<!--<tr>
					<td class="kboard-list-img"><img style="width:100%" src="http://ancle.thecakehouse.co.kr/wp-content/uploads/2014/07/게시판-헤더1.png"></td>
				</tr>-->
				
				<?php while($content = $list->hasNextNotice()):?>
				<tr class="kboard-list-notice">
					<td class="kboard-list-uid"><?php echo __('<img src="http://ancle.thecakehouse.co.kr/wp-content/uploads/2014/07/notice.png">', 'kboard')?></td>
					<!--<td class="kboard-list-uid"><?php echo __('Notice', 'kboard')?></td>-->
					<td class="kboard-list-title"><div class="cut_strings">
							<a href="<?php echo $url->set('uid', $content->uid)->set('mod', 'document')->toString()?>"><?php echo $content->title?></a>
							<?php echo $content->getCommentsCount()?>
						</div></td>
					<td class="kboard-list-user">
						<?php if($content->member_uid):?>
							<span title="<?php echo $content->member_display?>"><?php echo get_avatar($content->member_display, 32, $default, $content->member_display);?></span>
						<?php else:?>
							<?php echo $content->member_display?>
						<?php endif?>
					</td>
					<td class="kboard-list-date"><?php echo date("Y.m.d", strtotime($content->date))?></td>
					<td class="kboard-list-view"><?php echo $content->view?></td>
				</tr>
				<?php endwhile?>
				<?php while($content = $list->hasNext()):?>
				<tr>
					<td class="kboard-list-uid"><?php echo $list->index()?></td>
					<td class="kboard-list-title"><div class="cut_strings">
							<a href="<?php echo $url->set('uid', $content->uid)->set('mod', 'document')->toString()?>"><?php echo $content->title?>
							<?php if($content->secret):?><img src="<?php echo $skin_path?>/images/icon_lock.png" alt="<?php echo __('Secret', 'kboard')?>"><?php endif?>
							</a>
							<?php echo $content->getCommentsCount()?>
						</div></td>
					<td class="kboard-list-user">
						<?php if($content->member_uid):?>
							<span title="<?php echo $content->member_display?>"><?php echo get_avatar($content->member_display, 32, $default, $content->member_display);?></span>
						<?php else:?>
							<?php echo $content->member_display?>
						<?php endif?>
					</td>
					<td class="kboard-list-date"><?php echo date("Y.m.d", strtotime($content->date))?></td>
					<td class="kboard-list-view"><?php echo $content->view?></td>
				</tr>
				<?php $boardBuilder->builderReply($content->uid)?>
				<?php endwhile?>
			</tbody>
		</table>
	</div>
	<!-- 리스트 끝 -->
	
	<!-- 페이징 시작 -->
	<div class="kboard-pagination">
		<ul class="kboard-pagination-pages">
			<?php echo kboard_pagination($list->page, $list->total, $list->rpp)?>
		</ul>
	</div>
	<!-- 페이징 끝 -->
	
	<!--<div class="kboard-avatar-poweredby">
		<a href="http://www.cosmosfarm.com/products/kboard" onclick="window.open(this.href); return false;" title="<?php echo __('KBoard is the best community software available for WordPress', 'kboard')?>">Powered by KBoard</a>
	</div>--><!-- 검색폼 시작 -->
	<div class="kboard-header">
		<form id="kboard-search-form" method="get" action="<?php echo $url->set('mod', 'list')->toString()?>">
			<?php echo $url->set('category1', '')->set('category2', '')->set('pageid', '1')->set('target', '')->set('keyword', '')->set('mod', 'list')->toInput()?>
			
			<?php if($board->use_category == 'yes'):?>
			<div class="kboard-category">
				<?php if($board->initCategory1()):?>
					<select name="category1" onchange="jQuery('#kboard-search-form').submit();">
						<option value=""><?php echo __('All', 'kboard')?></option>
						<?php while($board->hasNextCategory()):?>
						<option value="<?php echo $board->currentCategory()?>"<?php if($_GET['category1'] == $board->currentCategory()):?> selected="selected"<?php endif?>><?php echo $board->currentCategory()?></option>
						<?php endwhile?>
					</select>
				<?php endif?>
				
				<?php if($board->initCategory2()):?>
					<select name="category2" onchange="jQuery('#kboard-search-form').submit();">
						<option value=""><?php echo __('All', 'kboard')?></option>
						<?php while($board->hasNextCategory()):?>
						<option value="<?php echo $board->currentCategory()?>"<?php if($_GET['category2'] == $board->currentCategory()):?> selected="selected"<?php endif?>><?php echo $board->currentCategory()?></option>
						<?php endwhile?>
					</select>
				<?php endif?>
			</div>
			<?php endif?>
			
			<div class="kboard-search">
				<select name="target">
					<option value=""><?php echo __('전체', 'kboard')?></option>
					<option value="title"<?php if($_GET['target'] == 'title'):?> selected="selected"<?php endif?>><?php echo __('제목', 'kboard')?></option>
					<option value="content"<?php if($_GET['target'] == 'content'):?> selected="selected"<?php endif?>><?php echo __('내용', 'kboard')?></option>
					<option value="member_display"<?php if($_GET['target'] == 'member_display'):?> selected="selected"<?php endif?>><?php echo __('작성자', 'kboard')?></option>
				</select>
				<input type="text" name="keyword" value="<?php echo $_GET['keyword']?>">
				<button type="submit" class="kboard-avatar-button-small"><?php echo __('검색', 'kboard')?></button>
				<!--<button type="submit" class="kboard-avatar-button-small"><?php echo __('로그인', 'kboard')?></button>--->
				<a href="<?php echo $url->set('mod', 'editor')->toString()?>" class="kboard-avatar-button-small" style="clear:both;"><?php echo __('글쓰기', 'kboard')?></a>
				<!--<?php if($board->isWriter()):?>-->
	<!-- 버튼 시작 -->
	<!--<div class="kboard-control"
		<a href="<?php echo $url->set('mod', 'editor')->toString()?>" class="kboard-avatar-button-small" style="clear:both;"><?php echo __('글쓰기', 'kboard')?></a>
	</div>-->
	<!-- 버튼 끝 -->
	<!--<?php endif?>-->
	
	
			</div>
			
	</form>
	</div>
	<!-- 검색폼 끝 -->
</div>