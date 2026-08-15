@php
    $formRow = $row ?? null;
    $layoutMode = old('layout_mode', $layoutMode ?? (optional($formRow)->layout_mode ?? 'editor'));
    $contentValue = old('content_html', optional($formRow)->content_html ?? '');
    $builderSections = old('builder_sections') ? old('builder_sections') : ($builderSections ?? []);
    $pageLinkItems = isset($pages) ? $pages->map(function ($page) {
        return [
            'id' => $page->id,
            'title' => $page->title,
            'slug' => $page->slug,
        ];
    })->values() : collect([]);

    if (is_string($builderSections)) {
        $decodedSections = json_decode($builderSections, true);
        $builderSections = is_array($decodedSections) ? $decodedSections : [];
    }

    if (empty($builderSections) && $layoutMode === 'builder' && !empty(optional($formRow)->builder_sections)) {
        $builderSections = optional($formRow)->builder_sections;
    }

    if (empty($builderSections)) {
        $builderSections = [[
            'key' => uniqid('section_', false),
            'type' => 'content',
            'title' => '',
            'subtitle' => '',
            'content' => '',
            'image' => null,
            'image_position' => 'right',
            'image_alt' => '',
            'page_ids' => [],
        ]];
    }
@endphp

<div class="form-group col-md-12">
    <label for="title">{{ __('field_title') }} <span>*</span></label>
    <input type="text" class="form-control" name="title" id="title" value="{{ old('title', optional($formRow)->title) }}" required>

    <div class="invalid-feedback">
        {{ __('required_field') }} {{ __('field_title') }}
    </div>
</div>

<div class="form-group col-md-12">
    <label for="display_text">Display Text</label>
    <input type="text" class="form-control" name="display_text" id="display_text" value="{{ old('display_text', optional($formRow)->display_text) }}">
    <small class="text-muted">Used for breadcrumbs and headings on the frontend page layout. Defaults to Title if left empty.</small>
</div>

<div class="form-group col-md-6">
    <label for="layout_mode">Page Layout</label>
    @if(optional($formRow)->id)
        <select class="form-control" id="layout_mode" disabled>
            <option value="editor" @selected($layoutMode === 'editor')>Use content editor</option>
            <option value="builder" @selected($layoutMode === 'builder')>Use page builder</option>
        </select>
        <input type="hidden" name="layout_mode" value="{{ old('layout_mode', $layoutMode) }}">
    @else
        <select class="form-control" name="layout_mode" id="layout_mode">
            <option value="editor" @selected($layoutMode === 'editor')>Use content editor</option>
            <option value="builder" @selected($layoutMode === 'builder')>Use page builder</option>
        </select>
    @endif
    <small class="text-muted">Editor keeps the current single-content flow. Builder lets you arrange sections and linked pages.</small>
</div>

<div class="form-group col-md-12 editor-mode-field">
    <label for="content_html">{{ __('field_description') }} <span>*</span></label>
    <textarea class="form-control texteditor" name="content_html" id="content_html" rows="10">{{ $contentValue }}</textarea>
    <script>
        window.pageLinkPages = @json($pageLinkItems);
    </script>

    <div class="invalid-feedback">
        {{ __('required_field') }} {{ __('field_description') }}
    </div>
</div>

<div class="form-group col-md-12 builder-mode-field">
    <label class="form-label">Page Builder</label>
    <div class="alert alert-light border mb-3">
        Add as many sections as you need. Each section can contain styled text and an image aligned left or right.
    </div>

    <div class="card mb-3 p-3">
        <label class="form-label">Page Navigation</label>
        <div class="text-muted mb-2">Manage navigation buttons that will appear in the page sidebar (these are page-level and independent of individual sections).</div>
        <div class="row g-2 align-items-center">
            <div class="col-md-4">
                <label class="form-label">Nav position</label>
                <select class="form-control page-nav-position" name="page_nav_position">
                    <option value="left" {{ old('page_nav_position', $pageNavPosition ?? 'right') === 'left' ? 'selected' : '' }}>Left</option>
                    <option value="right" {{ old('page_nav_position', $pageNavPosition ?? 'right') === 'right' ? 'selected' : '' }}>Right</option>
                </select>
            </div>
            <div class="col-md-8 text-end">
                <button type="button" class="btn btn-outline-primary btn-sm d-inline-block mb-2 add-page-nav-item"><i class="fas fa-plus"></i> Add menu item</button>
            </div>
        </div>

        <div class="page-nav-items-list mt-2"></div>
        <input type="hidden" name="page_nav_items" class="page-nav-items-json" value="{{ old('page_nav_items', json_encode($pageNavItems ?? [])) }}">
    </div>

    <input type="hidden" name="builder_sections" class="builder-sections-json" value="">
    <div class="builder-sections-list"></div>
    <button type="button" class="btn btn-outline-primary btn-sm mt-3 add-builder-section">
        <i class="fas fa-plus"></i> Add Section
    </button>

    <div class="invalid-feedback d-block">
        @error('builder_sections') {{ $message }} @enderror
    </div>
</div>

<div class="form-group col-md-4">
    <label for="status" class="form-label">{{ __('select_status') }}</label>
    <select class="form-control" name="status" id="status">
        <option value="1" @selected(old('status', optional($formRow)->status ?? 1) == 1)>{{ __('status_active') }}</option>
        <option value="0" @selected(old('status', optional($formRow)->status ?? 1) == 0)>{{ __('status_inactive') }}</option>
    </select>
</div>

<style>
    .builder-section-row {
        border: 1px solid rgba(18, 88, 117, 0.12);
        border-radius: 22px;
        background: #fff;
        box-shadow: 0 10px 26px rgba(13, 43, 62, 0.06);
        padding: 18px;
        margin-bottom: 16px;
    }

    .builder-sections-list {
        display: grid;
        gap: 0;
    }

    .builder-section-menu-item {
        border: 1px dashed rgba(18, 88, 117, 0.14);
        border-radius: 16px;
        padding: 12px;
        margin-bottom: 10px;
        background: #fff;
    }

    .builder-section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-bottom: 14px;
    }

    .builder-section-row .form-label {
        font-weight: 600;
    }

    .builder-section-preview img {
        max-width: 100%;
        border-radius: 12px;
        display: block;
        margin-top: 10px;
    }

    .builder-section-image-preview {
        max-width: 220px;
        border-radius: 14px;
        display: block;
        margin-top: 10px;
    }

    .builder-nav-item {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 600px 120px auto;
        gap: 10px;
        align-items: center;
    }

    .builder-nav-item > * {
        min-width: 0;
    }

    .builder-nav-item .form-control,
    .builder-nav-item .btn {
        width: 100%;
    }

    /* .builder-nav-item .form-control.nav-item-title,
    .builder-nav-item .form-control.page-nav-item-title {
        font-size: 0.9rem;
        padding: 6px 8px;
    } */

    .builder-nav-buttons-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 12px;
    }

    .builder-nav-button-preview {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 16px;
        border-radius: 999px;
        background: linear-gradient(135deg, #125875, #1b8aad);
        color: #fff;
        font-weight: 700;
        text-decoration: none;
        transition: transform 0.15s ease, box-shadow 0.15s ease, opacity 0.15s ease;
    }

    .builder-nav-button-preview:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(13, 43, 62, 0.14);
        color: #fff;
        opacity: 0.96;
    }

    @media (max-width: 991.98px) {
        .builder-nav-item {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .builder-nav-item .remove-page-nav-item {
            grid-column: 1 / -1;
            justify-self: start;
            width: auto;
        }
    }

    @media (max-width: 575.98px) {
        .builder-nav-item {
            grid-template-columns: 1fr;
        }

        .builder-nav-item .remove-page-nav-item {
            grid-column: auto;
            width: 100%;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const layoutSelect = document.getElementById('layout_mode');
    const editorField = document.querySelector('.editor-mode-field');
    const builderField = document.querySelector('.builder-mode-field');
    const builderList = document.querySelector('.builder-sections-list');
    const addButton = document.querySelector('.add-builder-section');
    const builderJson = document.querySelector('.builder-sections-json');
    const pages = @json($pages->map(function ($page) {
        return ['id' => $page->id, 'title' => $page->title];
    })->values());
    const imageBase = @json(asset('uploads/page-builder'));
    const initialSections = @json($builderSections);
    const initialPageNavItems = @json($pageNavItems ?? []);

    function escapeHtml(value) {
        const element = document.createElement('div');
        element.textContent = value ?? '';
        return element.innerHTML;
    }

    function escapeAttribute(value) {
        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }

    function uniqueKey() {
        return 'section_' + Date.now() + '_' + Math.random().toString(36).slice(2, 8);
    }

    function sectionTemplate() {
        return {
            key: uniqueKey(),
            title: '',
            subtitle: '',
            content: '',
            image: '',
            image_position: 'right',
            image_alt: ''
        };
    }

    function pageOptions(selectedId) {
        let options = '<option value="">Select page</option>';
        pages.forEach(function (page) {
            const isSelected = String(selectedId || '') === String(page.id) ? 'selected' : '';
            options += `<option value="${page.id}" ${isSelected}>${escapeHtml(page.title)}</option>`;
        });
        return options;
    }

    function sectionMarkup(section) {
        const key = section.key || uniqueKey();
        const imageValue = section.image || '';
        const imageUrl = imageValue ? `${imageBase}/${encodeURIComponent(imageValue)}` : '';
        const imagePosition = section.image_position || 'right';

        return `
            <div class="builder-section-row" data-key="${escapeHtml(key)}">
                <div class="builder-section-header">
                    <div>
                        <span class="builder-section-badge">Section row</span>
                        <small class="text-muted d-block mt-2">Build a row with rich text, image placement, and navigation buttons.</small>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-builder-section"><i class="fas fa-trash-alt"></i> Remove</button>
                </div>

                <input type="hidden" class="section-key" value="${escapeHtml(key)}">
                <input type="hidden" class="section-current-image" value="${escapeHtml(imageValue)}">

                <div class="builder-section-title-row mb-3">
                    <div>
                        <label class="form-label">Section Title</label>
                        <input type="text" class="form-control section-title" value="${escapeHtml(section.title || '')}" placeholder="Section title">
                    </div>
                    <div>
                        <label class="form-label">Subtitle</label>
                        <input type="text" class="form-control section-subtitle" value="${escapeHtml(section.subtitle || '')}" placeholder="Optional subtitle">
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label">Body content</label>
                        <textarea class="form-control section-content texteditor" rows="7" placeholder="Add styled text here">${escapeHtml(section.content || '')}</textarea>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Image position</label>
                        <select class="form-control section-image-position">
                            <option value="left" ${imagePosition === 'left' ? 'selected' : ''}>Left</option>
                            <option value="right" ${imagePosition === 'right' ? 'selected' : ''}>Right</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Section image</label>
                        <input type="file" class="form-control section-image-file" name="builder_images[${escapeHtml(key)}]" accept="image/*">
                        <small class="text-muted">Upload a new image to replace the current one.</small>
                        ${imageUrl ? `<img class="builder-section-image-preview" src="${imageUrl}" alt="section image">` : ''}
                    </div>
                    <!-- Per-section navigation UI removed (page-level nav used instead) -->
                </div>
            </div>
        `;
    }

    function navItemMarkup(item) {
        return `
            <div class="builder-section-menu-item nav-item-row">
                <div class="builder-nav-item">
                    <input type="text" class="form-control nav-item-title" placeholder="Button title" value="${escapeHtml(item.title || '')}">
                    <select class="form-control nav-item-page">${pageOptions(item.page_id || '')}</select>
                    <select class="form-control nav-item-active">
                        <option value="1" ${String(item.active ?? 1) === '1' ? 'selected' : ''}>Active</option>
                        <option value="0" ${String(item.active ?? 1) === '0' ? 'selected' : ''}>Inactive</option>
                    </select>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-nav-item">Remove</button>
                </div>
            </div>
        `;
    }

    function pageNavItemMarkup(item) {
        return `
            <div class="builder-section-menu-item page-nav-item-row">
                <div class="builder-nav-item">
                    <input type="text" class="form-control page-nav-item-title" placeholder="Button title" value="${escapeHtml(item.title || '')}">
                    <select class="form-control page-nav-item-page">${pageOptions(item.page_id || '')}</select>
                    <select class="form-control page-nav-item-active">
                        <option value="1" ${String(item.active ?? 1) === '1' ? 'selected' : ''}>Active</option>
                        <option value="0" ${String(item.active ?? 1) === '0' ? 'selected' : ''}>Inactive</option>
                    </select>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-page-nav-item">Remove</button>
                </div>
            </div>
        `;
    }

    function syncBuilderSections() {
        // Ensure WYSIWYG editors have saved their content back to textareas
        if (typeof tinyMCE !== 'undefined' && typeof tinyMCE.triggerSave === 'function') {
            try { tinyMCE.triggerSave(); } catch (e) { /* ignore */ }
        }
        const sections = Array.from(builderList.querySelectorAll('.builder-section-row')).map(function (row) {
            const imageValue = row.querySelector('.section-current-image')?.value || '';
            const title = row.querySelector('.section-title')?.value || '';
            const subtitle = row.querySelector('.section-subtitle')?.value || '';
            const content = row.querySelector('.section-content')?.value || '';
            
            return {
                key: row.querySelector('.section-key')?.value || uniqueKey(),
                title: title,
                subtitle: subtitle,
                content: content,
                image: imageValue,
                image_position: row.querySelector('.section-image-position')?.value || 'right',
                image_alt: title
            };
        });

        if (builderJson) {
            builderJson.value = JSON.stringify(sections);
        }
    }

    function toggleMode() {
        const isBuilder = layoutSelect && layoutSelect.value === 'builder';

        if (editorField) {
            editorField.style.display = isBuilder ? 'none' : '';
        }
        if (builderField) {
            builderField.style.display = isBuilder ? '' : 'none';
        }
    }

    function updateSectionVisibility(row) {
        const typeField = row.querySelector('.section-type');
        const type = typeField ? typeField.value : 'content';

        const titleWrap = row.querySelector('.builder-section-title-row');
        if (titleWrap) titleWrap.style.display = '';
    }

    if (builderList) {
        const sections = Array.isArray(initialSections) && initialSections.length ? initialSections : [sectionTemplate()];
        builderList.innerHTML = sections.map(sectionMarkup).join('');

        // initialize page-level nav items
        let pageNavItems = Array.isArray(initialPageNavItems) ? initialPageNavItems : [];
        function renderPageNavItems() {
            const list = document.querySelector('.page-nav-items-list');
            const hidden = document.querySelector('.page-nav-items-json');
            if (!list) return;
            list.innerHTML = pageNavItems.map(function (it) { return pageNavItemMarkup(it); }).join('');
            if (hidden) hidden.value = JSON.stringify(pageNavItems);
        }
        renderPageNavItems();

        // page-level nav handlers
        const addPageNavBtn = document.querySelector('.add-page-nav-item');
        if (addPageNavBtn) {
            addPageNavBtn.addEventListener('click', function () {
                pageNavItems.push({ title: '', page_id: '', active: '1' });
                renderPageNavItems();
            });
        }

        document.addEventListener('click', function (event) {
            const removePage = event.target.closest('.remove-page-nav-item');
            if (removePage) {
                const row = removePage.closest('.page-nav-item-row');
                const list = Array.from(document.querySelectorAll('.page-nav-item-row'));
                const idx = list.indexOf(row);
                if (idx > -1) {
                    pageNavItems.splice(idx, 1);
                    renderPageNavItems();
                }
            }
        });

        document.addEventListener('input', function (event) {
            const row = event.target.closest('.page-nav-item-row');
            if (!row) return;
            const list = Array.from(document.querySelectorAll('.page-nav-item-row'));
            const idx = list.indexOf(row);
            if (idx === -1) return;
            const title = row.querySelector('.page-nav-item-title')?.value || '';
            const page_id = row.querySelector('.page-nav-item-page')?.value || '';
            const active = row.querySelector('.page-nav-item-active')?.value || '1';
            pageNavItems[idx] = { title: title, page_id: page_id, active: active };
            const hidden = document.querySelector('.page-nav-items-json');
            if (hidden) {
                hidden.value = JSON.stringify(pageNavItems);
            }
        });

        builderList.querySelectorAll('.builder-section-row').forEach(function (row) {
            updateSectionVisibility(row);
        });

        // per-section nav lists removed; page-level nav is used instead

        builderList.addEventListener('click', function (event) {
            const removeButton = event.target.closest('.remove-builder-section');
            if (!removeButton) {
                return;
            }

            const rows = builderList.querySelectorAll('.builder-section-row');
            const row = removeButton.closest('.builder-section-row');

            if (rows.length > 1 && row) {
                row.remove();
            }

            syncBuilderSections();
        });

        // per-section add/remove nav handlers removed — page-level nav is used instead

        if (addButton) {
            addButton.addEventListener('click', function () {
                builderList.insertAdjacentHTML('beforeend', sectionMarkup(sectionTemplate()));
                const row = builderList.querySelector('.builder-section-row:last-child');
                if (row) {
                    updateSectionVisibility(row);
                }
                syncBuilderSections();
            });
        }

        builderList.addEventListener('input', syncBuilderSections);
        builderList.addEventListener('change', function (event) {
            syncBuilderSections();
        });
        syncBuilderSections();
    }

    if (layoutSelect) {
        layoutSelect.addEventListener('change', function () {
            toggleMode();
            syncBuilderSections();
        });
    }

    toggleMode();
    syncBuilderSections();

    // Ensure editors are saved and builder JSON synced on form submit
    const adminForm = document.querySelector('form.needs-validation') || document.querySelector('form');
    if (adminForm) {
        adminForm.addEventListener('submit', function (e) {
            if (typeof tinyMCE !== 'undefined' && typeof tinyMCE.triggerSave === 'function') {
                try { tinyMCE.triggerSave(); } catch (err) { }
            }
            syncBuilderSections();
        });
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>