<div id="kboard-avatar-document">
	<div class="kboard-header"></div>
	
	<div class="kboard-document-wrap" itemscope itemtype="http://schema.org/Article">
		<div class="kboard-title" itemprop="name">
			<p><?php echo $content->title?></p>
		</div>
		
		<div class="kboard-detail">
			<?php if($content->category1):?>
			<div class="detail-attr detail-category1">
				<div class="detail-name"><?php echo $content->category1?></div>
			</div>
			<?php endif?>
			<?php if($content->category2):?>
			<div class="detail-attr detail-category2">
				<div class="detail-name"><?php echo $content->category2?></div>
			</div>
			<?php endif?>
			<div class="detail-attr detail-writer">
				<div class="detail-name"><?php echo __('작성자', 'kboard')?></div>
				<div class="detail-value">
					<?php if($content->member_uid):?>
						<span title="<?php echo $content->member_display?>"><?php echo get_avatar($content->member_display, 32, $default, $content->member_display);?></span>
					<?php else:?>
						<?php echo $content->member_display?>
					<?php endif?>
				</div>
			</div>
			<div class="detail-attr detail-date">
				<div class="detail-name"><?php echo __('작성일', 'kboard')?></div>
				<div class="detail-value"><?php echo date("Y-m-d H:i", strtotime($content->date))?></div>
			</div>
			<div class="detail-attr detail-view">
				<div class="detail-name"><?php echo __('조회수', 'kboard')?></div>
				<div class="detail-value"><?php echo $content->view?></div>
			</div>
		</div>
		
		<div class="kboard-content" itemprop="description">
			<div class="content-view">
				<?php if($content->thumbnail_file):?><p class="thumbnail-area"><img src="<?php echo get_site_url() . $content->thumbnail_file?>" alt=""></p><?php endif;?>
				
				<?php echo $content->content?>
			</div>
		</div>
		
		<?php if($content->attach->file1[0]):?>
		<div class="kboard-attach">
			<?php echo __('첨부파일', 'kboard')?> : <a href="<?php echo $url->getDownloadURLWithAttach($content->uid, 'file1')?>"><?php echo $content->attach->file1[1]?></a>
		</div>
		<?php endif?>
		
		<?php if($content->attach->file2[0]):?>
		<div class="kboard-attach">
			<?php echo __('첨부파일', 'kboard')?> : <a href="<?php echo $url->getDownloadURLWithAttach($content->uid, 'file2')?>"><?php echo $content->attach->file2[1]?></a>
		</div>
		<?php endif?>
		
		<?php if($content->attach->file3[0]):?>
		<div class="kboard-attach">
			<?php echo __('첨부파일', 'kboard')?> : <a href="<?php echo $url->getDownloadURLWithAttach($content->uid, 'file3')?>"><?php echo $content->attach->file3[1]?></a>
		</div>
		<?php endif?>
	</div>
	
	<?php if($board->isComment()):?>
	<div class="kboard-comments-area"><?php echo $board->buildComment($content->uid)?></div>
	<?php endif?>
	
	<div class="kboard-control">
		<div class="left">
			<a href="<?php echo $url->toString()?>" class="kboard-avatar-button-small"><?php echo __('목록', 'kboard')?></a>
			<a href="<?php echo $url->getDocumentURLWithUID($content->getPrevUID())?>" class="kboard-avatar-button-small"><?php echo __('이전으로', 'kboard')?></a>
			<a href="<?php echo $url->getDocumentURLWithUID($content->getNextUID())?>" class="kboard-avatar-button-small"><?php echo __('다음으로', 'kboard')?></a>
			<?php if($board->isWriter() && !$content->notice):?><a href="<?php echo $url->set('parent_uid', $content->uid)->set('mod', 'editor')->toString()?>" class="kboard-avatar-button-small"><?php echo __('덧글 달기', 'kboard')?></a><?php endif?>
		</div>
		<?php if($board->isEditor($content->member_uid) || $board->permission_write=='all'):?>
		<div class="right">
			<a href="<?php echo $url->set('uid', $content->uid)->set('mod', 'editor')->toString()?>" class="kboard-avatar-button-small"><?php echo __('수정하기', 'kboard')?></a>
			<a href="<?php echo $url->set('uid', $content->uid)->set('mod', 'remove')->toString()?>" class="kboard-avatar-button-small" onclick="return confirm('<?php echo __('Are you sure you want to delete?', 'kboard')?>');"><?php echo __('삭제 하기', 'kboard')?></a>
		</div>
		<?php endif?>
	</div>
	
	<!--<div class="kboard-avatar-poweredby">
		<a href="http://www.cosmosfarm.com/products/kboard" onclick="window.open(this.href); return false;" title="<?php echo __('KBoard is the best community software available for WordPress', 'kboard')?>">Powered by KBoard</a>
	</div>-->
</div>