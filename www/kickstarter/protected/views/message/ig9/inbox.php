<?php 
	$module = Yii::app()->getModule('message');
	$user = Yii::app()->user->model();
	$titleSuffix = ($module->getCountUnreadedMessages($user->id)) ? '(' . $module->getCountUnreadedMessages($user->id) . ')' : '';

	$this->pageTitle = ___('Inbox').$titleSuffix.' - '. $user->username;
	$this->breadcrumbs=array(
		MessageModule::t("Messages"),
		MessageModule::t("Inbox"),
	);

	$ac = Yii::app()->assetCompiler;
	$baseUrl = $this->assetsUrl;
	$cs = Yii::app()->clientScript;

	$cs->registerScriptFile($baseUrl."/js/core/humane.min.js");

	$ac->registerAssetGroup(array('message.less', 'notification.less', 'message.js'), $baseUrl);
?>

<div class='container' id='message-inbox'>
	<div class='sidebar'>
		<div class='compose'>
			<a href='/message/compose' class='btn btn-danger' id='btn-compose'><?php __("Compose") ?></a>
		</div>
		<?php $this->renderPartial(Yii::app()->getModule('message')->viewPath . '/_sidebar') ?>
	</div>

	<div class='content'>
		<div id='message-list' <?php echo $theMessage || $composing ? "style='display: none'" : "" ?>>
			<div class='toolbar'>
				<div class='buttons'>
					<span class='btn btn-select' ><input type='checkbox' id='select'/> <?php __("Select") ?></span>
					<span class='btn btn-refresh' ><?php __("Refresh") ?></span>
					<span class='btn disabled btn-markasread' ><?php __("Mark as read") ?></span>
					<span class='btn disabled btn-markasunread' ><?php __("Mark as unread") ?></span>
					<span class='btn disabled btn-delete' ><?php __("Delete") ?></span>
				</div>
				<div id='summary-text'></div>
			</div>
			<form id='theform'>
			<?php
			  $this->widget('zii.widgets.grid.CGridView', 
			  	array(
			      'dataProvider' => $messagesAdapter,
			      'hideHeader' => true,
			      'summaryText' => '{start}|{end}|{count}',
			      'summaryCssClass' => 'hidden original-summary-text',
			      'afterAjaxUpdate' => 'ig9.afterAjaxUpdate',
			      // 'enableHistory' => true,
			      'pager' => array(
			      	'class' => 'CLinkPager',
			      	'header' => '',
			      	'prevPageLabel' => '«',
			      	'nextPageLabel' => '»',
			      	'hiddenPageCssClass' => 'disabled',
			      	'lastPageCssClass' => 'hidden',
			      	'firstPageCssClass' => 'hidden',
			      	'htmlOptions' => array(
			      		'class' => 'dont-style-me'
			      	)
			      ),
			      'pagerCssClass' => 'pagination pagination-centered',
			      'itemsCssClass' => 'table table-hover',
			      'htmlOptions' => array(
			        'class' => 'table table-hover',
			      ),
			      'rowCssClassExpression' => '"message-{$data->id} ".($data->is_read ? "" : "unread")',
			      'columns' => array(
			        array(
			          'name' => '',
			          'type' => 'raw',
			          'value' => function ($data, $row) use ($controller) {
					        return "<input type='checkbox' name='message_ids[]' class='message-checkbox' value={$data->id} />";
					      },
			          'htmlOptions' => array(
			            'class' => 'id',
			            'width' => 10
			          ) ,
			        ) ,
			        array(
			          'name' => ___('Sender') ,
			          'value' => '$data->sender->username',
			          'htmlOptions' => array(
			            'class' => 'sender',
			            'width' => 80
			          ) ,
			        ) ,
			        array(
			          'name' => ___('Content') ,
			          'sortable' => false,
			          'type' => 'html',
			          'value' => function ($data, $row) use ($controller) {
					        $subject = $data->subject;
					        $body = substr(strip_tags(trim($data->body)), 0, 130).'...';
					        return "<span class='message-subject'>{$subject}</span><p class='message-body'>{$body}</p><div class='message-body-full'>{$data->body}</div>";
					      },
			          'htmlOptions' => array(
			            'class' => 'title'
			          ) ,
			        ) ,
			        array(
			          'name' => ___('Time') ,
			          'type' => 'raw',
			          'value' => function ($data, $row) use ($controller) {
			          	$timestamp = CDateTimeParser::parse($data->created_at, "yyyy-MM-dd hh:mm:ss");
			          	$time = date("g:i a", $timestamp);
			          	$time .= "<br/>";
			          	$time .= date("M n, Y", $timestamp);
			        
			          	return $time;
					      },
			          'htmlOptions' => array(
			            'class' => 'time',
			            'width' => 100
			          ) ,
			        ) ,
			      ) ,
			    )
			  );
			?>
				<div class='loading'>
					<div class='spinner'></div>
				</div>

			</form>
		</div>

		<div id='message-detail' <?php echo $theMessage ? "style='display: block'" : "" ?>>
			<div class='toolbar'>
				<div class='buttons'>
					<span class='btn btn-back'>← <?php __("Back") ?></span>
					<span class='btn btn-markasunread-single'><?php __("Mark as unread") ?></span>
					<span class='btn btn-delete-single'><?php __("Delete") ?></span>
				</div>
			</div>
			<div class='message'>
				<div class='header'>
					<h3 id='message-subject'><?php echo $theMessage->subject ?></h3>
					<span id='message-sender'><?php echo $theMessage->sender->username ?></span> &mdash; <span id='message-time'><?php echo date("g:i a", CDateTimeParser::parse($theMessage->created_at, "yyyy-MM-dd hh:mm:ss")) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .date("M n, Y", CDateTimeParser::parse($theMessage->created_at, "yyyy-MM-dd hh:mm:ss")) ?></span>
				</div>
				<div class='body'>
					<p id='message-body'>
						<?php echo $theMessage->body ?>
					</p>
				</div>
				<div id='message-reply'>
					<div id="editor-placeholder"><a href="#" class='open-editor'><?php __('Click here to reply') ?></a></div>
					<div id='editor-wrapper'>
						<form action='' id='reply-form' method='POST'>
							<input type="hidden" name="receiver" id="reply-receiver" value="<?php echo $theMessage->sender->username ?>">
							<p>
								<input type="text" name="Message[subject]" value="Re: <?php echo $theMessage->subject ?>" id='reply-subject'>
							</p>
							<textarea id='reply-editor' name="Message[body]"><p>&nbsp;</p><blockquote><?php echo $theMessage->body ?></blockquote></textarea>
						</form>

						<div class='toolbar'>
							<div class='buttons'>
								<span class='btn btn-reply-send btn-danger'><?php __("Send") ?></span>
								<span class='btn btn-reply-save'><?php __("Save now") ?></span>
								<span class='btn btn-reply-discard'><?php __("Discard") ?></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="message-compose" <?php echo $composing ? "style='display: block'" : "" ?>>
			<div class='toolbar'>
				<div class='buttons'>
					<span class='btn btn-send btn-danger'><?php __("Send") ?></span>
					<span class='btn btn-save'><?php __("Save now") ?></span>
					<span class='btn btn-discard btn-back'><?php __("Discard") ?></span>
				</div>
			</div>
			<form action='' id='compose-form' method='POST'>
				<input type="hidden" name="id" value="" id="message-id">
				<p>
					<label for='receiver'><?php __("To") ?></label>
					<input type="text" name="receiver" value="<?php echo $to ?>" id='receiver'>
				</p>
				<p>
					<label for='subject'><?php __("Subject") ?></label>
					<input type="text" name="Message[subject]" value="" id='subject'>
				</p>
				<?php 
					$this->widget('widgets.redactorjs.Redactor', array(
					  'model' => Message::model(),
					  'attribute' => 'body',
					  'editorOptions' => array(
					    'focus' => false,
					    // 'buttons' => array('bold', 'italic', 'deleted', '|', 'unorderedlist', 'orderedlist', 'outdent', 'indent', '|', 'link')
					    'buttons' => array('formatting', '|', 'bold', 'italic', 'deleted', '|', 'unorderedlist', 'orderedlist', 'outdent', 'indent', '|', 'image', 'video', 'table', 'link', '|', 'alignleft', 'aligncenter', 'alignright', 'justify', '|', 'horizontalrule')
					  )
					));
				?>
			</form>

			<div class='toolbar'>
				<div class='buttons'>
					<span class='btn btn-send btn-danger'><?php __("Send") ?></span>
					<span class='btn btn-save'><?php __("Save now") ?></span>
					<span class='btn btn-discard btn-back'><?php __("Discard") ?></span>
				</div>
			</div>
		</div>
	</div>

</div>

<?php $this->renderPartial(Yii::app()->getModule('message')->viewPath . '/_suggest'); ?>