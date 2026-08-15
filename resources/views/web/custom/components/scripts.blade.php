<!-- jQuery -->
<script src="{{ asset('dist/js/vendor/jquery-3.7.1.min.js') }}"></script>

<!-- Swiper JS -->
<script src="{{ asset('dist/js/swiper-bundle.min.js') }}"></script>

<!-- Bootstrap -->
<script src="{{ asset('dist/js/bootstrap.min.js') }}"></script>

<!-- Magnific Popup -->
<script src="{{ asset('dist/js/jquery.magnific-popup.min.js') }}"></script>

<!-- Counter Up -->
<script src="{{ asset('dist/js/jquery.counterup.min.js') }}"></script>

<!-- Range Slider -->
<script src="{{ asset('dist/js/jquery-ui.min.js') }}"></script>

<!-- Isotope Filter -->
<script src="{{ asset('dist/js/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('dist/js/isotope.pkgd.min.js') }}"></script>

<!-- Wow JS -->
<script src="{{ asset('dist/js/wow.min.js') }}"></script>

<!-- GSAP Animation -->
<script src="{{ asset('dist/js/gsap.min.js') }}"></script>

<!-- ScrollTrigger -->
<script src="{{ asset('dist/js/ScrollTrigger.min.js') }}"></script>

<!-- SplitText -->
<script src="{{ asset('dist/js/SplitText.min.js') }}"></script>

<!-- Lenis JS -->
<script src="{{ asset('dist/js/lenis.min.js') }}"></script>

<!-- Pusher -->
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>

<!-- Main JS File -->
<script src="{{ asset('dist/js/main.js') }}"></script>

<script>
	(() => {
		const chatMessages = document.querySelector('.chat-messages'),
			chatInput = document.querySelector('.chat-input input'),
			chatToggles = document.querySelectorAll('.chat-toggle'),
			sendBtn = document.getElementById('sendBtn'),
			chatWindow = document.getElementById('chatWindow'),
			csrfMeta = document.querySelector('meta[name="csrf-token"]'),
			chatLeaveBtn = document.getElementById('chatLeaveBtn'),
			chatNewBtn = document.getElementById('chatNewBtn'),
			chatUnreadBadge = document.getElementById('chatUnreadBadge'),
			chatNotice = document.getElementById('chatNotice'),
			chatStatusText = document.getElementById('chatStatusText');

		if (!chatMessages || !chatInput || !sendBtn || !chatWindow || !csrfMeta) {
			return;
		}

		const pusherKey = @json(config('broadcasting.connections.pusher.key'));
		const pusherCluster = @json(config('broadcasting.connections.pusher.options.cluster'));
		const storageKey = 'public_chat_id';
		let currentChatId = localStorage.getItem(storageKey);
		let pusherInstance = null;
		let subscribedChannel = null;
		let seenMessages = {};
		let isChatClosed = false;
		let unreadCount = 0;
		let chatVisible = false;

		chatWindow.style.display = 'none';

		function containScrollEvents(node) {
			if (!node) {
				return;
			}

			node.addEventListener('wheel', function (event) {
				event.stopPropagation();
			}, { passive: true });

			node.addEventListener('touchmove', function (event) {
				event.stopPropagation();
			}, { passive: true });
		}

		containScrollEvents(chatWindow);
		containScrollEvents(chatMessages);

		function updateUnreadBadge() {
			if (!chatUnreadBadge) {
				return;
			}

			if (unreadCount > 0) {
				chatUnreadBadge.textContent = unreadCount;
				chatUnreadBadge.style.display = 'inline-flex';
			} else {
				chatUnreadBadge.style.display = 'none';
			}
		}

		function setNoticeVisible(visible) {
			if (!chatNotice) {
				return;
			}

			chatNotice.style.display = visible ? 'block' : 'none';
		}

		function setStatusText(text) {
			if (chatStatusText && text) {
				chatStatusText.textContent = text;
			}
		}

		function api(path, options) {
			const config = options || {};
			const headers = {
				Accept: 'application/json',
				'X-Requested-With': 'XMLHttpRequest',
				'X-CSRF-TOKEN': csrfMeta.getAttribute('content')
			};

			if (pusherInstance && pusherInstance.connection && pusherInstance.connection.socket_id) {
				headers['X-Socket-Id'] = pusherInstance.connection.socket_id;
			}

			config.headers = Object.assign(headers, config.headers || {});

			return fetch(path, config).then(function (response) {
				return response.json().then(function (json) {
					if (!response.ok) {
						throw json;
					}

					return json;
				});
			});
		}

		function renderMessage(message, senderType, messageId) {
			if (messageId && seenMessages[messageId]) {
				return;
			}

			if (messageId) {
				seenMessages[messageId] = true;
			}

			const messageNode = document.createElement('div');
			messageNode.className = 'msg ' + (senderType === 2 ? 'received' : 'sent');
			messageNode.textContent = message;
			chatMessages.appendChild(messageNode);
			chatMessages.scrollTop = chatMessages.scrollHeight;
			setNoticeVisible(false);
		}

		function setClosedState(closed) {
			isChatClosed = !!closed;
			chatInput.disabled = isChatClosed;
			sendBtn.disabled = isChatClosed;
			setStatusText(isChatClosed ? 'Chat closed' : 'New chat');
		}

		function subscribeToChat() {
			if (!window.Pusher || !pusherKey || !currentChatId) {
				return;
			}

			if (!pusherInstance) {
				pusherInstance = new Pusher(pusherKey, {
					cluster: pusherCluster,
					forceTLS: true
				});
			}

			if (subscribedChannel) {
				pusherInstance.unsubscribe(subscribedChannel.name);
			}

			subscribedChannel = pusherInstance.subscribe('public-chat.' + currentChatId);
			subscribedChannel.bind('chat.message.sent', function (eventData) {
				if (typeof eventData.status !== 'undefined') {
					setClosedState(parseInt(eventData.status, 10) === 2);
				}

				if (eventData.sender_type === 2) {
					renderMessage(eventData.message, 2, eventData.message_id);
					if (!chatVisible) {
						unreadCount += 1;
						updateUnreadBadge();
						setNoticeVisible(true);
						setStatusText('New reply');
					} else {
						unreadCount = 0;
						updateUnreadBadge();
						setNoticeVisible(false);
						setStatusText('New chat');
					}
				}
			});

			subscribedChannel.bind('chat.status.updated', function (eventData) {
				setClosedState(parseInt(eventData.status, 10) === 2);
			});
		}

		function loadMessages(chatId) {
			return api('{{ url('chat') }}/' + encodeURIComponent(chatId) + '/messages').then(function (data) {
				chatMessages.innerHTML = '';
				seenMessages = {};
				setClosedState(parseInt(data.status, 10) === 2);

				if (!data.messages.length) {
					renderMessage('Hi there! How can we help you today?', 2);
					return;
				}

				data.messages.forEach(function (message) {
					renderMessage(message.message, message.sender_type, message.id);
				});
			});
		}

		function ensureSession() {
			return api('{{ route('chat.session') }}', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json'
				},
				body: JSON.stringify({
					chat_id: currentChatId || null
				})
			}).then(function (data) {
				currentChatId = data.chat_id;
				localStorage.setItem(storageKey, currentChatId);
				setClosedState(parseInt(data.status, 10) === 2);
				subscribeToChat();
				return loadMessages(currentChatId);
			});
		}

		function leaveChat() {
			if (!currentChatId) {
				return;
			}

			api('{{ url('chat') }}/' + encodeURIComponent(currentChatId) + '/leave', {
				method: 'POST'
			}).finally(function () {
				currentChatId = null;
				localStorage.removeItem(storageKey);
				chatMessages.innerHTML = '';
				seenMessages = {};
				unreadCount = 0;
				updateUnreadBadge();
				setNoticeVisible(false);
				setClosedState(false);
				chatMessages.innerHTML = '<div class="msg received">Hi there! How can we help you today?</div>';
				setStatusText('New chat');
			});
		}

		function startNewChat() {
			if (!currentChatId) {
				chatMessages.innerHTML = '<div class="msg received">Hi there! How can we help you today?</div>';
				setNoticeVisible(false);
				setStatusText('New chat');
				return ensureSession();
			}

			return api('{{ url('chat') }}/' + encodeURIComponent(currentChatId) + '/leave', {
				method: 'POST'
			}).finally(function () {
				currentChatId = null;
				localStorage.removeItem(storageKey);
				seenMessages = {};
				unreadCount = 0;
				updateUnreadBadge();
				setNoticeVisible(false);
				chatMessages.innerHTML = '<div class="msg received">Hi there! How can we help you today?</div>';
				setStatusText('New chat');
				return ensureSession();
			});
		}

		function toggleChat() {
			chatWindow.style.display = chatWindow.style.display === 'flex' ? 'none' : 'flex';
			chatVisible = chatWindow.style.display === 'flex';
			if (chatWindow.style.display === 'flex') {
				chatInput.focus();
				unreadCount = 0;
				updateUnreadBadge();
				setNoticeVisible(false);
				if (!currentChatId) {
					ensureSession();
				}
			}
		}

		function sendMessage() {
			const messageText = chatInput.value.trim();

			if (!messageText || !currentChatId || isChatClosed) {
				return;
			}

			sendBtn.disabled = true;

			api('{{ url('chat') }}/' + encodeURIComponent(currentChatId) + '/message', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json'
				},
				body: JSON.stringify({ message: messageText })
			}).then(function (message) {
				renderMessage(message.message, 1, message.id);
				chatInput.value = '';
			}).finally(function () {
				sendBtn.disabled = isChatClosed;
			});
		}

		chatToggles.forEach(function (chatToggle) {
			chatToggle.addEventListener('click', toggleChat);
		});

		if (chatLeaveBtn) {
			chatLeaveBtn.addEventListener('click', leaveChat);
		}

		if (chatNewBtn) {
			chatNewBtn.addEventListener('click', startNewChat);
		}

		chatInput.addEventListener('keypress', function (event) {
			if (event.key === 'Enter') {
				event.preventDefault();
				sendMessage();
			}
		});

		sendBtn.addEventListener('click', sendMessage);

		ensureSession();
	})();
</script>

@yield('extra_js')
