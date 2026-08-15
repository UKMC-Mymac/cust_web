<div class="chat-btn">
	<img class="chat-toggle" src="<?php echo e(asset('dist/images/homepage/chat.png')); ?>" alt="chat button" />
	<span class="chat-unread-badge" id="chatUnreadBadge" style="display:none;">0</span>
</div>

<style>
	.chat-btn {
		position: fixed;
		right: 30px;
		bottom: 55px;
		height: 50px;
		width: 50px;
		cursor: pointer;
		display: block;
		border-radius: 50px;
		z-index: 1200;
	}

	.chat-unread-badge {
		position: absolute;
		top: -5px;
		right: -5px;
		min-width: 18px;
		height: 18px;
		padding: 0 4px;
		border-radius: 999px;
		background: #ef4444;
		color: #fff;
		font-size: 10px;
		line-height: 18px;
		text-align: center;
		font-weight: 700;
	}

	.chat-window {
		display: none;
		position: fixed;
		bottom: 90px;
		right: 20px;
		width: 350px;
		height: min(500px, calc(100vh - 120px));
		flex-direction: column;
		background: #fff;
		border-radius: 15px;
		box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
		overflow: hidden;
		overscroll-behavior: contain;
		z-index: 1200;
	}

	.chat-header {
		display: flex;
		align-items: flex-start;
		justify-content: space-between;
		padding: 16px 18px;
		background: var(--theme-color, #0f172a);
		color: #fff;
	}

	.chat-header-left {
		display: flex;
		flex-direction: column;
		gap: 2px;
	}

	.chat-title {
		font-size: 15px;
		font-weight: 700;
	}

	.chat-status {
		font-size: 11px;
		opacity: 0.85;
	}

	.chat-header-actions {
		display: flex;
		align-items: center;
		gap: 8px;
		flex-wrap: wrap;
		justify-content: flex-end;
	}

	.chat-action-btn {
		border: 0;
		border-radius: 999px;
		padding: 7px 10px;
		background: rgba(255, 255, 255, 0.16);
		color: #fff;
		font-size: 11px;
		font-weight: 600;
		cursor: pointer;
	}

	.chat-notice {
		padding: 8px 14px;
		background: #fff8e1;
		color: #7c4a03;
		font-size: 12px;
		font-weight: 600;
		border-bottom: 1px solid #ffe0a3;
	}

	.chat-pill-btn {
		border: 1px solid rgba(15, 23, 42, 0.12);
		border-radius: 999px;
		padding: 7px 12px;
		background: #fff;
		color: var(--theme-color, #0f172a);
		font-size: 12px;
		font-weight: 600;
		cursor: pointer;
	}

	.chat-pill-btn.primary {
		background: var(--theme-color, #0f172a);
		border-color: var(--theme-color, #0f172a);
		color: #fff;
	}

	.chat-messages {
		flex: 1;
		min-height: 0;
		overflow-y: auto;
		-webkit-overflow-scrolling: touch;
		padding: 16px;
		background: #fff;
		overscroll-behavior: contain;
	}

	.chat-input {
		display: flex;
		gap: 10px;
		padding: 12px;
		border-top: 1px solid #edf2f7;
		background: #fff;
	}

	.chat-input input {
		flex: 1;
		border: 1px solid #d6dde8;
		border-radius: 10px;
		padding: 10px 12px;
	}

	.chat-input button {
		border: 0;
		border-radius: 10px;
		padding: 10px 14px;
		background: var(--theme-color, #0f172a);
		color: #fff;
		font-weight: 600;
	}

	.chat-header-link {
		border: 0;
		border-radius: 999px;
		padding: 6px 10px;
		background: rgba(255, 255, 255, 0.16);
		font-size: 11px;
		font-weight: 600;
		color: #fff;
		cursor: pointer;
	}

	.chat-header-link.is-muted {
		opacity: 0.8;
		cursor: default;
	}
</style>

<div class="chat-window" id="chatWindow">
	<div class="chat-header">
		<div class="chat-header-left">
			<span class="chat-title"><?php echo e(__('Admissions Office')); ?></span>
		</div>
		<div class="chat-header-actions">
			<button type="button" class="chat-header-link" id="chatNewBtn"><?php echo e(__('New chat')); ?></button>
			<button type="button" class="chat-header-link" id="chatLeaveBtn"><?php echo e(__('Leave chat')); ?></button>
			<span class="chat-toggle" style="cursor: pointer">✕</span>
		</div>
	</div>

	<div class="chat-notice" id="chatNotice" style="display:none;">
		<span><?php echo e(__('New reply from admissions')); ?></span>
	</div>

	<div class="chat-messages" id="chatMessages">
		<div class="msg received"><?php echo e(__('Hi there! How can we help you today?')); ?></div>
	</div>

	<div class="chat-input">
		<input type="text" id="chatInput" placeholder="<?php echo e(__('Type a message...')); ?>" />
		<button id="sendBtn"><?php echo e(__('Send')); ?></button>
	</div>

</div>
<?php /**PATH D:\office_project\cust\resources\views/web/custom/components/chat.blade.php ENDPATH**/ ?>