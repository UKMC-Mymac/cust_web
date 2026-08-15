    <!-- Required Js -->
    <script src="{{ asset('plugins/jquery/js/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/popper/js/popper.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-scrollbar/js/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('js/pcoded.min.js') }}"></script>

    <!-- select2 Js -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

    <!-- datatable Js -->
    <script src="{{ asset('plugins/data-tables/js/datatables.min.js') }}"></script>
    <script src="{{ asset('plugins/tinymce/tinymce.min.js') }}"></script>
    <script>
        if (window.tinymce && typeof window.tinymce.overrideDefaults === 'function') {
            window.tinymce.overrideDefaults({
                service_message: '',
                promotion: false,
                api_key: ''
            });
        }
    </script>

    <script type="text/javascript">
    (function () {
        "use strict";

        if (!window.tinymce) {
            console.error('TinyMCE failed to load');
            return;
        }

        @php
            $editorPages = \App\Models\Web\Page::query()
                ->where('status', 1)
                ->where('language_id', \App\Models\Language::version()->id)
                ->orderBy('title')
                ->get(['id', 'title', 'slug']);
        @endphp
        window.pageLinkPages = @json($editorPages);

        @php
            $editorMembers = \App\Models\Web\Member::query()
                ->where('status', 1)
                ->orderBy('name')
                ->get(['id', 'name', 'designation', 'slug', 'description'])
                ->map(function ($member) {
                    $image = null;

                    if (!empty($member->description) && preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $member->description, $matches)) {
                        $image = $matches[1];
                    }

                    return [
                        'id' => $member->id,
                        'name' => $member->name,
                        'designation' => $member->designation,
                        'slug' => $member->slug,
                        'image' => $image,
                    ];
                })->values();
            $activeLanguage = \App\Models\Language::version();
        @endphp

        var isRtl = @json(optional($activeLanguage)->direction == 1);
        var pageLinkRouteTemplate = @json(route('page.single', ['slug' => '__PAGE_SLUG__'], false));
        var memberRouteTemplate = @json(route('members.single', ['slug' => '__MEMBER_SLUG__'], false));
        var editorMembers = @json($editorMembers);
        var memberFallbackImage = @json(asset('dist/images/fallback_member.jpg'));

        function escapeHtml(value) {
            var element = document.createElement('div');
            element.textContent = value == null ? '' : String(value);
            return element.innerHTML;
        }

        function escapeAttr(value) {
            return String(value == null ? '' : value)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        function buildPageLinkHtml(page) {
            var safeTitle = page && page.title ? page.title : 'View page';
            var safeSlug = page && page.slug ? page.slug : '';
            var safeUrl = safeSlug ? pageLinkRouteTemplate.replace('__PAGE_SLUG__', encodeURIComponent(safeSlug)) : '#';

            return '<a class="page-inline-link" href="' + escapeAttr(safeUrl) + '" style="display:inline-flex;align-items:center;gap:8px;padding:5px 10px;border-radius:1px;background:#125875;color:#fff;font-weight:bold;text-decoration:none;">' +
                '<span>' + escapeHtml(safeTitle) + '</span>' +
            '</a>';
        }

        function getMemberSelectItems() {
            return (Array.isArray(editorMembers) ? editorMembers : []).map(function (member) {
                return {
                    text: member.name + (member.designation ? ' — ' + member.designation : ''),
                    value: String(member.id)
                };
            });
        }

        function findMemberById(memberId) {
            return (Array.isArray(editorMembers) ? editorMembers : []).find(function (member) {
                return String(member.id) === String(memberId);
            });
        }

        function buildMemberGridSelectorItems(columns) {
            var items = [];
            for (var index = 1; index <= columns; index++) {
                items.push({
                    type: 'selectbox',
                    name: 'member_' + index,
                    label: 'Member ' + index,
                    items: getMemberSelectItems()
                });
            }

            return items;
        }

        function openMemberGridMemberDialog(editor, columns) {
            var safeColumns = parseInt(columns, 10) || 2;
            if (safeColumns < 2) {
                safeColumns = 2;
            }
            if (safeColumns > 6) {
                safeColumns = 6;
            }

            var initialData = { columns: String(safeColumns) };
            for (var index = 1; index <= safeColumns; index++) {
                initialData['member_' + index] = '';
            }

            editor.windowManager.open({
                title: 'Select members',
                body: {
                    type: 'panel',
                    items: buildMemberGridSelectorItems(safeColumns)
                },
                buttons: [
                    { type: 'cancel', text: 'Cancel' },
                    { type: 'submit', text: 'Insert Row', primary: true }
                ],
                initialData: initialData,
                onSubmit: function (api) {
                    var data = api.getData();
                    api.close();

                    var selectedMembers = [];
                    for (var i = 1; i <= safeColumns; i++) {
                        var member = findMemberById(data['member_' + i]);
                        if (!member) {
                            continue;
                        }

                        var exists = selectedMembers.some(function (item) {
                            return String(item.id) === String(member.id);
                        });

                        if (!exists) {
                            selectedMembers.push(member);
                        }
                    }

                    if (!selectedMembers.length) {
                        editor.windowManager.alert('Please select at least one member');
                        return;
                    }

                    editor.insertContent(buildMemberGridHtml(selectedMembers));
                }
            });
        }

        function buildMemberHtml(member, align) {
            if (align) {
                member = member || {};
                member.align = align;
            }
            var safeName = member && member.name ? member.name : 'Member';
            var safeDesignation = member && member.designation ? member.designation : '';
            var safeSlug = member && member.slug ? member.slug : safeName.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
            var safeUrl = safeSlug ? memberRouteTemplate.replace('__MEMBER_SLUG__', encodeURIComponent(safeSlug)) : '#';

            var alignClass = '';
            // default alignment is center when not specified
            if (member && member.align) {
                alignClass = ' align-' + String(member.align);
            }

            return '<a class="member-inline-link' + alignClass + '" href="' + escapeAttr(safeUrl) + '" style="display:inline-flex;flex-direction:column;align-items:flex-start;gap:2px;padding:8px 12px;border-radius:6px;background:#125875;color:#fff;text-decoration:none;white-space:normal;cursor:pointer;">' +
                '<span style="font-weight:700;line-height:1.2;">' + escapeHtml(safeName) + '</span>' +
                (safeDesignation ? '<small style="opacity:.9;line-height:1.2;">' + escapeHtml(safeDesignation) + '</small>' : '') +
            '</a>';
        }

        function buildMemberCardHtml(member, align) {
            var safeName = member && member.name ? member.name : 'Member';
            var safeDesignation = member && member.designation ? member.designation : '';
            var safeSlug = member && member.slug ? member.slug : safeName.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
            var safeUrl = safeSlug ? memberRouteTemplate.replace('__MEMBER_SLUG__', encodeURIComponent(safeSlug)) : '#';
            var img = member && member.image ? String(member.image) : (typeof memberFallbackImage !== 'undefined' ? memberFallbackImage : '/dist/images/fallback_member.jpg');

            var alignClass = '';
            if (align) {
                alignClass = ' align-' + String(align);
            }

            return '<table class="member-card-embed' + alignClass + '" role="presentation" cellspacing="0" cellpadding="0" style="width:100%;max-width:320px;border:1px solid #e6e9ef;border-radius:14px;background:#fff;border-collapse:separate;border-spacing:0;overflow:hidden;margin:0;">' +
                '<tr><td style="padding:0;"><img src="' + escapeAttr(img) + '" alt="' + escapeAttr(safeName) + '" style="width:100%;aspect-ratio:1 / 1;object-fit:cover;object-position:center;display:block;" /></td></tr>' +
                '<tr><td style="padding:12px 14px 6px;text-align:center;"><a class="member-card-link" href="' + escapeAttr(safeUrl) + '" style="color:#0f3a4f;text-decoration:none;font-weight:700;line-height:1.35;display:inline-block;">' + escapeHtml(safeName) + '</a></td></tr>' +
                (safeDesignation ? '<tr><td style="padding:0 14px 14px;text-align:center;font-size:13px;line-height:1.45;color:#5f7380;">' + escapeHtml(safeDesignation) + '</td></tr>' : '') +
            '</table>';
        }

        function buildMemberGridHtml(members) {
            var selectedMembers = Array.isArray(members) ? members.filter(function (member) {
                return member && member.id;
            }) : [];

            if (!selectedMembers.length) {
                return '';
            }

            var cellWidth = (100 / selectedMembers.length).toFixed(4) + '%';

            return '<div class="is-member-grid-wrap" style="overflow-x:auto;margin:1rem 0;">' +
                '<table class="is-member-grid" role="presentation" cellspacing="0" cellpadding="0" style="width:100%;table-layout:fixed;border-collapse:separate;border-spacing:12px 0;">' +
                    '<tr>' + selectedMembers.map(function (member) {
                        var safeName = member.name || 'Member';
                        var safeDesignation = member.designation || '';
                        var safeSlug = member.slug || safeName.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
                        var safeUrl = safeSlug ? memberRouteTemplate.replace('__MEMBER_SLUG__', encodeURIComponent(safeSlug)) : '#';
                        var img = member.image ? String(member.image) : (typeof memberFallbackImage !== 'undefined' ? memberFallbackImage : '/dist/images/fallback_member.jpg');

                        return '<td style="width:' + cellWidth + ';vertical-align:top;">' +
                            '<table class="is-member-grid-card" role="presentation" cellspacing="0" cellpadding="0" style="width:100%;border:1px solid #e6e9ef;border-radius:14px;background:#fff;border-collapse:separate;border-spacing:0;overflow:hidden;">' +
                                '<tr><td style="padding:0;"><img src="' + escapeAttr(img) + '" alt="' + escapeAttr(safeName) + '" style="width:100%;aspect-ratio:1 / 1;object-fit:cover;object-position:center;display:block;" /></td></tr>' +
                                '<tr><td style="padding:12px 14px 6px;text-align:center;"><a class="is-member-grid-link" href="' + escapeAttr(safeUrl) + '" style="color:#0f3a4f;text-decoration:none;font-weight:700;line-height:1.35;display:inline-block;">' + escapeHtml(safeName) + '</a></td></tr>' +
                                (safeDesignation ? '<tr><td style="padding:0 14px 14px;text-align:center;font-size:13px;line-height:1.45;color:#5f7380;">' + escapeHtml(safeDesignation) + '</td></tr>' : '') +
                            '</table>' +
                        '</td>';
                    }).join('') + '</tr>' +
                '</table>' +
            '</div>';
        }

        function buildEmailLinkHtml(emailAddress, label) {
            var safeEmail = emailAddress ? String(emailAddress).trim() : '';
            var safeLabel = label ? String(label).trim() : safeEmail;
            var href = safeEmail ? 'mailto:' + safeEmail : '#';

            return '<a class="contact-inline-link contact-inline-email" href="' + escapeAttr(href) + '" style="display:inline-flex;align-items:center;gap:8px;padding:5px 10px;border-radius:1px;background:#125875;color:#fff;font-weight:bold;text-decoration:none;">' +
                '<span>' + escapeHtml(safeLabel || 'Email') + '</span>' +
            '</a>';
        }

        function buildPhoneLinkHtml(phoneNumber, label) {
            var safePhone = phoneNumber ? String(phoneNumber).trim() : '';
            var safeLabel = label ? String(label).trim() : safePhone;
            var normalizedPhone = safePhone.replace(/[^0-9+]/g, '');
            var href = normalizedPhone ? 'tel:' + normalizedPhone : '#';

            return '<a class="contact-inline-link contact-inline-phone" href="' + escapeAttr(href) + '" style="display:inline-flex;align-items:center;gap:8px;padding:5px 10px;border-radius:1px;background:#125875;color:#fff;font-weight:bold;text-decoration:none;">' +
                '<span>' + escapeHtml(safeLabel || 'Phone') + '</span>' +
            '</a>';
        }

        function registerMemberLink(editor) {
            try {
                var buttons = editor.ui && editor.ui.registry && typeof editor.ui.registry.getAll === 'function'
                    ? editor.ui.registry.getAll().buttons || {}
                    : {};

                if (buttons.memberLink || buttons.memberlink) {
                    return;
                }

                editor.ui.registry.addButton('pageLink', {
                    text: 'Page Link',
                    onAction: function () {
                        var pageItems = Array.isArray(window.pageLinkPages) ? window.pageLinkPages : [];

                        editor.windowManager.open({
                            title: 'Insert page link',
                            body: {
                                type: 'panel',
                                items: [
                                    {
                                        type: 'selectbox',
                                        name: 'page_id',
                                        label: 'Select page',
                                        items: pageItems.map(function (page) {
                                            return { text: page.title, value: String(page.id) };
                                        })
                                    },
                                    {
                                        type: 'input',
                                        name: 'label',
                                        label: 'Link text',
                                        placeholder: 'Leave empty to use the page title'
                                    }
                                ]
                            },
                            buttons: [
                                { type: 'cancel', text: 'Cancel' },
                                { type: 'submit', text: 'Insert', primary: true }
                            ],
                            initialData: { page_id: '', label: '' },
                            onSubmit: function (api) {
                                var data = api.getData();
                                var selectedPage = pageItems.find(function (page) {
                                    return String(page.id) === String(data.page_id);
                                });

                                if (!selectedPage) {
                                    return;
                                }

                                editor.insertContent(buildPageLinkHtml({
                                    id: selectedPage.id,
                                    title: data.label && data.label.trim() ? data.label.trim() : selectedPage.title,
                                    slug: selectedPage.slug
                                }));

                                api.close();
                            }
                        });
                    }
                });

                editor.ui.registry.addButton('memberLink', {
                    text: 'Member',
                    onAction: function () {
                        editor.windowManager.open({
                            title: 'Select member',
                            body: {
                                type: 'panel',
                                items: [
                                                { type: 'selectbox', name: 'member_id', label: 'Member', items: getMemberSelectItems() },
                                                { type: 'input', name: 'label', label: 'Custom label', placeholder: 'Optional' },
                                                { type: 'checkbox', name: 'include_image', label: 'Include image (if available)' },
                                                { type: 'selectbox', name: 'align', label: 'Alignment', items: [
                                                    { text: 'Left', value: 'left' },
                                                    { text: 'Center', value: 'center' },
                                                    { text: 'Right', value: 'right' }
                                                ] }
                                ]
                            },
                            buttons: [
                                { type: 'cancel', text: 'Cancel' },
                                { type: 'submit', text: 'Insert', primary: true }
                            ],
                            initialData: { member_id: '', label: '', include_image: true },
                            onSubmit: function (api) {
                                var data = api.getData();
                                api.close();

                                var selected = findMemberById(data.member_id);
                                if (!selected) {
                                    editor.windowManager.alert('Please select a member');
                                    return;
                                }

                                var label = data.label && String(data.label).trim() ? String(data.label).trim() : selected.name;
                                var includeImage = !!data.include_image;
                                var align = data.align || 'center';

                                var payload = {
                                    id: selected.id,
                                    name: label,
                                    designation: selected.designation,
                                    slug: selected.slug,
                                    image: selected.image || ''
                                };

                                if (includeImage) {
                                    editor.insertContent(buildMemberCardHtml(payload, align));
                                } else {
                                    // inline member link can also carry alignment class if needed
                                    editor.insertContent(buildMemberHtml(payload, align));
                                }
                            }
                        });
                    }
                });

                editor.ui.registry.addButton('memberGrid', {
                    text: 'Member Row',
                    onAction: function () {
                        editor.windowManager.open({
                            title: 'Choose row columns',
                            body: {
                                type: 'panel',
                                items: [
                                    { type: 'selectbox', name: 'columns', label: 'Columns', items: [
                                        { text: '2 columns', value: '2' },
                                        { text: '3 columns', value: '3' },
                                        { text: '4 columns', value: '4' },
                                        { text: '5 columns', value: '5' },
                                        { text: '6 columns', value: '6' }
                                    ]},
                                ]
                            },
                            buttons: [
                                { type: 'cancel', text: 'Cancel' },
                                { type: 'submit', text: 'Next', primary: true }
                            ],
                            initialData: { columns: '2' },
                            onSubmit: function (api) {
                                var data = api.getData();
                                api.close();

                                var wantedColumns = parseInt(data.columns, 10) || 2;
                                if (wantedColumns < 2) {
                                    wantedColumns = 2;
                                }
                                if (wantedColumns > 6) {
                                    wantedColumns = 6;
                                }

                                openMemberGridMemberDialog(editor, wantedColumns);
                            }
                        });
                    }
                });

                editor.ui.registry.addButton('emailLink', {
                    text: 'Email',
                    onAction: function () {
                        editor.windowManager.open({
                            title: 'Insert email link',
                            body: {
                                type: 'panel',
                                items: [
                                    { type: 'input', name: 'email', label: 'Email address', placeholder: 'name@example.com' },
                                    { type: 'input', name: 'label', label: 'Link text', placeholder: 'Leave empty to use the email address' }
                                ]
                            },
                            buttons: [
                                { type: 'cancel', text: 'Cancel' },
                                { type: 'submit', text: 'Insert', primary: true }
                            ],
                            initialData: { email: '', label: '' },
                            onSubmit: function (api) {
                                var data = api.getData();

                                if (!data.email || !String(data.email).trim()) {
                                    return;
                                }

                                editor.insertContent(buildEmailLinkHtml(data.email, data.label));
                                api.close();
                            }
                        });
                    }
                });

                editor.ui.registry.addButton('phoneLink', {
                    text: 'Phone',
                    onAction: function () {
                        editor.windowManager.open({
                            title: 'Insert phone link',
                            body: {
                                type: 'panel',
                                items: [
                                    { type: 'input', name: 'phone', label: 'Phone number', placeholder: '+1234567890' },
                                    { type: 'input', name: 'label', label: 'Link text', placeholder: 'Leave empty to use the phone number' }
                                ]
                            },
                            buttons: [
                                { type: 'cancel', text: 'Cancel' },
                                { type: 'submit', text: 'Insert', primary: true }
                            ],
                            initialData: { phone: '', label: '' },
                            onSubmit: function (api) {
                                var data = api.getData();

                                if (!data.phone || !String(data.phone).trim()) {
                                    return;
                                }

                                editor.insertContent(buildPhoneLinkHtml(data.phone, data.label));
                                api.close();
                            }
                        });
                    }
                });

                editor.ui.registry.addButton('uploadFile', {
                    icon: 'upload',
                    tooltip: 'Upload File (PDF, Word, Zip, etc.)',
                    onAction: function () {
                        var fileInput = document.createElement('input');
                        fileInput.type = 'file';
                        fileInput.accept = '.jpg,.jpeg,.png,.gif,.ico,.svg,.webp,.pdf,.doc,.docx,.txt,.zip,.rar,.csv,.xls,.xlsx,.ppt,.pptx,.mp3,.avi,.mp4,.mpeg,.3gp,.mov,.ogg,.mkv';
                        
                        fileInput.onchange = function () {
                            var file = fileInput.files[0];
                            if (!file) return;

                            var formData = new FormData();
                            formData.append('file', file);

                            editor.setProgressState(true);

                            var xhr = new XMLHttpRequest();
                            xhr.open('POST', '{{ route('admin.page.upload') }}');

                            var tokenMeta = document.querySelector('meta[name="csrf-token"]') || document.querySelector('meta[name="_token"]');
                            if (tokenMeta) {
                                xhr.setRequestHeader('X-CSRF-TOKEN', tokenMeta.getAttribute('content'));
                            }

                            xhr.onload = function () {
                                editor.setProgressState(false);
                                if (xhr.status !== 200) {
                                    alert('HTTP Error: ' + xhr.status);
                                    return;
                                }

                                var json = JSON.parse(xhr.responseText);
                                if (!json || typeof json.location !== 'string') {
                                    alert('Invalid response from server.');
                                    return;
                                }

                                var fileUrl = json.location;
                                var fileName = file.name;
                                var extension = fileName.split('.').pop().toLowerCase();
                                
                                 var displayOptions = [
                                    { text: 'Insert as a beautiful Link Card', value: 'link_card' },
                                    { text: 'Insert as standard inline Text Link', value: 'simple_link' }
                                ];
                                if (extension === 'pdf') {
                                    displayOptions.unshift({ text: 'Embed as professional PDF Viewer Frame', value: 'frame' });
                                }

                                editor.windowManager.open({
                                    title: 'Configure File Display',
                                    body: {
                                        type: 'panel',
                                        items: [
                                            {
                                                type: 'selectbox',
                                                name: 'display_mode',
                                                label: 'Display Mode',
                                                items: displayOptions
                                            },
                                            {
                                                type: 'input',
                                                name: 'label',
                                                label: 'Label / Link Text (Optional)',
                                                placeholder: 'e.g., Click to view document'
                                            },
                                            {
                                                type: 'selectbox',
                                                name: 'align',
                                                label: 'Alignment / Side Position',
                                                items: [
                                                    { text: 'Full Width / Inline (Center)', value: 'center' },
                                                    { text: 'Float Left', value: 'left' },
                                                    { text: 'Float Right', value: 'right' }
                                                ]
                                            },
                                            {
                                                type: 'selectbox',
                                                name: 'height',
                                                label: 'Frame Height (Only for Frame Embed)',
                                                items: [
                                                    { text: 'Small (450px)', value: '450px' },
                                                    { text: 'Medium (650px)', value: '650px' },
                                                    { text: 'Large (850px)', value: '850px' }
                                                ]
                                            }
                                        ]
                                    },
                                    buttons: [
                                        { type: 'cancel', text: 'Cancel' },
                                        { type: 'submit', text: 'Insert File', primary: true }
                                    ],
                                    initialData: {
                                        display_mode: extension === 'pdf' ? 'frame' : 'link_card',
                                        label: '',
                                        align: 'center',
                                        height: '650px'
                                    },
                                    onSubmit: function (api) {
                                        var data = api.getData();
                                        api.close();

                                        var safeLabel = data.label && data.label.trim() ? data.label.trim() : fileName;
                                        var alignment = data.align || 'center';

                                        if (data.display_mode === 'frame') {
                                            var containerStyle = 'position:relative;height:' + data.height + ';margin:20px 0;border-radius:14px;overflow:hidden;box-shadow:0 12px 32px rgba(13,43,62,0.15);border:1px solid rgba(18,88,117,0.12);background:#fff;';
                                            
                                            if (alignment === 'left') {
                                                containerStyle += 'width:48%;float:left;margin-right:24px;margin-bottom:24px;';
                                            } else if (alignment === 'right') {
                                                containerStyle += 'width:48%;float:right;margin-left:24px;margin-bottom:24px;';
                                            } else {
                                                containerStyle += 'width:100%;clear:both;';
                                            }

                                            var frameHtml = '<div class="pdf-frame-container align-' + alignment + '" style="' + containerStyle + '">' +
                                                '<iframe src="' + escapeAttr(fileUrl) + '" width="100%" height="100%" style="border:none;" allowfullscreen></iframe>' +
                                                '</div>';
                                            
                                            if (alignment !== 'center') {
                                                frameHtml += '<div style="clear:both;height:0;overflow:hidden;"></div>';
                                            }
                                            editor.insertContent(frameHtml);
                                        } else if (data.display_mode === 'link_card') {
                                            var cardStyle = '';
                                            if (alignment === 'left') {
                                                cardStyle = 'float:left;margin-right:16px;margin-bottom:16px;';
                                            } else if (alignment === 'right') {
                                                cardStyle = 'float:right;margin-left:16px;margin-bottom:16px;';
                                            }
                                            var linkHtml = '<a class="editor-file-link ext-' + escapeAttr(extension) + ' align-' + alignment + '" style="' + cardStyle + '" href="' + escapeAttr(fileUrl) + '" target="_blank">' + escapeHtml(safeLabel) + '</a>';
                                            editor.insertContent(linkHtml);
                                        } else {
                                            var linkHtml = '<a class="pdf-simple-link" href="' + escapeAttr(fileUrl) + '" target="_blank">' + escapeHtml(safeLabel) + '</a>';
                                            editor.insertContent(linkHtml);
                                        }
                                    }
                                });
                            };

                            xhr.onerror = function () {
                                editor.setProgressState(false);
                                alert('Upload failed due to a network error.');
                            };

                            xhr.send(formData);
                        };
                        
                        fileInput.click();
                    }
                });

                editor.on('init change', function () {
                    editor.save();
                });

                console.log('memberLink registered for editor', editor.id || editor.targetElm || '(unknown)');
            } catch (error) {
                console.error('memberLink register error', error);
            }
        }

        tinymce.init({
            selector: '.texteditor',
            license_key: 'gpl',
            directionality: isRtl ? 'rtl' : 'ltr',
            language: '{{ optional($activeLanguage)->code ?? "en" }}',
            height: 540,
            plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen paste table media help wordcount emoticons quickbars autosave codesample directionality',
            toolbar: 'undo redo restoredraft | memberLink memberGrid pageLink uploadFile | blocks fontfamily fontsize | bold italic underline strikethrough forecolor backcolor removeformat | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | table image media link emailLink phoneLink codesample blockquote hr | charmap emoticons | code fullscreen preview',
            menubar: 'file edit view insert format tools table help',
            toolbar_mode: 'sliding',
            branding: false,
            resize: true,
            quickbars_selection_toolbar: 'bold italic underline | quicklink h2 h3 blockquote quickimage quicktable',
            quickbars_insert_toolbar: 'quickimage quicktable hr',
            contextmenu: 'link image table spellchecker',
            convert_urls: false,
            relative_urls: false,
            remove_script_host: false,
            paste_data_images: false,
            automatic_uploads: true,
            images_reuse_filename: false,
            images_upload_handler: function (blobInfo, success, failure) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('admin.page.upload') }}');

                var tokenMeta = document.querySelector('meta[name="csrf-token"]') || document.querySelector('meta[name="_token"]');
                if (tokenMeta) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', tokenMeta.getAttribute('content'));
                }

                xhr.onload = function () {
                    if (xhr.status !== 200) {
                        failure('HTTP Error: ' + xhr.status);
                        return;
                    }

                    var json = JSON.parse(xhr.responseText);
                    if (!json || typeof json.location !== 'string') {
                        failure('Invalid JSON: ' + xhr.responseText);
                        return;
                    }

                    success(json.location);
                };

                xhr.onerror = function () {
                    failure('Image upload failed due to a network error.');
                };

                var formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                xhr.send(formData);
            },
            content_style: 'body { font-family: Arial, Helvetica, sans-serif; font-size: 16px; line-height: 1.7; } img { max-width:100%; height:auto; }',
            setup: function (editor) {
                editor.ui.registry.addButton('pageLink', {
                    text: 'Page Link',
                    onAction: function () {
                        var pageItems = Array.isArray(window.pageLinkPages) ? window.pageLinkPages : [];

                        editor.windowManager.open({
                            title: 'Insert page link',
                            body: {
                                type: 'panel',
                                items: [
                                    {
                                        type: 'selectbox',
                                        name: 'page_id',
                                        label: 'Select page',
                                        items: pageItems.map(function (page) {
                                            return { text: page.title, value: String(page.id) };
                                        })
                                    },
                                    {
                                        type: 'input',
                                        name: 'label',
                                        label: 'Link text',
                                        placeholder: 'Leave empty to use the page title'
                                    }
                                ]
                            },
                            buttons: [
                                { type: 'cancel', text: 'Cancel' },
                                { type: 'submit', text: 'Insert', primary: true }
                            ],
                            initialData: { page_id: '', label: '' },
                            onSubmit: function (api) {
                                var data = api.getData();
                                var selectedPage = pageItems.find(function (page) {
                                    return String(page.id) === String(data.page_id);
                                });

                                if (!selectedPage) {
                                    return;
                                }

                                editor.insertContent(buildPageLinkHtml({
                                    id: selectedPage.id,
                                    title: data.label && data.label.trim() ? data.label.trim() : selectedPage.title,
                                    slug: selectedPage.slug
                                }));

                                api.close();
                            }
                        });
                    }
                });

                registerMemberLink(editor);
            }
        });

        document.addEventListener('tinymce-editor-init', function (event) {
            try {
                registerMemberLink(event && event.detail && event.detail.editor ? event.detail.editor : event.editor || event);
            } catch (error) {
                console.error(error);
            }
        });
    })();
    </script>
