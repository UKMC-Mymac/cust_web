# Custom Landing Page - Blade Template Structure

## Overview

This directory contains the complete Blade template structure for the custom landing page. All HTML files from the `cust` folder have been converted to Laravel Blade templates for seamless integration with your university management system.

## Directory Structure

```
resources/views/web/custom/
├── layouts/
│   └── app.blade.php                    # Main layout template
├── components/
│   ├── head-meta.blade.php              # Meta tags, CSS files
│   ├── preloader.blade.php              # Loading animation
│   ├── header.blade.php                 # Header with logo
│   ├── navigation.blade.php             # Main navigation menu
│   ├── mobile-navigation.blade.php      # Mobile menu
│   ├── footer.blade.php                 # Footer section
│   ├── search-box.blade.php             # Search functionality
│   ├── scroll-top.blade.php             # Scroll to top button
│   ├── chat.blade.php                   # Chat widget
│   └── scripts.blade.php                # JavaScript files
├── sections/
│   ├── hero.blade.php                   # Hero banner with slider
│   ├── academics.blade.php              # Academic programs slider
│   ├── why-choose-us.blade.php          # Why choose us section
│   ├── apply.blade.php                  # Application/Admission section
│   ├── clubs.blade.php                  # Clubs showcase
│   └── testimonials.blade.php           # Student testimonials slider
└── index.blade.php                       # Main home page

```

## File Descriptions

### Layouts

- **app.blade.php**: Main layout that includes all components and yields content. All pages should extend this layout.

### Components

- **head-meta.blade.php**: Contains all meta tags, title, description, keywords, and CSS includes
- **preloader.blade.php**: Loading animation shown before page loads
- **header.blade.php**: Top header with logo and contact information
- **navigation.blade.php**: Main navigation menu with dropdowns (desktop)
- **mobile-navigation.blade.php**: Mobile responsive menu
- **footer.blade.php**: Footer with links, social media, and copyright
- **search-box.blade.php**: Search popup/modal
- **scroll-top.blade.php**: Back to top button
- **chat.blade.php**: Chat widget for visitor communication
- **scripts.blade.php**: All JavaScript library includes

### Sections

- **hero.blade.php**: Hero slider with 2 slides, calls to action
- **academics.blade.php**: Program/course cards in a swiper slider (6 programs)
- **why-choose-us.blade.php**: 4 reasons to choose CUST with video embed
- **apply.blade.php**: Application section with admission info
- **clubs.blade.php**: Campus clubs showcase (4 clubs)
- **testimonials.blade.php**: Student testimonials slider (8 slides)

### Pages

- **index.blade.php**: Main homepage that includes all sections

## How to Use

### 1. Create a Route

Add this to your `routes/web.php`:

```php
Route::get('/', function () {
    return view('web.custom.index');
})->name('home');
```

### 2. Using Custom Page in Controller

```php
Route::get('/', 'WebController@index')->name('home');
```

In your controller:

```php
public function index()
{
    return view('web.custom.index');
}
```

### 3. Extending the Layout for Other Pages

To create additional pages using the same layout:

```php
@extends('web.custom.layouts.app')

@section('title', 'Page Title')
@section('meta_description', 'Page description')
@section('meta_keywords', 'keywords here')

@section('content')
    <!-- Your page content here -->
@endsection
```

## Asset Paths

All assets reference the `dist/` directory. Make sure your public folder has:

- `dist/css/` - CSS files
- `dist/js/` - JavaScript files
- `dist/images/` - Image files
- `dist/img/` - Additional images/icons
- `dist/fonts/` - Font files

Asset Helper:

```php
{{ asset('dist/css/style.min.css') }}      # CSS
{{ asset('dist/js/main.js') }}             # JavaScript
{{ asset('dist/images/logo-white.png') }}  # Images
```

## Blade Features Used

### 1. Sections

Each section is included via @include():

```php
@include('web.custom.sections.hero')
```

### 2. Dynamic Data with @php/@endphp

Data arrays are defined inline using PHP blocks:

```php
@php
    $programs = [
        ['title' => 'BSC', 'duration' => '4 years'],
        // more items
    ];
@endphp

@foreach($programs as $program)
    <!-- Display program -->
@endforeach
```

### 3. Route Helper

Navigation uses the route() helper:

```php
<a href="{{ route('home') }}">Home</a>
```

### 4. Asset Helper

All resources use the asset() helper for proper path resolution:

```php
{{ asset('dist/images/logo.png') }}
```

### 5. CSRF Protection

Built into the layout for forms:

```php
<meta name="csrf-token" content="{{ csrf_token() }}">
```

## Customization

### 1. Update Academic Programs

Edit `sections/academics.blade.php` - Modify the `$programs` array with actual data.

### 2. Update Why Choose Us Points

Edit `sections/why-choose-us.blade.php` - Modify the `$reasons` array.

### 3. Update Clubs

Edit `sections/clubs.blade.php` - Modify the `$clubs` array.

### 4. Update Testimonials

Edit `sections/testimonials.blade.php` - Modify the `$testimonials` array.

### 5. Update Contact Info

Edit `components/header.blade.php` and `components/footer.blade.php` to update email, phone, social media links.

### 6. Update Navigation Links

Edit `components/navigation.blade.php` and `components/mobile-navigation.blade.php`.

## Database Integration (Future)

To pull data from database instead of hardcoded arrays:

### Example: Pull Programs from Database

```php
@php
    $programs = \App\Models\Program::all();
@endphp

@foreach($programs as $program)
    <div class="swiper-slide">
        <div class="academic-card">
            <h3>{{ $program->title }}</h3>
            <p>{{ $program->description }}</p>
            <!-- More content -->
        </div>
    </div>
@endforeach
```

## Important Notes

1. **Images**: Images are referenced but not included. Ensure all image files exist in the public/dist/images/ directory.
2. **JavaScript Libraries**: All required libraries (Swiper, Bootstrap, jQuery, etc.) are included via CDN/local references in scripts.blade.php
3. **CSS Classes**: CSS files should be present in public/dist/css/ directory
4. **Responsive Design**: Layout is fully responsive with Bootstrap grid system
5. **SEO**: Meta tags are set up for proper SEO - customize for each page

## Navigation Menu Structure

The menu supports nested items with sub-menus:

- Home
- About (with sub-items)
- Admission (with sub-menus for Undergraduate, Graduate, International)
- Academics (with sub-menus for Schools, Centers, Policies)
- Research (with sub-items)
- Campus Life (with sub-items)
- Contact Us

## Deployment Checklist

- [ ] Copy `dist/` folder to `public/` directory
- [ ] Ensure all image files are in `public/dist/images/`
- [ ] Update contact information in header and footer
- [ ] Update social media links
- [ ] Set up routes in `routes/web.php`
- [ ] Test responsive design on mobile devices
- [ ] Verify all CSS and JavaScript assets load correctly
- [ ] Update meta tags for SEO
- [ ] Test all interactive elements (sliders, modals, etc.)

## Support

For issues or customizations needed, refer to the original HTML files in the `cust/` folder for reference.
