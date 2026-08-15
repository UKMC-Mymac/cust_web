@extends('admin.layouts.master')
@section('title', $title)

@section('page_css')
<style>
    .chat-layout {
        min-height: 70vh;
        border: 1px solid #dfe4ea;
        border-radius: 12px;
        overflow: hidden;
        background: #fff;
    }

    .chat-sidebar {
        border-right: 1px solid #e7ecf2;
        background: #f8fafc;
        height: 70vh;
        display: flex;
        flex-direction: column;
    }

    .chat-sidebar-list {
        overflow-y: auto;
        flex: 1;
    }

    .chat-thread-item {
        cursor: pointer;
        border-bottom: 1px solid #edf2f7;
        padding: 12px;
    }

    .chat-thread-item.active {
        background: #e6f0f7;
    }

    .chat-content {
        height: 70vh;
        display: flex;
        flex-direction: column;
    }

    .chat-content-body {
        flex: 1;
        overflow-y: auto;
        padding: 16px;
        background: #f6f9fc;
    }

    .chat-bubble {
        max-width: 78%;
        border-radius: 12px;
        padding: 9px 12px;
        margin-bottom: 10px;
        font-size: 13px;
        line-height: 1.4;
    }

    .chat-bubble.visitor {
        background: #fff;
        border: 1px solid #dde5ee;
    }

    .chat-bubble.admin {
        margin-left: auto;
        background: #dceefb;
        border: 1px solid #c2dff6;
    }
</style>
@endsection

@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block p-0">
                        <div class="row g-0 chat-layout">
                            <div class="col-lg-4">
                                <aside class="chat-sidebar">
                                    <div class="p-3 border-bottom">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h5 class="mb-0">Live Chat</h5>
                                            @if(Auth::user()->is_admin == 1 || Auth::user()->hasRole('super-admin'))
                                            <button type="button" id="deleteAllChatsBtn" class="btn btn-xs btn-outline-danger" title="Delete All Chats"><i class="fas fa-trash-alt"></i> Delete All</button>
                                            @endif
                                        </div>
                                        <input type="text" id="threadSearch" class="form-control" placeholder="Search by chat ID or visitor">
                                    </div>
                                    <div id="threadList" class="chat-sidebar-list"></div>
                                </aside>
                            </div>
                            <div class="col-lg-8">
                                <section class="chat-content">
                                    <div class="d-flex justify-content-between align-items-center border-bottom px-3 py-2">
                                        <div>
                                            <h6 id="chatHeaderTitle" class="mb-0">Select a chat</h6>
                                            <small id="chatHeaderMeta" class="text-muted"></small>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <button type="button" id="toggleStatusBtn" class="btn btn-sm btn-outline-secondary d-none">Close Chat</button>
                                            @if(Auth::user()->is_admin == 1 || Auth::user()->hasRole('super-admin'))
                                            <button type="button" id="deleteChatBtn" class="btn btn-sm btn-outline-danger d-none ms-2"><i class="fas fa-trash-alt"></i> Delete Chat</button>
                                            @endif
                                        </div>
                                    </div>
                                    <div id="chatMessages" class="chat-content-body"></div>
                                    <div class="border-top p-3">
                                        <div class="input-group">
                                            <textarea id="adminMessageInput" class="form-control" rows="2" placeholder="Reply to visitor" disabled></textarea>
                                            <button id="adminSendBtn" class="btn btn-primary" type="button" disabled>Send</button>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page_js')
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script>
    (function () {
        var threadList = document.getElementById('threadList');
        var threadSearch = document.getElementById('threadSearch');
        var chatHeaderTitle = document.getElementById('chatHeaderTitle');
        var chatHeaderMeta = document.getElementById('chatHeaderMeta');
        var chatMessages = document.getElementById('chatMessages');
        var adminMessageInput = document.getElementById('adminMessageInput');
        var adminSendBtn = document.getElementById('adminSendBtn');
        var toggleStatusBtn = document.getElementById('toggleStatusBtn');

        if (!threadList || !chatMessages) {
            return;
        }

        var pusherKey = @json($pusherKey);
        var pusherCluster = @json($pusherCluster);

        var currentChatId = null;
        var currentStatus = 1;
        var channelMap = {};

        function api(path, options) {
            var config = options || {};
            var headers = {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            };

            if (window.__adminChatPusher && window.__adminChatPusher.connection && window.__adminChatPusher.connection.socket_id) {
                headers['X-Socket-Id'] = window.__adminChatPusher.connection.socket_id;
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

        function renderThreadItem(thread) {
            var wrapper = document.createElement('div');
            wrapper.className = 'chat-thread-item' + (thread.chat_id === currentChatId ? ' active' : '');
            wrapper.dataset.chatId = thread.chat_id;

            var title = thread.visitor_name ? thread.visitor_name : thread.chat_id;
            var preview = thread.last_message ? thread.last_message : 'No messages yet';
            var status = thread.status === 2 ? 'Closed' : 'Open';

            wrapper.innerHTML =
                '<div class="d-flex justify-content-between align-items-center">' +
                    '<strong>' + escapeHtml(title) + '</strong>' +
                    '<span class="badge ' + (thread.status === 2 ? 'bg-secondary' : 'bg-success') + '">' + status + '</span>' +
                '</div>' +
                '<div class="small text-muted">' + escapeHtml(thread.chat_id) + '</div>' +
                '<div class="small mt-1 text-truncate">' + escapeHtml(preview) + '</div>';

            wrapper.addEventListener('click', function () {
                openThread(thread.chat_id);
            });

            return wrapper;
        }

        function renderThreads(threads) {
            threadList.innerHTML = '';

            if (!threads.length) {
                threadList.innerHTML = '<div class="p-3 text-muted small">No chat found.</div>';
                return;
            }

            threads.forEach(function (thread) {
                threadList.appendChild(renderThreadItem(thread));
                ensureThreadSubscription(thread.chat_id);
            });
        }

        function renderMessage(message) {
            var bubble = document.createElement('div');
            bubble.className = 'chat-bubble ' + (message.sender_type === 2 ? 'admin' : 'visitor');
            bubble.innerHTML = '<div>' + escapeHtml(message.message) + '</div>';
            chatMessages.appendChild(bubble);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function renderSystemNotice(text) {
            var notice = document.createElement('div');
            notice.className = 'text-center text-muted small my-2';
            notice.innerHTML = '<span class="badge bg-light text-dark border">' + escapeHtml(text) + '</span>';
            chatMessages.appendChild(notice);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function loadThreads() {
            var search = encodeURIComponent((threadSearch.value || '').trim());
            api('{{ route($route . '.threads') }}?search=' + search)
                .then(function (threads) {
                    renderThreads(threads);
                })
                .catch(function () {
                    threadList.innerHTML = '<div class="p-3 text-danger small">Failed to load chats.</div>';
                });
        }

        function openThread(chatId) {
            currentChatId = chatId;
            chatMessages.innerHTML = '';

            api('{{ url('admin/chat') }}/' + encodeURIComponent(chatId) + '/messages')
                .then(function (data) {
                    currentStatus = data.status;
                    chatHeaderTitle.textContent = 'Chat: ' + data.chat_id;
                    chatHeaderMeta.textContent = data.assigned_to ? 'Assigned to: ' + data.assigned_to : 'Unassigned';

                    adminMessageInput.disabled = currentStatus === 2;
                    adminSendBtn.disabled = currentStatus === 2;
                    toggleStatusBtn.classList.remove('d-none');
                    toggleStatusBtn.textContent = currentStatus === 2 ? 'Reopen Chat' : 'Close Chat';

                    var deleteChatBtn = document.getElementById('deleteChatBtn');
                    if (deleteChatBtn) {
                        deleteChatBtn.classList.remove('d-none');
                    }

                    data.messages.forEach(renderMessage);
                    loadThreads();
                })
                .catch(function () {
                    chatHeaderTitle.textContent = 'Unable to open chat';
                });
        }

        function sendReply() {
            if (!currentChatId) {
                return;
            }

            var text = adminMessageInput.value.trim();
            if (!text) {
                return;
            }

            adminSendBtn.disabled = true;

            api('{{ url('admin/chat') }}/' + encodeURIComponent(currentChatId) + '/message', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({message: text})
            }).then(function (message) {
                renderMessage(message);
                adminMessageInput.value = '';
                loadThreads();
            }).catch(function (error) {
                if (error && parseInt(error.status, 10) === 2) {
                    currentStatus = 2;
                    adminMessageInput.disabled = true;
                    adminSendBtn.disabled = true;
                    toggleStatusBtn.textContent = 'Reopen Chat';
                    renderSystemNotice('This chat is closed. Reopen it before replying.');
                    loadThreads();
                }
            }).finally(function () {
                adminSendBtn.disabled = currentStatus === 2;
            });
        }

        function toggleStatus() {
            if (!currentChatId) {
                return;
            }

            var nextStatus = currentStatus === 2 ? 1 : 2;

            api('{{ url('admin/chat') }}/' + encodeURIComponent(currentChatId) + '/status', {
                method: 'PATCH',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({status: nextStatus})
            }).then(function (data) {
                currentStatus = data.status;
                adminMessageInput.disabled = currentStatus === 2;
                adminSendBtn.disabled = currentStatus === 2;
                toggleStatusBtn.textContent = currentStatus === 2 ? 'Reopen Chat' : 'Close Chat';
                loadThreads();
            });
        }

        function ensureThreadSubscription(chatId) {
            if (!window.Pusher || !pusherKey || channelMap[chatId]) {
                return;
            }

            if (!window.__adminChatPusher) {
                window.__adminChatPusher = new Pusher(pusherKey, {
                    cluster: pusherCluster,
                    forceTLS: true
                });

                var inboxChannel = window.__adminChatPusher.subscribe('admin-chat.inbox');
                inboxChannel.bind('chat.message.sent', function () {
                    loadThreads();
                });
                inboxChannel.bind('chat.status.updated', function (eventData) {
                    if (eventData.chat_id === currentChatId) {
                        currentStatus = parseInt(eventData.status, 10);
                        adminMessageInput.disabled = currentStatus === 2;
                        adminSendBtn.disabled = currentStatus === 2;
                        toggleStatusBtn.textContent = currentStatus === 2 ? 'Reopen Chat' : 'Close Chat';

                        if (eventData.updated_by === 'visitor' && currentStatus === 2) {
                            renderSystemNotice('Visitor left the chat.');
                        } else if (eventData.updated_by === 'admin' && currentStatus === 2) {
                            renderSystemNotice('Support closed this chat.');
                        } else if (currentStatus === 1) {
                            renderSystemNotice('Chat was reopened.');
                        }
                    }

                    loadThreads();
                });
            }

            var channel = window.__adminChatPusher.subscribe('public-chat.' + chatId);
            channel.bind('chat.message.sent', function (eventData) {
                if (eventData.chat_id === currentChatId) {
                    renderMessage(eventData);
                }
                loadThreads();
            });

            channel.bind('chat.status.updated', function (eventData) {
                if (eventData.chat_id === currentChatId) {
                    currentStatus = parseInt(eventData.status, 10);
                    adminMessageInput.disabled = currentStatus === 2;
                    adminSendBtn.disabled = currentStatus === 2;
                    toggleStatusBtn.textContent = currentStatus === 2 ? 'Reopen Chat' : 'Close Chat';

                    if (eventData.updated_by === 'visitor' && currentStatus === 2) {
                        renderSystemNotice('Visitor left the chat.');
                    } else if (eventData.updated_by === 'admin' && currentStatus === 2) {
                        renderSystemNotice('Support closed this chat.');
                    } else if (currentStatus === 1) {
                        renderSystemNotice('Chat was reopened.');
                    }
                }

                loadThreads();
            });

            channelMap[chatId] = true;
        }

        function escapeHtml(value) {
            return String(value || '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function deleteChat() {
            if (!currentChatId) {
                return;
            }

            if (!confirm('Are you sure you want to permanently delete this chat history? This cannot be undone.')) {
                return;
            }

            var deleteChatBtn = document.getElementById('deleteChatBtn');
            if (deleteChatBtn) {
                deleteChatBtn.disabled = true;
            }

            api('{{ url('admin/chat') }}/' + encodeURIComponent(currentChatId), {
                method: 'DELETE'
            }).then(function (data) {
                currentChatId = null;
                chatMessages.innerHTML = '';
                chatHeaderTitle.textContent = 'Select a chat';
                chatHeaderMeta.textContent = '';
                adminMessageInput.disabled = true;
                adminSendBtn.disabled = true;
                toggleStatusBtn.classList.add('d-none');
                
                if (deleteChatBtn) {
                    deleteChatBtn.classList.add('d-none');
                }

                loadThreads();
            }).catch(function (error) {
                alert(error.message || 'Failed to delete chat.');
            }).finally(function() {
                if (deleteChatBtn) {
                    deleteChatBtn.disabled = false;
                }
            });
        }

        function deleteAllChats() {
            if (!confirm('Are you sure you want to permanently delete ALL chats and their messages? This cannot be undone.')) {
                return;
            }

            var deleteAllChatsBtn = document.getElementById('deleteAllChatsBtn');
            if (deleteAllChatsBtn) {
                deleteAllChatsBtn.disabled = true;
            }

            api('{{ route($route . '.destroy-all') }}', {
                method: 'DELETE'
            }).then(function (data) {
                currentChatId = null;
                chatMessages.innerHTML = '';
                chatHeaderTitle.textContent = 'Select a chat';
                chatHeaderMeta.textContent = '';
                adminMessageInput.disabled = true;
                adminSendBtn.disabled = true;
                toggleStatusBtn.classList.add('d-none');
                
                var deleteChatBtn = document.getElementById('deleteChatBtn');
                if (deleteChatBtn) {
                    deleteChatBtn.classList.add('d-none');
                }

                loadThreads();
                alert('All chats deleted successfully.');
            }).catch(function (error) {
                alert(error.message || 'Failed to delete all chats.');
            }).finally(function() {
                if (deleteAllChatsBtn) {
                    deleteAllChatsBtn.disabled = false;
                }
            });
        }

        threadSearch.addEventListener('input', loadThreads);
        adminSendBtn.addEventListener('click', sendReply);
        adminMessageInput.addEventListener('keydown', function (event) {
            if ((event.ctrlKey || event.metaKey) && event.key === 'Enter') {
                event.preventDefault();
                sendReply();
            }
        });
        toggleStatusBtn.addEventListener('click', toggleStatus);
        
        var deleteChatBtn = document.getElementById('deleteChatBtn');
        if (deleteChatBtn) {
            deleteChatBtn.addEventListener('click', deleteChat);
        }

        var deleteAllChatsBtn = document.getElementById('deleteAllChatsBtn');
        if (deleteAllChatsBtn) {
            deleteAllChatsBtn.addEventListener('click', deleteAllChats);
        }

        loadThreads();
    })();
</script>
@endsection
